@extends('home.partial.layout')
@section('content')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<main id="main" class="main">
    <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Final Pay Report</h1>
                        <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Final Pay Reports</li>
                        </ol>
                        </nav>
                        
                    </div>
                </div>
            

                <!--<div class="col-auto float-right ml-auto" style="margin-bottom: 30px;">
                <a href="#" data-toggle="modal" data-target="#add_appraisal" class="btn btn-primary add-btn" style="padding-bottom: 8px;"><i class="bi bi-plus-lg"></i>Add Appraisal</a>
                </div>-->

            </div>
            <div class="row">
                <div class="float-end">
                <button type="button" class="btn btn-success" onclick="ExportToExcel('xlsx')">Download Excel</button>
                    <!-- <button type="button" class="btn btn-danger"><a href="#"  class="text-light">Download PDF</a></button> -->
                </div>
            </div>
            
        </div>
        

        <!-- /Page Header -->

       

        <!-- /Search Filter -->
        <div class="row">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="table-responsive" style="max-height: 700px; overflow-y: auto;">
                    <table class="table table-striped custom-table datatable dataTable-selector" id="tbl_exporttable_to_xls" style="display: inline-table; padding: 5px;">
                    <thead style="position: sticky; top: 0;z-index:999;">
                        <tr>
                            <th style="position:sticky;left:0;background:#c2e0ab;z-index:1;">Sl.No</th>
                            <th style="position:sticky;left: 5%;background:#c2e0ab;z-index:1;">Emp.No</th>
                            <th style="position:sticky;left:11%;background:#c2e0ab;z-index:1;">QID</th>
                            <th style="position:sticky;left:20%;background:#c2e0ab;z-index:1;">Passport No</th>
                            <th style="position:sticky;left:29%;background:#c2e0ab;z-index:1;">Name</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>D.o.b</th>
                            <th>Date of Joining</th>
                            <th>Last Working Day</th>
                            <th>Total days of Employement</th>
                            <th>Unpaid Leave</th>
                            <th>Net Days worked</th>
                            <th>Gross Salary</th>
                            <th>Salary</th>
                            <th>Notice Period</th>
                            <th>Notice period(Remarks)</th>
                            <th>Total Days of Last Month</th>
                            <th>Total Days of Last Month(Remarks)</th>
                            <th>Current Monthly Salary</th>
                            <th>Notice Pay</th>
                            <th>Annual Leave (Entitled annual)</th>
                            <th>Accured Annual Leave</th>
                            <th>Annual Leave Balance</th>
                            <th>Leave Accural Amount</th>
                            <th>Eligibility of  Gratuity</th>
                            <th>Eligible Days</th>
                            <th>Gratuity</th>
                            <th>Gratuity deduction</th>
                            <th>Total gratuity</th>
                            <th>Ticket Accural</th>
                            <th>Return Ticket</th>
                            <th>Net pay</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($gratiuity as $val)
                       <tr>
                        <td style="position:sticky;left:0;background:#c2e0ab;z-index:1;">{{$loop->iteration}}</td>
                        <td style="position:sticky;left:5%;background:#c2e0ab;z-index:1;">{{$val->employee_no}}</td>
                        <td style="position:sticky;left:11%;background:#c2e0ab;z-index:1;">{{$val->qidno}}</td>
                        <td style="position:sticky;left:20%;background:#c2e0ab;z-index:1;">{{$val->passportno}}</td>
                        <td style="position:sticky;left:29%;background:#c2e0ab;z-index:1;"><a href="{{route('final-statement',$val->id)}}"> {{$val->name}} &nbsp;{{$val->lname}}</a> </td>
                        <td>{{$val->designation}}</td>
                        <td>{{$val->department}}</td>
                        <td>{{$val->dob}}</td>
                        <td>{{$val->joining_date}}</td>
                        <td>{{$val->last_working_day}}</td>
                        <td>{{$val->total_days_employment}}</td>
                        <td>{{$val->annual_leave_balance}}</td>
                        <td>{{$val->net_days_worked}}</td>
                        <td>{{$val->gross_total}}</td>
                        <td></td>
                        <td>{{$val->notice_period}}</td>
                        <td>{{$val->notice_period_remarks}}</td>
                        <td>{{$val->total_days_last_month}}</td>
                        <td></td>
                        <td>{{$val->current_month_salary}}</td>
                        <td>{{$val->notice_pay}}</td>
                        <td>{{$val->annual_leave_entitled}}</td>
                        <td>{{$val->accrued_annual_leave}}</td>
                        <td>{{$val->annual_leave_balance}}</td>
                        <td>{{$val->leave_accrual_amount}}</td>
                        <td></td>
                        <td>{{$val->eligible_days}}</td>
                        <td>{{$val->gratuity_add}}</td>
                        <td>{{$val->gratuity_ded}}</td>
                        <td>{{$val->gratuity_total}}</td>
                        <td>{{$val->ticket_accrual_amount}}</td>
                        <td>{{$val->return_ticket_amount}}</td>
                        <td>{{number_format(($val->net_pay+$val->last_payroll), 2)}}</td>
                        <td>{{$val->remarks}}</td>
                       </tr>
                       @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
</main>
@endsection
<script>

    function ExportToExcel(type, fn, dl) {
        // alert("hs");
        var elt = document.getElementById('tbl_exporttable_to_xls');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
            XLSX.writeFile(wb, fn || ('Employee_Timesheet.' + (type || 'xlsx')));
    }

</script>