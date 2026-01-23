<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HrmController;
use App\Models\Employee\Employees;
use App\Models\Earning;
use App\Models\Monthlysalary;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class EarningController extends HrmController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = date('F-Y');  
        $status = 1;
        $earnings = Earning::with('employee','employee.employeeDepartment','employee.designations')
        /*->whereHas('employee', function ($query) use ($status) {
            $query->where('status', $status);
        })*/
        ->Where('month_year', 'like', '%'.$date.'%')->get();
        
        return view('hr_payroll.list_employee_earnings',compact('earnings'));
    }
    public function earningField($id = null){
        //$date = date('F-Y');  
		if($id !=null){
			$earning 	= Earning::find($id);
		}
		else{
			$earning	= new Earning();
		}
        $total_addition_amount = array_sum(request('additional_amount'));
        $earning->employee_id				= request('emp_id');
		//$earning->month_year		        = $date;
        $earning->additional_amount			= json_encode(request('additional_amount'));
        $earning->additional_reason			= json_encode(request('additional_type'));
        $earning->remarks				    = request('remarks');
        $earning->total_addtional_amount    = $total_addition_amount;
		return $earning;
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
        if(!isset($request->chose_month)){
            return redirect()->back()->with('error', trans('messages.err_chose_month'));
        }

        $total_addition_amount = array_sum($request->additional_amount);
        $date = $request->chose_month; //date('F-Y');

        /*Earning exist or not*/
        $earning_data = Earning::where('month_year', 'like', '%'.$date.'%')->get();
        if($earning_data->isNotEmpty()){
            return redirect()->back()->with('error', trans('messages.err_item_already'));
        }
    
        $data = array(
			'employee_id' => $request->emp_id,
            'month_year' => "$date",
			'additional_amount' => json_encode($request->additional_amount),
			'additional_reason' => json_encode($request->additional_type),
            'remarks' => $request->remarks,
            'total_addtional_amount'=>"$total_addition_amount"
		);
        
       //select query empl_id and date and dept_id gt or 0
        Earning::create($data);
        return redirect()->route('earnings.employees')->with('success', trans('messages.successC'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd($id);
        $data = Earning::find($id);
        //dd($data);
        return response()->json($data);
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function edit(Earning $earning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
     
        $earning = $this->earningField($id);
        //dd($earning);
		$earning->save();
		return redirect('earnings')->with('success', trans('messages.successU'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Earning $earning,$id)
    {
        //
        $earning = Earning::findOrfail($id);
        $earning->delete();
        return redirect()->back()->with('success', trans('messages.successD'));
    }
    public function search(Request $request)
    {
        //dd($request);
        $month = $request->earning_month;
        $emp_id = $request->emp_id;
        $emp_name = $request->emp_name;
        $department = $request->department;
        $formattedMonth = Carbon::parse($month)->format('F-Y');
        //dd( $department );
        $earnings = Earning::with('employee','employee.employeeDepartment','employee.designations')
                ->when($formattedMonth, function ($query, $formattedMonth) {
                    return $query->where('month_year', 'like', '%'.$formattedMonth.'%');
                })
                ->when($emp_id, function ($query, $emp_id) {
                    return $query->where('employee_id', $emp_id);
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
       
        //dd($earnings);
        if ($earnings->isEmpty()) {
            return redirect('earnings')->with('error', 'No matching records found.');
        } else {
            return view('hr_payroll.list_employee_earnings', compact('earnings'));
        }
    }
    public function employees()
    {
        //
        $date = date('F-Y');
        $employees = Employees::with(['employeePayrollInformation', 'employeeDepartment','designations', 'employeeEarnings' => function ($query) use ($date) {
            $query->where('total_addtional_amount', '>', 0)
                ->where('month_year', '=', $date);
        }])
        ->where('status', 1)
        ->orderByRaw('CAST(employee_no AS SIGNED)', 'asc')
        ->get();
        $options = [
            'Choose Additions Type...',
            'Fuel',
            'Additional Task',
            'Ticket Accrual',
            'Return Ticket',
            'Continuos Allowanace',
            'Temporary Allowance'
        ];
        
        //Last payroll date
        $last_payroll = MonthlySalary::select('created_at')
                        ->where('is_gratuity', 0)
                        ->orderBy('id', 'desc')->first();
        if(null!=$last_payroll){
            $last_payroll_date = $last_payroll->created_at;
            $startDate = $last_payroll->created_at;
            $nextMonth = $startDate->copy()->addMonth();
            $startDate->addMonth();

            $curDate = Carbon::now();
            $endDate = $curDate->copy()->addMonths(2);

            $months = [];
            while ($startDate->lte($endDate)) {
                $months[$startDate->format('F-Y')] = $startDate->format('F-Y');
                $startDate->addMonth();
            }
        }else{
            $months = '';
            $last_payroll_date = '';
        }

        return view('hr_payroll.employee_earnings',compact('employees','options', 'months', 'last_payroll_date', 'nextMonth'));
    }
    public function emploees_filter(Request $request){
        $emp_id = $request->emp_id;
        $emp_name = $request->emp_name;
        $department = $request->department;
        //dd($request);
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

        $options = [
            'Choose Additions Type...',
            'Fuel',
            'Additional Task',
            'Ticket Accrual',
            'Return Ticket',
            'Continuos Allowanace',
            'Temporary Allowance'
        ];

        //Last payroll date
        $last_payroll = MonthlySalary::select('created_at')
                        ->where('is_gratuity', 0)
                        ->orderBy('id', 'desc')->first();
        if(null!=$last_payroll){
            $last_payroll_date = $last_payroll->created_at;
            $startDate = $last_payroll->created_at;
            $nextMonth = $startDate->copy()->addMonth();
            $startDate->addMonth();

            $curDate = Carbon::now();
            $endDate = $curDate->copy()->addMonths(2);

            $months = [];
            while ($startDate->lte($endDate)) {
                $months[$startDate->format('F-Y')] = $startDate->format('F-Y');
                $startDate->addMonth();
            }
        }else{
            $months = '';
            $last_payroll_date = '';
        }

    //dd($earnings);
    if ($employees->isEmpty()) {
        return redirect('earnings.employees')->with('error', 'No matching records found.');
    } else {
        return view('hr_payroll.employee_earnings',compact('employees','options', 'months', 'last_payroll_date', 'nextMonth'));
    }
    }
}
