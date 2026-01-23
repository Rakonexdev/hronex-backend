<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HrmController;
use App\Models\Employee\Employees;
use App\Models\Deduction;
use App\Models\Monthlysalary;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DeductionController extends HrmController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $date = date('F-Y');  
        $deductions = Deduction::with('employee','employee.employeeDepartment','employee.designations')
         /*->whereHas('employee', function ($query) use ($status) {
            $query->where('status', $status);
        })*/
        ->Where('month_year', 'like', '%'.$date.'%')->get();
        return view('hr_payroll.list_employee_deduction',compact('deductions'));
    }

    public function deductionField($id = null){
        //$date = date('F-Y');  
		if($id !=null){
			$deduction 	= Deduction::find($id);
		}
		else{
			$deduction	= new Deduction();
		}
        $total_deduction_amount = array_sum(request('deduction_amount'));
        $deduction->employee_id				= request('emp_id');
		//$deduction->month_year		        = $date;
        $deduction->deduction_amount			= json_encode(request('deduction_amount'));
        $deduction->deduction_reason			= json_encode(request('deduction_type'));
        $deduction->remarks				    = request('remarks');
        $deduction->total_deduction_amount    = $total_deduction_amount;
		return $deduction;
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

        $total_deduction_amount = array_sum($request->deduction_amount);   
        $date = $request->chose_month; //date('F-Y');

        /*Deduction exist or not*/
        $deduction_data = Deduction::where('month_year', 'like', '%'.$date.'%')->get();
        if($deduction_data->isNotEmpty()){
            return redirect()->back()->with('error', trans('messages.err_item_already'));
        }

        $data = array(
			'employee_id' => $request->emp_id,
            'month_year' => "$date",
			'deduction_amount' => json_encode($request->deduction_amount),
			'deduction_reason' => json_encode($request->deduction_type),
            'remarks' => $request->remarks,
            'total_deduction_amount'=>"$total_deduction_amount"
		);
        
        Deduction::create($data);
        return redirect()->back()->with('success', trans('messages.successC'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd($id);
        $data = Deduction::find($id);
        //dd($data);

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function edit(Deduction $deduction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $deduction = $this->deductionField($id);
        //dd($earning);
		$deduction->save();
		return redirect()->back()->with('success', trans('messages.successU'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deduction $deduction,$id)
    {
        //
        //dd($id);
        $deduction = Deduction::findOrfail($id);
        $deduction->delete();
        return redirect()->back()->with('success', trans('messages.successD'));

    }
    public function employees()
    {
        //
        $date = date('F-Y');
        $employees = Employees::with(['employeePayrollInformation', 'employeeDepartment','designations','employeeDeduction' => function ($query) use ($date) {
            $query->where('total_deduction_amount', '>', 0)
                ->where('month_year', '=', $date);
        }])
        ->where('status', 1)
        ->orderByRaw('CAST(employee_no AS SIGNED)', 'asc')
        ->get();
        $options = [
            'Choose Deduction Type...',
            'Unpaid',
            'Disciplinary',
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

        return view('hr_payroll.employee_deduction',compact('employees','options', 'months', 'last_payroll_date', 'nextMonth'));
    }
    public function search(Request $request)
    {
        //dd($request);
        $month = $request->deduction_month;
        $emp_id = $request->emp_id;
        $emp_name = $request->emp_name;
        $department = $request->department;
        $formattedMonth = Carbon::parse($month)->format('F-Y');
        //dd( $department );
        $deductions = Deduction::with('employee','employee.employeeDepartment','employee.designations')
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
        if ($deductions->isEmpty()) {
            return redirect('deduction')->with('error', 'No matching records found.');
        } else {
            return view('hr_payroll.list_employee_deduction', compact('deductions'));
        }
    }

    public function emploees_filter(Request $request){
        $emp_id = $request->emp_id;
        $emp_name = $request->emp_name;
        $department = $request->department;
        $employees = Employees::with('employeePayrollInformation','employeeDepartment','employeeDeduction','designations')
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
            'Choose Deduction Type...',
            'Unpaid',
            'Disciplinary'
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
            return view('hr_payroll.employee_deduction',compact('employees','options', 'months', 'last_payroll_date', 'nextMonth'));
        }

    }
}
