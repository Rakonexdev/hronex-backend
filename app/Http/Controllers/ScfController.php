<?php

namespace App\Http\Controllers;

use App\Models\Scf;
use Illuminate\Http\Request;
use App\Models\Employee\Employees;
use App\Http\Controllers\HrmController;
use App\Models\ScfData;
use Exception;

class ScfController extends HrmController
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
        if($user->hasRole('Principal') || $user->hasRole('Hr') || $user->id ==1){
            $employees = Employees::with('designations','departments','scf')
                        ->whereNotNull('joiningdate')
                        ->whereNotNull('department')
                        ->whereNotNull('designation')
                        ->where('employees.status', '=', 1)
                        ->orderByRaw("CASE 
                                    WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                    ELSE employees.employee_no END")
                        ->orderBy('employees.employee_no')
                        ->get();
        }
        if($user->hasRole('Vp')){
            $employees = Employees::with('designations','departments','scf')
                        ->whereNotNull('joiningdate')
                        ->whereNotNull('department')
                        ->whereNotNull('designation')
                        ->where('employees.status', '=', 1)
                        ->where('employees.department', '=', 1)
                        ->orderByRaw("CASE 
                                    WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                    ELSE employees.employee_no END")
                        ->orderBy('employees.employee_no')
                        ->get();
        }
        if($user->hasRole('Executive-Admin')){
            $employees = Employees::with('designations','departments','scf')
                        ->whereNotNull('joiningdate')
                        ->whereNotNull('department')
                        ->whereNotNull('designation')
                        ->where('employees.status', '=', 1)
                        ->where('employees.department', '=', 2)
                        ->orderByRaw("CASE 
                                    WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                    ELSE employees.employee_no END")
                        ->orderBy('employees.employee_no')
                        ->get();
        }
        return view('appraisal.scf',compact('employees'));
    }

    public function getEmployeeDetails(Request $request)
    {
        $id = $request->employee_id;
    
        $employee = Employees::with('designations','departments')->find($id);
        // $appraisal_datas = Appraisal_datas::get();
        $concerns = ScfData::get();
        return response()->view('appraisal.scf_form', ['employee' => $employee,'concerns'=>$concerns])->header('Content-Type', 'text/html');
    }
    public function editEmployeeDetails(Request $request)
    {
       // dd($request);
        $id = $request->employee_id;
        $scf = scf::with('employee','employee.departments','employee.designations')->find($id);
        $scf_id = json_decode($scf->scf_data);
        $scf_datas = ScfData::whereIn('id', $scf_id)->get();
        $employee = Employees::with('user','departments','designations')->where('employee_id',$scf->employee_id)->first();
        return response()->view('appraisal.edit_scf_form', ['scf' => $scf,'scf_datas' => $scf_datas,'employee'=>$employee])->header('Content-Type', 'text/html');
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
        try {
            $user_id = auth()->user()->id;
            if ($request->pip_required == 1) {
                $pip_required = 1;
            } else {
                $pip_required = 0;
            }
    
            $data = [
                'scf_date' => $request->date,
                'concern_from_number' => $request->concern_form_number,
                'employee_id' => $request->employee_id,
                'staff_member' => $request->staff_member,
                'scf_data' => json_encode($request->concern_ids), 
                'scf_ans_data' => json_encode($request->concerns),
                'raising_concern' => $request->raising_concern,
                'suggestions_made' => $request->suggestion,
                'breif_description' => $request->description,
                'follow_up' => $request->followup,
                'comment' => $request->comments,
                'date_of_concern' => $request->concern_date,
                'slt_member' => $user_id,
                'slt_member_ack' => 1,
                'pip_required' => $pip_required
            ];
    
            Scf::create($data);
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $e) {
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
     * @param  \App\Models\Scf  $scf
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->employee_id;
        $scf = Scf::with('employee','employee.departments','employee.designations')->find($id);
        $scf_id = json_decode($scf->scf_data);
        $scf_datas = ScfData::whereIn('id', $scf_id)->get();
        $employee = Employees::with('user','departments','designations')->where('employee_id',$scf->employee_id)->first();
        return response()->view('appraisal.view_scf_form', ['scf' => $scf,'scf_datas' => $scf_datas,'employee'=>$employee])->header('Content-Type', 'text/html');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Scf  $scf
     * @return \Illuminate\Http\Response
     */
    public function edit(Scf $scf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Scf  $scf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // dd($id);
        $user_id = auth()->user()->id;
        $scf = Scf::findorfail($id);
        if($request->pip_required == 1){
            $pip_required = 1;
        }else{
            $pip_required = 0;
        }   
        $data = [
            'scf_date' =>$request->date,
            'concern_from_number'=>$request->concern_form_number,
            'employee_id'=>$request->employee_id,
            'staff_member'=>$request->staff_member,
            'scf_data'=> json_encode($request->concern_ids), 
            'scf_ans_data'=>json_encode($request->concerns),
            'raising_concern'=>$request->raising_concern,
            'suggestions_made'=>$request->suggestion,
            'breif_description'=>$request->description,
            'follow_up'=>$request->followup,
            'comment'=>$request->comments,
            'date_of_concern'=>$request->concern_date,
            'slt_member'=>$user_id,
            'slt_member_ack'=>1,
            'pip_required'=>$pip_required
        ];
        $scf->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Scf  $scf
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $scf = Scf::findorfail($id);
        $scf->delete();
        return redirect()->back();
    
    }
}
