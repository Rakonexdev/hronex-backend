<?php

namespace App\Http\Controllers\Employee;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Employee\Employees;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Leave\LeaveApplication;
use App\Http\Controllers\HrmController;
use App\Models\Leave\LeaveApplicationStatus;
use App\Models\Leave\LeaveType;
use Illuminate\Support\Facades\DB;
use App\Notifications\AllNotification;
use Illuminate\Support\Facades\Notification;
use App\Events\HrmUpdates;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\LeaveApplicationChanges;

class LeaveApproveController extends HrmController
{
    public function index(Request $request)
    {
        $user = Auth::user();              

        $leave_applications = LeaveApplication::with([
                                                'employee',
                                                'leavetypes',
                                                'employee.designations',
                                                'employee.departments'
                                ])->select('leave_applications.*', 
                                           'users.name',
                                           'leave_application_status.id as statusid', 
                                           'leave_application_status.comment')
                                  ->leftjoin('users', 'users.id', '=', 'leave_applications.forward_from')
                                  ->leftJoin('leave_application_status', function($query) {
                                            $query->on('leave_application_status.leave_id','=','leave_applications.id')
                                                ->whereRaw('leave_application_status.id IN (select MAX(las.id) 
                                                    from leave_application_status as las join leave_applications as la 
                                                    on la.id = las.leave_id group by la.id)');
                                        })
                                  ->orderBy('id', 'desc');
        if ($request && $request->employee_no) {
            $emps = Employees::where('employee_no', $request->employee_no)->select('id')->first();
            $leave_applications = $leave_applications->where('employee_id', $emps->id);
            $search_empno = $request->employee_no;
        }else{ $search_empno = ''; }
        $leave_applications = $leave_applications->where('leave_applications.status', '!=', 9); 
        $leave_applications = $leave_applications->get();  
        
        /*Get all user ids under Vice Principal role*/
        $vp_role_ids = User::whereHas(
                        'roles', function($q){
                            $q->where('name', VP_ROLE);
                        })->pluck('id')->toArray();

        /*Get all user ids under Executive Admin role*/
        $exad_role_ids = User::whereHas(
            'roles', function($q){
                $q->where('name', EXAD_ROLE);
            })->pluck('id')->toArray();
        
        /*Get all user ids under HR role*/
        $hr_role_ids = User::whereHas(
                        'roles', function($q){
                            $q->where('name', HR_ROLE);
                        })->pluck('id')->toArray(); 

        /*Get All user ids under Principal*/ 
        $principal_role_ids = User::whereHas(
                            'roles', function($q){
                                $q->where('name',PRINCIPAL_ROLE);
                            })->pluck('id')->toArray();              

        /*Get approval status keys */
        $leave_stat = collect($this->leave_approval_status)->keys();   

        /*Get employee's all leave details*/    
        if($leave_applications->isNotEmpty()){
            foreach($leave_applications as $eachlp){                
                $depart_id = isset($eachlp->employee->departments) ? $eachlp->employee->departments->id : 0;
                $eachlp->full_leave_data = $this->currentTotalLeaves($eachlp->employee_id, $depart_id);
                $eachlp->avatar = User::where('id', $eachlp->employee->user_id)->pluck('avatar')->first();
                $retract_data = DB::table('leave_application_amendments')->select('id')
                                               ->where('leave_id', $eachlp->id)->first();
                if($retract_data){
                    $eachlp->retract_data = $retract_data->id;
                }else{
                    $eachlp->retract_data = 0;
                }
                $eachlp->single_leave_data = $this->currentTotalLeaves($eachlp->employee_id, $depart_id, $eachlp->leave_type);
            }
        }

        /* Employee list for new leave creation */
        $employees = Employees::select('employee_id', 'employee_no', 'name', 'lname')
                                ->where('status', 1)
                                ->orderByRaw("CASE 
                                            WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                            ELSE employees.employee_no END")
                                ->orderBy('employees.employee_no')
                                ->get();


        return view('leave.leave_approve', compact('leave_applications', 'vp_role_ids', 'exad_role_ids', 'hr_role_ids','principal_role_ids', 'leave_stat', 'search_empno', 'employees'));
    }

    public function approve(Request $request)
    {  
        $validation = $request->validate([
                'comment' => 'required'
        ]);  
	 
        /*Get some crutial data related with the approval */
        $dataForApproval = $this->getDataForLeaveApproval($request); 
        
        /*Add new data to status table*/
        $leave_status_data = LeaveApplicationStatus::create([
                'leave_id' => $request->leave_id,  
                'applier_id' => $request->employee_id,                
                'approver_id' => $dataForApproval->role_ids,
                'leave_status' => $dataForApproval->leave_status,
                'assigned_to_role' =>1,
                'assigned_to_id' => 1,
                'comment'=> ($request->comment)?$request->comment:'Nil',
        ]);
        $principal_role_ids = User::whereHas('roles', function ($q) {
            $q->where('name', PRINCIPAL_ROLE);
        })->pluck('id')->toArray();
        /*Update application table*/
        $leave_application = LeaveApplication::find($request->leave_id);
        $leave_application->status = $dataForApproval->leave_status;
        $leave_application->forward_from = $dataForApproval->role_ids;
        $leave_application->forward_to = $dataForApproval->to_id;
        // Check if $dataForApproval->role_ids is in the array of principal role IDs
        if (in_array($dataForApproval->role_ids, $principal_role_ids) && $dataForApproval->leave_status == $this->leave_approval_status['approved']) {
            if(0==$leave_application->paid_status){
                $leave_application->paid_status = $dataForApproval->exceeded_leave_days;
            }
        }
        $leave_application->save();

        $leave_app = LeaveApplication::with(['leavetypes'])->find($request->leave_id);
        $leave_type_name = $leave_app->leavetypes->name;

        $info['leave_id'] = $request->leave_id;
        $info['employee_id'] = $request->employee_id;
        $info['leave_type'] = $leave_type_name;
        $info['date_from'] = $leave_application->date_from;
        $info['date_to'] = $leave_application->date_to;
        $info['status'] = $dataForApproval->leave_status;
        $info['from_id'] = $dataForApproval->role_ids;
        $info['to_id'] = $dataForApproval->to_id;
        $info['comment'] = ($request->comment)?$request->comment:'Nil';

        $send_notif_and_email = $this->sendEmailAndNotifications($info, 'A');

        return redirect()->back()->with('success', trans('messages.successO'));
    }

    /*
     * Calculate the yearly leave entitlement based on the policy
     *
     * @param string $staff_type The type of staff, either "Admin" or "Academic"
     * @param int $months_of_service The number of months of service
     * @return int The number of days of annual leave entitlement
    */
    function calculateYearlyLeave($staff_type, $months_of_service)
    {
        // Determine the number of days of annual leave entitlement based on the staff type
        switch ($staff_type) {
            case 'Admin':
                $annual_leave_days = getAnnualLeaveCount(2, $this->academic_year);
                break;
            case 'Academic':
                $annual_leave_days = getAnnualLeaveCount(1, $this->academic_year);
                break;
            default:
                throw new InvalidArgumentException('Invalid staff type specified');
        }

        // Determine the annual leave entitlement based on the length of service
        if ($months_of_service < 10) {
            // First year of service, no annual leave entitlement
            $annual_leave_entitlement = 0;
        } else if ($months_of_service >= 10 && $months_of_service <= 12) {
            // Pro-rata entitlement based on the number of months of service
            $annual_leave_entitlement = round(($annual_leave_days / 12) * $months_of_service);
        } else {
            // Full entitlement
            $annual_leave_entitlement = $annual_leave_days;
        }

        return $annual_leave_entitlement;
    }

    public function calculateAnnualLeave(int $months_of_service, $employee_type, int $attendance_percentage, bool $is_first_year = false): int
    {
        if ($is_first_year) {
            return 0; // Not eligible for annual leave in the first year.
        }

        if ($months_of_service < 10) {
            return 0; // Not eligible for annual leave until after 10 months of service.
        }
        $currentYear = date('Y');
        $avaliableLeaveDays = DB::table('leave_types')
                ->sum('leave_days');
                
        //$annual_leave_days = $employee_type === 1 ? 30 : 45;
        $annual_leave_days =  round($avaliableLeaveDays);
        //var_dump($annual_leave_days);
       /* if ($attendance_percentage < 100) {
            $annual_leave_days = round(($attendance_percentage / 100) * $annual_leave_days); // Pro-rata annual leave based on attendance.
        }*/

        return $annual_leave_days;
    }

    public function getLeaveTypes(): array {
        $currentYear = date('Y');
        $leaveTypes = DB::table('leave_types')->get()->toArray();
        $leaveTypesArray = [];
        foreach($leaveTypes as $leaveType) {
            $leaveTypesArray[] = get_object_vars($leaveType);
        }
        return $leaveTypesArray;
    }

    public function pendingAnnualLeave(int $months_of_service, $employee_id, int $attendance_percentage, bool $is_first_year = false): array
    {
        if ($is_first_year) {
            return []; // Not eligible for annual leave in the first year.
        }
    
        if ($months_of_service < 10) {
            return []; // Not eligible for annual leave until after 10 months of service.
        }
    
        $leaveTypes = LeaveApproveController::getLeaveTypes();
        $pendingLeaves = array();
    
        foreach($leaveTypes as $leaveType) {
            $leaveDays = $leaveType['leave_days'];
            $leaveId = $leaveType['id'];
            $leaveName = $leaveType['name'];
            $pendingLeaves[$leaveName] = 0;
    
            /*if ($attendance_percentage < 100) {
                $leaveDays = round(($attendance_percentage / 100) * $leaveDays); // Pro-rata annual leave based on attendance.
            }
            */
            // Calculate pending leaves for the current leave type based on approved leave applications
            $approvedLeaveDays = DB::table('leave_applications')
                ->select(DB::raw('SUM(no_days) as approved_leave_days'))
                ->where('leave_type', '=', $leaveId)
                ->where('status', '=', 2)
                ->where('employee_id', '=', $employee_id)
                ->groupBy('employee_id', 'leave_type')
                ->pluck('approved_leave_days')
                ->first();
            //print_r($leaveDays);
            //print_r($approvedLeaveDays);
            $pendingLeaves[$leaveName] = $leaveDays - $approvedLeaveDays;
        }
    
        return $pendingLeaves;
    } 

    public function showLeaveDetails(LeaveApplication $leave_application, $id)
    {
        $leave_applications = LeaveApplication::with([
            'employee',
            'leavetypes',
            'leaveapplicationstatus',
            'employee.designations',
            'employee.departments'
            ])->where('id', $id)->first();

        // return $leave_application->attendancePercentage(1);
        $leaves = LeaveApplication::with(['leaveapplicationstatus'])
                ->where('employee_id', $leave_applications->employee_id)
                ->where('status', 2)
                ->get();
        $taken_leaves = count($leaves);
        $joining_date = $leave_applications->employee->joiningdate;

        $date = Carbon::parse($joining_date);
        $now = Carbon::now();
        $month_of_service = $date->diffInMonths($now);

        $available_leaves = $this->calculateAnnualLeave($month_of_service, $leave_applications->employee->department, 100);

        return view('leave.leave_details', compact(['leave_applications', 'available_leaves', 'taken_leaves']));
    }

    protected function getDataForLeaveApproval($request)
    {
  
        $dataForLeaveApproval = new \stdClass();
        $dataForLeaveApproval->exceeded_leave_days = 0;
        
        $user_role = Auth::user();
        $leave_id = $request->input('leave_id');
        $employee_id = $request->input('employee_id');       
        $leaveApplication = LeaveApplication::with(['leavetypes'])->find($leave_id);

        if ($leaveApplication) {
            // Calculate the sum_no_days by summing the no_days values of related leave type LeaveApplication records with approved
            $sum_no_days = LeaveApplication::where('employee_id', $employee_id)
                ->where('status', $this->leave_approval_status['approved'])
                ->where('leave_type', $leaveApplication->leave_type)
                ->where('academic_year', $this->academic_year)
                ->sum('no_days');
    
            // Get the associated LeaveType for the LeaveApplication
            $leaveType = $leaveApplication->leavetypes;

            // Compare the sum_no_days with leave_days to determine if leave days have been exceeded
            $dataForLeaveApproval->exceeded_leave_days = ($sum_no_days >= $leaveType->leave_days || 11==$leaveApplication->leave_type) ? 1 : 0;             
        }
       
        /*Get approval action keys [ 'approve', 'reject', 'hold'  ]*/
        $leave_stat = collect($this->leave_approval_action)->keys();
        
        /*Get employee data*/
        $employee = Employees::where('employee_id', $request->employee_id)->first();

        /*Set form submit actions to lower case*/
        $leave_action = lcfirst($request->approval_action);

        /*Leave action handling*/
        switch($leave_action){
            case($leave_stat[0]):
                        $leave_status = $this->leave_approval_status['approved']; 
                        break;
            case($leave_stat[1]):
                        $leave_status = $this->leave_approval_status['rejected']; 
                        break;
            case($leave_stat[2]):
                        $leave_status = $this->leave_approval_status['hold']; 
                        break;
            default:
                        $leave_status = $this->leave_approval_status['hold']; 
                        break;
        }
            
            
        if ($user_role->hasRole('Hr')){
            $hrRole = Role::where('name', HR_ROLE)->first();
            $user_id = User::role($hrRole)->first();
            $role_ids = $user_id->id; 

            /*For HR: If the approval action is 'approve' then set it to 'verified'
                      Also take Principal's id as forwarder(to) id */
            if($leave_stat[0] == $leave_action){
                $leave_status = $this->leave_approval_status['verified'];

                $to_Pr = Role::where('name', PRINCIPAL_ROLE)->first();
                $to_user_id = User::role($to_Pr)->first();
                $to_id = $to_user_id->id;
            }else{
                $to_id = $role_ids;
            }
        }

        if ($user_role->hasRole('Principal')) {
            $principal_Role = Role::where('name', PRINCIPAL_ROLE)->first();
            $user_id = User::role($principal_Role)->first();
            $role_ids = $user_id->id;                 
             
            /* Return logic is here: Will ad later */
            /*if($leave_stat[3] == $leave_action){
                $to_Hr = Role::where('name', HR_ROLE)->first();
                $to_user_id = User::role($to_Hr)->first();
                $to_id = $to_user_id->id;
            }else*/ 
            if($leave_stat[0] == $leave_action){
                $leave_status = $this->leave_approval_status['approved'];

                $to_hr = Role::where('name', HR_ROLE)->first();
                $to_user_id = User::role($to_hr)->first();
                $to_id = $to_user_id->id;
            }else{
                //$to_id = $role_ids;
                $to_id = $user_id->id;
            }  
        }

        $dataForLeaveApproval->role_ids = $role_ids;
        $dataForLeaveApproval->to_id = $to_id;
        $dataForLeaveApproval->leave_status = $leave_status;

        return $dataForLeaveApproval;
    }

    public function currentTotalLeaves($employee_id=0, $dept_id=0, $leave_typeId=0)
    {        
        $leaveData = DB::table('leave_types')
                                ->select('id', 'name', 'applicable_to', 'leave_days', 'bg_color')
                                ->where('active', 1);
        if(0!=$leave_typeId){
            $leaveData = $leaveData->where('id', $leave_typeId);
        }
        $leaveData = $leaveData->get()->toArray();
                                /*->where('academic_year', $this->academic_year)->get()->toArray();*/

        if(0 >= count($leaveData))
            return NULL;

        foreach($leaveData as $eachleaveData){
            $leave_type_id = $eachleaveData->id;
            /*If it is not an admin employee & type is annual leave, then count it from the academic calendar */
            if(2!=$dept_id && 2 == $leave_type_id){
                $eachleaveData->leave_days = getAnnualLeaveCount(1, $this->academic_year);
            }

            $leave_count = LeaveApplication::where('status', $this->leave_approval_status['approved'])
                            ->where('leave_type', $leave_type_id)
                            /* Leave type is not 'leave without pay' then check paid status is zero' */
                            ->when(11!=$leave_type_id, function ($query){
                                return $query->where('paid_status', 0);
                            })
                            ->where('academic_year', $this->academic_year);
            if(0 != $employee_id){
                $leave_count = $leave_count->where('employee_id', $employee_id);
            }            
            $leave_count = $leave_count->sum('no_days');

            /* Casual & Short leave type inter connection logic here */
            if(1==$leave_type_id){ // If casual, then fetch short leave count & calculate
                $sl_count = getAllLeaveCount(6, $this->academic_year, $employee_id);
                $leave_count = (float)($leave_count + $sl_count/2);
            }else if(6==$leave_type_id){ // If short, then fetch casual leave count & calculate
                $cl_count = getAllLeaveCount(1, $this->academic_year, $employee_id);
                $leave_count = (int)($leave_count + $cl_count*2);
            }

            $eachleaveData->taken_days = ($leave_count) ? $leave_count : 0;
        } 

        return $leaveData;
    }


    protected function sendEmailAndNotifications($info, $through='A')
    {
        $employee_data = Employees::where('id', $info['employee_id'])
                                           ->select('user_id', 'name', 'lname')
                                           ->first();
        $employee_userid = $employee_data->user_id;
        $leave_type = $info['leave_type'];

        /*Email notification to next approver*/
        $approver_data = User::where('id', $info['to_id'])
                           ->select('email')
                           ->first();

        if($info['status']==$this->leave_approval_status['approved']){
            $view = "emails.leave-approval-notify";
            $head = "The ".Auth::user()->roles[0]->name." has authorised";
            $subj = trans('messages.leave_decs_notif');
        }else if($info['status']==$this->leave_approval_status['rejected']){
            $view = "emails.leave-approval-notify";
            $head = "The ".Auth::user()->roles[0]->name." denies";
            $subj = trans('messages.leave_decs_notif');
        }else{
            $view = "emails.leave-request-notify";
            $head = "";
            $subj = trans('messages.leave_rqst_notif');
        }

        if(isset($info['comment']))
            $comment = $info['comment'];
        else 
            $comment = '';
        
        /*Send email to principal to decide the final approval through email itself */
        $principal_role_ids = User::whereHas('roles', function ($q) {
            $q->where('name', PRINCIPAL_ROLE);
        })->pluck('id')->toArray();

        if ( in_array($info['to_id'], $principal_role_ids) && 'A' == $through ) {
            $tkn = Str::random(64);
            $tokenA = $tkn."_A_".$approver_data->email."_L_".$info['leave_id']."_D_".$this->leave_approval_status['approved'];
            $tokenR = $tkn."_A_".$approver_data->email."_L_".$info['leave_id']."_D_".$this->leave_approval_status['rejected'];

            \DB::table('email_decision')->insert([
                'email' => $approver_data->email,
                'token' => $tkn,
                'created_at' => Carbon::now()
            ]);

            Mail::send("emails.leave-approval-through-mail", ['head'=> $head, 'employee'=> $employee_data->name.' '.$employee_data->lname, 'tokenA'=> $tokenA, 'tokenR'=> $tokenR, 'leave_type'=> $leave_type, 'date_from'=> $info['date_from'], 'date_to'=> $info['date_to'], 'comment'=>$comment ], function($message) use($approver_data,$subj,$employee_data,$leave_type){
                $message->to($approver_data->email);
                $message->subject($subj.': '.$employee_data->name.' '.$employee_data->lname.'-'.$leave_type);
            });
        /*Send email next approver */
        }else{
            Mail::send($view, ['head'=> $head, 'employee'=> $employee_data->name.' '.$employee_data->lname, 'leave_type'=> $leave_type, 'date_from'=> $info['date_from'], 'date_to'=> $info['date_to'], 'comment'=>$comment ], function($message) use($approver_data,$subj,$employee_data,$leave_type){
                $message->to($approver_data->email);
                $message->subject($subj.': '.$employee_data->name.' '.$employee_data->lname.'-'.$leave_type);
            });
        }


        /*Notification area*/              
        $notif = new AllNotification();

        /*Store notifications: Add notification data to table*/
        if($info['status']==$this->leave_approval_status['approved'] ||
           $info['status']==$this->leave_approval_status['rejected']){
            $noif_type = $this->notification_list[1];
        }else{
            $noif_type = $this->notification_list[2];
        }
        $notifdata['type'] = $noif_type; /*trans('messages.leave_rqst_notif'); */
        $notifdata['notifiable_type'] = 'App\Models\Leave\LeaveApplication';
        $notifdata['notifiable_id'] = $info['to_id'];
        $notifdata['title'] = trans('messages.leave_rqst_notif');
        $notifdata['link'] = 'leaveapproval';

        /*Final approval: Approved message Otherwise awaiting decision message*/
        if($info['status']==$this->leave_approval_status['approved']){ 
            $notifdata['data'] = trans('messages.leave_approved_inf');
        }else{
            $notifdata['data'] = trans('messages.leave_rqst_pndng');
        }

        /*Add data to notification table */
        $notifs = $notif->addnotifications($notifdata);

        /*Handle the push notification */
        if(1==$notifs){
            //$notif->passNotification();
        } 

        /*Handle push notification to employee*/
        if($info['status']==$this->leave_approval_status['approved'] ||
           $info['status']==$this->leave_approval_status['rejected']){

            $notif_data = new \stdClass();
            $notif_data->title = trans('messages.leave_rqst_notif');                
            $notif_data->body = ($info['status']==$this->leave_approval_status['approved']) ? trans('messages.leave_approved_msg') : trans('messages.leave_rejected_msg');
                           
            $send_notif = $notif->sendPushNotifications($notif_data, $employee_userid); 

        }
    }


    public function leave_decision_through_mail($token)
    {
        $newtoken1 = explode('_L_', $token);
        $newtoken2 = explode('_A_', $newtoken1[0]);        

        $existDecCheck = \DB::table('email_decision')
                              ->where([
                                'email' => $newtoken2[1], 
                                'token' => $newtoken2[0]
                              ])
                              ->first();
        if($existDecCheck){

            $to_hr = Role::where('name', HR_ROLE)->first();
            $to_user_id = User::role($to_hr)->first();
            $to_id = $to_user_id->id;

            $decision = explode('_D_', $newtoken1[1]);

            $leave_application = LeaveApplication::with(['leavetypes'])->find($decision[0]);

            $sum_no_days = LeaveApplication::where('employee_id', $leave_application->employee_id)
                                            ->where('leave_type', $leave_application->leave_type)
                                            ->where('status', $this->leave_approval_status['approved'])
                                            ->sum('no_days');
            $paid_stat = ($sum_no_days > $leave_application->leavetypes->leave_days) ? 1 : 0;
            $leave_type_name = $leave_application->leavetypes->name;

            LeaveApplicationStatus::create([
                    'leave_id' => $leave_application->id,  
                    'applier_id' => $leave_application->employee_id,                
                    'approver_id' => $leave_application->forward_to,
                    'leave_status' => $decision[1],
                    'assigned_to_role' =>1,
                    'assigned_to_id' => 1,
                    'comment'=> 'Nil',
            ]);

            $leave_application_new = LeaveApplication::find($decision[0]);
            $leave_application_new->status = $decision[1];
            $leave_application_new->forward_from = $leave_application->forward_to;
            $leave_application_new->forward_to = $to_id;                     
            $leave_application_new->paid_status = $paid_stat;            
            $leave_application_new->save();          
            

            $info['leave_id'] = $decision[0];
            $info['employee_id'] = $leave_application->employee_id;
            $info['leave_type'] = $leave_type_name;
            $info['date_from'] = $leave_application->date_from;
            $info['date_to'] = $leave_application->date_to;
            $info['status'] = $decision[1];
            $info['from_id'] = $leave_application->forward_to;
            $info['to_id'] = $to_id;
            $info['comment'] = '';
            
            $send_notif_and_email = $this->sendEmailAndNotifications($info, 'M');

            \DB::table('email_decision')->where([ 'email'=> $newtoken2[1], 'token' => $newtoken2[0] ])->delete();

            if($decision[1]==$this->leave_approval_status['approved'])
                $msg_info = trans('messages.leave_approved_inf');
            else
                $msg_info = trans('messages.leave_rejected_inf');

            return redirect('login')->with('success', $msg_info);

        }else{

           return redirect('login')->with('error', trans('messages.lbl_act_done_alrdy'));

        }
        
    }

    public function leaveretract()
    {
        $user = Auth::user();

        $cancel_applications = DB::table('leave_application_amendments')
                                     ->select('leave_application_amendments.*', 
                                              'leave_applications.date_from', 'leave_applications.date_to', 'leave_applications.status AS leavestatus',
                                              'leave_types.name AS ltype', 'leave_types.bg_color',
                                              'employees.name', 'employees.lname', 'employees.employee_no',
                                              'users.avatar')
                                     ->leftjoin('leave_applications', 'leave_applications.id', '=', 'leave_application_amendments.leave_id')
                                     ->leftjoin('leave_types', 'leave_types.id', '=', 'leave_applications.leave_type')
                                     ->leftjoin('employees', 'leave_application_amendments.employee_id', '=', 'employees.id')
                                     ->leftjoin('users', 'users.id', '=', 'employees.user_id')
                                     ->orderBy('leave_application_amendments.id', 'desc')
                                     ->get();

        /*Get approval status keys */
        $leave_stat = collect($this->leave_approval_status)->keys();
               
        return view('leave.leave_retract', compact('cancel_applications', 'leave_stat'));
    }

    public function approveLeaveCancel(Request $request)
    { 
        try{
            
            //DB::table('leave_application_amendments')->where('id', $request->id)->update(['status'=>$request->status]);
            DB::table('leave_application_amendments')->where('leave_id', $request->leave_id)->update(['status'=>$request->status]);
            if(1==$request->status){
                LeaveApplication::where('id', $request->leave_id)->update(['status'=>$this->leave_approval_status['cancelled']]);
            }
            
            return response()->json(1);
        }catch(\Exception $e){
            return response()->json(0);
        }
        
    }
    public function re_assign(Request $request)
    {
        $user = Auth::user();

        $dateFrom = new \DateTime($request->date_from);
        $dateTo = new \DateTime($request->date_to);
        $interval = $dateFrom->diff($dateTo);

        //Leave Application
        $existing_leave = LeaveApplication::findorfail($request->id);        
        $existing_leave->leave_type = $request->leaveType;
        $existing_leave->date_from = $request->date_from;
        $existing_leave->date_to = $request->date_to;
        $existing_leave->reason = (null!=$request->reason) ? $request->reason : $existing_leave->reason;
       // $existing_leave->status = $request->status;
        $existing_leave->no_days = $interval->days + 1;
        if($request->leaveType == 6 || $request->leaveType == 10 ){
            if($request->startTime != null){
                $existing_leave->time_from = $request->startTime;
            }
            if($request->endTime != null){
                $existing_leave->time_end = $request->endTime;
            }
        }else{
            $existing_leave->time_from = null;
            $existing_leave->time_end = null;
        }
        $existing_leave->paid_status = (11!=$request->leaveType) ? $request->paid_status : 1;
        $existing_leave->save();

        // Leave Application change
        $change_application = new LeaveApplicationChanges;
        $change_application->leave_type = $request->leaveType;
        $change_application->employee_id = $existing_leave->employee_id;
        $change_application->date_from = $request->date_from;
        $change_application->date_to = $request->date_to;
        $change_application->no_days = $interval->days + 1;
        $change_application->reason = (null!=$request->reason) ? $request->reason : $existing_leave->reason;
        $change_application->changed_by =  $user->id;
        $change_application->leave_application_id = $existing_leave->id;
        $change_application->save();

        return response()->json();
    }

    public function add_leave(Request $request)
    {
        $user = Auth::user();
        $dateFrom = new \DateTime($request->date_from);
        $dateTo = new \DateTime($request->date_to);
        $interval = $dateFrom->diff($dateTo);

        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'leave_type' => 'required',
            'date_from' => 'required',
            'date_to' => 'required'
        ]);

        if ($validator->fails()) {
            return trans('messages.validation_err_text');
        }
        
        try{

            $employee = Employees::find($request->employee_id);
           
            /*if($employee->department != 2) {
                $vpRole = Role::where('name', VP_ROLE)->first();
                $user_id = User::role($vpRole)->first();
                $role_ids = $user_id->id;
            }else{
                $exAdRole = Role::where('name', EXAD_ROLE)->first();
                $user_id = User::role($exAdRole)->first();
                $role_ids = $user_id->id;
            } */    
            
            $hrRole = Role::where('name', HR_ROLE)->first();
            $user_id = User::role($hrRole)->first();
            $role_ids = $user_id->id;

            $filename = NULL;
            if ($request->hasFile('attachment')) {
                $validator = Validator::make($request->all(), [
                    'attachment' => 'mimes:jpg,jpeg,png,pdf,docx,xlsx|max:1024',
                ]);
    
                if ($validator->fails()) {
                    return trans('messages.file_upload_type');
                }                
                $filename = fileUpload([$request->file('attachment')], 'uploads/employees/leave');
            }

            $leave_application = new LeaveApplication;
            $leave_application->employee_id = $request->employee_id;
            $leave_application->leave_type = $request->leave_type;
            $leave_application->date_from = $request->date_from;
            $leave_application->date_to = $request->date_to;
            $leave_application->reason = $request->reason;
            $leave_application->no_days = $interval->days + 1;
            if($request->leave_type == 6 || $request->leave_type == 10 ){
                if($request->time_from != null){
                    $leave_application->time_from = $request->time_from;
                }
                if($request->time_end != null){
                    $leave_application->time_end = $request->time_end;
                }
            }else{
                $leave_application->time_from = null;
                $leave_application->time_end = null;
            }
            $leave_application->attachment = $filename;
            $leave_application->forward_from = $request->employee_id;
            $leave_application->forward_to = $role_ids;
            $leave_application->created_by = $user->id;
            $leave_application->updated_by = $user->id;
            $leave_application->academic_year = $this->academic_year;
            $leave_application->paid_status = (11!=$request->leave_type) ? $request->paid_status : 1;
            
            $leave_application->save();

            $leave_status = LeaveApplicationStatus::create([
                'leave_id' => $leave_application->id,
                'applier_id' => $request->employee_id,
                'approver_id' => $role_ids,
                'leave_status' => $this->leave_approval_status['applied'],
                'assigned_to_role' =>1,
                'assigned_to_id' => 1,
                'comment'=> $request->reason ?? 'no comment',
                ]);

            /*Email notification to next approver*/
            $approver_data = User::where('id', $role_ids)
                                ->select('email')
                                ->first();

            $leave_app = LeaveApplication::with(['leavetypes'])->find($leave_application->id);
            $leave_type_name = $leave_app->leavetypes->name;

            Mail::send('emails.leave-request-notify', ['employee' => $employee->name.' '.$employee->lname, 'leave_type' => $leave_type_name, 'date_from'=> $request->date_from, 'date_to'=> $request->date_to ], function($message) use($approver_data,$employee,$leave_type_name){
                    $message->to($approver_data->email);
                    $message->subject(trans('messages.leave_rqst_notif').': '.$employee->name.' '.$employee->lname.'-'.$leave_type_name);
            });

            /*Mobile Push notification */
            $notif_data = new \stdClass();
            $notif = new AllNotification();
            $notif_data->title = trans('messages.leave_rqst_notif');
            $notif_data->body = trans('messages.leave_rqst_pndng');
            $notif_data->link = 'leaveapproval';

            $send_notif = $notif->sendPushNotifications($notif_data, $role_ids);

            return 1;

        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function deleteLeave(Request $request)
    {
        try{            
            $leaveData = LeaveApplication::findorfail($request->id);
            $leaveData->status = 9;
            $leaveData ->save();
            return response()->json(['message' => trans('messages.successO')], 200);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}