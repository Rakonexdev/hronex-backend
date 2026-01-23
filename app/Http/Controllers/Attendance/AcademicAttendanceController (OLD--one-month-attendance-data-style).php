<?php

namespace App\Http\Controllers\Attendance;

use App\Models\Employee\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\HrmController;
use App\Models\Leave\LeaveApplication;
use App\Models\Employee\Employees;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AcademicAttendanceController extends HrmController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    // Get the current month and last month
    $currentMonth = Carbon::now()->month;
    $lastMonth = Carbon::now()->subMonth()->month;
    $currentDate = Carbon::now();
    $currentDay = $currentDate->day;
  
    if ($currentDay > 25) {
        $startDate = $currentDate->copy()->addMonth()->day(26)->startOfDay();
        $endDate = $currentDate->copy()->addMonth()->day(25)->endOfDay();
    } else {
        $startDate = $currentDate->subMonth()->day(26)->startOfDay();
        $endDate = $currentDate->addMonth()->day(25)->endOfDay();
    }
    
    $status = $this->leave_approval_status['approved'];
    
    $acadmic_employees = Employees::with(['attendance' => function($query) use ($startDate, $endDate) {
        $query->whereBetween('check_in', [$startDate, $endDate]);
    }])
        ->where('status', 1)->where('employees.status',1)
        ->select('id', 'employee_id', 'employee_no', 'user_id', 'name', 'lname')
        ->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")
        ->orderBy('employees.employee_no')
        ->get();
   
    
    $leaveApplication = LeaveApplication::where('status', $status)
        ->where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date_from', [$startDate, $endDate])
                ->orWhereBetween('date_to', [$startDate, $endDate]);
        })
       ->select('employee_id', 'leave_type', 'date_from', 'date_to', 'status')->get();
    
    return view('attendance.academic_attendance',compact('acadmic_employees'));
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
    public function store(Request $request,$check_in)
    {
        //
        //$data = $check_in;
        //return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcademicAttendance  $academicAttendance
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicAttendance $academicAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicAttendance  $academicAttendance
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicAttendance $academicAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicAttendance  $academicAttendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AcademicAttendance $academicAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicAttendance  $academicAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicAttendance $academicAttendance)
    {
        //
    }
    public function getcheckin(Request $Request ,$check_in, $employee_id)
    {   
        $data = Attendance::where(function ($query) use ($check_in) {
            $query->whereDate('check_in', $check_in)
            ->orWhereDate('check_out', $check_in);
        })
        ->where('employee_id', $employee_id)
        ->orderBy('id', 'asc')
        ->get();
        
        
       /*$dateTime_checkout  = $data->filter(function ($item) {
            return !is_null($item->check_out);
        })->sortBy('check_out')->last();
       $lastCheckoutTime = $dateTime_checkout ? $dateTime_checkout->check_out : '';*/
       
       $dateTime_checkout = $data->filter(function ($item) {
        return !is_null($item->check_out);
        })->sortBy('check_out')->last();
        
        if (isset($dateTime_checkout)) {
            $lastCheckoutTime = $dateTime_checkout->check_out;
        } else {
            $lastCheckoutTime = '';
        }
        $totalWorkingHours =0;
        $workingHours = [];
        $totalBreakTime = 0;
        foreach ($data as $key => $record) {
            if ($record->status === 'check-out') {
                $prevRecord = $data[$key-1];
                $workingHours[] = [
                    'check_in' => $prevRecord->check_in,
                    'check_out' => $record->check_out,
                    'working_hours' => (strtotime($record->check_out) - strtotime($prevRecord->check_in))/3600
                ];
                $totalWorkingHours += (strtotime($record->check_out) - strtotime($prevRecord->check_in))/3600;
                //$breakTime = (strtotime($record->check_in) - strtotime($prevRecord->check_out))/60; // in minutes
                //$totalBreakTime += $breakTime;
                if ($key < count($data) - 1) {
                    $nextRecord = $data[$key+1];
                    $breakTime = (strtotime($nextRecord->check_in) - strtotime($record->check_out))/60; // in minutes
                    $totalBreakTime += $breakTime;
                }
            }
        }
        $otHours = 0;
        foreach ($workingHours as $workingHour) {
            $workingHourHours = $workingHour['working_hours'];
            if ($workingHourHours > 7) {
                $otHours += $workingHourHours - 7;
            }
        }
        
        
        $responseData = [
            'data' => $data,
            'lastCheckoutTime' => $lastCheckoutTime,
            'working_hours' => $totalWorkingHours,
            'totalBreakTime' => $totalBreakTime,
            'otHours' => $otHours,
        ];
        
        return response()->json($responseData);
    }

    public function getleave(Request $Request ,$leave, $employee_id)
    {
        $leave_data =    LeaveApplication::with('leavetypes')->where('employee_id',$employee_id)
                ->where(function ($query) use ($leave) {
                    $query->where('date_from', '<=', $leave)
                        ->where('date_to', '>=', $leave);
                })
            ->first();
        return response()->json($leave_data);
    }
    
    public function getdata(Request $request,$startDate)
    {
      
        $date = Carbon::createFromFormat('Y-m-d', $startDate)->month;
        $startDate =$request->startDate;
        $endDate = $request->endDate;
  
          /* $acadmic_employees = Employees::with(['attendance' => function($query) use ($date) {
                    $query->whereMonth('check_in', $date);
                }])

                ->with(['leaveApplication' => function($query) use ($date) {
                    $query->where('status', $this->leave_approval_status['approved'])
                        ->where(function ($query) use ($date){
                            $query->whereMonth('date_from' , $date)
                                ->orWhereMonth('date_to', $date);              

                        });
                }])
                ->where('department', 1)
                ->get();
*/
            $leave_status = $this->leave_approval_status['approved'];
            $acadmic_employees = Employees::with(['attendance' => function($query) use ($startDate, $endDate) {
                $query->whereBetween('check_in', [$startDate, $endDate]);
            }])->where('employees.status', 1)
                ->select('id', 'employee_id', 'user_id', 'name', 'lname')
                ->get();

            /*$acadmic_employees = Employees::with(['attendance' => function($query) use ($date) {
                $query->whereMonth('check_in', $date);
            }])
            ->where('department', 1)
            ->get();
            
            $leaveApplication = LeaveApplication::where('status', $leave_status)
            ->where(function ($query) use ($date) {
                $query->whereMonth('date_from', $date)
                    ->orWhereMonth('date_to', $date);
            })
            ->get();*/
        $leaveApplication = LeaveApplication::where('status', $leave_status)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date_from', [$startDate, $endDate])
                    ->orWhereBetween('date_to', [$startDate, $endDate]);
            })
            ->select('employee_id', 'leave_type', 'date_from', 'date_to', 'status')
            ->get();

    

            $acadmic_employees->each(function ($employee) use ($leaveApplication) {
                $employee->leaveApplication = $leaveApplication
                    ->where('employee_id', $employee->employee_id)
                    ->values();
            });
            // dd($acadmic_employees);

        return view('attendance.academic_attendance_ajax_data',compact('acadmic_employees','startDate','endDate'));
    }

    public function add_attendance(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|integer',
                'status' => 'required|in:check-in,check-out',
                'comment' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.errorU'));
            }

            $check_datetime = $request->check_date.' '.$request->check_time;
            $input_datetime = Carbon::parse($check_datetime)->format('Y-m-d H:i:s');

            $attendance = new Attendance();
            $attendance->employee_id = $request->employee_id;
            $attendance->shift_id = 1;
            $attendance->status = $request->status;
            
            if ('check-out'==$request->status) {
                $attendance->check_out = $input_datetime;
                $attendance->check_in = NULL;
            }else{
                $attendance->check_in = $input_datetime;
                $attendance->check_out = NULL;
            }
            $attendance->created_at = date('Y-m-d H:i:s');
            $attendance->updated_at = date('Y-m-d H:i:s');
            $attendance->comment = $request->comment;
            $attendance->created_by = Auth::user()->id;

            $attendance->save();

            return redirect()->back()->with('success', trans('messages.successU'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', trans('messages.errorU'));
        }
    }

}
