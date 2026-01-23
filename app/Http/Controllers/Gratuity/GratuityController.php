<?php

namespace App\Http\Controllers\Gratuity;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee\Employees;
use App\Models\Gratuity\Gratuity;
use App\Models\Gratuity\GratuityStatus;
use App\Models\Employee\Resignations;
use App\Models\Earning;
use App\Models\Monthlysalary;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HrmController;
use App\Models\Leave\LeaveApplication;
use App\Models\Leave\LeaveType;
use App\Models\Masters\Designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;

class GratuityController extends HrmController
{

    /**
     * Description: Display the listing of the gratuity.
     * Params: 
     * Method: Get
     * return: Gratuity data for [for lst] & Employee ids[for create gratuity]
    **/
    public function index()
    {       
        $authUserId = auth()->user()->id; 
        $emp_list = NULL;       
        $gratuity_data = Gratuity::with('employee',
                                            'employee.designations','gratuitystatus')
                                            /*->where('active_decider', $authUserId)*/
                                            ->whereHas('gratuitystatus', function ($query) use ($authUserId) {
                                                $query->where('source_id', $authUserId)
                                                      ->orWhere('dest_id', $authUserId);
                                            })->paginate(10);   
        $emp_list = Employees::select('id','employee_id','user_id', 'employee_no')
                                ->with('gratuity')
                                ->where('status', 1)
                                ->whereNotNull('joiningdate')
                                ->whereNotNull('department')
                                ->whereNotNull('designation')
                                ->orderByRaw("CASE 
                                            WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                            ELSE employees.employee_no END")
                                ->orderBy('employees.employee_no')
                                ->get();        
                          
        return view('gratuity.list', compact('gratuity_data', 'emp_list') );
    }    

    /**
     * Description: Get employee related data for creation using seach by id.
     * Params: Employee Id
     * Method: Post
     * return: Employee data
    **/
    public function empdet(Request $request)
    {
        $req = $request->all();  
        $emp_data = Employees::with(['designations',
                                    'employeePayrollInformation' => function ($query) {
                                        $query->orderBy('id', 'desc')->take(1);
                                    },
                                    'employeeDepartment'])
                        ->where('employee_no', $req['employeeid'])
                        ->whereNotNull('joiningdate')
                        ->whereNotNull('department')
                        ->whereNotNull('designation')
                        ->first();
        $leavedata = $this->getLeaveRelatedData($emp_data->id);
        $last_payroll_data = MonthlySalary::select('net_salary')
                                            ->where('employee_id', $emp_data->id)
                                            ->orderBy('id', 'desc')->first();
        if($last_payroll_data){
            $last_payroll_amount = $last_payroll_data->net_salary;
        }else{
            $last_payroll_amount = 0;
        }

        return view('gratuity.partials.add_data', compact('emp_data', 'leavedata', 'last_payroll_amount') );
    } 

    /**
     * Description: Get gratuity related data with employee details for edit modal.
     * Params: Id
     * Method: Post
     * return: Gratuity & Employee data
    **/
    public function gratuitydet(Request $request)
    {
        $req = $request->all();  
        $emp_data = Gratuity::with([ 'gratuitystatus',
                                    'employee',
                                    'employee.designations',
                                    'employee.employeePayrollInformation' => function ($query) {
                                        $query->orderBy('id', 'desc')->take(1);
                                    },
                                    'employee.employeeDepartment'])->where('id', $req['gratuityid'])->first();
        $leavedata = $this->getLeaveRelatedData($emp_data->employee->id);
        $last_payroll_data = MonthlySalary::select('net_salary')
                                            ->where('employee_id', $emp_data->employee->id)
                                            ->orderBy('id', 'desc')->first();
        if($last_payroll_data){
            $last_payroll_amount = $last_payroll_data->net_salary;
        }else{
            $last_payroll_amount = 0;
        }
                      
        return view('gratuity.partials.update_data', compact('emp_data', 'leavedata', 'last_payroll_amount') );
    }   
    
    /**
     * Description: Store/Update new/existing gratuity data.
     * Params: Form elements
     * Method: Post
     * return: Success / Failure message
    **/
    public function addGratuity(Request $request)
    {
        try {
            /*Gratuity create/update: By HR users only*/
            if(!Auth::user()->hasRole(HR_ROLE)){
                return redirect('gratuity')->with('error', trans('messages.unatuhorised'));
            }

            /*Gratuity update: Before review submission only*/
            $gratuity = Gratuity::find($request->id);
            if($gratuity){
                if($this->gratuity_status[0] != $gratuity->status){
                    return redirect('gratuity')->with('error', trans('messages.no_access'));
                }
            }

            /*Form validation */
            $data = Validator::make($request->all(), Gratuity::$rules, Gratuity::$errmsgs);
            if ($data->fails()) {
                return redirect('gratuity')->withErrors($data)->withInput();
            } 
            
            /* Add/Update gratuity main table */
            if($request->last_payroll_chk){
                $request->net_pay = $request->net_pay-$request->last_payroll;
                $request->net_pay_round_off = $request->net_pay_round_off-$request->last_payroll;
            }

            $grat = Gratuity::updateOrCreate([
                    'id' => $request->id,
                ], [
                    'employee_id' => $request->employee_id,
                    'joining_date' => $request->joining_date, 
                    'last_working_day' => $request->last_working_day, 
                    'notice_pay' => $request->notice_pay, 
                    'total_days_employment' => $request->total_days_employment, 
                    'notice_period' => $request->notice_period, 
                    'notice_period_remarks' => $request->notice_period_remarks, 
                    'net_days_worked' => $request->net_days_worked, 
                    'total_days_last_month' => $request->total_days_last_month, 
                    'current_month_salary' => $request->current_month_salary, 
                    'eligible_days' => $request->eligible_days,                    
                    'gratuity_add' => $request->gratuity_add, 
                    'gratuity_ded' => $request->gratuity_ded, 
                    'gratuity_total' => $request->gratuity_total, 
                    'annual_leave_entitled' => $request->annual_leave_entitled, 
                    'accrued_annual_leave' => $request->accrued_annual_leave, 
                    'annual_leave_availed' => $request->annual_leave_availed, 
                    'annual_leave_balance' => $request->annual_leave_balance,                     
                    'leave_accrual_amount' => $request->leave_accrual_amount, 
                    'ticket_accrual_amount' => $request->ticket_accrual_amount, 
                    'return_ticket_amount' => $request->return_ticket_amount,
                    'last_payroll_chk' => ($request->last_payroll_chk) ? 1 : 0, 
                    'last_payroll' => ($request->last_payroll_chk) ? $request->last_payroll : 0, 
                    'net_pay' => $request->net_pay, 
                    'net_pay_round_off' => $request->net_pay_round_off, 
                    'active_decider' => Auth::user()->id,
                    'remarks' => $request->remarks, 
                    'status' => $this->gratuity_status[0]
            ]);                                
           
            /* Add/Update gratuity status table */
            $grat_status = $grat->gratuitystatus()->updateOrCreate([                    
                    'id' => $request->gratuity_status_id,
                ],[
                'gratuity_id' => $grat->id,                 
                'source_id' => Auth::user()->id,
                'dest_id' => Auth::user()->id, 
                'gratuity_status' => $grat->status,
                'comment' => 'Nil'
            ]); 

            return redirect('gratuity')->with('success', trans('messages.successO'));

        }catch (\Exception $e) {
           return redirect('gratuity')->with('error', trans('messages.errorCom'));
        } 
    }    

    /**
     * Description: Search gratuity data.
     * Params: Form elements
     * Method: Post
     * return: Success with data / Failure message
    **/
    public function search(Request $request)
    {               
        $emp_no = $request->emp_id;
        $emp_name = $request->emp_name;
        $department = $request->department;

        if(null != $emp_no){
            $emp_det = Employees::select('id')->where('employee_no', $emp_no)->first();
            if($emp_det)
                $employee_id = $emp_det->id;
            else 
                $employee_id = 0;
        }else{
            $employee_id = 0;
        }        

        $gratuity_data = Gratuity::with('employee','employee.employeeDepartment')
                ->when($employee_id, function ($query, $employee_id) {
                    return $query->where('employee_id', $employee_id);
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
            ->paginate(10);

            $emp_list = Employees::select('id','employee_id','user_id', 'employee_no')
                                ->with('gratuity')
                                ->where('status', 1)
                                ->whereNotNull('joiningdate')
                                ->whereNotNull('department')
                                ->whereNotNull('designation')
                                ->orderByRaw("CASE 
                                            WHEN employees.employee_no REGEXP '^[0-9]+$' THEN LPAD(employees.employee_no, 10, '0') 
                                            ELSE employees.employee_no END")
                                ->orderBy('employees.employee_no')
                                ->get();        
        
            return view('gratuity.list', compact('gratuity_data', 'emp_list') );       
    }    

    /**
     * Description: Get gratuity data for update the status and assigning.
     * Params: id
     * Method: Get
     * return: Gratuity data for modal
    **/
    public function getGratuityForStatus($gratuityid)
    {
        $toAssign = NULL;                 
        $user = Auth::user();
        $curgratList = Arr::except($this->gratuity_status, [0]);
        
        /*If the user is HR: Option for assign to Accounts for review*/
        if ($user->hasRole(HR_ROLE)) {

            $ac_role = Role::where('name', ACC_ROLE)->first();
            $toAssign = User::role($ac_role)->get();
            $curgratList = Arr::except($curgratList, [2,3]);

        /*If the user is Accounts: Option for assign to Principal for approval*/
        } elseif ($user->hasRole(ACC_ROLE)) {

            $pr_role = Role::where('name', PRINCIPAL_ROLE)->first();
            $toAssign = User::role($pr_role)->get();            
            $curgratList = Arr::except($curgratList, [1,3]);

        /*If the user is Principal: Option for approval & same id*/
        } elseif ($user->hasRole(PRINCIPAL_ROLE)) {
            
            $toAssign = User::where('id', auth()->user()->id)->get();
            $curgratList = Arr::except($curgratList, [1,2]);

        }

        $grat = Gratuity::with('employee')
                                ->where('id', $gratuityid)->first(); 
        $latest_stat = GratuityStatus::where('gratuity_id', $gratuityid)
                                ->latest()->first();           
        
        return view('gratuity.partials.data_status', compact('grat','toAssign', 'curgratList', 'latest_stat') );
    }

    /**
     * Description: Update gratuity status and assigning.
     * Params: form data
     * Method: Post
     * return: Success / Failure message & reload
    **/
    public function updateGratuityStatus(Request $request)
    { 
        try {
            $gratuity = Gratuity::findOrFail($request->id);

            /*Blocking gratuity status update after final approval*/
            if($this->gratuity_status[3] == $gratuity->status)
                return trans('messages.lbl_approve').' & '.trans('messages.lbl_payroll').' '.trans('messages.lbl_generate');

            /* If the final settlement after the 25th day of current month: 
               It should reflect in next month payroll  */
            if(25 < date('d')){
                $date = Carbon::now();
                $month_year = $date->addMonth()->format('F-Y');
            }else{
                $month_year = date('F-Y');
            } 
            if($request->status == $this->gratuity_status[3]){
                $monthlySalary = MonthlySalary::where('month_year', $month_year)
                                            ->where('employee_id', $gratuity->employee_id)->first();
                if($monthlySalary) {
                    return trans('messages.lbl_oops').' '.trans('messages.lbl_payroll').' '.lcfirst(trans('messages.lbl_forthis_mth')).' '.lcfirst(trans('messages.lbl_already')).' '.lcfirst(trans('messages.lbl_generate'));
                }
            }

            $gratuity->active_decider = $request->dest_id;
            $gratuity->status = $request->status;
            $gratuity->save();

            $grat_status = $gratuity->gratuitystatus()->create([                
                'gratuity_id' => $request->id,                 
                'source_id' => Auth::user()->id,
                'dest_id' => $request->dest_id, 
                'gratuity_status' => $request->status,
                'comment' => $request->comment
            ]);

            /*Store the gratuity data into the payroll section after final approval*/
            if($request->status == $this->gratuity_status[3]){
                $reflectPayroll = $this->reflectPayroll($request->id, $month_year);
            }

            return trans('messages.successU');

        }catch (\Exception $e) {
            return trans('messages.errorCom');
        } 

    }

    /**
     * Description: Update payroll.
     * Params: id
     * Method: Get
     * return: Success / Failure status
    **/
    protected function reflectPayroll($id, $month_year)
    {
        $grat_data = Gratuity::with(['employee',
                                    'employee.employeePayrollInformation' => function ($query) {
                                        $query->orderBy('id', 'desc')->take(1);
                                    }
                                   ])->where('id', $id)->first();
        
        /*Total additional*/
        $total_addtional_amount = $grat_data->ticket_accrual_amount+$grat_data->return_ticket_amount;

        /*Total gross*/
        $total_gross_salary = $grat_data->notice_pay+$grat_data->current_month_salary;
        

        /*Earning data*/
        $earning = new Earning;

        $earning->employee_id = $grat_data->employee_id;
        $earning->month_year = $month_year;
        $earning->additional_amount = json_encode(array($grat_data->ticket_accrual_amount, $grat_data->return_ticket_amount));
        $earning->additional_reason = json_encode(array("Ticket Accrual", "Return Ticket"));
        $earning->ticket_accural_amount = $grat_data->ticket_accrual_amount;
        $earning->return_tkt_amount = $grat_data->return_ticket_amount;
        $earning->remarks = trans('messages.grat_head');
        $earning->total_addtional_amount = $total_addtional_amount;
        $earning->save();

        /*Final Payroll data*/
        $monthlySalary = new MonthlySalary;

        $monthlySalary->employee_id = $grat_data->employee_id;
        $monthlySalary->month_year = $month_year;
        $monthlySalary->total_gross_salary = $total_gross_salary; /*$grat_data->employee->employeePayrollInformation[0]->gross_total;*/
        $monthlySalary->no_of_leave_days = 0;
        $monthlySalary->total_leave_deduction_amount = 0;
        $monthlySalary->total_addtional_amount = $total_addtional_amount;
        $monthlySalary->total_deduction_amount = 0;
        $monthlySalary->paid_reason = trans('messages.grat_head');
        $monthlySalary->total_leave_accural_amount = $grat_data->leave_accrual_amount;
        $monthlySalary->total_gratuity_amount = $grat_data->gratuity_total;
        $monthlySalary->is_gratuity = 1;
        $monthlySalary->net_salary = $grat_data->net_pay;
        $monthlySalary->save(); 

        return 1;       
        
    }

    /**
     * Description: For leave related data to works on gratuity module.
     * Params: id
     * Method: Get
     * return: Return data as an object
    **/
    protected function getLeaveRelatedData($employee_id)
    {
        $leavedata = new \stdClass();

        $emp_data = Employees::with(['employeePayrollInformation' => function ($query) {
                                        $query->orderBy('id', 'desc')->take(1);
                                    }])
                                ->where('employee_id', $employee_id)
                                ->first();
        $joindate = $emp_data->joiningdate;
        $date = Carbon::parse($joindate);
        $now = Carbon::now();

        /*Annual leave type: 
           We may change the id if different types of leaves added in table for each department*/
        if(2 == $emp_data->department)  $lvtpid = 2;
        else  $lvtpid = 2;

        /*$annual_leave_type = LeaveType::where('id', $lvtpid)*/
                                /*->where('applicable_to',$emp_data->employee->department)*/
                                /*->first();*/

        $annual_leave_availed = LeaveApplication::where('employee_id',$emp_data->employee_id)
                                ->where('leave_type',$lvtpid)
                                ->where('status', $this->leave_approval_status['approved'])
                                ->where('academic_year', $this->academic_year)
                                ->sum('no_days');

        /*Unpaid leave: From leave application table*/
        $unpaid_leave =  LeaveApplication::where('employee_id',$emp_data->employee_id)
                ->where('status', $this->leave_approval_status['approved'])
                ->where('paid_status', 1)
                ->sum('no_days');

        /*We may need to change it based on last working day later*/
        $total_days_employment = $date->diffInDays($now, false)+1;

        /**Notice period: Default-30 */
        $np = DB::table('notice_period')->select('np_days')
                                        ->where('employee_id', $employee_id)
                                        ->first();
        if($np)
            $leavedata->notice_period = $np->np_days;
        else
            $leavedata->notice_period = 30;
        
        //Net days worked = Total days of Employement - Unpaid Leave 
        $net_days_worked =  $total_days_employment-$unpaid_leave;

        //Accured Annual Leave = (Net Days worked/30)*2.5  
        //$accured_annual_leave = ($net_days_worked/30)*2.5;
        //$accured_annual_leave = getAnnualLeaveCount($emp_data->department, $this->academic_year);

        /**Notice period: Default-30 */
        $leavedata->notice_pay = 0; //($leavedata->notice_period/30)*$emp_data->employeePayrollInformation[0]->gross_total;

        //Annual Leave (Entitled annual)
        /*if ($total_days_employment >= 365 && $emp_data->department=1) {
            $annual_leave = 45;
        } elseif($total_days_employment >= 365 && $emp_data->department=2) {
            $annual_leave = 30;
        }else{
            $annual_leave = 0;
        }*/

        if ($total_days_employment >= 365) {
            $annual_leave = getAnnualLeaveCount($emp_data->department, $this->academic_year);
            //Accured Annual Leave = (Net Days worked/30)*2.5              
            $accured_annual_leave = $annual_leave;
        } else{
            $annual_leave = 0;
            $accured_annual_leave = 0;
        }

        $leavedata->net_days_worked = $net_days_worked;
        $leavedata->total_days_employment = $total_days_employment;
        $leavedata->unpaid_leave = $unpaid_leave;
        $leavedata->accured_annual_leave = round($accured_annual_leave);
        $leavedata->annual_leave = $annual_leave;
        $leavedata->annual_leave_availed = $annual_leave_availed;
        $leavedata->annual_leave_balance = $leavedata->accured_annual_leave-$annual_leave_availed;
        $leavedata->leave_accrual_amount = ($emp_data->employeePayrollInformation[0]->basic_salary/30)*$leavedata->annual_leave_balance;

        return $leavedata;
    }

    public function store(Request $request){ }
    public function show($id){ }
    public function status(Request $request){ }    
    public function update(Request $request, $id){ }
    public function destroy($id){ }

}