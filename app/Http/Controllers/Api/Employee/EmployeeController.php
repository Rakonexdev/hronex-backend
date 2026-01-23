<?php

namespace App\Http\Controllers\Api\Employee;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Employee\Employees;
use App\Models\Employee\EmployeeFiles;
use App\Models\Masters\Department;
use App\Models\Masters\Designation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee\HealthInformation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Notifications\Notifications;
use App\Models\Scf;
use App\Models\AppraisalReport;

class EmployeeController extends Controller
{
    public function show(int $id)
    {
        if ($id <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid ID'
            ], 422);
        }

        $user = User::with('employee', 'employee_emergency', 'employee_payroll_info', 'health_information')->find($id);
        $user->qr_data = enc_dec_data($id, 'enc');
        if(!$user->employee){
            return response()->json([
                "message"=>"dont have employee data"
                ], 404);
        }
        $user->temp_id = $user->employee->employee_no; //employeeIdMaker($user->employee->id);
        if(NULL!=$user->employee->relevant_degree && ''!=$user->employee->relevant_degree && 0!=$user->employee->relevant_degree){
            $relevantDegreeData = \DB::table('relevant_degree')->select('name', 'description')
                                    ->where('id', $user->employee->relevant_degree)->first();
            $user->employee->relevant_degree_data = $relevantDegreeData;
        }else{
            $user->employee->relevant_degree_data = '';
        }

        $country_data = \DB::table('countries')->select('country_name')
                        ->where('id', $user->employee->nationality)->first();
        $user->employee->nationality = $country_data ? $country_data->country_name : '';

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $avatar_url = asset('uploads/users/profile/' . $user->avatar);

        $user->avatar = $user->avatar ? $avatar_url : null;

        if ($user->employee && $user->employee->other_qualifications) {
            $user->employee->other_qualifications = unserialize($user->employee->other_qualifications);
        }

        if ($user->health_information && $user->health_information->mental_details) {
            $user->health_information->mental_details = unserialize($user->health_information->mental_details);
        }

        if ($user->health_information && $user->health_information->physical_details) {
            $user->health_information->physical_details = unserialize($user->health_information->physical_details);
        }

        if ($user->employee && $user->employee->department) {
            $department = Department::find($user->employee->department);
            if ($department) {
                $departmentName = $department->name;
                $user->employee->department = $departmentName;
            }
        }

        if ($user->employee && $user->employee->designation) {
            $designation = Designation::find($user->employee->designation);
            if ($designation) {
                $designationName = $designation->name;
                $user->employee->designation = $designationName;
            }
        }
        $scf = Scf::where('employee_id',$user->employee->employee_id)->pluck('pip_required')->first();
        $appraisal = AppraisalReport::where('employee_id',$user->employee->employee_id)->latest()->pluck('evaluation_date')->first();
        // $user->prf_avaliable = $user->employee->joiningdate;
        $currentDate = Carbon::now();

        $joiningDate = Carbon::parse($user->employee->joiningdate);
        $diffInYears = $currentDate->diffInYears($joiningDate);

        $appraisal_date = Carbon::parse($appraisal);
        $diffInappraisal = $currentDate->diffInYears($appraisal_date);
        //dd($diffInYears);
        // Check if the difference is more than 1 year
       if ($diffInYears >= 1) {
            $user->employee->prf_avaliable = 0;
        } else {
            $user->employee->prf_avaliable = 1;
        }
        //appraisal
        if($diffInYears >= 1){
            $user->employee->appraisal_avaliable = 1;
        }else{
            $user->employee->appraisal_avaliable = 0;
        }
        
        if(!$scf){
            $user->employee->pip_avaliable = null;
        }else{
          $user->employee->pip_avaliable = 1 ;  
        }
        
        $user->employee->age = $user->employee->age? Carbon::parse($user->employee->dob)->diff(date('Y-m-d'))->format('%y') : '';

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function employeeDocumentold(int $id)
    {
        try {
            $user = User::with('employee_emergency', 'employee_payroll_info', 'health_information')->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ], 404);
        }

        $attachments = [
            'qid_attaches' => $user->employee->qid_attaches ?? null,
            'passport_attaches' => $user->employee->passport_attaches ?? null,
            'hmc_card_atch' => $user->health_information->hmc_card_atch ?? null,
            'health_insurance_atch' => $user->health_information->health_insurance_atch ?? null,
            'bank_docs' => $user->employee_payroll_info->bank_docs ?? null,
            'degree_attaches' => $user->employee->degree_attaches ?? null,
            'disclaimer_ltr_moe_atch' => $user->employee->disclaimer_ltr_moe_atch ?? null,
            'declaration_ltr_moe_atch' => $user->employee->declaration_ltr_moe_atch ?? null,
            'police_clearance_atch' => $user->employee->police_clearance_atch ?? null,
            'experience_letter_atch' => $user->employee->experience_letter_atch ?? null,
        ];

        return response()->json([
            'success' => true,
            'data' => $attachments
        ]);
    }

    public function employeeDocument(int $id)
    {
        try {

            $attachments = EmployeeFiles::where('user_id', $id)->get();
            if(!empty($attachments)){
                foreach ($attachments as $eachfl) {
                    $eachfl->file_data = (is_array($eachfl->file_data)) ? $eachfl->file_data : unserialize($eachfl->file_data);
                }
            }
            return response()->json([
                'success' => true,
                'data' => $attachments
            ]);

        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.errorCom')
            ], 404);
        }        
    }

    public function employeeDocExpiries(int $id)
    {
        try {

            $expiries = Employees::where('user_id', $id)->select('qidexpiry','passportexpiry')->get();            
            return response()->json([
                'success' => true,
                'data' => $expiries
            ]);

        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => trans('messages.errorCom')
            ], 404);
        }        
    }


    public function healthInfoUpdate(Request $request, $id)
    {
        // if (!Auth::user()->hasRole('Employee') || Auth::user()->hasRole('Super-Admin')) {
        //     return response()->json([
        //         'message' => 'Health Information is only accessible to employees.'
        //     ], 403);
        // }

        // $validated_data = $request->validate(HealthInformation::$rules);

        try {
            $health_info = HealthInformation::where('user_id', $id)->firstOrFail();
            if (!$health_info) {
                return response()->json([
                    'message' => 'Unable to find health information'
                ], 404);
            }
            $validated_data['mental_details'] = serialize($request->mental_details);
            $validated_data['physical_details'] = serialize($request->physical_details);
            $health_info->update($validated_data);

            return response()->json([
                'message' => 'Health information updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function healthInfoStore(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'hmc_card_no' => 'nullable|string|max:50',
            'hmc_card_atch' => 'nullable|string|max:200',
            'health_insurance_status' => 'nullable|string|max:25',
            'health_insurance_atch' => 'nullable|string|max:200',
            'health_insurance_name' => 'nullable|string|max:100',
            'blood_group' => 'nullable|string|max:50',
            'medical_ailment_physical' => 'nullable|string|max:25',
            'physical_details' => 'nullable|string',
            'medical_ailment_mental' => 'nullable|string|max:25',
            'mental_details' => 'nullable|string',
            'medication_details' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $employeeHealthInfo = HealthInformation::create($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Employee health information stored successfully.',
                'data' => $employeeHealthInfo
            ], 201);

        } catch (\Exception $e) {
            // If an error occurs, return an error response with a detailed message
            return response()->json([
                'error' => true,
                'message' => 'Failed to store employee health information. ' . $e->getMessage()
            ], 500);
        }
    }

    public function notification($id)
    {

        return response()->json(['data'=>$id]);
    }

    public function currentUpdates()
    {
        try {

            $ids = [Auth::user()->id, 0];
            $data = NULL;            

            $notifs = Notifications::whereNull('read_at')->whereIn('notifiable_id', $ids)->get();  
            if(!$notifs->isEmpty()){
                foreach($notifs as $eachnotif){
                    $ntfs = new \stdClass(); 
                    $ntfs->id = $eachnotif->id;
                    $ntfs->title = $eachnotif->title;  
                    $ntfs->data = $eachnotif->data;
                    $ntfs->title_date = $eachnotif->title_date;
                    $ntfs->type = $eachnotif->type;
                    $ntfs->notify_to = (0==$eachnotif->notifiable_id) ? 'All' : Auth::user()->name;
                    $data[] = $ntfs;

                    /*$eachnotif->read_at = date('Y-m-d H:i:s');
                    $eachnotif->save();*/
                }
            }          
            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() /*trans('messages.errorCom')*/
            ], 404);
        }        
    }

    public function updateNotifRead(Request $request)
    {
        try {
            $notifs = Notifications::whereNull('read_at')->where('id', $request->notify_id)->first(); 
            $notifs->read_at = date('Y-m-d H:i:s');
            $notifs->save();

            return response()->json([
                'success' => true                
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false
            ], 404);
        }
    }

    public function list()
    {
        $list = Employees::select('id','user_id','name','lname','employee_no')
                           ->where('status', 1)
                           ->get();

        return response()->json([
            'success' => true,
            'data' => $list
        ], 200);
    }

    public function update_avatar(Request $request)
    {
        try { 

            $request->validate([
                'avatar' => 'required|mimes:png,jpg,jpeg,webp|max:2048'
            ]);

            if ($request->hasFile('avatar'))
                $avatar =  fileUpload([$request->avatar], 'uploads/users/profile');
            else 
                $avatar = 'avatar.png';

            $user = User::where('id', Auth::user()->id)
            ->update([
                'avatar' => $avatar
            ]);
            
            return response()->json([
                'message' => trans('messages.successU'),
                'avatar' => $avatar,
            ], 201);            

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);
        }
    }
    
}