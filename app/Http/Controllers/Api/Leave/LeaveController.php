<?php

namespace App\Http\Controllers\Api\Leave;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Employee\Employees;
use App\Http\Controllers\HrmController;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Leave\LeaveApplication;
use Illuminate\Support\Facades\Validator;
use App\Models\Leave\LeaveApplicationStatus;
use App\Http\Controllers\Employee\LeaveApproveController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AllNotification;
use Illuminate\Support\Facades\Notification;
use DB;

class LeaveController extends HrmController
{
    public function leaveTypes()
    {
        try {
            $leave_types = DB::table('leave_types')->where('active', 1)->get();
            return response()->json([
                'success' => true,
                'data' => $leave_types
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching leave types.'
            ], 500);
        }
    }    

    public function applyLeave(Request $request)
    {       
        $user = Auth::user();
        $respM = '';

        try {
            $validatedData = $request->validate([
                'employee_id' => 'required',
                'leave_type' => 'required',
                'date_from' => 'required',
                'date_to' => 'required',
                'time_from' => 'required',
                'time_end' => 'required',
                'no_days' => 'required',
            ]);

            $employee = Employees::find($request->employee_id);
            //if ($user->hasRole('Executive-Admin') || $user->hasRole('Vp') || $user->hasRole('Principal') ){
                $hrRole = Role::where('name', HR_ROLE)->first();
                $user_id = User::role($hrRole)->first();
                $role_ids = $user_id->id;
            /*}else{
                if($employee->department != 2) {
                    $vpRole = Role::where('name', VP_ROLE)->first();
                    $user_id = User::role($vpRole)->first();
                    $role_ids = $user_id->id;
                }else{
                    $exAdRole = Role::where('name', EXAD_ROLE)->first();
                    $user_id = User::role($exAdRole)->first();
                    $role_ids = $user_id->id;
                }
            }*/
           
            /*if($employee->department == 2) {
                $hrRole = Role::where('name', HR_ROLE)->first();                
                $user_id = User::role($hrRole)->first();
                $role_ids = $user_id->id;
            }*/
            
            $filename = null;
            if ($request->hasFile('attachment')) {
                
                $validator = Validator::make($request->all(), [
                    'attachment' => 'mimes:jpg,jpeg,png,pdf,docx,xlsx|max:1024',
                ]);
    
                if ($validator->fails()) {
                    return response()->json(['error' => trans('messages.file_upload_type')], 400);
                }
                
                $filename = fileUpload([$request->file('attachment')], 'uploads/employees/leave');
            }
            
            
            $existingLeave = LeaveApplication::where('employee_id', $request->employee_id)
                    ->where(function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->where('date_from', '<=', $request->date_from)
                                ->where('date_to', '>=', $request->date_from);
                        })->orWhere(function ($query) use ($request) {
                            $query->where('date_from', '<=', $request->date_to)
                                ->where('date_to', '>=', $request->date_to);
                        });
                    })
                    ->whereNotIn('status', [$this->leave_approval_status['rejected'], $this->leave_approval_status['cancelled']])
                    ->latest('created_at')
                    ->get();
        
            if ($existingLeave->isNotEmpty()){
                if(count($existingLeave)>=2){
                    return response()->json(['error' => trans('messages.leave_date_conflict') ], 409);
                }else{
                    $respM = trans('messages.leave_date_conflict').' & '.trans('messages.successO');
                }
            }else{
                $respM = trans('messages.successO');
            }

                $leave = LeaveApplication::create($validatedData + ['reason'=> $request->reason ?? NULL,
                                'attachment' => $filename, 
                                'forward_from' => $request->employee_id,
                                'forward_to' => $role_ids,
                                'created_by' => $user->id, 
                                'updated_by' => $user->id,
                                'academic_year' => $this->academic_year,
                                'paid_status' => (11==$request->leave_type) ? 1 : 0]
                );

                $leave_status = LeaveApplicationStatus::create([
                'leave_id' => $leave->id,
                'applier_id' => $leave->employee_id,                
                'approver_id' => $role_ids,
                'leave_status' => $this->leave_approval_status['applied'],
                'assigned_to_role' =>1,
                'assigned_to_id' => 1,
                'comment'=> $request->reason ?? 'no comment',
                ]);

                $employee_data = Employees::where('id', $leave->employee_id)
                ->select('user_id', 'name', 'lname')
                ->first();
                $to_id = $employee_data->user_id;

                /*Email notification to next approver*/
                $approver_data = User::where('id', $role_ids)
                ->select('email')
                ->first();

                $leave_app = LeaveApplication::with(['leavetypes'])->find($leave->id);
                $leave_type_name = $leave_app->leavetypes->name;

                Mail::send('emails.leave-request-notify', ['employee' => $employee_data->name.' '.$employee_data->lname, 'leave_type' => $leave_type_name, 'date_from'=> $request->date_from, 'date_to'=> $request->date_to ], function($message) use($approver_data,$employee_data,$leave_type_name){
                $message->to($approver_data->email);
                $message->subject(trans('messages.leave_rqst_notif').': '.$employee_data->name.' '.$employee_data->lname.'-'.$leave_type_name);
                });

                /*Mobile Push notification */
                $notif_data = new \stdClass();
                $notif = new AllNotification();
                $notif_data->title = trans('messages.leave_rqst_notif');
                $notif_data->body = trans('messages.leave_rqst_pndng');
                $notif_data->link = 'leaveapproval';

                $send_notif = $notif->sendPushNotifications($notif_data, $role_ids);

                /*Web notification */
                //$send_notif = $notif->sendWebNotifications($notif_data, $role_ids);

                return response()->json(['success' => true, 'data' => $leave_status, 'msg' =>$respM ], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 404);
        }
    }    

    public function approveLeave(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'approver_id' => 'required|integer',
                'leave_id' => 'required|integer',
                'leave_status_id' => 'required|integer',
                'status' => 'required|integer',
                'employee_id' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $status = LeaveApplicationStatus::find($request->input('leave_status_id'));
            $status->status = $request->input('status');

            if($request->input('status') == 2){
                $employee = Employees::find($request->employee_id);
                if($employee->department == 2) {
                    $role_ids = User::role(PRINCIPAL_ROLE)->pluck('id')->toArray();
                }

                if($employee->department != 2) {
                    $role_ids = User::role(HR_ROLE)->pluck('id')->toArray();
                }
                array_push($role_ids, 1);
                $status->approver_id = $role_ids;
            }

            $status->save();

            $leave_application = LeaveApplication::find($request->input('leave_id'));
            $leave_application->status = $request->input('status');
            $leave_application->save();

            $leave_type = LeaveType::findOrFail($leave->leave_type);

            $user = Auth::user();
            $hrRole = Role::where('name', 'Hr')->first();
            $vpRole = Role::where('name', 'Vp')->first();

            return response()->json(['success' => true, 'data' => leaveApplicationStatus($request->input('status'))], 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function showLeaveDetails($id)
    {
        $leave_applications = LeaveApplication::with([
            'employee',
            'leavetypes',
            'leaveapplicationstatus',
            'employee.designations',
            'employee.departments'
        ])->where('employee_id', $id)
          ->orderBy('id', 'desc')->get();

        if($leave_applications->isNotEmpty()){
            foreach($leave_applications as $eachapl){
                $leave_cancel = DB::table('leave_application_amendments')->select('status')
                                                                        ->where('leave_id', $eachapl->id)
                                                                        ->first();
                if($leave_cancel){
                    $eachapl->cancel_status = $leave_cancel->status;
                }else{
                    $eachapl->cancel_status = '-1';
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $leave_applications,
        ]);
    }

    public function trackLeaveDetails($id)
    {
       
        $leave_applications = LeaveApplication::with([
            'employee',
            'leavetypes',
            'leaveapplicationstatus',
            'employee.designations',
            'employee.departments'
        ])->where('id', $id)
          ->orderBy('id', 'desc')->get();

        if($leave_applications->isNotEmpty()){
            foreach($leave_applications as $eachapl){
                $leave_cancel = DB::table('leave_application_amendments')->select('status')
                                                                        ->where('leave_id', $eachapl->id)
                                                                        ->first();
                if($leave_cancel){
                    $eachapl->cancel_status = $leave_cancel->status;
                }else{
                    $eachapl->cancel_status = '-1';
                }
            }
        }
       
        return response()->json([
            'status' => 'success',
            'data' => $leave_applications,
        ]);
    }

    function getLeaveTypes(): array {
        $currentYear = date('Y');
        $leaveTypes = DB::table('leave_types')->where('active', 1)->get()->toArray();
        return $leaveTypes;
    }

    /*public function totalLeaves(LeaveApplication $leave_application, $id)
    {
        
        $employee_id = $id;
        try{
            $taken_applications = [];
            $employee = Employees::with('designations','departments')->where('employee_id', $id)->first();
            $now = Carbon::now();
            $joining_date = $employee->joiningdate;
            $date = Carbon::parse($joining_date);

            $leave_applications = LeaveApplication::with([
                'employee',
                'leavetypes',
                'leaveapplicationstatus',
                'employee.designations',
                'employee.departments'
                ])->where('employee_id', $id)->first();
            
            if($leave_applications){
                $taken_applications = LeaveApplication::with([
                    'employee',
                    'leavetypes',
                    'leaveapplicationstatus',
                    'employee.designations',
                    'employee.departments'
                    ])->where('employee_id', $id)
                        ->where('status', $this->leave_approval_status['approved'])->get();          
                                
                $leave = new LeaveApproveController();
                $month_of_service = $date->diffInMonths($now);
                //$month_of_service = 20;
                $attendance_percentage = 100; 
                $employee_type = $leave_applications->employee->employee_type; 
                $is_first_year = $month_of_service < 12;
                // $available_leaves = $leave->calculateAnnualLeave($month_of_service, $leave_applications->employee->department, 100);
               // $pending_leaves = $leave->pendingAnnualLeave($month_of_service, $employee_id, $attendance_percentage, $is_first_year);
                $pending_leaves = get_pending_leaves($employee_id,$month_of_service,$is_first_year);
                $available_leaves = get_avaliable_leaves($employee_id,$month_of_service,$is_first_year);
                // dd($available_leaves);
            }else{
                $month_of_service = $date->diffInMonths($now);
                $attendance_percentage = 100; 
                $employee_type = $employee->employee_type; 
                $is_first_year = $month_of_service < 12;
                $leave = new LeaveApproveController();
                $available_leaves = $leave->calculateAnnualLeave($month_of_service, $employee->department, 100);
                // $pending_leaves = $leave->pendingAnnualLeave($month_of_service, $employee_id, $attendance_percentage, $is_first_year);
                $pending_leaves = get_pending_leaves($employee_id,$month_of_service,$is_first_year);
                $available_leaves = get_avaliable_leaves($employee_id,$month_of_service,$is_first_year);

            }

            $pending_leave_keys = array_keys($pending_leaves);
            $pending_leave_values = array_values($pending_leaves);

            $pending_leave_list = [];
            for ($i = 0; $i < count($pending_leave_keys); $i++) {
                $pending_leave_list[] = [
                    'name' => $pending_leave_keys[$i],
                    'days' => $pending_leave_values[$i]
                ];
            }

                return response()->json(['success' => true,
                    'data' =>[
                        'available_leaves' => $available_leaves,
                        'taken_leaves' => count($taken_applications),
                        'pending_leaves' => $pending_leave_list,
                    ]], 201);
                    
            return response()->json(['success' => false, 'data' => 'Employee not found'], 404);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }*/

    public function totalLeaves($employee_id)
    {
        $now = Carbon::now();
        $total_leaves = 0;
        $availbale_leaves = 0;
        $taken_leaves = 0;
        $pending_leave_list = [];

        try{

            $employee = Employees::select('joiningdate', 'department')
                                ->where('employee_id', $employee_id)->first();
            $joining_date = Carbon::parse($employee->joiningdate);
            $month_of_service = $joining_date->diffInMonths($now);
            $is_first_year = ($month_of_service < 12) ? 1 : 0;
            

            /*Get all leave types */
            $leave_types = DB::table('leave_types')->where('active', 1)->get();
            
            foreach($leave_types as $eachltp){
                /*Annual leave count logic here */
                if(2==$eachltp->id){
                    /*Annual leave applicable only after 1 year of service */
                    //if(1==$is_first_year)
                        //$eachltp->leave_days = 0;
                    //else
                        $eachltp->leave_days = getAnnualLeaveCount($employee->department, $this->academic_year);
                } 

                $leave_approved = LeaveApplication::select(DB::raw('SUM(no_days) as taken_days'))
                                                    ->where('employee_id', $employee_id)
                                                    ->where('leave_type', $eachltp->id)
                                                    ->where('academic_year', $this->academic_year)
                                                    ->where('status', $this->leave_approval_status['approved'])
                                                    ->first();
                if($leave_approved){
                    $taken_days = $leave_approved->taken_days;
                }else{
                    $taken_days = 0;
                }

                /*Remaining */
                $remaining = ($eachltp->leave_days-$taken_days >=0)? $eachltp->leave_days-$taken_days : 0;

                /*Pending leave array storing here */
                $pending_leave_list[] = [
                    'name' => $eachltp->name,
                    'days' => $eachltp->leave_days,
                    'remaining' => $remaining
                ];

                /*Total leave count storing here */
                $total_leaves = $total_leaves+$eachltp->leave_days;

                /*Taken leave count(for total) storing here*/
                $taken_leaves = $taken_leaves+$taken_days;
            }

            /**Available leave count(for total) here */
            $availbale_leaves = $total_leaves-$taken_leaves;


            return response()->json(['success' => true,
                'data' =>[
                    'available_leaves' => $availbale_leaves,
                    'taken_leaves' => $taken_leaves,
                    'pending_leaves' => $pending_leave_list,
                ]], 201
            );

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function attachLeaveDoc(Request $request)
    {
        $filename = null;

        $validate = Validator::make($request->all(), [
            'attachment' => 'mimes:jpg,jpeg,png,pdf,docx,xlsx|max:1024',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => trans('messages.file_upload_type')], 400);
        }

        if ($request->hasFile('attachment')) {
            $filename = fileUpload([$request->file('attachment')], 'uploads/employees/leave');
        }

        try{
            $formData = LeaveApplication::where('id', $request->leave_id)
                                        ->update([
                                                    'attachment' => $filename
                                                ]); 
            
            return response()->json(['success' => trans('messages.successO')], 201);

        } catch (\Throwable $th) {

            return response()->json(['error' => trans('messages.errorCom')], 500);

        }
    }

    public function leaveCancel(Request $request)
    {
        try{
            
            $request->validate([
                'leave_id' => 'required',
                'employee_id' => 'required',
                'reason' => 'required',
            ]);

            DB::table('leave_application_amendments')->insert(
                                    ['leave_id'=> $request->leave_id,
                                     'employee_id' => $request->employee_id, 
                                     'reason' => $request->reason,
                                     'request_status' => $this->leave_approval_status['cancelled'],
                                     'request_from' => $request->request_from ? $request->request_from : 'E',
                                     'created_by' => Auth::user()->id, 
                                     'status' => 0
                                    ]);

            return response()->json(['success' => true, 'message' => trans('messages.successO')], 201);

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }    
}
