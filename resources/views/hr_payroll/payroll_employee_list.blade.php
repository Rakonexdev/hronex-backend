@extends('home.partial.layout')

@section('content')
@php


@endphp

<main id="main" class="main">

    <!-- Page Header -->

    <div class="pagetitle">
    <div class="row align-items-center">

        <div class="col">
            <div class="pagetitle">
                <h1>Employee Payroll</h1>
                <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Employee Payroll</li>
                </ol>
                </nav>
            </div>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success al-sign" style="margin-left: 15px; width: 97.5%;">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 97.5%;">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 97.5%;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif    
        <!--<div class="col-auto float-right ml-auto" style="margin-bottom: 30px;">
        <a href="#" data-toggle="modal" data-target="#add_payroll" class="btn btn-primary add-btn" style="padding-bottom: 8px;"><i class="bi bi-plus-lg"></i>Add Payroll</a>-->
        </div>

    </div>
    </div>

    <!-- /Page Header -->

        <!-- Search Filter -->
    
    <form action="{{route('payroll.search')}}" method="post">
    @csrf 
    <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                <!-- <label class="focus-label">Salary month</label> -->
                    <input type="month" name="salary_month" value="@if(isset($month)){{date('Y-m', strtotime($month))}}@endif" class="form-control"> 
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <!-- <label class="focus-label">Emp ID</label> -->
                    <input type="text" name="emp_id" class="form-control" placeholder="Emp ID">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="emp_name" class="form-control" placeholder="Employee Name">
                    <!-- <label class="focus-label">Employee Name</label> -->
                </div>
            </div>

            <div class="col-md-2">
                <select id="department" name="department" class="form-select form-group" style="color: #8D8D8D;">
                    <option value="0">Department...</option>
                    @forelse (masterDropdown('departments') as $designation)
                    <option value="{{$designation->id}}">{{$designation->name}}</option>
                    @empty
                    <option>No data available</option>
                    @endforelse
                </select>
            </div>


            <div class="col-md-2" style="padding-top: 7px;">
                <button type="submit" class="btn btn-block btn-alpha">Search</button>
            </div>
            <div class="col-md-1" style="padding-top: 7px;">
                <a href="{{url('payroll')}}"><button type="button" class="btn btn-block btn-alpha">Clear</button></a>
            </div>

        </div>
    </form>
    <!-- /Search Filter -->
   <form method="POST" name="payroll_form" id="payroll_form" action="{{route('payroll.store')}}">
    @csrf
    <div class="mb-3 d-flex mt-5">
        <span id="PayrollDoneDtBtn" type="button" class="btn btn-secondary mb-3 ">
            Last payroll:
            @if(isset($last_payroll_entry) && ''!=$last_payroll_entry)
                {{date('d/m/Y H:i:s', strtotime($last_payroll_entry))}} (For: {{$last_payroll_for}})
            @else 
                Not Yet
            @endif
        </span>
        @if( Auth::user()->hasRole(HR_ROLE) && 18 <= date('d'))
        <div class="col-md-12 col-xl-3 col-xxl-3">
            <select class="form-select" name="chose_month" id="chose_month" required>
                <option value="">Choose Month...</option>
                @if(isset($last_payroll_date) && ''!=$last_payroll_date && isset($months) && ''!=$months)
                    @foreach($months as $value => $month)
                        <option value="{{ $value }}" {{ $value !== $nextMonth->format('F-Y') ? 'disabled' : "style=font-weight:bold;" }}>{{ $month }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-12 col-xl-3 col-xxl-3">
            <input name="applicable_month" id="applicable_month" type="hidden" value="@if(isset($nextMonth)){{$nextMonth->format('F-Y')}}@endif" >
            <button id="generateSalaryBtn" type="button" class="btn btn-primary mb-3 generate-btn">Generate payroll</button>
        </div>
       @endif
    </div>
    <div class="row">
        <div class="col-md-6 my-2" style="font-size: 12px; color: #064fad; font-weight: 600;">
            Leave Deduction: Calculated from the next day after the last payroll date to the present.
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin-top: 30px;">
        <div class="table-responsive">
            <table  id="employeeTable" class="table table-striped custom-table datatable dataTable-selector" style="display: inline-table; padding: 5px;">
            <thead>
                <tr>
                <th>Name</th>
                <th>Emp. No.</th>
                <!-- <th>Join
                    <br> Date</th>
                <th>Department</th> -->
                <th>Basic</th>
                <th>Gross</th>
                <th>Leave
                    <br> Deduction</th>
                <th>Additional
                    <br> Salary</th>
                <th>Other
                    <br> Deduction</th>
                <th>Net
                    <br> Salary</th>
                <!--<th>Payslip</th>-->
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if(isset($employees) && !empty($employees))
                @foreach($employees as $employee)
                @if(!empty($employee->employeePayrollInformation) && $employee->employeePayrollInformation->gross_total !=null)
                <tr>
                    <td>
                        <h2 class="table-avatar">
                        <!--<a href="Profile-FAS HRMS.html"><img class="avatar avatar-xs" src="assets/img/profile-img.jpg"></a>-->
                        <a href="{{route('employees.show', $employee->user_id)}}">{{$employee->name}}{{$employee->lname}}<span>@if($employee->designations){{$employee->designations->name}}@else @endif</span></a>
                        </h2>
                    </td>
                    <td>
                        <input type="hidden" id="employee_id" class="employee-id" name="employee_id[]" value="{{$employee->employee_id}}">
                        {{$employee->employee_no}}
                    </td>
                    <!-- <td>
                    {!-- date('d-m-Y', strtotime($employee->joiningdate)) --}
                    </td>
                    <td>{!-- $employee->employeeDepartment->name --}</td> -->
                    <td>

                        <input type="hidden" id="basic_salary" name="basic_salary[]" value="@if(!empty($employee->employeePayrollInformation)){{$employee->employeePayrollInformation->basic_salary}}@else 0 @endif">
                        @if(!empty($employee->employeePayrollInformation)){{$employee->employeePayrollInformation->basic_salary}}@else 0 @endif

                    </td>
                    <td>

                        <input type="hidden" id="gross_total" name="gross_total[]" value="@if(!empty($employee->employeePayrollInformation)){{$employee->employeePayrollInformation->gross_total}}@else 0 @endif">
                        @if(!empty($employee->employeePayrollInformation)){{$employee->employeePayrollInformation->gross_total}}@else 0 @endif

                    </td>
                    <td>
                    <input type="hidden" class="leave-deduction" id="total_leave_deduction_amount" name="total_leave_deduction_amount[]" value="{{$employee->total_leave_deduction_amount}}">
                        {{ number_format($employee->total_leave_deduction_amount, 1)}}
                    @if ($employee->no_of_leave_days)
                        <input type="hidden" id="no_of_leave_days" name="no_of_leave_days[]" value="{{ $employee->no_of_leave_days}}">
                    @else
                    <input type="hidden" id="no_of_leave_days" name="no_of_leave_days[]" value="0">

                        
                    @endif
                    </td>
                    <td> 
                                       
                        @if ($employee->employeeEarnings)
                        <input type="hidden" class="additional-amount" id="total_addtional_amount" name="total_addtional_amount[]" value="{{ $employee->employeeEarnings->total_addtional_amount }}">

                            {{ $employee->employeeEarnings->total_addtional_amount }}
                        @else
                        <input type="hidden" id="total_addtional_amount" name="total_addtional_amount[]" value="0">

                            0
                        @endif
                    </td>
                    <td>
                        @if ($employee->employeeDeduction)
                        <input type="hidden" class="deduction-amount" id="total_deduction_amount" name="total_deduction_amount[]" value="{{ $employee->employeeDeduction->total_deduction_amount }}">

                            {{ $employee->employeeDeduction->total_deduction_amount }}
                        @else
                        <input type="hidden" id="total_deduction_amount" name="total_deduction_amount[]" value="0">

                            0
                        @endif
                    </td>
                    <td>
                    <input type="hidden" class="net-salary" id="total_net_salary" name="total_net_salary[]" value="{{ $employee->total_net_salary }}">

                        {{ number_format($employee->total_net_salary,2 )}}
                    </td>
                   <!-- <td>
                        <a class="btn btn-sm btn-primary" href="Payslip-FAS HRMS.html">Generate Payslip</a>
                    </td>-->
                    <td>
                        <textarea name="remarks[]" id="remarks" class="form-control" placeholder="Remark for month (if any)"></textarea>
                    
                        <!--<div class="action-btn bg-cyan-500 ms-2">
                        <a href="#" data-toggle="modal" data-target="#view_payroll">
                            <i class="bi bi-eye" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                        </a>
                        </div>
                        <div class="action-btn bg-green-500 ms-2" style="margin-left: 0px !important;">
                        <a href="#" data-toggle="modal" data-target="#add_payroll">
                            <i class="bi bi-plus-lg" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                        </a>
                        </div>
                        <div class="action-btn bg-red-500 ms-2">
                        <a href="#" data-toggle="modal" data-target="#delete_payroll">
                            <i class="bi bi-trash" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                        </a>
                        </div>-->
                    </td>
                        
                    </tr>
                @endif
                    @endforeach
            @endif
            @if(isset($salary_data) && !empty($salary_data) && !isset($employees))
                @foreach($salary_data as $salary)
                <tr>
                    <td>
                        <h2 class="table-avatar">
                        <a href="#">{{$salary->employee->name}}{{$salary->employee->lname}}<span>@if($salary->employee->designations) {{$salary->employee->designations->name}} @endif</span></a>
                        </h2>
                    </td>
                    <td>
                        {{$salary->employee->employee_no}}
                    </td>
                    <!-- <td>
                    {!-- date('d-m-Y', strtotime($salary->employee->joiningdate)) --}
                    </td>
                    <td>
                        {!--$salary->employee->departments->name--}
                    </td> -->
                    <td>
                   
                        {{$salary->basic_salary}}
                       
                    </td>
                    <td>
                   
                        {{$salary->total_gross_salary}}
                       
                    </td>
                    <td>
                        {{$salary->total_leave_deduction_amount}}
                    </td>
                    <td> 
                                       
                       {{$salary->total_addtional_amount}}
                    </td>
                    <td>
                        {{$salary->total_deduction_amount}}
                    </td>
                    <td>
                        {{$salary->net_salary}}
                    </td>
                   <td>
                        <a class="btn btn-sm btn-primary" href="{{route('payroll.payslip',['month'=>$salary->month_year,'id'=>$salary->employee_id])}}" target="_blank">Generate Payslip</a>
                    </td>
                    <td>
                        <!--<div class="action-btn bg-cyan-500 ms-2">
                        <a href="#" data-toggle="modal" data-target="#view_payroll">
                            <i class="bi bi-eye" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                        </a>
                        </div>
                        <div class="action-btn bg-green-500 ms-2" style="margin-left: 0px !important;">
                        <a href="#" data-toggle="modal" data-target="#add_payroll">
                            <i class="bi bi-plus-lg" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                        </a>
                        </div>
                        <div class="action-btn bg-red-500 ms-2">
                        <a href="#" data-toggle="modal" data-target="#delete_payroll">
                            <i class="bi bi-trash" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                        </a>
                        </div>-->
                    </td>
                        
                    </tr>
                @endforeach
            @endif
            </tbody>
            </table>
        </div>
        </div>
    </div>
    </form>
    <!-- /Page Content -->

  </main><!-- End #main -->
<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
/* $(document).ready(function() {
    $('#employeeTable').DataTable({
        //"serverSide": true,
        "ajax": {
            "url": "{{route('payroll.store')}}", 
            "type": "POST",
        },
        "pageLength": 200,
        "lengthMenu": [10, 25, 50, 100, 200], 
        "columns": [
            { "data": "employee_id" },
            { "data": "name" },
            { "data": "joining_date" },
            { "data": "department" },
            { "data": "gross_salary" },
            { "data": "leave_deduction" },
            { "data": "additional_salary" },
            { "data": "other_deduction" },
            { "data": "net_salary" },
            { "data": "action" }
            // Add more columns as needed
        ],
        // Other DataTables options and configurations
    });
}); */

document.addEventListener('DOMContentLoaded', (event) => {
    const generate = document.getElementById('generateSalaryBtn');
    const applicable_month = document.getElementById("applicable_month").value;
    


    generate.addEventListener('click', function(event){
        const chose_month = document.querySelector('select[name="chose_month"]').value;
        const payroll_form = document.getElementById('payroll_form');

        if(''==chose_month){ alert("Please choose a month"); return false; }

        if(applicable_month != chose_month){
            alert("Kindly select the following month of the last payroll"); return false;
        }

        // Generate payroll
        payroll_form.submit();
    }); 
});

</script>
@endsection