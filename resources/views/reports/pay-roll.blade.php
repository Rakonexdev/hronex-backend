@extends('home.partial.layout')
@section('content')

@php

$admin_dept_count = 0;
$academic_dept_count = 0;
$grat_total = 0;

$time=strtotime($currentMonth);

@endphp


<!-- <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script> -->

<style>
    /* .table-wrapper {
    max-height: 600px;
    overflow-y: scroll;
}
thead.fixed-top{
        position: sticky;
        top:0;
    } */
</style>
<main id="main" class="main">
    <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Employees Payroll Report</h1>
                        <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Employee Reports</li>
                        </ol>
                        </nav>
                        
                    </div>
                </div>
            

                <!--<div class="col-auto float-right ml-auto" style="margin-bottom: 30px;">
                <a href="#" data-toggle="modal" data-target="#add_appraisal" class="btn btn-primary add-btn" style="padding-bottom: 8px;"><i class="bi bi-plus-lg"></i>Add Appraisal</a>
                </div>-->

            </div>
            
        </div>
        

        <!-- /Page Header -->

        <!-- Search Filter -->
        <form action="#" method="get">
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="curMonth" name="department"  class="form-label">Month</label>
                        <select name="curMonth" id="curMonth" class="form-control" style="color: #8D8D8D;">
                            <option value="0" selected>Choose Month...</option>
                            @for ($i = 0; $i <= 12; $i++)
                                @php $month = date("F-Y", strtotime( date( 'Y-m-01' )." -$i months")); @endphp                            
                                    <option value="{{$month}}" @if($currentMonth==$month) selected @endif>{{$month}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                
                <div class="col-md-2" style="padding-top: 33px;"> 
                    <button type="submit" class="btn btn-block btn-alpha">Filter</button>  
                </div>

            </div>
        </form>

        @if($payroll_details->isNotEmpty())

        <div class="row">
            <div class="float-end">

                    <a id="dlink"  style="display:none;"></a>
                    <button type="button" class="btn btn-danger" onclick="return report.tableToExcel('tbl_exporttable_to_xls', 'EXCELREPORT', 'Report.xls');">
                        Download Excel
                    </button>
            
                <!--<button type="button" class="btn btn-danger "><a href="{{ route('payrollreportExport', 'excel') }}" class="text-light">Download Excel</a></button> -->
                <!-- <button type="button" class="btn btn-danger"><a href="{{ route('payrollreportExport', 'pdf') }}"  class="text-light">Download PDF</a></button> -->
            </div>
        </div>

        <!-- /Search Filter -->
       
        <div class="row">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="table-responsive">
                    <div class="table-wrapper" style="max-height: 600px;overflow-y: scroll;">
                        <table class="table table-striped custom-table datatable dataTable-selector" id="tbl_exporttable_to_xls" style="display: inline-table; padding: 5px;">
                            <thead class="fixed-top" style="position: sticky; top:0;">
                            <tr>
                                <th colspan="16" style="background-color:#D8D8D8;font-size:16px;text-align:center;">{{$thiscompany}}-Payroll - {{date("Y",$time)}}</th>
                            </tr>
                            <tr>
                                <th colspan="16" style="background-color:#D8D8D8;font-size:16px;text-align:center;">
                                {{date("F",$time)}}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4"></th>
                                <!-- <th></th>
                                <th></th>
                                <th></th> -->
                                <th colspan="2" style="background-color:#D8D8D8;">Master Data</th>
                                <th style="background-color:#D8D8D8;">
                                @php
                                    $additionalAmountSum = 0;
                                    foreach ($payroll_details as $payroll_detail) {
                                        $additionalAmountSum += $payroll_detail->total_gross_salary;
                                    }
                                    echo $additionalAmountSum;
                                @endphp
                                </th>
                                <th style="background-color:#92D050 ;"></th>
                                <th style="background-color:#92D050 ;">Additional</th>
                                <th style="background-color:#92D050 ;">
                                @php
                                    $additionalAmountSum = 0;
                                    foreach ($payroll_details as $payroll_detail) {
                                        $additionalAmountSum += $payroll_detail->total_addtional_amount;
                                    }
                                    echo $additionalAmountSum;
                                @endphp
                                </th>
                                <th style="background-color:#E5B8B7 ;">Deduction</th>
                                <th style="background-color:#E5B8B7 ;">
                                @php
                                        $additionalAmountSum = 0;
                                        foreach ($payroll_details as $payroll_detail) {
                                            $additionalAmountSum += $payroll_detail->total_deduction_amount;
                                        }
                                        echo $additionalAmountSum;
                                    @endphp</th>
                                <th colspan="5">
                                    
                                </th>
                                <!-- <th >
                                    
                                </th>
                                <th>
                                    
                                </th>
                                <th>
                                    
                                </th>
                                <th></th> -->
                            </tr>
                            <tr  style="background-color:#D8D8D8;">
                                <th>Emp No</th>
                                <th>Emp Name</th>
                                <th>Joining Date</th>
                                <th>Designations</th>
                                <th>Basic</th>
                                <th>Gross</th>
                                <th>Others</th>
                                <th>Total</th>
                                <th>Gratuity</th>
                                <th style="background-color:#92D050 ;">Additional</th>
                                <th style="background-color:#92D050 ;">Total</th>
                                <th style="background-color: #E5B8B7;">Deduction</th>
                                <th style="background-color: #E5B8B7;">Total</th>
                                <th>
                                    Final
                                </th>
                                <th>
                                    Final without Round
                                </th>
                                <th>
                                    Dept
                                </th>
                                <th>IBAN</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            
                            <tbody>
                                @foreach($payroll_details as $payroll_detail)

                                @php
                                        if(2==$payroll_detail->dept_id)
                                            $admin_dept_count++;
                                        else 
                                            $academic_dept_count++;

                                        $grat_total += $payroll_detail->gratuity;
                                @endphp
                                
                                <tr>
                                    <td @if(!empty($payroll_detail->addtional_amount)) style="background-color:#92D050;" @elseif(!empty($payroll_detail->deduction_amount)) style="background-color:#FFFF00;" @elseif(\Carbon\Carbon::parse($payroll_detail->employee_joiningdate)->addMonth() >= \Carbon\Carbon::now()) style="background-color:#FF0000;" @endif>{{$payroll_detail->employee_no}}</td>
                                    <td @if(!empty($payroll_detail->addtional_amount)) style="background-color:#92D050;" @elseif(!empty($payroll_detail->deduction_amount)) style="background-color:#FFFF00;" @elseif(\Carbon\Carbon::parse($payroll_detail->employee_joiningdate)->addMonth() >= \Carbon\Carbon::now()) style="background-color:#FF0000;" @endif>
                                        {{$payroll_detail->employee_name}}
                                    </td>
                                    <td @if(!empty($payroll_detail->addtional_amount)) style="background-color:#92D050;" @elseif(!empty($payroll_detail->deduction_amount)) style="background-color:#FFFF00;" @elseif(\Carbon\Carbon::parse($payroll_detail->employee_joiningdate)->addMonth() >= \Carbon\Carbon::now()) style="background-color:#FF0000;" @endif>
                                        {{$payroll_detail->employee_joiningdate}}
                                    </td>
                                    <td @if(!empty($payroll_detail->addtional_amount)) style="background-color:#92D050;" @elseif(!empty($payroll_detail->deduction_amount)) style="background-color:#FFFF00;" @elseif(\Carbon\Carbon::parse($payroll_detail->employee_joiningdate)->addMonth() >= \Carbon\Carbon::now()) style="background-color:#FF0000;" @endif>
                                        {{$payroll_detail->designation}}
                                    </td>
                                    <td>
                                        {{$payroll_detail->basic}}
                                    </td>
                                    <td>
                                        {{$payroll_detail->gross}}
                                    </td>
                                    <td>
                                        {{$payroll_detail->others}}
                                    </td>
                                    <td>
                                        {{$payroll_detail->total_gross_salary}}
                                    </td>
                                    <td>
                                        {{$payroll_detail->gratuity}}
                                    </td>
                                    <td>
                                        {{$payroll_detail->addtional_amount}}
                                    </td>
                                    <td style="color:#0070C0">
                                        {{$payroll_detail->total_addtional_amount}}
                                    </td>
                                    <td>
                                        {{$payroll_detail->deduction_amount}}
                                    </td>
                                    <td  @if($payroll_detail->total_deduction_amount > 0)style="background-color: #E5B8B7;" @endif>
                                    {{$payroll_detail->total_deduction_amount}}
                                    </td>
                                    <td>
                                        {{round($payroll_detail->net_salary)}}
                                    </td>
                                    <td>
                                        {{$payroll_detail->net_salary}}
                                    </td>
                                    <td>
                                        {{$payroll_detail->department}}
                                    </td>
                                    <td>
                                        {{$payroll_detail->iban}}
                                    </td>
                                    <td>
                                        {{$payroll_detail->remarks}}
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan='17'>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan='17'>
                                        <span>Summary:</span>
                                        <table style="font-size:12px;">
                                            <tr>
                                                <th>Department</th>
                                                <th>Count</th>
                                            </tr>
                                            <tr>
                                                <td>Administration</td>
                                                <td>{{$admin_dept_count}}</td>
                                            </tr>
                                            <tr>
                                                <td>Academic</td>
                                                <td>{{$academic_dept_count}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan='2'>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>Gratuity amount for {{$currentMonth}}</td>
                                                <td>{{number_format($grat_total, 2)}}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="row alert alert-danger">
                {{trans('messages.no_data')}}
            </div>
        @endif
</main>
@endsection

<script src="{{ asset('js/export.js') }}"></script>

<script>

    //function ExportToExcel(type, fn, dl) {
        // Find a <table> element with id="myTable":
        //let table = document.getElementById("tbl_exporttable_to_xls");

        // Create an empty <tr> element and add it to the 1st position of the table:
        //let row = table.insertRow(0);

        // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
        //let cell1 = row.insertCell(0);
        //let cell2 = row.insertCell(1);

        // Add some text to the new cells:
        //cell1.innerHTML = "First Assalam school - Payroll Working";
        //cell2.innerHTML = "NEW CELL2";

        //var elt = document.getElementById('tbl_exporttable_to_xls');
        //var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        //return dl ?
            //XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
            //XLSX.writeFile(wb, fn || ('Employee_Payroll.' + (type || 'xlsx')));
    //}

</script>