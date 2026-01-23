<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masters\ShiftAssign;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ShiftAssignController extends HrmController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employes = DB::table('employees')
            ->join('designations', 'employees.designation', '=', 'designations.id')
            ->select('employees.*', 'designations.name as designations')
            ->where('employees.status', 1)
            ->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")
            ->orderBy('employees.employee_no')
            ->get();
        return view('settings.shift_assign',compact('employes'));
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
        $shift_assign = new ShiftAssign;
        $shift_assign->employee_id = $request->emp_id;
        $shift_assign->shift_id = $request->shift;
        $shift_assign->date_from = $request->start_date;
        $shift_assign->date_end = $request->end_date;
        $shift_assign->save();
        return response()->json('sucess U');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shift =  ShiftAssign::where('employee_id',$id)->latest('created_at')->first();
        return response()->json($shift);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shift = ShiftAssign::findorfail($id);
        $shift->employee_id = $request->emp_id;
        $shift->shift_id = $request->shift;
        $shift->date_from = $request->start_date;
        $shift->date_end = $request->end_date;
        $shift->save();
        return response()->json('success u');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function filter(Request $request) 
    {
        $employees = DB::table('employees')->join('designations', 'employees.designation', '=', 'designations.id')
        ->select('employees.*', 'designations.name as designations')
        ->where('employees.status', 1);

        // Apply filters based on form inputs
        if (!empty($request->input('emp_id'))) {
            $employees = $employees->where('employee_id', $request->input('emp_id'));
        }
            $name = $request->input('emp_name');
           
        if (!empty($name)) {
            // dd($name);
            $employees = $employees->where('employees.name', 'LIKE', '%' . $name . '%');
           
        }
        //dd($employees);
        if (!empty($request->input('dept'))) {
            // dd($request->input('dept'));
            $employees = $employees->where('department', $request->input('dept'));
        }
        $employees = $employees->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")->orderBy('employees.employee_no');

        $filteredEmployees = $employees->get();
            return response()->json($filteredEmployees);
    }
    public function getShiftData()
    {
        $shiftData = get_shift_data(); 

        return Response::json($shiftData);
    }
    public function getShiftassigned()
    {
        $latestShiftAssigns = DB::table('shift_assigns')
            ->select('employee_id', DB::raw('MAX(date_from) as latest_date'))
            ->groupBy('employee_id');

        $employees = DB::table('employees')
            ->join('designations', 'employees.designation', '=', 'designations.id')
            ->leftjoinSub($latestShiftAssigns, 'latest_shift_assigns', function ($join) {
                $join->on('employees.employee_id', '=', 'latest_shift_assigns.employee_id');
            })
            ->leftjoin('shift_assigns', function ($join) {
                $join->on('employees.employee_id', '=', 'shift_assigns.employee_id')
                    ->on('shift_assigns.date_from', '=', 'latest_shift_assigns.latest_date');
            })
            ->leftjoin('school_shift', 'shift_assigns.shift_id', '=', 'school_shift.id')
            ->select(
                'employees.*',
                'designations.name as designations',
                'shift_assigns.date_from as start_date',
                'shift_assigns.date_end as end_date',
                'school_shift.name as shift'
            )
            ->where('employees.status', 1)
            ->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")
            ->orderBy('employees.employee_no')
            ->get();
        return view('settings.list_shift_assign',compact('employees'));
    }
    public function assignedfilter(Request $request)
    {
        $latestShiftAssigns = DB::table('shift_assigns')
            ->select('employee_id', DB::raw('MAX(date_from) as latest_date'))
            ->groupBy('employee_id');

        $employees = DB::table('employees')
            ->join('designations', 'employees.designation', '=', 'designations.id')
            ->leftjoinSub($latestShiftAssigns, 'latest_shift_assigns', function ($join) {
                $join->on('employees.employee_id', '=', 'latest_shift_assigns.employee_id');
            })
            ->leftjoin('shift_assigns', function ($join) {
                $join->on('employees.employee_id', '=', 'shift_assigns.employee_id')
                    ->on('shift_assigns.date_from', '=', 'latest_shift_assigns.latest_date');
            })
            ->leftjoin('school_shift', 'shift_assigns.shift_id', '=', 'school_shift.id')
            ->select(
                'employees.*',
                'designations.name as designations',
                'shift_assigns.date_from as start_date',
                'shift_assigns.date_end as end_date',
                'school_shift.name as shift'
            );

        if (!empty($request->input('emp_id'))) {
            $employees = $employees->where('employees.employee_id', $request->input('emp_id'));
        }

        $name = $request->input('emp_name');
        if (!empty($name)) {
            $employees = $employees->where('employees.name', 'LIKE', '%' . $name . '%');
        }

        if (!empty($request->input('dept'))) {
            $employees = $employees->where('employees.department', $request->input('dept'));
        }

        try {
            $employees = $employees->where('employees.status', 1)
                                    ->orderByRaw("CASE 
                                            WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                            ELSE employees.employee_no END")
                                    ->orderBy('employees.employee_no');
            $filteredEmployees = $employees->get();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($filteredEmployees);
    }

}
