<?php

namespace App\Http\Controllers\Employee;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee\Employees;
use App\Models\Employee\EmployeeStatus;
use App\Models\Employee\EmployeeFiles;
use App\Models\Employee\EmployeePayrollInformation;
use App\Models\Masters\Department;
use Illuminate\Support\Facades\DB;
use App\Models\Masters\Designation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HrmController;

use App\Exports\UserExport;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Mail\AllEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AllNotification;


class EmployeesController extends HrmController
{
    public function index(Request $request)
    {
        $currentDate = date('Y-m-d'); 
        $expiryDate = Carbon::parse($currentDate)->addDays(30);

        $employees = Employees::with(['employeeStatus' => function ($query) {
                                        $query->orderBy('id', 'desc')->take(1);
                                    }])
                    ->select('employees.*', 'user.avatar as avatar', 'desig.name as designation_name', 'desig.id as designation_id', 'depar.id as department_id', 'depar.name as department_name')
                    ->leftJoin('designations as desig', 'employees.designation', '=', 'desig.id')
                    ->leftJoin('departments as depar', 'employees.department', '=', 'depar.id')
                    ->leftJoin('users as user', 'employees.user_id', '=', 'user.id')
                    ->where('employees.status', '=', 1)
                    ->where(function($query) use($currentDate, $expiryDate, $request){
                        if($request->has('type') && 'QE'==$request->type){
                            //$query->whereBetween('qidexpiry', [$currentDate, $expiryDate]);
                            $query->where('qidexpiry', '<=', $expiryDate);
                        }else if($request->has('type') && 'PE'==$request->type){
                            //$query->whereBetween('passportexpiry', [$currentDate, $expiryDate]);
                            $query->where('passportexpiry', '<=', $expiryDate);
                        }
                    })
                    ->orderByRaw("CASE 
                                WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                ELSE employees.employee_no END")
                    ->orderBy('employees.employee_no')
                    ->get();        
        return view('employee.onboarding', compact('employees','request'));
    }

    public function inactive(Request $request)
    {
        $employees = Employees::with(['employeeStatus' => function ($query) {
                                        $query->orderBy('id', 'desc')->take(1);
                                    }])
                    ->select('employees.*', 'user.avatar as avatar', 'desig.name as designation_name', 'desig.id as designation_id', 'depar.id as department_id', 'depar.name as department_name')
                    ->leftJoin('designations as desig', 'employees.designation', '=', 'desig.id')
                    ->leftJoin('departments as depar', 'employees.department', '=', 'depar.id')
                    ->leftJoin('users as user', 'employees.user_id', '=', 'user.id')
                    ->orderByRaw("CASE 
                                WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                ELSE employees.employee_no END")
                    ->orderBy('employees.employee_no')
                    ->where('employees.status', '=', 0)
                    ->get();        
        return view('employee.onboarding', compact('employees','request'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $docs = new \stdClass();        

        $data = Employees::with(['employeeStatus' => function ($query) {
                                        $query->orderBy('id', 'desc')->take(1);
                                    }])
        ->leftJoin('employee_emergency_details', 'employees.user_id', '=', 'employee_emergency_details.user_id')
        ->leftJoin('designations', 'employees.designation', '=', 'designations.id')
        ->leftJoin('users', 'employees.user_id', '=', 'users.id')
        ->leftJoin('departments', 'employees.department', '=', 'departments.id')
        ->leftJoin('school_shift', 'employees.school_shift', '=', 'school_shift.id')
        ->leftJoin('contract_type', 'employees.contract_type', '=', 'contract_type.id')
        ->leftJoin('countries', 'employees.nationality', '=', 'countries.id')
        ->leftJoin('sponsorship_status', 'employees.sponsorship_status', '=', 'sponsorship_status.id')
        ->leftJoin('relevant_degree', 'employees.relevant_degree', '=', 'relevant_degree.id')
        ->leftJoin('employee_payroll_informations', 'employees.user_id', '=', 'employee_payroll_informations.user_id')
        ->leftJoin('employee_health_informations', 'employees.user_id', '=', 'employee_health_informations.user_id')
        ->leftJoin('relationship', 'employee_emergency_details.relationship_primary', '=', 'relationship.id')
        ->leftJoin('relationship as relationship_secondary', 'employee_emergency_details.relationship_secondary', '=', 'relationship_secondary.id')        
        ->select(
            'employees.*',
            'employees.user_id as userid',
            'employee_emergency_details.*',
            'designations.name as designation_name',
            'departments.name as department_name',
            'school_shift.name as shift_name',
            'contract_type.name as contract_type_name',
            'sponsorship_status.name as sponsorship_status_name',
            'relevant_degree.name as relevant_degree_name',
            'relationship.name as relationship_primary_name',
            'relationship_secondary.name as relationship_secondary_name',
            'countries.*',
            'employee_payroll_informations.*',
            'employee_health_informations.*',
            'users.avatar'            
        )
        ->where('employees.user_id', '=', $id)->first();
            // return $employees;
        // return $employees;
        if (!$data) {
            return redirect('employees');
        }
        
        $employeeFiles = EmployeeFiles::where('user_id', $data->userid)->get();
        $data->employeeFiles = $employeeFiles; 

        /*Set all docs in single*/
        $docs->qid_attaches = $data->qid_attaches;
        $docs->passport_attaches = $data->passport_attaches;
        $docs->degree_attaches = $data->degree_attaches;
        $docs->disclaimer_ltr_moe_atch = $data->disclaimer_ltr_moe_atch;
        $docs->declaration_ltr_moe_atch = $data->declaration_ltr_moe_atch;
        $docs->police_clearance_atch = $data->police_clearance_atch;
        $docs->experience_letter_atch = $data->experience_letter_atch;
        $docs->bank_docs = $data->bank_docs;
        $docs->hmc_card_atch = $data->hmc_card_atch;
        $docs->health_insurance_atch = $data->health_insurance_atch;
        $docs->inactive_attachment = (null!=$data->employeeStatus)?$data->employeeStatus->inactive_attachment:NULL;

        return view('employee.employees_profile', ['data' => $data, 'attaches' =>$docs]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    { 
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'designation' => 'nullable|max:255',
            'department' => 'nullable|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $user = User::findOrFail($id);
            $user->name = $request->name .' '. $request->lname;
            if ($request->avatar) {
                $user->avatar = fileUpload([$request->avatar], 'uploads/users/profile');
            }
            $user->save();

            $employee = Employees::where('user_id', $id)->first();
            $employee->name = $request->name;
            $employee->lname = $request->lname;
            $employee->designation = $request->designation;
            $employee->department = $request->department;
            $employee->save();
            return redirect()->back()->with('success', trans('messages.successU'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', trans('messages.errorU'));
        }
    }


    public function destroy($id)
    {
        $user = Employees::where('user_id', $id)->findOrfail();
        $user->delete();
        return redirect()->back()->with('success', trans('messages.successD'));
    }

    public function search(Request $request)
    {
        $currentDate = date('Y-m-d'); 
        $expiryDate = Carbon::parse($currentDate)->addDays(30);

        $employees = Employees::with(['employeeStatus' => function ($query) {
                                        $query->orderBy('id', 'desc')->take(1);
                                    }])
            ->select('employees.*', 'user.avatar as avatar', 'desig.name as designation_name', 'desig.id as designation_id', 'depar.id as department_id', 'depar.name as department_name')
            ->leftJoin('designations as desig', 'employees.designation', '=', 'desig.id')
            ->leftJoin('departments as depar', 'employees.department', '=', 'depar.id')
            ->leftJoin('users as user', 'employees.user_id', '=', 'user.id')
            ->when((int) $request->input('emp_id'), function($query, $emp_id) {
                return $query->where('employees.employee_no', 'like', '%'.$emp_id.'%');
            })
            ->when((String) $request->input('emp_name'), function($query, $name) {
                $names = explode(' ', $name);
                if(count($names) == 2) {
                    return $query->where('employees.name', 'like', '%'.$names[0].'%')
                                 ->where('employees.lname', 'like', '%'.$names[1].'%');
                } else {
                    return $query->where(function($query) use ($names) {
                        foreach($names as $name) {
                            $query->orWhere('employees.name', 'like', '%'.$name.'%')
                                  ->orWhere('employees.lname', 'like', '%'.$name.'%');
                        }
                    });
                }
            })
            ->when($request->input('department'), function($query, $department) {
                return $query->where('depar.id', '=', $department);
            })
            ->when($request->input('doj'), function($query, $doj) {
                return $query->whereDate('employees.joiningdate', '=', $doj);
            })            
            ->orderByRaw("CASE 
                                WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                ELSE employees.employee_no END")
                    ->orderBy('employees.employee_no')
            ->get();

        if ($employees->isEmpty()) {
            return redirect('employees')->with('error', 'No matching records found.');
        } else {
            return view('employee.onboarding', compact('employees','request'));
        }
    }

    public function filter(Request $request)
    {  
        $employees = Employees::with(['employeeStatus'])
            ->select('employees.*', 'user.avatar as avatar', 'desig.name as designation_name', 'desig.id as designation_id', 'depar.id as department_id', 'depar.name as department_name')
            ->leftJoin('designations as desig', 'employees.designation', '=', 'desig.id')
            ->leftJoin('departments as depar', 'employees.department', '=', 'depar.id')
            ->leftJoin('users as user', 'employees.user_id', '=', 'user.id')
            ->where('employees.status', $request->statusval)
            ->orderBy('employees.joiningdate', $request->filterjd)
            ->get();

        if ($employees->isEmpty()) {
            return redirect('employees')->with('error', 'No matching records found.');
        } else {
            return view('employee.onboarding', compact('employees','request'));
        }
    }

    public function getEmployeeName($id) {
        try {
            $user = Employees::where('employee_id', $id)->first();
    
            if ($user->department) {
                $department = Department::find($user->department);
                if ($department) {
                    $departmentName = $department->name;
                    $user->department = $departmentName;
                }
            }
    
            if ($user->designation) {
                $designation = Designation::find($user->designation);
                if ($designation) {
                    $designationName = $designation->name;
                    $user->designation = $designationName;
                }
            }
            return $user;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function bulkimport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx',
        ]);

        try{
            $file = $request->file('file');

            $validator = Validator::make(
              [
                  'file'      => $request->file,
                  'extension' => strtolower($request->file->getClientOriginalExtension()),
              ],
              [
                  'file'          => 'required',
                  'extension'      => 'required|in:csv,xlsx,xls',
              ]
            );            
        
            $rows = Excel::import(new UserImport, $file);

            return redirect()->back()->with('success', trans('messages.successO'));  
        }catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }  
    }

    public function statusUpdate(Request $request)
    {
        $validate = $request->all();
        $employee = Employees::where('employee_id', $request->employee_id)->first();       
        $validate['user_id'] = $employee->user_id;
        $validate['created_by'] = Auth::user()->id;
        
        $data = Validator::make($validate, EmployeeStatus::$rules);
        if ($data->fails()) {
            return redirect()->back()->withErrors($data)->withInput();
        }

        $employee_status = EmployeeStatus::where('employee_id', $request->employee_id)
                                           ->orderBy('id', 'desc')->first();
        if($employee_status){
            if($request->current_status == $employee_status->current_status){
                return redirect()->back()->with('success', trans('messages.successO'));
            }

            if(null==$employee_status->inactive_attachment){
                $validate['inactive_attachment'] = (null!=$request->inactive_attachment) ? fileUpload([$request->inactive_attachment], 'uploads/employees/inactive') : '';
            }else{
                $validate['inactive_attachment'] = $employee_status->inactive_attachment;
            } 
        }else{
            $validate['inactive_attachment'] = $request->inactive_attachment ? fileUpload([$request->inactive_attachment], 'uploads/employees/inactive') : null;
        }   

        try{   

            $employeeStatus = new EmployeeStatus;
            $employeeStatus->create($validate);
            
            $employee->status = $request->current_status;
            $employee->save();

            /*Add attachment to employee files table*/
            if(null!=$validate['inactive_attachment'] && ''!=$validate['inactive_attachment']){
                $attch = $validate['inactive_attachment'];
                $attch_file = [$attch];
                $employeeFiles = new EmployeeFiles;
                $employeeFiles->user_id = $employee->user_id;
                $employeeFiles->file_type = 'inactive';
                $employeeFiles->file_path = 'uploads/employees/inactive';
                $employeeFiles->file_data = $attch_file;
                $employeeFiles->created_by = Auth::user()->id;
                $employeeFiles->updated_by = 0;
                $employeeFiles->save();
            }

            return redirect('employees')->with('success', trans('messages.successO'));
        }catch (\Exception $e) {
            return redirect('employees')->with('error', trans('messages.errorCom') );
        }  
    }


    /*Employee onboarding new*/
    public function saveEmployeeMainData(Request $request)
    { 
        if(0 == $request->user_id){           
            $validator = Validator::make($request->all(), Employees::$main_rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'type' =>'validation',
                    'errors' => $validator->errors(),
                ], 422);
            }
        }

        try {  
            
            if(0 == $request->user_id){

                /*Create User data first*/
                $user = new User();
                $user->name = $request->name.' '.$request->lname;
                $user->email = $request->email;
                $user->password = Hash::make(123456);
                /*$user->avatar = $request->avatar ? fileUpload([$request->avatar]) : 'avatar.png';*/
                if ($request->avatar) {
                    $user->avatar = fileUpload([$request->avatar], 'uploads/users/profile');
                }
                $user->save();
                $user_id = $user->id;

            }else{
                $user_id = $request->user_id;
                $user = User::find($user_id);
                $user->name = $request->name.' '.$request->lname;
                $user->email = $request->email;
                if ($request->avatar) {
                    $user->avatar = fileUpload([$request->avatar], 'uploads/users/profile');
                }   
                $user->save();
            }

            // Add/Update the main data to the employee table        
            $formData = Employees::updateOrCreate([                    
                                'user_id' => $request->user_id,
                            ], 
                            [
                                'user_id' => $user_id,
                                'employee_id' => $request->employee_id,
                                'employee_no' => $request->employee_no,
                                'employee_type' => '',
                                'name' => $request->name,
                                'lname' => $request->lname,
                                'dob' => $request->dob,
                                'age' => $request->age,
                                'gender' => $request->gender,
                                'nationality' => $request->nationality,
                                'email' => $request->email,
                                'marital_status' => $request->marital_status,
                                'qidno' => $request->qidno,
                                'qidexpiry' => $request->qidexpiry,
                                'passportno' => $request->passportno,
                                'passportexpiry' => $request->passportexpiry,
                                'mobile1' => $request->mobile1,
                                'mobile1_code' => getCountry('phone_code', 182), /*getCountry('phone_code', $request->nationality),*/
                                'mobile2' => $request->mobile2,
                                'mobile2_code' => getCountry('phone_code', 182), /*getCountry('phone_code', $request->nationality),*/
                            ]);        
            

            if ($formData) {
                //Fetch employee data using user id and update employee_id field by id field in the employee table 
                $employee = Employees::where('user_id', $user_id)->select('id')->first();
                $employee->employee_id = $employee->id;
                $employee->save();
                
                return response()->json([
                    'status' => 'success',
                    'mode' => $request->user_id,
                    'type' => 'M',
                    'message' => trans('messages.successO'),
                    'user_id' => $formData->user_id
                ]);
            }

            return response()->json([
                'status' => 'error',
                'type' =>'saving-error',
                'message' => trans('messages.errorCom'),
            ], 500);

        }catch (\Exception $e) {
           return response()->json([
                'status' => 'error',
                'type' => 'exception',
                'message' => /*trans('messages.errorCom')*/ $e->getMessage(),
            ], 500);
        } 
    }

    public function saveEmployeeOtherData(Request $request)
    {
        $validator = Validator::make($request->all(), Employees::$other_rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'type' => 'validation',
                'errors' => $validator->errors(),
            ], 422);
        } 

        try {            
            
            // Save the other data to the employee table
            $formData = Employees::where('user_id', $request->user_id)
                        ->update([
                                    'school_shift' => $request->school_shift,
                                    'joiningdate' => $request->joiningdate, 
                                    'department' => $request->department, 
                                    'designation' => $request->designation, 
                                    'end_probation' => $request->end_probation, 
                                    'contract_type' => $request->contract_type, 
                                    'contract_length' => $request->contract_length, 
                                    'end_contract' => $request->end_contract, 
                                    'service_years' => $request->service_years,
                                    'sponsorship_status' => $request->sponsorship_status, 
                                    'relevant_degree' => $request->relevant_degree, 
                                    'degree_details' => $request->degree_details,
                                    'degree_attest_status' => $request->degree_attest_status,                    
                                    'other_qualifications' => (count(array_filter($request->other_qualifications))>0)?serialize($request->other_qualifications):NULL, 
                                    'disclaimer_ltr_moe' => $request->disclaimer_ltr_moe, 
                                    'declaration_ltr_moe' => $request->declaration_ltr_moe, 
                                    'hrcomment' => $request->hrcomment
                                ]); 

            if ($formData) {

                /*Role assigning to new users*/
                $user = User::find($request->user_id);

                if(2 != $request->department){
                    $user->assignRole('Employee');
                }else{
                    if(16 == $request->designation){
                        $user->assignRole('Principal');
                    }else if(17 == $request->designation){
                        $user->assignRole('Vp');
                    }else if(20 == $request->designation){
                        $user->assignRole('Accounts');
                    }else if(22 == $request->designation){
                        $user->assignRole('Hr');
                    }else if(26 == $request->designation){
                        $user->assignRole('Executive-Admin');
                    }
                } 

                /*Send email confirmation to user/employee*/
                $user_data = User::where('id', $request->user_id)
                                   ->select('email')
                                   ->whereNull('email_verified_at')
                                   ->first();

                if($user_data){
                    $token = Str::random(64);       
                    DB::table('password_resets')->insert([
                        'email' => $user_data->email,
                        'token' => $token,
                        'created_at' => Carbon::now()
                    ]); 
                    
                    $token = $token."_mail_".$user_data->email;
                    Mail::send('emails.user_create', ['token' => $token], function($message) use($user_data){
                        $message->to($user_data->email);
                        $message->subject(trans('messages.onboard_email_subj'));
                    });

                    /*Mail::to($user_data->email)->send(new AllEmail($user_data,$subject,$body));*/
                }

                return response()->json([
                    'status' => 'success',
                    'mode' => 1,
                    'type' => 'O',
                    'message' => trans('messages.successO'),
                ]);

                return response()->json([
                    'status' => 'success',
                    'mode' => 1,
                    'type' => 'O',
                    'message' => trans('messages.successO'),
                ]);
            }

            return response()->json([
                'status' => 'error',
                'type' => 'saving-error',
                'message' => trans('messages.errorCom'),
            ], 500);

        }catch (\Exception $e) {
           return response()->json([
                'status' => 'error',
                'type' => 'exception',
                'message' => /*trans('messages.errorCom')*/$e->getMessage(),
            ], 500);
        } 
    }

    public function saveEmployeeFileData(Request $request)
    {
        try{
              
            $sfl = NULL;      
            $data = NULL;
            $fls = NULL;

            $form_data = $request->all();
            if(2 >= count($form_data)){
                return redirect()->back()->with('error', trans('messages.errorFlempty'));
            } 

            //Check duplicate files
            $flatArray = collect($form_data)->flatten(1)->all();
            $duplicates = collect($flatArray)->duplicates();
            if($duplicates->isNotEmpty()){
                return redirect()->back()->with('error', trans('messages.errorFldupe'));
            }

            foreach($form_data as $key => $attaches){
                if (!in_array( $key, array('_token', 'user_id') )){
                    if(is_array($attaches)){
                        $multifl = NULL;
                        foreach($attaches as $eachatt){
                            $multifl[] = fileUpload([$eachatt], 'uploads/employees/files');
                        }
                        $fls = json_encode($multifl);
                    }else{                        
                        $sfl = fileUpload([$attaches], 'uploads/employees/files');
                        $fls = json_encode([$sfl]);
                    } 

                    /*Remove existing attachments except the 'other' type*/
                    if('other' != $key){
                        $attachment = EmployeeFiles::where('user_id', $request->user_id)
                                                   ->where('file_type', $key)
                                                   ->first();
                        if($attachment){
                            /*Remove the file from the folder*/
                            foreach($attachment->file_data as $file){
                                $file_path = public_path('uploads/employees/files/'.$file);
                                if(File::exists($file_path)) {
                                    File::delete($file_path);
                                }
                            }
                            
                            $attachment->delete();  
                        }
                    }
                    
                    $data[] = [
                                "user_id" => $request->user_id,
                                "file_data" => $fls,
                                "file_type" => $key,
                                "file_path" => 'uploads/employees/files',
                                "created_by" => Auth::user()->id,
                                "updated_by" => 0
                            ];
                    $fls = NULL;       
                }             
            }            

            // Save the file data to the employee files table
            if(NULL != $data)
                $formData = EmployeeFiles::insert($data);

            if ($formData) {
                return redirect('employees')->with('success', trans('messages.successO'));
            }

        }catch (\Exception $e) {
           return redirect('employees')->with('error', trans('messages.errorCom'));
        } 
    }

    public function saveEmployeePayrollData(Request $request)
    {        
        $form_data = $request->all();
        $validator = Validator::make($form_data, EmployeePayrollInformation::$rules);

        if ($validator->fails()) { 
            return response()->json([
                'status' => 'error',
                'type' => 'validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {            

            // Add/Update the payroll data to the employee payroll table        
            $formData = EmployeePayrollInformation::updateOrCreate([                    
                                'user_id' => $request->user_id,
                            ], 
                            [
                                'user_id' => $request->user_id,
                                'basic_salary' => $request->basic_salary,
                                'accomodation_allowance' => $request->accomodation_allowance,
                                'transport_allowance' => $request->transport_allowance,
                                'continuous_allowance' => $request->continuous_allowance,
                                'temp_allowance' => $request->temp_allowance,
                                'other_allowance' => $request->other_allowance,
                                'gross_total' => $request->gross_total,
                                'salary_effective_from' => $request->salary_effective_from
                            ]); 

            if ($formData) {
                return response()->json([
                    'status' => 'success',
                    'mode' => $request->user_id,
                    'type' => 'P',
                    'message' => trans('messages.successO'),
                    'user_id' => $formData->user_id
                ]);
            }

            return response()->json([
                'status' => 'error',                
                'type' => 'saving-error',
                'message' => trans('messages.errorCom'),
            ]);

        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'type' => 'exception',
                'message' => trans('messages.errorCom'), /*$e->getMessage()*/
            ], 500);
        }
    }

    public function editEmployee($user_id)
    {
        $data = Employees::with([   'employeePayrollInformation' => function ($query) {
                                        $query->orderBy('id', 'desc')->take(1);
                                    },
                                    'emergencyDetails',
                                    'healthInformation',
                                    'employeeFiles',
                                    'user',
                                    'employeeStatus' => function ($query) {
                                        $query->orderBy('id', 'desc')->take(1);
                                    }
                                ])        
        ->leftJoin('designations', 'employees.designation', '=', 'designations.id')        
        ->leftJoin('departments', 'employees.department', '=', 'departments.id')
        ->leftJoin('school_shift', 'employees.school_shift', '=', 'school_shift.id')
        ->leftJoin('contract_type', 'employees.contract_type', '=', 'contract_type.id')
        ->leftJoin('countries', 'employees.nationality', '=', 'countries.id')
        ->leftJoin('sponsorship_status', 'employees.sponsorship_status', '=', 'sponsorship_status.id')
        ->leftJoin('relevant_degree', 'employees.relevant_degree', '=', 'relevant_degree.id') 
        ->select(
            'employees.*',
            'employees.user_id as userid',            
            'designations.name as designation_name',
            'departments.name as department_name',
            'school_shift.name as shift_name',
            'contract_type.name as contract_type_name',
            'sponsorship_status.name as sponsorship_status_name',
            'relevant_degree.name as relevant_degree_name',
            'countries.*'
        )
        ->where('employees.user_id', '=', $user_id)->first(); 

        if (!$data) {
            return redirect('employees');
        }

        if(null != $data->emergencyDetails){
            $data->primary_relation = DB::table('relationship')->select('name')->where('id', $data->emergencyDetails->relationship_primary)->first();
            $data->secondary_relation = DB::table('relationship')->select('name')->where('id', $data->emergencyDetails->relationship_secondary)->first();
        }else{
            $data->primary_relation = '';
            $data->secondary_relation = '';
        }

        $last_row = Employees::where('user_id', $user_id)->first();
        if(!empty($last_row))
            $last_id = $last_row->id;
        
        return view('employee.employees_information', compact('last_id', 'data') );
    }

    public function deleteFile(Request $request)
    { 
        try {           
            
            $attachment = EmployeeFiles::find($request->file_id);
            $file_data = $attachment->file_data;            

            /*Remove an item from the JSON data column*/            
            $key = array_search($request->file_item, $file_data);
            if ($key !== false) {
                unset($file_data[$key]);
            }else{
                return response()->json(['message' => trans('messages.errorCom')], 500);
            }         
            $attachment->file_data = $file_data;
            $attachment->save(); 

            /*Get file path before the row deletion, for remove it from the folder*/
            $filePath = $attachment->file_path.'/'.$request->file_item;          

            // Delete the attachment row from db [if no file against it's json column].            
            if(0 >= count($attachment->file_data))
                $attachment->delete();

            /*Delete file from the storage itself*/            
            if (File::exists(public_path($filePath))) {
                File::delete(public_path($filePath));
            }

            return response()->json(['message' => trans('messages.successO')], 200);

        }catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500); /*trans('messages.errorCom')*/
        }        
    }

    public function showFiles($user_id)
    {
        $data = new \stdClass();
        $data->employeeFiles = EmployeeFiles::where('user_id', $user_id)->get(); 
       
        return view('employee.partials.attaches', compact('data'));
    }  

    public function alertsToNotify()
    {
        try {

            /*Notification area*/              
            $notif = new AllNotification();

            /*For Passport/Qid expire[before 30 days] notifications*/
            $doc_expires = getExpireDocData();
            
            if($doc_expires->isNotEmpty()){
                foreach($doc_expires as $eachnt){ 
                    $pass = (null!=$eachnt->passportexpiry) ? $this->notification_list[5].' Expiry:'.$eachnt->passportexpiry." " : '';
                    $qid = (null!=$eachnt->qidexpiry) ? $this->notification_list[6].' Expiry:'.$eachnt->qidexpiry : '';
                    $expiry_data = $pass.' '.$qid;

                    $notifdata = [
                           'type' => $this->notification_list[7],
                           'notifiable_type' => 'App\Models\Employee\Employees', 
                           'notifiable_id' => $eachnt->user_id, 
                           'title' => $eachnt->name.' '.$eachnt->lname, 
                           'data' => $expiry_data      
                    ]; 

                    $notifs = $notif->addnotifications($notifdata);  
                }            
            }

            /*For profile un-complete[ 5 days after the account creation ] notifications*/
            $profile_uncomplete = getProfileUncompleteData();

            if($profile_uncomplete->isNotEmpty()){
                foreach($profile_uncomplete as $eachnt){  
                    $notifdata = [
                           'type' => $this->notification_list[4],
                           'notifiable_type' => 'App\Models\Employee\Employees', 
                           'notifiable_id' => $eachnt->user_id, 
                           'title' => $eachnt->name.' '.$eachnt->lname, 
                           'data' => trans('messages.warn_prfl_incmplt')      
                    ]; 

                    $notifs = $notif->addnotifications($notifdata);  
                }    
            }

            return response()->json(['message' => trans('messages.successO')]);
        }catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage() /*trans('messages.errorCom')*/]);
        }     
    }

}