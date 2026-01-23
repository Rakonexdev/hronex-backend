<?php

namespace App\Http\Controllers\Appraisal;

use App\Models\Appraisal;
use App\Models\AppraisalReport;
use Illuminate\Http\Request;
use App\Http\Controllers\HrmController;
use App\Models\Employee\Employees;
use App\Models\Masters\Appraisal_datas;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Svg\Tag\Rect;
use Illuminate\Database\Eloquent\Builder;
use App\Models\PipAppraisalReports;
use function PHPSTORM_META\type;

class AppraisalController extends HrmController
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = auth()->user();
        $role = $user->role;
        $one_year = Carbon::now()->subYear()->format('Y-m-d');
        if($user->hasRole('Principal') || $user->hasRole('Hr') || $user->id ==1){
            $employees = Employees::with(['designations','departments','appraisalreprot'=>function($query) {
                $query->latest(); 
            }
            ])
            ->whereNotNull('joiningdate')
            ->whereNotNull('department')
            ->whereNotNull('designation')
            ->where('employees.status', '=', 1)
            ->where('joiningdate', '<=', $one_year)
            ->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")
            ->orderBy('employees.employee_no')
            ->get();
        // dd($employees);
        }
        if($user->hasRole('Vp')){
            $employees = Employees::with(['designations','departments','appraisalreprot'=>function($query) {
                                    $query->latest(); 
                                }
                                ])
                                ->whereNotNull('joiningdate')
                                ->whereNotNull('department')
                                ->whereNotNull('designation')
                                ->where('employees.status', '=', 1)
                                ->where('employees.department', '=', 1)
                                ->where('joiningdate', '<=', $one_year)
                                ->orderByRaw("CASE 
                                            WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                            ELSE employees.employee_no END")
                                ->orderBy('employees.employee_no')
                                ->get();
            
        }
        if($user->hasRole('Executive-Admin')){
            $employees = Employees::with(['designations','departments','appraisalreprot'=>function($query) {
                                    $query->latest(); 
                                }
                                ])
                                ->whereNotNull('joiningdate')
                                ->whereNotNull('department')
                                ->whereNotNull('designation')
                                ->where('employees.status', '=', 1)
                                ->where('employees.department', '=', 2)
                                ->where('joiningdate', '<=', $one_year)
                                ->orderByRaw("CASE 
                                            WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                            ELSE employees.employee_no END")
                                ->orderBy('employees.employee_no')
                                ->get();
        }
        return view('appraisal.performance_appraisal',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function appraisalField($id = null){
        $user =  auth()->user();
        
		if($id !=null){
			$appraisalReport 	= AppraisalReport::find($id);
          
		}
		else{
			$appraisalReport	= new AppraisalReport();
		}

        $appraisal_datas = Appraisal_datas::all();
        if($user->hasRole(HR_ROLE) || $user->hasRole('Executive-Admin')) {
            $hod_ratings = request('hod_rating');
            $hod_ratings_competencies = [];
            $hod_ratings_characteristics = [];
            foreach ($hod_ratings as $index => $hod_rating) {

               // $principal_rating = request('principal_rating.' . $index);
                $principal_rating = null;
                $type = request('type.' . $index);
               
                $applicable_to = request('applicable_to.' . $index);
            
                if ($type == "COMPETENCIES (Ratings and Weightages entered by Appraiser)") {
                    // Add hod_rating to $hod_ratings_competencies array
                    if (!is_null($hod_rating)) {
                        $hod_ratings_competencies[] = $hod_rating;
                    }
                    
                    // Add principal_rating to $principal_ratings_competencies array
                    if (!is_null($principal_rating)) {
                        $principal_ratings_competencies[] = $principal_rating;
                    }
                } elseif ($type == "Employee Characteristics" ) {
                    // Add hod_rating to $hod_ratings_characteristics array
                    if (!is_null($hod_rating)) {
                        $hod_ratings_characteristics[] = $hod_rating;
                    }
                    
                    // Add principal_rating to $principal_ratings_characteristics array
                    if (!is_null($principal_rating)) {
                        $principal_ratings_characteristics[] = $principal_rating;
                    }
                }
            }        
        }
       
        if($user->hasRole('Principal')){
            $principal_ratings_competencies = [];
            $principal_ratings_characteristics = [];
        }
        
        
     
       
        // Calculate average hod rating for COMPETENCIES
        $hod_average_competencies = count($hod_ratings_competencies) > 0 ? array_sum($hod_ratings_competencies) / count($hod_ratings_competencies) : null;
        $principal_average_competencies = count($principal_ratings_competencies) > 0 ? array_sum($principal_ratings_competencies) / count($principal_ratings_competencies) : null;
        $hod_average_characteristics = count($hod_ratings_characteristics) > 0 ? array_sum($hod_ratings_characteristics) / count($hod_ratings_characteristics) : null;
        //dd($hod_average_characteristics);
        $principal_average_characteristics = count($principal_ratings_characteristics) > 0 ? array_sum($principal_ratings_characteristics) / count($principal_ratings_characteristics) : null;
        
        $appraisalReport->evaluation_date				= request('evaluation_date');
		$appraisalReport->evaluation_type		        = request('evaluation_type');
        $appraisalReport->evaluation_period		        = request('evaluation_period');
        $appraisalReport->employee_id		            = request('employee_id');
        $appraisalReport->appraisal_data			    = json_encode(request('appraisal_data'));
        $appraisalReport->hod_rating			        = json_encode(request('hod_rating'));
        $appraisalReport->hod_rating_avg_compt          = $hod_average_competencies;
        $appraisalReport->hod_rating_avg_chart          = $hod_average_characteristics;
        $appraisalReport->principal_rating			    = json_encode(request('principal_rating'));
        $appraisalReport->principal_rating_avg_compt    = $principal_average_competencies;    
        $appraisalReport->principal_rating_avg_chart    = $principal_average_characteristics;
        $appraisalReport->future_targets_data			= json_encode(request('future_target'));
        $appraisalReport->future_target_review_date		= json_encode(request('future_target_date'));
        $appraisalReport->future_targets_recommended    = json_encode(request('future_recommended'));
        $appraisalReport->training_title			    = json_encode(request('training_title'));
        $appraisalReport->training_due_date			    = json_encode(request('training_date'));
        $appraisalReport->training_recommended			= json_encode(request('training_recomended'));
        $appraisalReport->employee_comments			    = request('employee_comments');
        $appraisalReport->hod_comments			        = request('hod_comments');
        $appraisalReport->principal_comments			= request('principal_comments');

		return $appraisalReport;
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(request('hod_rating'));
        try{
            $user =  auth()->user();
            if($user->hasRole(VP_ROLE) || $user->hasRole('Executive-Admin')) {
                $hod_ratings = request('hod_rating');
                $hod_ratings_competencies = [];
                $hod_ratings_characteristics = [];
                foreach ($hod_ratings as $index => $hod_rating) {
    
                   // $principal_rating = request('principal_rating.' . $index);
                    $principal_rating = null;
                    $principal_ratings_competencies[]  = null;
                    $principal_ratings_characteristics[] = null;
                    $type = request('type.' . $index);
                   
                    $applicable_to = request('applicable_to.' . $index);
                
                    if ($type == "COMPETENCIES (Ratings and Weightages entered by Appraiser)") {
                        // Add hod_rating to $hod_ratings_competencies array
                        if (!is_null($hod_rating)) {
                            $hod_ratings_competencies[] = $hod_rating;
                        }
                        
                        // Add principal_rating to $principal_ratings_competencies array
                        if (!is_null($principal_rating)) {
                            $principal_ratings_competencies[] = $principal_rating;
                        }
                    } elseif ($type == "Employee Characteristics" ) {
                        // Add hod_rating to $hod_ratings_characteristics array
                        if (!is_null($hod_rating)) {
                            $hod_ratings_characteristics[] = $hod_rating;
                        }
                        
                        // Add principal_rating to $principal_ratings_characteristics array
                        if (!is_null($principal_rating)) {
                            $principal_ratings_characteristics[] = $principal_rating;
                        }
                    }
                }
                $future_targets = request('future_target');
                $future_recommended = [];
                foreach($future_targets as $future_target){
                    if($future_target != null){
                        $future_recommended[] = "HOD";
                    }
                }
                // dd($future_recommended);
                $training_titles = request('training_title');
                $training_recomended = [];
                foreach($training_titles as $training_title){
                    if($training_title != null){
                        $training_recomended[] = "HOD";
                    }
                }  
            }
            // $appraisalReport = $this->appraisalField();
            if($user->hasRole('Principal')){
                $hod_rating = null;
                $hod_ratings_competencies[]=null;
                $hod_ratings_characteristics[] = null;
                $principal_ratings = request('principal_rating');
                $principal_ratings_competencies = [];
                $principal_ratings_characteristics = [];
                foreach ($principal_ratings as $index => $principal_rating) {
    
                   // $principal_rating = request('principal_rating.' . $index);
                    // $principal_rating = null;
                    $type = request('type.' . $index);
                   
                    $applicable_to = request('applicable_to.' . $index);
                
                    if ($type == "COMPETENCIES (Ratings and Weightages entered by Appraiser)") {
                        // Add hod_rating to $hod_ratings_competencies array
                        if (!is_null($hod_rating)) {
                            $hod_ratings_competencies[] = $hod_rating;
                        }
                        
                        // Add principal_rating to $principal_ratings_competencies array
                        if (!is_null($principal_rating)) {
                            $principal_ratings_competencies[] = $principal_rating;
                        }
                    } elseif ($type == "Employee Characteristics" ) {
                        // Add hod_rating to $hod_ratings_characteristics array
                        if (!is_null($hod_rating)) {
                            $hod_ratings_characteristics[] = $hod_rating;
                        }
                        
                        // Add principal_rating to $principal_ratings_characteristics array
                        if (!is_null($principal_rating)) {
                            $principal_ratings_characteristics[] = $principal_rating;
                        }
                    }
                }
                $future_targets = request('future_target');
                $future_recommended = [];
                foreach($future_targets as $future_target){
                    if($future_target != null){
                        $future_recommended[] = "Principal";
                    }
                }
                $training_titles = request('training_title');
                $training_recomended = [];
                foreach($training_titles as $training_title){
                    if($training_title != null){
                        $training_recomended[] = "Principal";
                    }
                }     
            }
            
                $appraisalReport = new AppraisalReport();
            
                // Calculate average hod rating for COMPETENCIES
                $hod_average_competencies = count($hod_ratings_competencies) > 0 ? array_sum($hod_ratings_competencies) / count($hod_ratings_competencies) : null;
                $principal_average_competencies = count($principal_ratings_competencies) > 0 ? array_sum($principal_ratings_competencies) / count($principal_ratings_competencies) : null;
                $hod_average_characteristics = count($hod_ratings_characteristics) > 0 ? array_sum($hod_ratings_characteristics) / count($hod_ratings_characteristics) : null;
                $principal_average_characteristics = count($principal_ratings_characteristics) > 0 ? array_sum($principal_ratings_characteristics) / count($principal_ratings_characteristics) : null;
                
                $appraisalReport->evaluation_date				= request('evaluation_date');
                $appraisalReport->evaluation_type		        = request('evaluation_type');
                $appraisalReport->evaluation_period		        = request('evaluation_period');
                $appraisalReport->employee_id		            = request('employee_id');
                $appraisalReport->appraisal_data			    = json_encode(request('appraisal_data'));
                $appraisalReport->hod_rating			        = json_encode(request('hod_rating'));
                $appraisalReport->hod_rating_avg_compt          = $hod_average_competencies;
                $appraisalReport->hod_rating_avg_chart          = $hod_average_characteristics;
                $appraisalReport->principal_rating			    = json_encode(request('principal_rating'));
                $appraisalReport->principal_rating_avg_compt    = $principal_average_competencies;    
                $appraisalReport->principal_rating_avg_chart    = $principal_average_characteristics;
                $appraisalReport->future_targets_data			= json_encode(request('future_target'));
                $appraisalReport->future_target_review_date		= json_encode(request('future_target_date'));
                $appraisalReport->future_targets_recommended    = json_encode($future_recommended);
                $appraisalReport->training_title			    = json_encode(request('training_title'));
                $appraisalReport->training_due_date			    = json_encode(request('training_date'));
                $appraisalReport->training_recommended			= json_encode($training_recomended);
                $appraisalReport->employee_comments			    = request('employee_comments');
                $appraisalReport->hod_comments			        = request('hod_comments');
                $appraisalReport->principal_comments			= request('principal_comments');
                $appraisalReport->save();
                return redirect()->back();
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
       
        
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appraisal  $appraisal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->employee_id;
        $appraisal_datas = AppraisalReport::with('employee','employee.departments','employee.designations')->find($id);
        $appraisalDataIds = json_decode($appraisal_datas->appraisal_data);
        $appraisalFeedback = Appraisal_datas::with('appriasal_type')->whereIn('id', $appraisalDataIds)->get();
        return response()->view('appraisal.view_employee_details', ['appraisalDataIds' => $appraisalDataIds,'appraisal_datas' => $appraisal_datas,'appraisalFeedback' => $appraisalFeedback])->header('Content-Type', 'text/html');
    }

    public function pip_show(Request $request)
    { 
        $id = $request->employee_id;
        $appraisal_datas = AppraisalReport::with('employee','employee.departments','employee.designations')->find($id);
        $appraisalDataIds = json_decode($appraisal_datas->appraisal_data);
        $appraisalFeedback = Appraisal_datas::with('appriasal_type')->whereIn('id', $appraisalDataIds)->get();
        return response()->view('probationary_appraisal.view_employee_details', ['appraisalDataIds' => $appraisalDataIds,'appraisal_datas' => $appraisal_datas,'appraisalFeedback' => $appraisalFeedback])->header('Content-Type', 'text/html');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appraisal  $appraisal
     * @return \Illuminate\Http\Response
     */
    public function edit(Appraisal $appraisal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appraisal  $appraisal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appraisal $appraisal)
    {
        //
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appraisal  $appraisal
     * @return \Illuminate\Http\Response
     */
    public function delete(Appraisal $appraisal,$id)
    {
        //
        $appraisalReport 	= AppraisalReport::find($id);
        $appraisalReport->delete();
        return redirect()->back();
    }
    public function getEmployeeDetails(Request $request)
    {
        $id = $request->employee_id;
    
        $employee = Employees::with('designations','departments')->find($id);
        $appraisal_datas = Appraisal_datas::get();
        
        return response()->view('appraisal.employee_details', ['employee' => $employee,'appraisal_datas' => $appraisal_datas])->header('Content-Type', 'text/html');
    }


    public function editEmployeeDetails(Request $request)
    {
        //dd($request);
        $id = $request->employee_id;
        $appraisal_datas = AppraisalReport::with('employee','employee.departments','employee.designations')->where('employee_id',$id)->latest()->first();
        $appraisalDataIds = json_decode($appraisal_datas->appraisal_data);
        $appraisalFeedback = Appraisal_datas::with('appriasal_type')->whereIn('id', $appraisalDataIds)->get();
        $employees = Employees::with('user')->where('employee_id',$id)->get();
        // dd($appraisalFeedback);
        
        //return response()->json($employee);
        return response()->view('appraisal.edit_employee_details', ['appraisalDataIds' => $appraisalDataIds,'appraisal_datas' => $appraisal_datas,'appraisalFeedback' => $appraisalFeedback,'employees'=>$employees])->header('Content-Type', 'text/html');
    }
    public function pip_editEmployeeDetails(Request $request)
    {
        $id = $request->employee_id;
        $appraisal_datas = PipAppraisalReports::with('employee','employee.departments','employee.designations')->find($id);
        $appraisalDataIds = json_decode($appraisal_datas->appraisal_data);
        $appraisalFeedback = Appraisal_datas::with('appriasal_type')->whereIn('id', $appraisalDataIds)->get();
        $employees = Employees::with('user')->where('employee_id',$id)->get();
        // dd($appraisalFeedback);
        
        //return response()->json($employee);/
        return response()->view('probationary_appraisal.edit_employee_details', ['appraisalDataIds' => $appraisalDataIds,'appraisal_datas' => $appraisal_datas,'appraisalFeedback' => $appraisalFeedback,'employees'=>$employees])->header('Content-Type', 'text/html');
    }
    public function updateEmployeeDetails(Request $request,$id)
    {
      try{  
            $user =  auth()->user();
            $appraisal_datas = request('appraisal_data');
            $appraisalReport 	= AppraisalReport::find($id);
            if($user->hasRole(VP_ROLE) || $user->hasRole('Executive-Admin')) {
                $hod_ratings = request('hod_rating');
                $hod_ratings_competencies = [];
                $hod_ratings_characteristics = [];
                if($appraisalReport->principal_rating != null){
                    $principal_rating = $appraisalReport->principal_rating;
                    $principal_average_competencies = $appraisalReport->principal_rating_avg_compt;
                    $principal_average_characteristics = $appraisalReport->principal_rating_avg_chart;
                    $principal_comments = $appraisalReport->principal_comments;

                }else{
                    $principal_rating = null;
                    $principal_rating_avg_compt = null;
                    $principal_rating_avg_chart = null;
                    $principal_comments = null;
                }
                foreach($hod_ratings as $index=>$hod_rating){
                    foreach($appraisal_datas as $index=>$appraisal_data){
                        $type = Appraisal_datas::with('appriasal_type')->findorfail($appraisal_data);
                        // dd($type->appriasal_type->type_name);
                        if($type->appriasal_type->type_name == "COMPETENCIES (Ratings and weightages entered by appraiser)"){
                        $hod_ratings_competencies[] =  $hod_rating;
                        }
                        if($type->appriasal_type->type_name == "Employee Characteristics"){
                            $hod_ratings_characteristics[] =  $hod_rating;
                        }
                    }
                }
                $hod_rating = json_encode(request('hod_rating'));
                $hod_rating_avg_compt = count($hod_ratings_competencies) > 0 ? array_sum($hod_ratings_competencies) / count($hod_ratings_competencies) : null;
                $hod_rating_avg_chart = count($hod_ratings_characteristics) > 0 ? array_sum($hod_ratings_characteristics) / count($hod_ratings_characteristics) : null;
                $hod_comments = request('hod_comments');
            }
                
            if($user->hasRole('Principal')){
                $principal_ratings_competencies = [];
                $principal_ratings_characteristics = [];
                if($appraisalReport->hod_rating != null){
                    $hod_rating = $appraisalReport->hod_rating;
                    $hod_rating_avg_compt = $appraisalReport->hod_rating_avg_compt;
                    $hod_rating_avg_chart = $appraisalReport->hod_rating_avg_chart;
                    $hod_comments = $appraisalReport->hod_comments;
                }else{
                    $hod_rating = null;
                    $hod_rating_avg_compt = null;
                    $hod_rating_avg_chart = null;
                    $hod_comments = null;
                }
                $principal_ratings = request('principal_rating');
                
                foreach($principal_ratings as $index=>$principal_rating){
                    foreach($appraisal_datas as $index=>$appraisal_data){
                        $type = Appraisal_datas::with('appriasal_type')->findorfail($appraisal_data);
                        // dd($type->appriasal_type->type_name);
                        if($type->appriasal_type->type_name == "COMPETENCIES (Ratings and weightages entered by appraiser)"){
                        $principal_ratings_competencies[] =  $principal_rating;
                        }
                        if($type->appriasal_type->type_name == "Employee Characteristics"){
                            $principal_ratings_characteristics[] =  $principal_rating;
                        }
                    }
                }
                $principal_rating = json_encode(request('principal_rating'));
                $principal_average_competencies = count($principal_ratings_competencies) > 0 ? array_sum($principal_ratings_competencies) / count($principal_ratings_competencies) : null;
                $principal_average_characteristics = count($principal_ratings_characteristics) > 0 ? array_sum($principal_ratings_characteristics) / count($principal_ratings_characteristics) : null;
                $principal_comments = request('principal_comments');
                // $future_targets_value = request('future_target');
                // $future_targets_datas = array_push($future_targets_data,$future_targets_value);
            
            }

            $appraisalReport->hod_rating                    = $hod_rating;
            $appraisalReport->hod_rating_avg_compt          = $hod_rating_avg_compt;
            $appraisalReport->hod_rating_avg_chart          = $hod_rating_avg_chart;
            $appraisalReport->principal_rating              = $principal_rating;
            $appraisalReport->principal_rating_avg_compt    = $principal_average_competencies;    
            $appraisalReport->principal_rating_avg_chart    = $principal_average_characteristics;
            $appraisalReport->future_targets_data			= json_encode(request('future_target'));
            $appraisalReport->future_target_review_date		= json_encode(request('future_target_date'));
            $appraisalReport->future_targets_recommended    = json_encode(request('future_recommended'));
            $appraisalReport->training_title			    = json_encode(request('training_title'));
            $appraisalReport->training_due_date			    = json_encode(request('training_date'));
            $appraisalReport->training_recommended			= json_encode(request('training_recomended'));
            $appraisalReport->employee_comments			    = request('employee_comments');
            $appraisalReport->hod_comments			        = $hod_comments;
            $appraisalReport->principal_comments			= $principal_comments; 
            $appraisalReport->save();
            return redirect()->back();
        }
        catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function update_hr_comment(Request $request,$id)
    {
        // dd($request);
        try{
            // $actions = request('hr_action');
            $appraisalReport 	= AppraisalReport::find($id);
            $appraisalReport->hr_action = json_encode(request('hr_action'));
            $appraisalReport->hr_comments = json_encode(request('hr_comment'));
            $appraisalReport->hr_action_by = "Hr";
            $appraisalReport->save();
            return redirect()->back();
            
        }catch (Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }  
    }

    //pip appraisal
    public function pip_getEmployeeDetails(Request $request)
    {
        $id = $request->employee_id;
    
        $employee = Employees::with('designations','departments')->find($id);
        $appraisal_datas = Appraisal_datas::get();

        return response()->view('probationary_appraisal.employee_details', ['employee' => $employee,'appraisal_datas' => $appraisal_datas])->header('Content-Type', 'text/html');
    }
    public function emploees_filter(Request $request){
        $one_year = Carbon::now()->subYear()->format('Y-m-d');
        $emp_id = $request->emp_id;
        $emp_name = $request->emp_name;
        $department = $request->department;
        //dd($request->department);
        $employees = Employees::with('employeePayrollInformation','employeeDepartment','employeeEarnings','designations')
        ->when($emp_id, function ($query, $emp_id) {
            return $query->where('employee_id', $emp_id);
        })
        ->when($emp_name, function ($query, $emp_name) {
            return $query->where( function ($query) use ($emp_name) {
                $query->where('name', 'like', '%'.$emp_name.'%')
                ->orWhere('lname', 'like', '%'.$emp_name.'%');
            });
            
        })
        ->when($department, function ($query, $department) {
            return $query->whereHas('employeeDepartment', function ($query) use ($department) {
                $query->where('id',$department);
            });
        })
        ->get();

       

    //dd($earnings);
    if ($employees->isEmpty()) {
            return redirect('appraisal.index')->with('error', 'No matching records found.');
        } else {
            return view('appraisal.performance_appraisal',compact('employees'));
        }
    }

}
