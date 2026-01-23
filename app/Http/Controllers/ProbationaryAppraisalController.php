<?php

namespace App\Http\Controllers;

use App\Models\ProbationaryAppraisal;
use Illuminate\Http\Request;
use App\Models\Employee\Employees;
use App\Http\Controllers\HrmController;
use App\Models\AppraisalReport;
use App\Models\Pip;
use App\Models\Masters\Appraisal_datas;
use App\Models\PipAppraisalReports;

class ProbationaryAppraisalController extends HrmController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;
        if($user->hasRole('Principal') || $user->hasRole('Hr') || $user->id == 1){
            $employees = Employees::with('designations','departments','pipappraisalreport','pip')
                                ->whereNotNull('joiningdate')
                                ->whereNotNull('department')
                                ->whereNotNull('designation')
                                ->where('employees.status', '=', 1)
                                // ->whereHas('pip', function ($query) {
                                //     $query->where('pip_status', 1);
                                // })
                                ->orderByRaw("CASE 
                                            WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                            ELSE employees.employee_no END")
                                ->orderBy('employees.employee_no')
                                ->get();
        }
        if($user->hasRole('Vp')){
            $employees = Employees::with('designations','departments','pipappraisalreport','pip')
                                ->whereNotNull('joiningdate')
                                ->whereNotNull('department')
                                ->whereNotNull('designation')
                                ->where('employees.status', '=', 1)
                                ->where('employees.department', '=', 1)
                                // ->whereHas('pip', function ($query) {
                                //     $query->where('pip_status', 1);
                                // })
                                ->orderByRaw("CASE 
                                            WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                            ELSE employees.employee_no END")
                                ->orderBy('employees.employee_no')
                                ->get();
        }
        if($user->hasRole('Executive-Admin')){
            $employees = Employees::with('designations','departments','pipappraisalreport','pip')
                                ->whereNotNull('joiningdate')
                                ->whereNotNull('department')
                                ->whereNotNull('designation')
                                ->where('employees.status', '=', 1)
                                ->where('employees.department', '=', 2)
                                // ->whereHas('pip', function ($query) {
                                //     $query->where('pip_status', 1);
                                // })
                                ->orderByRaw("CASE 
                                            WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                            ELSE employees.employee_no END")
                                ->orderBy('employees.employee_no')
                                ->get();
        }
        return view('probationary_appraisal.index',compact('employees'));
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
			$appraisalReport 	= PipAppraisalReports::find($id);
          
		}
		else{
			$appraisalReport	= new PipAppraisalReports();
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
        // $appraisalReport->evaluation_period		        = request('evaluation_period');
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
        //  dd($request);
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
            
                $appraisalReport = new PipAppraisalReports();
            
                // Calculate average hod rating for COMPETENCIES
                $hod_average_competencies = count($hod_ratings_competencies) > 0 ? array_sum($hod_ratings_competencies) / count($hod_ratings_competencies) : null;
                $principal_average_competencies = count($principal_ratings_competencies) > 0 ? array_sum($principal_ratings_competencies) / count($principal_ratings_competencies) : null;
                $hod_average_characteristics = count($hod_ratings_characteristics) > 0 ? array_sum($hod_ratings_characteristics) / count($hod_ratings_characteristics) : null;
                $principal_average_characteristics = count($principal_ratings_characteristics) > 0 ? array_sum($principal_ratings_characteristics) / count($principal_ratings_characteristics) : null;
                
                $appraisalReport->evaluation_date				= request('evaluation_date');
                $appraisalReport->evaluation_type		        = request('evaluation_type');
                // $appraisalReport->evaluation_period		        = request('evaluation_period');
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
     * @param  \App\Models\ProbationaryAppraisal  $probationaryAppraisal
     * @return \Illuminate\Http\Response
     */
    public function show(ProbationaryAppraisal $probationaryAppraisal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProbationaryAppraisal  $probationaryAppraisal
     * @return \Illuminate\Http\Response
     */
    public function edit(ProbationaryAppraisal $probationaryAppraisal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProbationaryAppraisal  $probationaryAppraisal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProbationaryAppraisal $probationaryAppraisal)
    {
        //
    }
    public function updateEmployeeDetails(Request $request,$id)
    {
        // dd($request);
      try{  
            $user =  auth()->user();
            $appraisal_datas = request('appraisal_data');
            $appraisalReport 	= PipAppraisalReports::find($id);
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProbationaryAppraisal  $probationaryAppraisal
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProbationaryAppraisal $probationaryAppraisal)
    {
        //
    }
    
}
