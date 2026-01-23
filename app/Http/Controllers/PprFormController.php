<?php

namespace App\Http\Controllers;

use App\Models\PprForm;
use Illuminate\Http\Request;
use App\Models\Employee\Employees;
use App\Http\Controllers\HrmController;
use App\Models\PerformanceReview;
use Carbon\Carbon;

class PprFormController extends HrmController
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
            $employees = Employees::with('designations','departments','ppr')
                            ->whereNotNull('joiningdate')
                            ->whereNotNull('department')
                            ->whereNotNull('designation')
                            ->where('employees.status', '=', 1)
                            ->where('employees.is_conformed', '=', 0)
                            ->where(function ($query) {
                                $query->whereRaw("employees.employee_no NOT REGEXP '^T[0-9]+$'")
                                    ->orWhereNull('employees.employee_no');
                            })
                            ->orderByRaw("CASE 
                                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                        ELSE employees.employee_no END")
                            ->orderBy('employees.employee_no')
                            ->get();
        }
        if($user->hasRole('Vp')){
            $employees = Employees::with('designations','departments','ppr')
                            ->whereNotNull('joiningdate')
                            ->whereNotNull('department')
                            ->whereNotNull('designation')
                            ->where('employees.status', '=', 1)
                            ->where('employees.department', '=', 1)
                            ->where('employees.is_conformed', '=', 0)
                            ->where(function ($query) {
                                $query->whereRaw("employees.employee_no NOT REGEXP '^T[0-9]+$'")
                                    ->orWhereNull('employees.employee_no');
                            })
                            ->orderByRaw("CASE 
                                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                        ELSE employees.employee_no END")
                            ->orderBy('employees.employee_no')
                            ->get();
        }
        if($user->hasRole('Executive-Admin')){
            $employees = Employees::with('designations','departments','ppr')
                            ->whereNotNull('joiningdate')
                            ->whereNotNull('department')
                            ->whereNotNull('designation')
                            ->where('employees.status', '=', 1)
                            ->where('employees.department', '=', 2)
                            ->where('employees.is_conformed', '=', 0)
                            ->where(function ($query) {
                                $query->whereRaw("employees.employee_no NOT REGEXP '^T[0-9]+$'")
                                    ->orWhereNull('employees.employee_no');
                            })
                            ->orderByRaw("CASE 
                                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                        ELSE employees.employee_no END")
                            ->orderBy('employees.employee_no')
                            ->get();
        }
        return view('ppr.ppr',compact('employees'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $today = Carbon::now();
        try{
        if($request->conformed == "on"){
                $conformed = 1;
              
            }else{
                $conformed = 0;
            }
            if($request->employee_ack == "on"){
                $employee_ack = 1;
                $date = ($today)->format('Y-m-d');
            }else{
                $employee_ack = 0;
                $date = ($today)->format('Y-m-d');
            }
            if($request->hod_ack == "on"){
                $hod_ack = 1;
            }else{
                $hod_ack = 0;
            }
            if($request->principla_ack == "on"){
                $principla_ack = 1;
            }else{
                $principla_ack = 0;
            }
            $data = [
                'employee_id' =>$request->employee_id,
                'review_period'=>$request->review_period,
                'review_date'=>$request->date,
                'objectives'=>json_encode($request->objectives),
                'discussion_points'=>json_encode($request->discussions),
                'performance_review'=>json_encode($request->performance_review),
                'performance_review_rating'=>json_encode($request->ratings),
                'performance_review_feedback'=>$request->performance_review_feedback,
                'require_improvement'=>$request->require_improvement,
                'areas_improvement'=>$request->areas_improvement,
                'areas_discussion_points'=>$request->areas_discussion_points,
                'work_environment'=>$request->work_environment,
                'manager_action_points'=>$request->manager_action_points,
                'over_all_perfamance'=>$request->over_all_perfamance,
                'appointment_conformed'=>$conformed,
                'no_conformed'=>$request->no_conformed,
                'extension_period'=>$request->extension_period,
                'probatinary_review'=>1,
                'employee_ack'=>$employee_ack,
                'hod_ack'=>$hod_ack,
                'principla_ack'=>$principla_ack,
                'ack_date'=>$date
            ];

            PprForm::create($data);
            return back()->with('Success U');
        }catch (\Illuminate\Database\QueryException $e) {
            // SQL error occurred
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                // MySQL Duplicate entry error code
                return redirect()->back()->with('error', 'Duplicate entry error. Please check your input data.');
            } else {
                return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
            }
        } catch (Exception $e) {
            // Other general errors
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PprForm  $pprForm
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->employee_id;
        $ppr_form = PprForm::with('employee','employee.departments','employee.designations')->find($id);
        $review_id = json_decode($ppr_form->performance_review);
        $review_data = PerformanceReview::whereIn('id', $review_id)->get();
        $employee = Employees::with('user','departments','designations')->where('employee_id',$ppr_form->employee_id)->first();
        return response()->view('ppr.view_ppr_form', ['ppr_form' => $ppr_form,'review_data' => $review_data,'employee'=>$employee])->header('Content-Type', 'text/html');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PprForm  $pprForm
     * @return \Illuminate\Http\Response
     */
    public function edit(PprForm $pprForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PprForm  $pprForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        // $user =  auth()->user();
        // $role = Auth::user();
        $today = Carbon::now();
        $ppr = PprForm::findorfail($id);
        if($request->conformed == "on"){
            $conformed = 1;
            
            // $employee = Employees::where('employee_id',$request->employee_id)->first();
            // $employee->is_conformed = 1;
            // $employee->save();
        }else{
            $conformed = 0;
        }
      
        if( $request->has('employee_ack') && $request->employee_ack == "on"){
            $employee_ack = 1;
            $date = ($today)->format('Y-m-d');
        }else{
            $employee_ack = $ppr->employee_ack;
            $date = ($today)->format('Y-m-d');
        }
       
        if($request->has('hod_ack') && $request->hod_ack == "on"){
            $hod_ack = 1;
           // $date = ($today)->format('Y-m-d');
        }else{
            $hod_ack =  $ppr->hod_ack;
        }
     
        if($request->has('principla_ack') && $request->principla_ack == "on"){
            $principla_ack = 1;
            //$date = ($today)->format('Y-m-d');
        }else{
            $principla_ack = $ppr->principla_ack;
        }
        // dd($principla_ack);
        $data = [
            'employee_id' =>$request->employee_id,
            'review_period'=>$request->review_period,
            'review_date'=>$request->date,
            'objectives'=>json_encode($request->objectives),
            'discussion_points'=>json_encode($request->discussions),
            'performance_review'=>json_encode($request->performance_review),
            'performance_review_rating'=>json_encode($request->ratings),
            'performance_review_feedback'=>$request->performance_review_feedback,
            'require_improvement'=>$request->require_improvement,
            'areas_improvement'=>$request->areas_improvement,
            'areas_discussion_points'=>$request->areas_discussion_points,
            'work_environment'=>$request->work_environment,
            'manager_action_points'=>$request->manager_action_points,
            'over_all_perfamance'=>$request->over_all_perfamance,
            'appointment_conformed'=>$conformed,
            'no_conformed'=>$request->no_conformed,
            'extension_period'=>$request->extension_period,
            'probatinary_review'=>1,
            'employee_ack'=>$employee_ack,
            'hod_ack'=>$hod_ack,
            'principla_ack'=>$principla_ack,
            'ack_date'=>$date
        ];
        $ppr->update($data);
        if($ppr->principla_ack ==1 && $ppr->hod_ack ==1 &&  $ppr->employee_ack == 1 && $ppr->appointment_conformed == 1 ){
            $employee = Employees::where('employee_id',$request->employee_id)->first();
            $employee->is_conformed = 1;
            $employee->save();
        }

        return back()->with('success u');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PprForm  $pprForm
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $ppr = PprForm::findorfail($id);
        $ppr->delete();
        return back()->with("success U");
    }
    public function getEmployeeDetails(Request $request)
    {
        // dd($request);
        $id = $request->employee_id;
    
        $employee = Employees::with('designations','departments')->find($id);
        $performance_reviews = PerformanceReview::get();
        
        return response()->view('ppr.ppr_form', ['employee' => $employee,'performance_reviews'=>$performance_reviews])->header('Content-Type', 'text/html');
    }

    public function editEmployeeDetails(Request $request)
    {
       // dd($request);
        $id = $request->employee_id;
        $ppr_form = PprForm::with('employee','employee.departments','employee.designations')->find($id);
        $review_id = json_decode($ppr_form->performance_review);
        $review_data = PerformanceReview::whereIn('id', $review_id)->get();
        $employee = Employees::with('user','departments','designations')->where('employee_id',$ppr_form->employee_id)->first();
        return response()->view('ppr.edit_ppr_form', ['ppr_form' => $ppr_form,'review_data' => $review_data,'employee'=>$employee])->header('Content-Type', 'text/html');
    }
    public function emploees_filter(Request $request){
        $emp_id = $request->emp_id;
        $emp_name = $request->emp_name;
        $department = $request->department;
        //dd($request->department);
        $employees = Employees::with('employeePayrollInformation','employeeDepartment','employeeEarnings','designations','ppr')
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
            return redirect('probation-period-review.index')->with('error', 'No matching records found.');
        } else {
            return view('ppr.ppr',compact('employees'));
        }
    }
}
