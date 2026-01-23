@extends('home.partial.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Employees Monthly Leave Report</h1>
                        <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Monthly Leave Report</li>
                        </ol>
                        </nav>
                        
                    </div>
                </div>
            </div>    
        </div>       

        <!-- Search Filter -->
        
        <form action="{{route('monthly_leave_report.post')}}" method="post"> <!-- target="_blank" -->
        @csrf 
        <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                    <label>Date From</label> <!-- class="focus-label" -->
                        <input type="date" name="date_from" value="{{isset($request->date_from)?$request->date_from:date('Y-m-01')}}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                    <label>Date To</label> <!-- class="focus-label" -->
                        <input type="date" name="date_to" value="{{isset($request->date_to)?$request->date_to:date('Y-m-d')}}" class="form-control" required>
                    </div>
                </div>               

                <!-- <div class="col-md-3">
                    <div class="form-group">
                        <label>Department</label>
                        <select id="department" name="department" class="form-select form-group" style="color: #8D8D8D;">
                            <option value="[1,2]">All</option>
                            @forelse (masterDropdown('departments') as $designation)
                            <option value="{{$designation->id}}">{{$designation->name}}</option>
                            @empty
                            <option>No data available</option>
                            @endforelse
                        </select>
                    </div>
                </div> -->

                <div class="col-md-2" style="padding-top: 2rem;">                    
                    <button type="submit" class="btn btn-block btn-alpha">Search</button>                    
                </div>

            </div>
        </form>

        <!-- <div class="col-md-12" style="min-height: 100vh;"></div> -->

        @if(NULL!=$leaves)
    <div class="row">
        <div class="d-flex justify-content-end">
            <form action="{{route('monthly_leave_report.post')}}" method="post"> <!-- target="_blank" -->
                @csrf 
                <input type="hidden" name="date_from" value="{{isset($request->date_from)?$request->date_from:date('Y-m-01')}}" class="form-control">
                <input type="hidden" name="date_to" value="{{isset($request->date_to)?$request->date_to:date('Y-m-d')}}" class="form-control">
                <input type="hidden" name="excel" value="1" class="form-control">
                <button type="submit" class="btn btn-danger ">
                    Download Excel
                </button>
            </form>
        <!-- <a id="dlink"  style="display:none;"></a>   
        <button type="button" class="btn btn-danger" id="Excel" onclick="return report.tableToExcel('table_result', 'EXCELREPORT', 'Monthly-Report.xlsx');">
           Download Excel
        </button>   -->     
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable dataTable-selector" style="display: inline-table; padding: 5px;" id="table_result">
                    <thead>
                    <tr>
                        <th>Emp Name</th>
                        <th>Emp No.</th>
                        <th>Leave Type</th>
                        <th>Date From</th>
                        <th>Date To</th>
                        <th>Time From</th>
                        <th>Time End</th>
                        <th>No. of Days</th>
                        <th>Reason</th>
                        <th>Paid Status</th>
                    </tr>
                    </thead>
                 
                    <tbody>
                        @foreach($leaves as $eachleave)                   
                        <tr>
                            <td>
                                {{$eachleave->employee->name}} {{$eachleave->employee->lname}}
                            </td>
                            <td>
                                {{$eachleave->employee->employee_no}}
                            </td>
                            <td>
                            {{$eachleave->leavetypes->name}}
                            </td>
                            <td>
                                {{date('d-m-Y', strtotime($eachleave->date_from))}}
                            </td>
                            <td>
                                {{date('d-m-Y', strtotime($eachleave->date_to))}}
                            </td>
                            <td>
                                {{('null'!=$eachleave->time_from)?$eachleave->time_from:'--'}}
                            </td>
                            <td>
                                {{('null'!=$eachleave->time_end)?$eachleave->time_end:'--'}}
                            </td>
                            <td>
                                {{$eachleave->no_days}}
                            </td>
                            <td width="10%">
                                {!! $eachleave->reason !!}
                            </td>
                            <td>
                                {{(1==$eachleave->paid_status)?'Unpaid':'Paid'}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
        <div class='col-xl-12 d-flex justify-content-center mt-3'>{{trans('messages.no_data')}}</div>
    @endif

    </main>
@endsection