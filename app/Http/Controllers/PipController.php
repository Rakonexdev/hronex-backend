<?php

namespace App\Http\Controllers;

use App\Models\Pip;
use Illuminate\Http\Request;
use App\Http\Controllers\HrmController;
use App\Models\Employee\Employees;
use Carbon\Carbon;

class PipController extends HrmController
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
        // dd();
        if($user->hasRole('Principal') || $user->hasRole('Hr') || $user->id == 1){
        $employees = Employees::with('designations','departments','pip','scf')
                    ->whereNotNull('joiningdate')
                    ->whereNotNull('department')
                    ->whereNotNull('designation')
                    ->where('employees.status', '=', 1)
                    // ->whereHas('scf', function ($query) {
                    //     $query->where('pip_required', 1);
                    // })
                    ->orderByRaw("CASE 
                                WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                ELSE employees.employee_no END")
                    ->orderBy('employees.employee_no')
                    ->get();
                    return view('pip.pip',compact('employees'));
                }
        if($user->hasRole('Vp')){
            $employees = Employees::with('designations','departments','pip','scf')
            ->whereNotNull('joiningdate')
            ->whereNotNull('department')
            ->whereNotNull('designation')
            ->where('employees.status', '=', 1)
            ->where('employees.department', '=', 1)
            // ->whereHas('scf', function ($query) {
            //     $query->where('pip_required', 1);
            // })
            ->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")
            ->orderBy('employees.employee_no')
            ->get();
            return view('pip.pip',compact('employees'));
        }
        if($user->hasRole('Executive-Admin')){
            $employees = Employees::with('designations','departments','pip','scf')
            ->whereNotNull('joiningdate')
            ->whereNotNull('department')
            ->whereNotNull('designation')
            ->where('employees.status', '=', 1)
            ->where('employees.department', '=', 2)
            // ->whereHas('scf', function ($query) {
            //     $query->where('pip_required', 1);
            // })
            ->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")
            ->orderBy('employees.employee_no')
            ->get();
            return view('pip.pip',compact('employees'));
        }
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
        try{
        $today = Carbon::now();
        if($request->principal_ackn =="on"){
            $principal_ackn = 1;
            $date = ($today)->format('Y-m-d');
        }else{
            $principal_ackn = 0;
            $date = ($today)->format('Y-m-d');
        }
        if($request->employee_ackn =="on"){
            $employee_ackn = 1;
            $date = ($today)->format('Y-m-d');
        }else{
            $employee_ackn = 0;
            $date = ($today)->format('Y-m-d');
        }
        $data = [
            'employee_id' =>$request->employee_id,
            'date' =>$request->date,
            'staff_member' =>$request->staff_member,
            'area_of_concern'=>$request->area_of_concern,
            'Observations'=>$request->Observations,
            'improment_goals'=>json_encode($request->improment_goals),
            'management_support'=>json_encode($request->management_support),
            'activity'=>json_encode($request->activity),
            'check_point_date'=>json_encode($request->check_point_date),
            'type_of_follow_up'=>json_encode($request->type_of_follow_up),
            'progress_expected'=>json_encode($request->progress_expected),
            'notes'=>json_encode($request->notes),
            'employee_ackn'=>$employee_ackn,
            'principal_ackn' => $principal_ackn,
            'employee_date'=>$date,
            'principal_date'=>$date,
            'pip_status'=>$request->pip_status
        ];
        Pip::create($data);
        return back()->with("success U");
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
     * @param  \App\Models\Pip  $pip
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // dd($request);
         $id = $request->employee_id;
         $pip = Pip::with('employee','employee.departments','employee.designations')->find($id);
         $employee = Employees::with('user','departments','designations')->where('employee_id',$pip->employee_id)->first();
         return response()->view('pip.view_pip_form', ['pip' => $pip,'employee'=>$employee])->header('Content-Type', 'text/html');
     }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pip  $pip
     * @return \Illuminate\Http\Response
     */
    public function edit(Pip $pip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pip  $pip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $pip =  Pip::findorfail($id);
        $today = Carbon::now();
        if($request->has('principal_ackn') && $request->principal_ackn =="on"){
            $principal_ackn = 1;
            $date = ($today)->format('Y-m-d');
        }else{
            $principal_ackn = 0;
            $date = ($today)->format('Y-m-d');
        }
        if($request->has('employee_ackn') && $request->employee_ackn =="on"){
            $employee_ackn = 1;
            $date = ($today)->format('Y-m-d');
        }else{
            $employee_ackn = 0;
            $date = ($today)->format('Y-m-d');
        }
        $data = [
            'employee_id' =>$request->employee_id,
            'date' =>$request->date,
            'staff_member' =>$request->staff_member,
            'area_of_concern'=>$request->area_of_concern,
            'Observations'=>$request->Observations,
            'improment_goals'=>json_encode($request->improment_goals),
            'management_support'=>json_encode($request->management_support),
            'activity'=>json_encode($request->activity),
            'check_point_date'=>json_encode($request->check_point_date),
            'type_of_follow_up'=>json_encode($request->type_of_follow_up),
            'progress_expected'=>json_encode($request->progress_expected),
            'notes'=>json_encode($request->notes),
            'employee_ackn'=>$employee_ackn,
            'principal_ackn' => $principal_ackn,
            'employee_date'=>$date,
            'principal_date'=>$date,
            'pip_status'=>$request->pip_status
        ];
        $pip->update($data);
        return redirect()->back()->with("success U");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pip  $pip
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $pip = Pip::findorfail($id);
        $pip->delete();
        return redirect()->back();
    }
    public function getEmployeeDetails(Request $request)
    {
        $id = $request->employee_id;
    
        $employee = Employees::with('designations','departments')->find($id);
        // $appraisal_datas = Appraisal_datas::get();
        
        return response()->view('pip.pip_form', ['employee' => $employee])->header('Content-Type', 'text/html');
    }
  
    public function editEmployeeDetails(Request $request)
    {
       // dd($request);
        $id = $request->employee_id;
        $pip = Pip::with('employee','employee.departments','employee.designations')->find($id);
        $employee = Employees::with('user','departments','designations')->where('employee_id',$pip->employee_id)->first();
        return response()->view('pip.pip_edit_form', ['pip' => $pip,'employee'=>$employee])->header('Content-Type', 'text/html');
    }
}
