<?php

namespace App\Http\Controllers;
use App\Http\Controllers\HrmController;
use Illuminate\Support\Facades\Auth;
use App\Models\Earning;
use App\Models\Employee\Employees;
use App\Models\Employee\EmployeePayrollInformation;
use App\Models\Monthlysalary;
use App\Models\Leave\LeaveApplication;
use App\Models\Gratuity\Gratuity;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonthlysalaryController extends HrmController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = date('F-Y');
        $last_month_start = date('Y-m-26', strtotime('last month'));
        $this_month_end = date('Y-m-25');
        $currentYear = Carbon::now()->year;
        $acamedic_staff_vaction_leave = Carbon::createFromDate($currentYear, 7, 1)->format('F-Y');
        $academic_strat_date = Carbon::createFromDate($currentYear, 3, 1)->format('F-Y');

        //Check payroll exist for this month
        $salary_data = MonthlySalary::where('month_year', 'like', '%'.$date.'%')->get();
        $month = $date;

        //Last payroll date
        $last_payroll_date = '';
        $last_payroll = MonthlySalary::select('created_at', 'month_year', 'entry_date')
                        ->where('is_gratuity', 0)
                        ->orderBy('id', 'desc')->first();
        if(null!=$last_payroll){
            $last_payroll_date = $last_payroll->created_at;
            $last_payroll_entry = $last_payroll->entry_date;
            $last_payroll_for = $last_payroll->month_year;
            
            // Define the starting date (you can customize this)
             $startDate = $last_payroll->created_at;

            //Next day
            $entry_date = $last_payroll->entry_date;
            $entry_date = Carbon::createFromFormat('Y-m-d H:i:s', $entry_date, 'Europe/London');
            $nextDay = $entry_date->copy()->addDay();

            // Move to the next month from the start date
            $nextMonth = $startDate->copy()->addMonth();
            $startDate->addMonth();

            // Get the current date
            $curDate = Carbon::now();

            // Add two months to the current date
            $endDate = $curDate->copy()->addMonths(2);

            // Generate a list of months from the starting date to the end date after the last payroll month
            $months = [];
            while ($startDate->lte($endDate)) {
                $months[$startDate->format('F-Y')] = $startDate->format('F-Y'); // e.g., '2023-05' => 'May 2023'
                $startDate->addMonth();
            }

            //Next date after last payroll date for leave check start
            $leave_check_start_date = $nextDay;
        }else{
            $leave_check_start_date = last_month_start;
        }

        $leave_check_end_date = Carbon::now();

        /* //End date for leave check
        $coming_mnth = $nextMonth->format('F-Y');
        if($date != $coming_mnth){
            list($monthName, $year) = explode('-', $coming_mnth);
            $monthNumber = Carbon::parse($monthName)->month;
            $date25th = Carbon::create($year, $monthNumber, 25);

            $leave_check_end_date = $date25th; //$date25th->toDateString();
        }else{
            $leave_check_end_date = $curDate;
        } */

        $employees = Employees::with([/*'employeePayrollInformation',*/ 'employeeDepartment','designations', 'employeeEarnings' => function($query) use ($date) {

            $query->where('month_year', 'like', '%'.$date.'%');
        }, 'employeeDeduction' => function($query) use ($date) {
            $query->where('month_year', 'like', '%'.$date.'%');},'monthlysalary' => function($query) use ($date) {
            $query->where('month_year', 'like', '%'.$date.'%');}])
        ->where('status', 1)
        ->whereNotNull('joiningdate')
        ->whereNotNull('department')
        ->whereNotNull('designation')
        //->orderByRaw('CAST(employee_no AS SIGNED)', 'asc')
        ->orderByRaw("CASE 
                        WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                        ELSE employees.employee_no END")
        ->orderBy('employees.employee_no')
        ->get();

        foreach($employees as $employee){
            
            $employee->employeePayrollInformation = EmployeePayrollInformation::where('user_id', $employee->user_id)->orderBy('id', 'desc')->first();

            if($employee->employeeDepartment->name == "Academic"){

            // condition for academics staff
                if($acamedic_staff_vaction_leave == $date){
                    //July month salary process
                    if($employee->joiningdate <= $academic_strat_date){
                        //Non earning staff
                        $employee_gross_salary = (!empty($employee->employeePayrollInformation))?$employee->employeePayrollInformation->gross_total:0;
                        if($employee->employeeEarnings)
                        {//addition amount
                        $employee_total_additions = $employee->employeeEarnings->total_addtional_amount;
                        }
                        else
                        {
                            $employee_total_additions = 0;
                        }
                        if($employee->employeeDeduction)
                        {//deduction amount
                            $employee_total_deduction = (!empty($employee->employeePayrollInformation))?$employee->employeePayrollInformation->gross_total:0;
                        }
                        else
                        {
                                $employee_total_deduction = 0;
                        }
                       // Y (how many days salary to be paid) = (total working days in academic year / how many days employee worked) * break days (25)
                        //X (amount for single day) = total package of the employee / 30 days
                        //Pay for non-earning month  = X  * Y(for the first year).
                        $no_of_days = (90/30)*25;
                        //dd($no_of_days);
                        $per_day_salary = $employee_gross_salary /30;
                        $pay_non_earning_month =  $no_of_days*$per_day_salary;
                        $total_net_salary = ($pay_non_earning_month+$employee_total_additions)-$employee_total_deduction;
                        $leave = 0;
                        $leave_deduction_amount = 0;
                        
                    }else{
                        //earining staff
                        $employee_gross_salary = (!empty($employee->employeePayrollInformation))?$employee->employeePayrollInformation->gross_total:0;
                        if($employee->employeeEarnings)
                        {//addition amount
                        $employee_total_additions = $employee->employeeEarnings->total_addtional_amount;
                        }
                        else
                        {
                            $employee_total_additions = 0;
                        }
                        if($employee->employeeDeduction)
                        {//deduction amount
                            $employee_total_deduction = $employee->employeeDeduction->total_deduction_amount;
                        }
                        else
                        {
                                $employee_total_deduction = 0;
                        }
                        //$leave_deduction_amount = $per_day_salary*$leave;
                        $total_net_salary =($employee_gross_salary +$employee_total_additions)- $employee_total_deduction;
                    }
    
                }else{
                    //regular month salary generation
                    $employee_gross_salary = (!empty($employee->employeePayrollInformation))?$employee->employeePayrollInformation->gross_total:0;
                    $employee_basic_salary = (!empty($employee->employeePayrollInformation))?$employee->employeePayrollInformation->basic_salary:0;
                    if($employee->employeeEarnings)
                    {
                    $employee_total_additions = $employee->employeeEarnings->total_addtional_amount;
                    }
                    else
                    {
                        $employee_total_additions = 0;
                    }
                    if($employee->employeeDeduction)
                    {
                        $employee_total_deduction = $employee->employeeDeduction->total_deduction_amount;
                    }
                    else
                    {
                            $employee_total_deduction = 0;
                    }
                    $employee_id = $employee->employee_id;
                    $leave = 0;
                    $half_leave = 0;

                    $leave =  LeaveApplication::where('employee_id',$employee_id)
                                ->whereBetween('date_from', [$leave_check_start_date, $leave_check_end_date])
                                ->whereBetween('date_to', [$leave_check_start_date, $leave_check_end_date])
                                ->where('status', $this->leave_approval_status['approved'])
                                ->where('paid_status', 1)
                                ->sum('no_days');
                    /* Short leave & half-sick leave count   */
                    $half_leave =  LeaveApplication::where('employee_id',$employee_id)
                                ->whereBetween('date_from', [$leave_check_start_date, $leave_check_end_date])
                                ->whereBetween('date_to', [$leave_check_start_date, $leave_check_end_date])
                                ->where('status', $this->leave_approval_status['approved'])
                                ->whereIn('leave_type', [6,12])
                                ->where('paid_status', 1)
                                ->sum('no_days');

                    if($half_leave && 0 < $half_leave){
                        $leave = (float)($leave - $half_leave/2);
                    }
    
                    $joing_date = $employee->joiningdate;
                    $per_day_salary = $employee_gross_salary/30;
                    $per_day_basic = $employee_basic_salary/30;
                    if ($joing_date  >= $last_month_start)
                    {
                        // joindate starts from after 26th
                        $date1 = new DateTime($joing_date);
                        $date2 = new DateTime($this_month_end);
                        $interval = $date1->diff($date2);
                        $days = $interval->days;
                        $employee_gross_salary = $per_day_salary*$days ;
                        $leave_deduction_amount = $per_day_basic*$leave;
                        $total_net_salary =($employee_gross_salary +$employee_total_additions)- $employee_total_deduction-$leave_deduction_amount;
                    }
                    else
                    {
                        //regular salary
                        $leave_deduction_amount = $per_day_basic*$leave;
                        $total_net_salary =($employee_gross_salary +$employee_total_additions)- $employee_total_deduction-$leave_deduction_amount;
                    }
               } 

            }
            else
            {
                //condition for other staff
                $employee_gross_salary = (!empty($employee->employeePayrollInformation))?$employee->employeePayrollInformation->gross_total:0;
                $employee_basic_salary = (!empty($employee->employeePayrollInformation))?$employee->employeePayrollInformation->basic_salary:0;
		if($employee->employeeEarnings)
                {
                $employee_total_additions = $employee->employeeEarnings->total_addtional_amount;
                }
                else
                {
                    $employee_total_additions = 0;
                }
                if($employee->employeeDeduction)
                {
                    $employee_total_deduction = $employee->employeeDeduction->total_deduction_amount;
                }
                else
                {
                        $employee_total_deduction = 0;
                }
                $employee_id = $employee->employee_id;
                $leave = 0;
                $half_leave = 0;

                $leave =  LeaveApplication::where('employee_id',$employee_id)
                                            ->whereBetween('date_from', [$leave_check_start_date, $leave_check_end_date])
                                            ->whereBetween('date_to', [$leave_check_start_date, $leave_check_end_date])
                                            ->where('status', $this->leave_approval_status['approved'])
                                            ->where('paid_status', 1)
                                            ->sum('no_days');

                /* Short leave & half-sick leave count   */
                $half_leave =  LeaveApplication::where('employee_id',$employee_id)
                                                ->whereBetween('date_from', [$leave_check_start_date, $leave_check_end_date])
                                                ->whereBetween('date_to', [$leave_check_start_date, $leave_check_end_date])
                                                ->where('status', $this->leave_approval_status['approved'])
                                                ->whereIn('leave_type', [6,12])
                                                ->where('paid_status', 1)
                                                ->sum('no_days');

                if($half_leave && 0 < $half_leave){
                    $leave = (float)($leave - $half_leave/2);
                }

                $joing_date = $employee->joiningdate;
                $per_day_salary = $employee_gross_salary/30;
                $per_day_basic = $employee_basic_salary/30;
                if ($joing_date  >= $last_month_start)
                {
                    // joindate starts from after 26th
                    $date1 = new DateTime($joing_date);
                    $date2 = new DateTime($this_month_end);
                    $interval = $date1->diff($date2);
                    $days = $interval->days;
                    $employee_gross_salary = $per_day_salary*$days ;
                    $leave_deduction_amount = $per_day_basic*$leave;
                    $total_net_salary =($employee_gross_salary +$employee_total_additions)- $employee_total_deduction-$leave_deduction_amount;
                }
                else
                {
                    //regular salary
                    $leave_deduction_amount = $per_day_basic*$leave;
                    $total_net_salary =($employee_gross_salary +$employee_total_additions)- $employee_total_deduction-$leave_deduction_amount;
                }
                //dd($employee->employeeDepartment->name);
            }
        
            $employee->no_of_leave_days = $leave;
            $employee->total_leave_deduction_amount = $leave_deduction_amount;
            $employee->total_net_salary = $total_net_salary;            
        }
     
        return view('hr_payroll.payroll_employee_list', compact('employees', 'salary_data', 'month', 'last_payroll_date', 'last_payroll_entry', 'last_payroll_for', 'months', 'nextMonth')); /*['employees' => $employees] */
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
        // Check if the user has the HR_ROLE
        if (!Auth::user()->hasRole(HR_ROLE)) {
            return redirect()->back()->with('error', trans('messages.unatuhorised'));
        }

        $date = $request->chose_month; //date('F-Y');
        $reason = "monthly salary";

        // Load last payroll date & check
        $last_payroll = MonthlySalary::select('created_at')
                        ->where('is_gratuity', 0)
                        ->orderBy('id', 'desc')->first();
        if(null!=$last_payroll) {
            $last_payroll_date = $last_payroll->created_at;
            $nextMonth = $last_payroll_date->copy()->addMonth();
            $payrollMonth = $nextMonth->format('F-Y');

            if($payrollMonth != $date){
                return redirect()->back()->with('error', trans('messages.err_payroll_month'));
            }
        }

        if($date != date('F-Y')){
            list($monthName, $year) = explode('-', $date);
            $monthNumber = Carbon::parse($monthName)->month;
            $date25th = Carbon::create($year, $monthNumber, 25);
            $created_at = $date25th->toDateString();
        }else{
            $created_at = Carbon::now();
        }

        /*Payroll exist or not*/
        $payroll_data = MonthlySalary::where('month_year', 'like', '%'.$date.'%')->get();
        if($payroll_data->isNotEmpty()){
            return redirect()->back()->with('error', trans('messages.err_payroll_already'));
        }

        try {
            for ($i = 0; $i < count($request->employee_id); $i++) {
                $monthlySalary = MonthlySalary::updateOrCreate(
                    [
                        'month_year' => $date,
                        'employee_id' => $request->employee_id[$i],
                    ],
                    [
                        'total_gross_salary' => $request->gross_total[$i],
                        'no_of_leave_days' => $request->no_of_leave_days[$i],
                        'total_leave_deduction_amount' => $request->total_leave_deduction_amount[$i],
                        'total_addtional_amount' => $request->total_addtional_amount[$i],
                        'total_deduction_amount' => $request->total_deduction_amount[$i],
                        'net_salary' => $request->total_net_salary[$i],
                        'paid_reason' => $reason,
                        'remarks' => $request->remarks[$i],
                        'created_at' => $created_at,
                        'entry_date' => Carbon::now()
                    ]
                );            
            }
            return redirect('payroll')->with('success', trans('messages.successC'));
        }catch (\Exception $e) {
            return redirect()->back()->with('error', trans('messages.errorCom'));
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monthlysalary  $monthlysalary
     * @return \Illuminate\Http\Response
     */
    public function show(Monthlysalary $monthlysalary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Monthlysalary  $monthlysalary
     * @return \Illuminate\Http\Response
     */
    public function edit(Monthlysalary $monthlysalary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Monthlysalary  $monthlysalary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Monthlysalary $monthlysalary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monthlysalary  $monthlysalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Monthlysalary $monthlysalary)
    {
        //
    }
    public function search(Request $request)
    {       
        $month = $request->salary_month;
        $emp_id = $request->emp_id;
        $emp_name = $request->emp_name;
        $department = $request->department;
        $formattedMonth = Carbon::parse($month)->format('F-Y');
       
        $salary_data = MonthlySalary::with('employee','employee.departments','employee.designations')
                ->when($formattedMonth, function ($query, $formattedMonth) {
                    return $query->where('month_year', 'like', '%'.$formattedMonth.'%');
                })
                /*->when($emp_id, function ($query, $emp_id) {
                    return $query->where('employee_id', $emp_id);
                })*/
                ->when($emp_id, function ($query, $emp_id) {
                    return $query->whereHas('employee', function ($query) use ($emp_id) {
                        $query->where('employee_no',  $emp_id);
                    });
                })
                ->when($emp_name, function ($query, $emp_name) {
                    return $query->whereHas('employee', function ($query) use ($emp_name) {
                        $query->where('name', 'like', '%'.$emp_name.'%')
                        ->orWhere('lname', 'like', '%'.$emp_name.'%');
                    });
                })
                ->when($department, function ($query, $department) {
                    return $query->whereHas('employee.employeeDepartment', function ($query) use ($department) {
                        $query->where('id',$department);
                    });
                })
            ->get();
        
            //Last payroll date
            $last_payroll_date = '';
            $last_payroll = MonthlySalary::select('created_at', 'month_year', 'entry_date')
                            ->where('is_gratuity', 0)
                            ->orderBy('id', 'desc')->first();
            if(null!=$last_payroll){
                $last_payroll_date = $last_payroll->created_at;
                $last_payroll_entry = $last_payroll->entry_date;
                $last_payroll_for = $last_payroll->month_year;
            }
       
        if ($salary_data->isEmpty()) {
            if($month==date('Y-m'))
                return redirect('payroll')->with('month');
            else
                return view('hr_payroll.payroll_employee_list', compact('month', 'last_payroll_date', 'last_payroll_entry', 'last_payroll_for'));
        } else {            
            return view('hr_payroll.payroll_employee_list', compact('salary_data', 'month', 'last_payroll_date', 'last_payroll_entry', 'last_payroll_for'));
        }
    }
    public function payslip($month,$id)
    {
        //dd($month)where('month_year', 'like', '%'.$month.'%');
        $payslip = Monthlysalary::with(['employee',
                                        'employee.designations',
                                        'employee.employeePayrollInformation' => function ($query) {
                                            $query->orderBy('id', 'desc')->take(1);
                                        },
                                        'earning',
                                        'deduction'])
            ->where('month_year', 'like', '%'.$month.'%')
            ->where('employee_id',$id)
            ->get();
        /*dd($payslip);*/
       
        
        if(1==$payslip[0]->is_gratuity){
            $gratuity = Gratuity::with('gratuitystatus')->where('employee_id',$id)->first();
            return view ('hr_payroll.pay_slip_gratuity',compact('payslip', 'gratuity'));
        }else{
            return view ('hr_payroll.pay_slip',compact('payslip'));
        }

    }

}
