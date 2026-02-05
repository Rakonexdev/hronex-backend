<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Exports\PayrollExport;
use App\Exports\TimesheetExport;
use App\Exports\MonthlyLeavesExport;
use App\Exports\EmployeeTimesheetExport;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee\Employees;
//use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;
use App\Models\Employee\Attendance;
use Carbon\Carbon;
use App\Models\Leave\LeaveType;
use App\Models\Leave\LeaveApplication;
use App\Models\Leave\LeaveApplicationStatus;
use App\Models\Gratuity\Gratuity;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Str;
use App\Models\AppraisalReport;
use App\Models\PprForm;
use App\Models\Scf;
use App\Models\Pip;
use App\Models\Masters\Appraisal_datas;
use App\Models\PerformanceReview;
use App\Models\ScfData;
use Illuminate\Support\Facades\Auth;
use App\Models\Masters\Department;

class ReportsController extends HrmController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
    public function employeeIndex()
    {
        $employees = DB::table('employees')
            ->select('employees.name','employees.lname','employees.employee_no','employees.email','departments.name as department','designations.name as designation','employees.employee_id','employees.gender','employees.dob','employees.age','employees.nationality','employees.marital_status','employees.mobile1_code','employees.mobile1','employees.mobile2_code','employees.mobile2','employees.qidno','employees.qidexpiry','employees.passportno','employees.passportexpiry','employees.joiningdate','employees.school_shift','employees.end_probation','contract_type.name as contract_type','employees.contract_length','employees.end_contract','employees.service_years','employees.hrcomment','employees.sponsorship_status','employees.fas_sponsor','employees.fas_spo_date','employees.tkt_allowance_dur','employees.relevant_degree','employee_payroll_informations.basic_salary as basic_salary','employee_payroll_informations.accomodation_allowance as accomodation_allowance','employee_payroll_informations.transport_allowance as transport_allowance','employee_payroll_informations.other_allowance as other_allowance','employee_payroll_informations.gross_total as gross_total',
            'employee_payroll_informations.bank_name as bank_name','employee_payroll_informations.account_no as account_no','employee_payroll_informations.iban_no as iban_no','countries.country_name as nationality')            
            ->join('departments', 'employees.department', '=', 'departments.id')
            ->join('designations', 'employees.designation', '=', 'designations.id')
            ->join('contract_type','employees.contract_type','=', 'contract_type.id')
            ->join('countries','employees.nationality','=', 'countries.id')
            ->join('employee_payroll_informations','employees.user_id','=','employee_payroll_informations.user_id')
            ->where('employees.status', 1)
            ->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")
            ->orderBy('employees.employee_no')
            ->get();
        return view('reports.employee-reports',compact('employees'));
    }
    public function employeeFilter(Request $request)
    {
        // dd($request);
        $data = $request->input('filterData');
        $employee = DB::table('employees')
                        ->select('employees.name','employees.lname','employees.employee_no','employees.email','departments.name as department','designations.name as designation','employees.employee_id','employees.gender','employees.dob','employees.age','employees.nationality','employees.marital_status','employees.mobile1_code','employees.mobile1','employees.mobile2_code','employees.mobile2','employees.qidno','employees.qidexpiry','employees.passportno','employees.passportexpiry','employees.joiningdate','employees.school_shift','employees.end_probation','contract_type.name as contract_type','employees.contract_length','employees.end_contract','employees.service_years','employees.hrcomment','employees.sponsorship_status','employees.fas_sponsor','employees.fas_spo_date','employees.tkt_allowance_dur','employees.relevant_degree','employee_payroll_informations.basic_salary as basic_salary','employee_payroll_informations.accomodation_allowance as accomodation_allowance','employee_payroll_informations.transport_allowance as transport_allowance','employee_payroll_informations.other_allowance as other_allowance','employee_payroll_informations.gross_total as gross_total',
                            'employee_payroll_informations.bank_name as bank_name','employee_payroll_informations.account_no as account_no','employee_payroll_informations.iban_no as iban_no','countries.country_name as nationality')            
                        ->join('departments', 'employees.department', '=', 'departments.id')
                        ->join('designations', 'employees.designation', '=', 'designations.id')
                        ->join('contract_type','employees.contract_type','=', 'contract_type.id')
                        ->join('countries','employees.nationality','=', 'countries.id')
                        ->join('employee_payroll_informations','employees.user_id','=','employee_payroll_informations.user_id')
                        ->where('employees.status', 1)
                        ->where(function($query) use ($data) {
                            $query->where('employees.name', 'like', '%' . $data . '%')
                                ->orWhere('employees.employee_no', 'like', '%' . $data . '%');
                        })
                        ->orderByRaw("CASE 
                                    WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                    ELSE employees.employee_no END")
                        // ->orderBy('employees.employee_no')
                        ->first();
        return view('reports.employee-filter',compact('employee')); 
    }
    public function employeeReset(Request $request)
    {
        $employees = DB::table('employees')
                        ->select('employees.name','employees.lname','employees.employee_no','employees.email','departments.name as department','designations.name as designation','employees.employee_id','employees.gender','employees.dob','employees.age','employees.nationality','employees.marital_status','employees.mobile1_code','employees.mobile1','employees.mobile2_code','employees.mobile2','employees.qidno','employees.qidexpiry','employees.passportno','employees.passportexpiry','employees.joiningdate','employees.school_shift','employees.end_probation','contract_type.name as contract_type','employees.contract_length','employees.end_contract','employees.service_years','employees.hrcomment','employees.sponsorship_status','employees.fas_sponsor','employees.fas_spo_date','employees.tkt_allowance_dur','employees.relevant_degree','employee_payroll_informations.basic_salary as basic_salary','employee_payroll_informations.accomodation_allowance as accomodation_allowance','employee_payroll_informations.transport_allowance as transport_allowance','employee_payroll_informations.other_allowance as other_allowance','employee_payroll_informations.gross_total as gross_total',
                        'employee_payroll_informations.bank_name as bank_name','employee_payroll_informations.account_no as account_no','employee_payroll_informations.iban_no as iban_no','countries.country_name as nationality')            
                        ->join('departments', 'employees.department', '=', 'departments.id')
                        ->join('designations', 'employees.designation', '=', 'designations.id')
                        ->join('contract_type','employees.contract_type','=', 'contract_type.id')
                        ->join('countries','employees.nationality','=', 'countries.id')
                        ->join('employee_payroll_informations','employees.user_id','=','employee_payroll_informations.user_id')
                        ->where('employees.status', 1)
                        ->orderByRaw("CASE 
                                    WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                    ELSE employees.employee_no END")
                        ->orderBy('employees.employee_no')
                        ->get();
        return view('reports.employee-reset',compact('employees'));
    }
    public function employeeExport($format)
    {
       
        $employees = DB::table('employees')
                    ->select('employees.name','employees.lname','employees.employee_no','employees.email','departments.name as department','designations.name as designation','employees.gender','employees.dob','employees.age','employees.nationality','employees.marital_status','employees.mobile1','employees.mobile2','employees.qidno','employees.qidexpiry','employees.passportno','employees.passportexpiry','employees.joiningdate','school_shift.name as school_shift','employees.end_probation','contract_type.name as contract_type','employees.contract_length','employees.end_contract','employees.service_years','sponsorship_status.name as sponsorship_status','employee_payroll_informations.basic_salary as basic_salary','employee_payroll_informations.accomodation_allowance as accomodation_allowance','employee_payroll_informations.transport_allowance as transport_allowance','employee_payroll_informations.other_allowance as other_allowance','employee_payroll_informations.gross_total as gross_total',
                    'employee_payroll_informations.bank_name as bank_name','employee_payroll_informations.account_no as account_no','employee_payroll_informations.iban_no as iban_no','countries.country_name as nationality')
                    ->join('departments', 'employees.department', '=', 'departments.id')
                    ->join('designations', 'employees.designation', '=', 'designations.id')
                    ->join('contract_type','employees.contract_type','=', 'contract_type.id')
                    ->join('countries','employees.nationality','=', 'countries.id')
                    ->join('school_shift','employees.school_shift','=', 'school_shift.id')
                    ->join('sponsorship_status','employees.sponsorship_status','=', 'sponsorship_status.id')
                    ->join('employee_payroll_informations','employees.user_id','=','employee_payroll_informations.user_id')
                    ->where('employees.status', 1)
                    ->orderByRaw("CASE 
                                WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                ELSE employees.employee_no END")
                    ->orderBy('employees.employee_no')
                    ->get();
        //dd($employees);

        if ($format === 'excel') {
            return Excel::download(new EmployeeExport($employees), 'employees.xlsx');
        } elseif ($format === 'pdf') {
            $pdf = app()->make(PDF::class);
            $pdf->loadView('exports.employee_pdf', compact('employees'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download('employees.pdf');
        }
    
    }
    public function employeeExportId($format,$id)
    {
        $employees = DB::table('employees')
                        ->select('employees.name','employees.lname','employees.employee_no','employees.email','departments.name as department','designations.name as designation','employees.gender','employees.dob','employees.age','employees.nationality','employees.marital_status','employees.mobile1','employees.mobile2','employees.qidno','employees.qidexpiry','employees.passportno','employees.passportexpiry','employees.joiningdate','school_shift.name as school_shift','employees.end_probation','contract_type.name as contract_type','employees.contract_length','employees.end_contract','employees.service_years','sponsorship_status.name as sponsorship_status','employee_payroll_informations.basic_salary as basic_salary','employee_payroll_informations.accomodation_allowance as accomodation_allowance','employee_payroll_informations.transport_allowance as transport_allowance','employee_payroll_informations.other_allowance as other_allowance','employee_payroll_informations.gross_total as gross_total',
                        'employee_payroll_informations.bank_name as bank_name','employee_payroll_informations.account_no as account_no','employee_payroll_informations.iban_no as iban_no','countries.country_name as nationality')
                        ->join('departments', 'employees.department', '=', 'departments.id')
                        ->join('designations', 'employees.designation', '=', 'designations.id')
                        ->join('contract_type','employees.contract_type','=', 'contract_type.id')
                        ->join('countries','employees.nationality','=', 'countries.id')
                        ->join('school_shift','employees.school_shift','=', 'school_shift.id')
                        ->join('sponsorship_status','employees.sponsorship_status','=', 'sponsorship_status.id')
                        ->join('employee_payroll_informations','employees.user_id','=','employee_payroll_informations.user_id')
                        ->where('employees.status', 1)
                        ->where('employees.employee_no',$id)
                        // ->orderByRaw("CASE 
                        //             WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        //             ELSE employees.employee_no END")
                        // ->orderBy('employees.employee_no')
                        ->get();
        //dd($employees);

        if ($format === 'excel') {
            return Excel::download(new EmployeeExport($employees), 'employees.xlsx');
        } elseif ($format === 'pdf') {
            $pdf = app()->make(PDF::class);
            $pdf->loadView('exports.employee_pdf', compact('employees'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download('employees.pdf');
        }
    }
    public function payrollIndex(Request $request)
    {
        if(isset($request->curMonth)){
            $currentMonth = Carbon::parse($request->curMonth)->format('F-Y');
        }else{
            $currentMonth = Carbon::now()->format('F-Y');
        }
        
        $payroll_details = DB::table('monthlysalaries')
        ->select(
            'employees.employee_no as employee_no',
            'employees.name as employee_name',
            'employees.joiningdate as employee_joiningdate',
            'designations.name as designation',
            'employee_payroll_informations.basic_salary as basic',
            'employee_payroll_informations.gross_total as gross',
            'employee_payroll_informations.other_allowance as others',
            'monthlysalaries.total_gross_salary',
            'gratuity.gratuity_total as gratuity',
            'earnings.total_addtional_amount as addtional_amount',
            'monthlysalaries.total_addtional_amount',
            'deductions.total_deduction_amount as deduction_amount',
            'monthlysalaries.total_deduction_amount as total_deduction_amount',
            'monthlysalaries.net_salary',
            'departments.name as department',
            'employee_payroll_informations.iban_no as iban',
            'monthlysalaries.month_year as month_year',
            'monthlysalaries.remarks',
            'employees.department as dept_id'
        )
        ->join('employees', 'monthlysalaries.employee_id', '=', 'employees.id')
        ->join('designations', 'employees.designation', '=', 'designations.id')
        ->join('employee_payroll_informations', 'employees.user_id', '=', 'employee_payroll_informations.user_id')
        ->leftJoin('gratuity', 'employees.employee_id', '=', 'gratuity.employee_id')
        ->leftJoin('earnings','employees.employee_id','=','earnings.employee_id')
        ->leftJoin('deductions','employees.employee_id','=','deductions.employee_id')
        ->join('departments', 'employees.department', '=', 'departments.id')
        ->where('monthlysalaries.month_year', 'LIKE', $currentMonth)
        ->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")
        ->orderBy('employees.employee_no')
        ->get();
        
        
        // dd($payroll_details);
        return view('reports.pay-roll',compact('payroll_details','currentMonth'));
    }
    public function payrollExport($format)
    {
        $currentMonth = Carbon::now()->format('F-Y');
        $payroll_details = DB::table('monthlysalaries')
        ->select(
            'employees.name as employee_name',
            'employees.joiningdate as employee_joiningdate',
            'designations.name as designation',
            'employee_payroll_informations.basic_salary as basic',
            'employee_payroll_informations.gross_total as gross',
            'employee_payroll_informations.other_allowance as others',
            'monthlysalaries.total_gross_salary',
            'gratuity.gratuity_total as gratuity',
            'earnings.total_addtional_amount as addtional_amount',
            'monthlysalaries.total_addtional_amount',
            'deductions.total_deduction_amount as deduction_amount',
            'monthlysalaries.net_salary',
            'departments.name as department',
            'employee_payroll_informations.iban_no as iban',
            'monthlysalaries.remarks',
            'employees.department as dept_id'
        )
        ->join('employees', 'monthlysalaries.employee_id', '=', 'employees.id')
        ->join('designations', 'employees.designation', '=', 'designations.id')
        ->join('employee_payroll_informations', 'employees.user_id', '=', 'employee_payroll_informations.user_id')
        ->leftJoin('gratuity', 'employees.employee_id', '=', 'gratuity.employee_id')
        ->leftJoin('earnings','employees.employee_id','=','earnings.employee_id')
        ->leftJoin('deductions','employees.employee_id','=','deductions.employee_id')
        ->join('departments', 'employees.department', '=', 'departments.id')
        ->where('monthlysalaries.month_year', 'LIKE', $currentMonth)
        ->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")
        ->orderBy('employees.employee_no')
        ->get();

        if ($format === 'excel') {
            return Excel::download(new PayrollExport($payroll_details), 'payroll.xlsx');
        } elseif ($format === 'pdf') {
            $pdf = app()->make(PDF::class);
            $pdf->loadView('exports.payroll_pdf', compact('payroll_details'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->download('payroll.pdf');
        }
    }

    public function timesheetIndex()
    {
        $employees = Employees::all(); 

    $dates = [];
  
    $startDate = Carbon::now()->subMonth()->startOfMonth()->setDay(26);
    $endDate = Carbon::now()->startOfMonth()->setDay(25);
   
    
    $attendanceData = [];
    foreach ($employees as $employee) {
       
        $attendance = [];
        $loopDate = clone $startDate;
        while ($loopDate <= $endDate) {
            $checkin = null;
            $leaveApplication = null;
            $attendanceRecord = DB::table('attendances')
               ->where('employee_id', $employee->employee_id)
                ->whereRaw("DATE_FORMAT(check_in, '%Y-%m-%d') = ?", [$loopDate->format('Y-m-d')])
                ->first();

            if ($attendanceRecord) {
              
                $checkin = 'H';
            }
            
            $leaveApplication = DB::table('leave_applications')
                    ->where('employee_id', $employee->employee_id)
                    ->where('status', $this->leave_approval_status['approved'])
                    ->where(function ($query) use ($loopDate) {
                        $formattedDate = $loopDate->format('Y-m-d');
                        $query->whereDate('date_from', '<=', $formattedDate)
                            ->whereDate('date_to', '>=', $formattedDate);
                    })
                    ->first();
            
            $attendance[$loopDate->format('Y-m-d')] = [
                'checkin' => $checkin ,
                'leave' => $leaveApplication ? 'L' : '',
            ];
           
            $loopDate->addDay();
        }
    
        $attendanceData[] = [
            'name' => $employee->name,
            'attendance' => $attendance,
        ];
    }
    //    
     while ($startDate <= $endDate) {
         $dates[] = $startDate->format('Y-m-d');
         $startDate->addDay();
     }
    //  dd($attendanceData);
        return view('reports.timesheet-reports',compact('attendanceData','dates'));
    }

    public function timesheetExport($format)
{
    $employees = Employees::all(); 

    $dates = [];
  
    $startDate = Carbon::now()->subMonth()->startOfMonth()->setDay(26);
    $endDate = Carbon::now()->startOfMonth()->setDay(25);
   
    
    $attendanceData = [];
    foreach ($employees as $employee) {
       
        $attendance = [];
        $loopDate = clone $startDate;
        while ($loopDate <= $endDate) {
            $checkin = null;
            $leaveApplication = null;
            $attendanceRecord = DB::table('attendances')
               ->where('employee_id', $employee->employee_id)
                ->whereRaw("DATE_FORMAT(check_in, '%Y-%m-%d') = ?", [$loopDate->format('Y-m-d')])
                ->first();

            if ($attendanceRecord) {
               
                $checkin = 'H';
            }
            
            
                $leaveApplication = DB::table('leave_applications')
                    ->where('employee_id', $employee->employee_id)
                    ->where('status', $this->leave_approval_status['approved'])
                    ->where(function ($query) use ($loopDate) {
                        $formattedDate = $loopDate->format('Y-m-d');
                        $query->whereDate('date_from', '<=', $formattedDate)
                            ->whereDate('date_to', '>=', $formattedDate);
                    })
                    ->first();
           
            $attendance[$loopDate->format('Y-m-d')] = [
                'checkin' => $checkin ,
                'leave' => $leaveApplication ? 'L' : '',
            ];
            // dd($attendance);
            $loopDate->addDay();
        }
    
        $attendanceData[] = [
            'name' => $employee->name,
            'attendance' => $attendance,
        ];
    }
   
     while ($startDate <= $endDate) {
         $dates[] = $startDate->format('Y-m-d');
         $startDate->addDay();
     }
   

    if ($format === 'excel') {
        return Excel::download(new TimesheetExport($attendanceData, $dates), 'Timesheet.xlsx');
    } elseif ($format === 'pdf') {
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('exports.timesheet', compact('attendanceData', 'dates'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('Timesheet.pdf');
    }
}


    public function monthly_leave_report(Request $request)
    {
        //return view('reports.monthly_leave_index');

        $leave_data = NULL;            

        $date_from = $request->date_from?$request->date_from:date('Y-m-01');
        $date_to = $request->date_to?$request->date_to:date('Y-m-d');

        $leaves = LeaveApplication::with(['employee','leavetypes'])
                                    ->where('status', $this->leave_approval_status['approved'])
                                    ->where(function($query) use ($date_from, $date_to){
                                        $query->whereBetween('date_from', [$date_from, $date_to])
                                              ->orWhereBetween('date_to', [$date_from, $date_to]); 
                                    })                                    
                                    ->orderby('date_from', 'desc')
                                    ->get();
        if($leaves->isNotEmpty()){
            foreach($leaves as $eachleave){
                $data = new \stdClass(); 
                
                $data->emp_id = $eachleave->employee->employee_no; //employeeIdMaker($eachleave->employee->employee_id);
                $data->emp_name = $eachleave->employee->name.' '.$eachleave->employee->lname;               
                $data->leave_type = $eachleave->leavetypes->name;
                $data->date_from = date('d-m-Y', strtotime($eachleave->date_from));
                $data->date_to = date('d-m-Y', strtotime($eachleave->date_to));
                $data->time_from = ('null'!=$eachleave->time_from)?$eachleave->time_from:'--';
                $data->time_end = ('null'!=$eachleave->time_end)?$eachleave->time_end:'--';
                $data->no_days = $eachleave->no_days;
                $data->paid_status = (1==$eachleave->paid_status) ? "Yes" : 'No';
                $data->reason = $eachleave->reason;
                /*$data->paid_status = (1==$eachleave->paid_status)?'Unpaid':'Paid';*/

                $leave_data[] = $data;
            }

            if($request->has('excel')){ 
                return Excel::download(new MonthlyLeavesExport($leave_data), 'monthly_leave_report.xlsx');
            }else{    
                return view('reports.monthly_leave_report', compact('leaves'))->with('request', $request);
            }
        }else{    
            $leaves = NULL;          
            return view('reports.monthly_leave_report', compact('leaves'));
        }  
    }

    public function employee_leave_sheet()
    {
        $emp_list = Employees::where('status', 1)->get();
        return view('reports.employee_leave_sheet', compact('emp_list'));
    }

    public function employee_leave_sheet_report(Request $request)
    {
        $leaves = NULL; 
        $unpaid = new \stdClass(); 

        $request->validate([
            'employee_id' => 'required',
        ]);

        $date_from = $request->date_from?$request->date_from:'';
        $date_to = $request->date_to?$request->date_to:'';
        $employee_id = $request->employee_id;

        $employee = Employees::with(['departments', 'designations'])
                                ->select('employee_id', 'employee_no', 'name', 'lname', 'joiningdate', 'department', 'designation')
                                ->where('id', $employee_id)->first();

        $leavetypes = LeaveType::select('id', 'name','leave_days')
                                ->where('active', 1)
                                ->get();

        foreach($leavetypes as $eachlt){
            $leave_summary = LeaveApplication::groupBy('leave_type')
                                    ->select(\DB::raw('SUM(no_days) as used_count') )
                                    ->where('employee_id', $employee_id)
                                    ->where('leave_type', $eachlt->id)
                                    ->where('status', $this->leave_approval_status['approved'])
                                    ->where('academic_year', $this->academic_year)
                                    ->get();
            if($leave_summary->isNotEmpty()){
                $eachlt->used_count = $leave_summary[0]->used_count; 
            }else{
                $eachlt->used_count = 0;  
            }
            $eachlt->balance = (($eachlt->leave_days - $eachlt->used_count) < 0) ? 0 : abs($eachlt->leave_days - $eachlt->used_count);
        }   

        $unpaid_data = LeaveApplication::select(\DB::raw('SUM(no_days) as unpaid_count'))
                                    ->where('employee_id', $employee_id)
                                    ->where('paid_status', 1)
                                    ->where('status', $this->leave_approval_status['approved'])                                    
                                    ->get(); 
        $unpaid->avail = (2!=$employee->department)?45:30;
        $unpaid->used = ($unpaid_data->isNotEmpty())?$unpaid_data[0]->unpaid_count:0;
        $unpaid->balance = abs($unpaid->avail - $unpaid->used);   

        $all_leaves = LeaveApplication::with(['leavetypes'])                                    
                                    ->where('employee_id', $employee_id)
                                    ->where('status', $this->leave_approval_status['approved'])
                                    /*->where(function($query) use ($date_from, $date_to){
                                        $query->whereBetween('date_from', [$date_from, $date_to])
                                              ->orWhereBetween('date_to', [$date_from, $date_to]); 
                                    })*/
                                    ->where('academic_year', $this->academic_year)
                                    ->orderby('date_from', 'desc')
                                    ->get(); 

        if($request->has('doc')){ 

            /*$phpWord = new PhpWord();
            $section = $phpWord->addSection();
            $html = view('reports.employee_leave_sheet_report', compact('employee', 'leavetypes', 'unpaid', 'all_leaves'))->render();
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, true);            
            $filename = 'employee_leave_sheet_report.docx';
            $phpWord->save($filename);        
            return response()->download($filename)->deleteFileAfterSend(true);*/

        }else{    
            
            return view('reports.employee_leave_sheet_report', compact('employee', 'leavetypes', 'unpaid', 'all_leaves'))
                                                                ->with('request', $request);
        }
        
    }

    public function employee_timesheet_report(Request $request)
    {          
        $dates = [];

        $date_from = $request->date_from?$request->date_from:( 25 < date('d')?date('Y-m-26'):date('Y-m-26', strtotime("-1 month")) );        
        $date_to = $request->date_to?$request->date_to:date('Y-m-d');

        while (strtotime($date_from) <= strtotime($date_to)) {
            $daynr = date('d', strtotime($date_from));
            $dayne = date('D', strtotime($date_from));
            $mnth  = date('F', strtotime($date_from));
            $dates[] = array('no'=>$daynr, 'name'=>$dayne, 'date'=>$date_from, 'month'=>$mnth);
            $date_from = date ("Y-m-d", strtotime("+1 day", strtotime($date_from)));
        }

        $employees = Employees::where('status', 1)/*->where('id', 17)*/
                      ->select('id','employee_no','name','lname','department')
                      ->orderByRaw("CASE 
                                WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                ELSE employees.employee_no END")
                      ->orderBy('employees.employee_no')
                      ->get();

        if($employees->isNotEmpty() && count($dates) > 0 ){
            foreach($employees as $eachemp){
                $emp_dept = Department::where('id', $eachemp->department)->select('name')->first();
                $eachemp->departmentname = ($emp_dept) ? $emp_dept->name : '';
                $leave_data = NULL; 
                $worked = 0;
                $paid = 0;
                $unpaid = 0;
                $datescount = count($dates);
                foreach($dates as $eachdate){
                        $matchdate = $eachdate['date'];
                        /*Holidays/Weekend: Friday & Saturday */
                        if('Fri'!=$eachdate['name'] && 'Sat'!=$eachdate['name']){

                            /*Fetch leave datails */
                            $leaves = LeaveApplication::with(['leavetypes'])
                                            ->where('status', $this->leave_approval_status['approved'])
                                            ->where('employee_id', $eachemp->id)
                                            ->where(function($query) use($matchdate){
                                                $query->whereDate('date_from', '<=', $matchdate)
                                                    ->whereDate('date_to', '>=', $matchdate);
                                            })->get();
                            
                            if($leaves->isNotEmpty()){

                                /*If leave type is short(SL) */
                                if($leaves[0]->leave_type==6){

                                    /*If leave is unpaid */
                                    if($leaves[0]->paid_status==1){
                                        $unpaid = $unpaid+0.5;
                                    }else{
                                        $paid = $paid+0.5;
                                    }
                                    $worked = $worked+0.5;

                                }else{

                                    if($leaves[0]->paid_status==1)
                                        $unpaid++;
                                    else
                                        $paid++;

                                }
                                $eachdate['leave'] = $leaves;
                            }else{
                                $eachdate['leave'] = null;
                                $worked++;
                            }
                        }else{
                            $datescount--;
                            $eachdate['leave'] = null;
                        }
                    /*Store to new array */
                    $leave_data[] = $eachdate;
                }
                $eachemp->leavedata = $leave_data;
                $eachemp->worked = $worked;
                $eachemp->paid = $paid;
                $eachemp->unpaid = $unpaid;
                $eachemp->emp_name = $eachemp->name.' '.$eachemp->lname;
            }

            /*Prepared/Reviewed/Approved admin details */
            $creators['prepared'] = Employees::select('name', 'lname')->where('user_id', 3)->first();
            $creators['reviewed'] = Employees::select('name', 'lname')->where('user_id', 64)->first();
            $creators['approved'] = Employees::select('name', 'lname')->where('user_id', 19)->first();
            
            $groupedEmployees = collect($employees)->groupBy('departmentname');

            //if($request->has('excel')){ 
                //return Excel::download(new EmployeeTimesheetExport($employees, $dates), 'Employee_Timesheet.xlsx');
            //}else{    
                return view('reports.employee_timesheet_report', compact('groupedEmployees', 'dates', 'creators'))->with('request', $request);
            //}
        }else{    
            $leaves = NULL;
            return view('reports.employee_timesheet_report', compact('groupedEmployees'));
        }  
    }
    public function attendance_report(Request $request)
    {
       
        // if($request->has('month'))
        //     $currentMonth = $request->month;
        // else 
        //     $currentMonth = Carbon::now()->month;
        // // dd($currentMonth);
        // $employees = Employees::select('id', 'employee_id', 'user_id', 'employee_no', 'name', 'lname')
        //                         ->where('status', 1)                                
        //                         ->orderByRaw("CASE 
        //                                         WHEN employee_no REGEXP '^[0-9]+$' THEN LPAD(employee_no, 10, '0') 
        //                                         ELSE employee_no END")
        //                         ->orderBy('employee_no')
        //                         ->get(); 
        // foreach($employees as $eachemp){
        //     $eachemp->attendance_data = Attendance::select('attendances.status', 'attendances.check_in', 'attendances.check_out')
        //                                 ->where('employee_id', $eachemp->id)
        //                                 ->where('academic_year', $this->academic_year)
        //                                 ->where(function ($subquery) use ($currentMonth) {
        //                                     $subquery->whereMonth('attendances.check_in', $currentMonth)
        //                                         ->orWhereMonth('attendances.check_out', $currentMonth);
        //                                 })
        //                                 ->get();
        //     dd($eachemp);
        // }    
       
        if ($request->has('month')) {
            $currentMonth = $request->month;
            $currentYear = $request->year ?? Carbon::now()->year;
        } else { 
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year; 
        }

        $currentYear = Carbon::now()->year; // Get the current year

        // Get all employees for the dropdown filter
        $employeeList = Employees::select('id', 'employee_no', 'name', 'lname')
                        ->where('status', 1)
                        ->orderBy('name')
                        ->get();

        $query = Employees::select('id', 'employee_id', 'user_id', 'employee_no', 'name', 'lname')
            ->where('status', 1);

        // Apply employee filter if selected
        if ($request->has('employee_id') && !empty($request->employee_id)) {
            $query->where('id', $request->employee_id);
        }

        $employees = $query->orderByRaw("CASE 
                            WHEN employee_no REGEXP '^[0-9]+$' THEN LPAD(employee_no, 10, '0') 
                            ELSE employee_no END")
            ->orderBy('employee_no')
            ->get();

        foreach ($employees as $eachemp) {
            $eachemp->attendance_data = Attendance::select('attendances.status', 'attendances.check_in', 'attendances.check_out')
                                        ->where('employee_id', $eachemp->id)
                                        /*->where('academic_year', $this->academic_year)*/
                                        ->where(function ($subquery) use ($currentMonth, $currentYear) {
                                            $subquery->whereMonth('attendances.check_in', $currentMonth)
                                                     ->whereYear('attendances.check_in', $currentYear)
                                                     ->orWhere(function ($subquery) use ($currentMonth, $currentYear) {
                                                         $subquery->whereMonth('attendances.check_out', $currentMonth)
                                                                  ->whereYear('attendances.check_out', $currentYear);
                                                     });
                                        })
                                        ->get();
        }

            
        return view('reports.attendance_report',compact('employees', 'currentMonth', 'employeeList'));
    }

    public function employee_presence_report(Request $request)
    {
        $employees = NULL;
        $curDate = ($request->has('curdate')) ? $request->curdate : date('Y-m-d');
        $timeFrom = ($request->has('timefrom')) ? $request->timefrom : '00:01';
        $timeTo = ($request->has('timeto')) ? $request->timeto : '23:59';

        /*DB::enableQueryLog();*/

        $emp_data = Employees::with(['attendance' => function($query) use($curDate, $timeFrom, $timeTo){
                                        $query->where(function($subquery1) use($curDate){
                                            $subquery1->whereDate('check_in', $curDate)
                                                    ->orWhereDate('check_out', $curDate);
                                        });
                                        /*->where(function($subquery2) use($timeFrom, $timeTo){
                                            $subquery2->whereTime('check_in', '<', $timeTo)
                                                    ->whereNull('check_out')

                                                    ->orWhere(function($subquery3) use($timeFrom, $timeTo){
                                                        $subquery3->whereTime('check_out', '>', $timeFrom)
                                                                    ->whereNull('check_in');
                                                    });
                                        });*/
                                    }])
                                    ->select('employee_id', 'employee_no', 'name', 'lname')
                                    ->where('status', 1)
                                    //->where('id', 12)
                                    ->get();
                                    
                                    /*$queries = DB::getQueryLog();
                                    $lastQuery = end($queries);
                                    dd($lastQuery);*/
        
        if($emp_data->isNotEmpty()){
            foreach($emp_data as $flt){

                $check_in = []; 
                $check_out = []; 
                $checkArray = NULL;

                /*If attendance data exist in a particular day */
                if($flt->attendance->isNotEmpty()){ 

                    /*Make  separate arrays for CheckIn & CheckOut 
                     *[This because, checkin time & checkout time are separate rows in the db table] */
                    foreach($flt->attendance as $attendance){
                        if($attendance->status == 'check-in')
                            $check_in[] = $attendance->check_in;
                        else
                            $check_out[] = $attendance->check_out;
                    }

                    /*Max count b/w arrays */
                    $chk_count = (count($check_in) >= count($check_out)) ? count($check_in) : count($check_out);
                    
                    /*Loop through max count array and find existance the data b/w the particular interval */
                    for ($i = 0; $i < $chk_count; $i++) {
                        $checkInTime = isset($check_in[$i]) ? $check_in[$i] : 0;
                        $checkOutTime = isset($check_out[$i]) ? $check_out[$i] : 0;

                        if (isDataPresentInterval($checkInTime, $checkOutTime, $timeFrom, $timeTo)) {
                            $checkInTime = (0!=$checkInTime)?Carbon::parse($checkInTime)->format('H:i'):'';
                            $checkOutTime = (0!=$checkOutTime)?Carbon::parse($checkOutTime)->format('H:i'):'';
                            $checkArray[] = "In: ".$checkInTime." - Out:".$checkOutTime;
                        }
                    }

                    /*If found data in b/w interval: store them to display */
                    if(NULL!=$checkArray){
                        $employees[] = array(
                            'employee_id' => $flt->employee_id,
                            'employee_no' => $flt->employee_no,
                            'employee_fullname' => $flt->name.' '.$flt->lname,
                            'timing' => $checkArray
                        );
                    }
                }
            }
        }

        return view('reports.employee_presence_report',compact('employees', 'curDate', 'timeFrom', 'timeTo'));
    }
    public function gratuityreport()
    {
        $emp_list = Gratuity::with(['gratuitystatus',
                                    'employee'])->get();
        return view('reports.gratuity_report_view', compact('emp_list'));
    }
    /* public function final_pay(Request $request)
    {
        $gratiuity = DB::table('gratuity')
                    ->select('gratuity.*','employees.employee_no','employees.qidno','employees.passportno'
                    ,'employees.name','employees.lname','employees.dob','departments.name as department',
                    'designations.name as designation','employee_payroll_informations.gross_total as gross_total')
                    ->leftJoin('employees','gratuity.employee_id','=','employees.employee_id')
                    ->leftJoin('employee_payroll_informations','employees.user_id','=','employee_payroll_informations.user_id')
                    ->leftJoin('departments','employees.department','=','departments.id')
                    ->leftjoin('designations','employees.designation','=','designations.id')
                    ->get();
        // dd($gratiuity);
        return view('reports.final_pay',compact('gratiuity'));
    } */
    public function final_statement(Request $request)
    {
        if(null!=$request->employee_id){
            $gratiuity = DB::table('gratuity')                    
                        ->where('gratuity.employee_id',$request->employee_id)
                        ->select('gratuity.*','employees.employee_no','employees.qidno','employees.passportno'
                        ,'employees.name','employees.lname','employees.dob','departments.name as department',
                        'designations.name as designation','employee_payroll_informations.gross_total as gross_total',
                        'employees.qidno','countries.country_name as country_name','employee_payroll_informations.basic_salary as basic_salary'
                        ,'employee_payroll_informations.accomodation_allowance as accomodation_allowance','employee_payroll_informations.transport_allowance as transport_allowance'
                        )
                        ->leftJoin('employees','gratuity.employee_id','=','employees.employee_id')
                        ->leftJoin('employee_payroll_informations','employees.user_id','=','employee_payroll_informations.user_id')
                        ->leftJoin('departments','employees.department','=','departments.id')
                        ->leftjoin('designations','employees.designation','=','designations.id')
                        ->leftJoin('countries','employees.nationality','=','countries.id')
                        ->first();                        
            return view('reports.final_statement',compact('gratiuity'));
        }else{
            $gratiuity = DB::table('gratuity')
                    ->select('gratuity.*','employees.employee_no','employees.qidno','employees.passportno'
                    ,'employees.name','employees.lname','employees.dob','departments.name as department',
                    'designations.name as designation','employee_payroll_informations.gross_total as gross_total')
                    ->leftJoin('employees','gratuity.employee_id','=','employees.employee_id')
                    ->leftJoin('employee_payroll_informations','employees.user_id','=','employee_payroll_informations.user_id')
                    ->leftJoin('departments','employees.department','=','departments.id')
                    ->leftjoin('designations','employees.designation','=','designations.id')
                    ->get();            
            return view('reports.final_pay',compact('gratiuity'));
        }
    }
    public function perfomanceIndex()
    {
        $employees = DB::table('employees')
            ->select('employees.name','employees.lname','employees.employee_no','employees.email','departments.name as department','designations.name as designation','employees.employee_id','employees.gender','employees.dob','employees.age','employees.nationality','employees.marital_status','employees.mobile1_code','employees.mobile1','employees.mobile2_code','employees.mobile2','employees.qidno','employees.qidexpiry','employees.passportno','employees.passportexpiry','employees.joiningdate','employees.school_shift','employees.end_probation','contract_type.name as contract_type','employees.contract_length','employees.end_contract','employees.service_years','employees.hrcomment','employees.sponsorship_status','employees.fas_sponsor','employees.fas_spo_date','employees.tkt_allowance_dur','employees.relevant_degree','employee_payroll_informations.basic_salary as basic_salary','employee_payroll_informations.accomodation_allowance as accomodation_allowance','employee_payroll_informations.transport_allowance as transport_allowance','employee_payroll_informations.other_allowance as other_allowance','employee_payroll_informations.gross_total as gross_total',
            'employee_payroll_informations.bank_name as bank_name','employee_payroll_informations.account_no as account_no','employee_payroll_informations.iban_no as iban_no','countries.country_name as nationality')            
            ->join('departments', 'employees.department', '=', 'departments.id')
            ->join('designations', 'employees.designation', '=', 'designations.id')
            ->join('contract_type','employees.contract_type','=', 'contract_type.id')
            ->join('countries','employees.nationality','=', 'countries.id')
            ->join('employee_payroll_informations','employees.user_id','=','employee_payroll_informations.user_id')
            ->where('employees.status', 1)
            ->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")
            ->orderBy('employees.employee_no')
            ->get();
        return view('reports.perfomance_index',compact('employees'));
    }
    public function permanceData(Request $request)
    {
        // dd($request);
        $emp_id = $request->employee_no;
        $appraisal = AppraisalReport::where('employee_id',$emp_id)->get();
        $ppr = PprForm::where('employee_id',$emp_id)->get();
        $scf = Scf::where('employee_id',$emp_id)->get();
        $pip = Pip::where('employee_id',$emp_id)->get();
        return view('reports.employee_perfomance_view',compact('appraisal','ppr','scf','pip'));
    }
    public function appraisal_report($id)
    {     
        $appraisal = AppraisalReport::with('employee.departments','employee.designations')->findorfail($id);
        $appraisalDataIds = json_decode($appraisal->appraisal_data);
        $appraisalFeedback = Appraisal_datas::with('appriasal_type')->whereIn('id', $appraisalDataIds)->get();
        // $employees = Employees::with('user')->where('employee_id',$id)->get();
        // dd($appraisal);
        return view('reports.perfomance.appraisal',compact('appraisal','appraisalFeedback','appraisalDataIds'));
    }
    public function ppr_report($id)
    {
        $ppr_form = PprForm::with('employee','employee.departments','employee.designations')->find($id);
        $review_id = json_decode($ppr_form->performance_review);
        $review_data = PerformanceReview::whereIn('id', $review_id)->get();
        $employee = Employees::with('user','departments','designations')->where('employee_id',$ppr_form->employee_id)->first();
        return view('reports.perfomance.ppr',['ppr_form' => $ppr_form,'review_data' => $review_data,'employee'=>$employee]);
    }
    public function scf_report($id)
    {
        // dd($id);
        $scf = Scf::with('employee','employee.departments','employee.designations')->find($id);
        $scf_id = json_decode($scf->scf_data);
        $scf_datas = ScfData::whereIn('id', $scf_id)->get();
        $employee = Employees::with('user','departments','designations')->where('employee_id',$scf->employee_id)->first();
        $staff_member =  User::where('id', $scf->slt_member)->first();
        // dd($staff_member->name);
        return view('reports.perfomance.scf',compact('staff_member','scf','scf_datas','employee'));
    }
    public function pip_report($id)
    {
        $pip = Pip::with('employee','employee.departments','employee.designations')->find($id);
        $employee = Employees::with('user','departments','designations')->where('employee_id',$pip->employee_id)->first();
        return view('reports.perfomance.pip',compact('pip','employee'));
    }
}
