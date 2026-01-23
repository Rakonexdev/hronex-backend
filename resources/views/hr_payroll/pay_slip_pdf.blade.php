
{{header("cache-Control: no-store, no-cache, must-revalidate")}}
{{header("cache-Control: post-check=0, pre-check=0", false)}}
{{header("Pragma: no-cache")}}
{{header("Expires: Sat, 26 Jul 1997 05:00:00 GMT")}}


<!DOCTYPE html>
<html>
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>FAS-HRMS</title>   

</head>
<style>

body {
    font-family: "Open Sans", sans-serif;
    min-height: 100vh;
    overflow-x: hidden;
}

#main {
    margin-top: 60px;
    padding: 25px 25px;
    transition: all 0.3s;
}

.row {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 0;
    display: flex;
    flex-wrap: wrap;
    margin-top: calc(-1 * var(--bs-gutter-y));
    /*margin-right: calc(-.5 * var(--bs-gutter-x));
    margin-left: calc(-.5 * var(--bs-gutter-x));*/
}

.row > * {
    flex-shrink: 0;
    width: 100%;
    max-width: 100%;    
    /*padding-right: calc(var(--bs-gutter-x) * .5);
    padding-left: calc(var(--bs-gutter-x) * .5);*/
    margin-top: var(--bs-gutter-y);
}

.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #ffffff;
    background-clip: border-box;
    border: 1px solid #ededed;
    /* border-radius: 10px; */
    box-shadow: 0 6px 30px rgba(182, 186, 203, 0.3);
    margin-bottom: 24px;
    transition: box-shadow 0.2s ease-in-out;
}

.card-body {
    flex: 1 1 auto;
    padding: 20px 20px;
}

.payslip-title {
    margin-bottom: 20px;
    text-align: center;
    text-decoration: underline;
    text-transform: uppercase;
}

h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6 {
    margin-top: 0;
    /*margin-bottom: 0.5rem;*/
    font-weight: 600;
    line-height: 1.2;
    color: #060606;
}

h4 {
    margin-bottom: 0;
    font-weight: 600;
    color: #012970;
    font-size: 1.25rem;
}

.m-b-20 {
    margin-bottom: 20px !important;
}

.text-uppercase {
    text-transform: uppercase !important;
}

ol, ul, dl {
    margin-top: 0;
    margin-bottom: 1rem;
    padding-inline-start: 1px;
}

.list-unstyled {
    list-style: none;
}

.col-md-12 {
    flex: 0 0 auto;
    width: 100%;
}

.col-lg-12 {
    flex: 0 0 auto;
    width: 100%;
}

.col-sm-6 {
    flex: 0 0 auto;
    width: 49%;
    padding-right: 6px;
    padding-left: 6px;
}

.float-right {
    float: right!important;
}

table {
    caption-side: bottom;
    border-collapse: collapse;
}

.table {
    /*--bs-table-bg: transparent;
    --bs-table-accent-bg: transparent;
    --bs-table-striped-color: #293240;
    --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
    --bs-table-active-color: #293240;
    --bs-table-active-bg: rgba(0, 0, 0, 0.1);
    --bs-table-hover-color: #293240;
    --bs-table-hover-bg: rgba(81, 69, 157, 0.02);*/
    width: 100%;
   /* margin-bottom: 1rem;*/
    color: #012970;
    vertical-align: top;
    /*border-color: #f1f1f1;*/
}

.table-bordered {
    border: 1px solid #f1f1f1;
}

.card:not(.table-card) .table {
    margin-bottom: 0;
}

.table > tbody {
    vertical-align: inherit;
}

thead, tbody, tfoot, tr, td, th {
    border-color: inherit;
    border-style: solid;
    border-width: 0;
}

.table-bordered > :not(caption) > * {
    border-width: 1px 0;
}

tr {
    display: table-row;
    vertical-align: inherit;
}

.table > tbody > tr > td {
    vertical-align: middle;
}

.table-bordered td, .table-bordered th {
    border: 1px solid #e4e1e1 !important;
    padding: 0.7rem 0.75rem;
}

b, strong {
    font-weight: 500;
}

.tot {
    font-weight: 700;
}

.m-t-10 {
    margin-top: 10px !important;
}

.m-t-20 {
    margin-top: 20px !important;
}


/*@media (min-width: 768px)
.col-md-12 {
    flex: 0 0 auto;
    width: 100%;
}

@media (min-width: 576px)


@media (min-width: 992px)
.col-lg-12 {
    flex: 0 0 auto;
    width: 100%;
}*/

</style>
<body>

    <main id="main" class="main">
        @if(null != $payslip)

            @foreach($payslip as $payslip)
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="payslip-title">
                                <!-- Salary Slip for the Month of payslip-month_year -->
                                <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('img/FAS Logo.png')))}}" alt="" class="inv-logo" alt="" style="max-height: 50px;">
                            </h4>
                            <div class="row">
                                <div class="col-sm-6 m-b-20">&nbsp;                                    
                                    <!--<ul class="list-unstyled mb-0">
                                        <li>Dreamguy's Technologies</li>
                                        <li>3864 Quiet Valley Lane,</li>
                                        <li>Sherman Oaks, CA, 91403</li>
                                    </ul>-->
                                </div>
                                <div class="col-sm-6 m-b-20" style="display: flex; flex-direction: row-reverse;">
                                    <div class="invoice-details">
                                        <h4 class="text-uppercase">Salary Slip</h4>
                                        <ul class="list-unstyled" style="padding-left: 20px;">
                                            <li style="font-size: 13px;">Salary Month: <span>{{$payslip->month_year}}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 m-b-20">
                                    <ul class="list-unstyled">
                                        <li>Employee ID : <span>{{$payslip->employee->employee_no}}</span></li>
                                        <li>Employee Name : <span>{{$payslip->employee->name}} &nbsp; {{$payslip->employee->lname}}</span></li>
                                        <li>Designation : <span>{{$payslip->employee->designations->name}}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <h5 class="m-b-10 m-t-10"><strong class="tot">EMOLUMENTS</strong><span class="float-right">QAR</span></h5>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Basic Pay</strong><span class="float-right">{{$payslip->employee->employeePayrollInformation[0]->basic_salary}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Transport Allowance</strong><span class="float-right">{{$payslip->employee->employeePayrollInformation[0]->transport_allowance}}</span></td>
                                                </tr>
                                                </tr>
                                                <tr>
                                                    <td><strong>Accomodation Allowance</strong><span class="float-right">{{$payslip->employee->employeePayrollInformation[0]->accomodation_allowance}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Continuous Allowance</strong><span class="float-right">{{$payslip->employee->employeePayrollInformation[0]->continuous_allowance}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Temporary Allowance</strong><span class="float-right">{{$payslip->employee->employeePayrollInformation[0]->temp_allowance}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Other Allowance </strong><span class="float-right">{{$payslip->employee->employeePayrollInformation[0]->other_allowance}}</span></td>
                                                </tr>

                                                <tr>
                                                <td><strong></strong><span class="float-right"></span></td>
                                            </tr>
                                            
                                        <tr>
                                            <td>
                                            <h5 class="m-t-10 tot"><strong class="tot">GROSS PAY</strong><span class="float-right">{{number_format($payslip->employee->employeePayrollInformation[0]->gross_total, 2)}}</span></h5>
                                            </td>
                                        </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <h5 class="m-b-10 m-t-10"><strong class="tot">ADDITIONS &DEDUCTIONS</strong><span class="float-right">QAR</span></h5>
                                        <table class="table table-bordered">
                                            <tbody>
                                            @if($payslip->earning)
                                                @php
                                                    $reasons = json_decode($payslip->earning->additional_reason);
                                                    $amounts = json_decode($payslip->earning->additional_amount);
                                                @endphp
                                                    @if (count($reasons) > 0 && count($amounts) > 0 && count($reasons) == count($amounts))
                                                    @for ($i = 0; $i < count($reasons); $i++)
                                                    <tr>
                                                        <td>                                                        
                                                                <strong>  Other Additions- {{ $reasons[$i] }}</strong> <span class="float-right">{{ $amounts[$i] }}<br></span>   
                                                        </td>
                                                    </tr>
                                                    @endfor
                                                    @endif
                                                @endif
                                                <tr>
                                                    <td><strong>Total Additions Amount</strong><span class="float-right"><strong>{{number_format($payslip->total_addtional_amount, 2)}}</strong></span></td>
                                                </tr>
                                            @if($payslip->deduction)
                                                @php
                                                    $reasons = json_decode($payslip->deduction->deduction_reason);
                                                    $amounts = json_decode($payslip->deduction->deduction_amount);
                                                @endphp
                                                    @if (count($reasons) > 0 && count($amounts) > 0 && count($reasons) == count($amounts))
                                                    @for ($i = 0; $i < count($reasons); $i++)
                                                    <tr>
                                                        <td>                                                        
                                                                Other Deduction- {{ $reasons[$i] }} <span class="float-right">{{ $amounts[$i] }}<br></span>   
                                                        </td>
                                                    </tr>
                                                    @endfor
                                                    @endif
                                                @endif
                                                
                                                <tr>
                                                    <td><strong>Total Deductions Amount</strong><span class="float-right"><strong>{{$payslip->total_deduction_amount}}</strong></span></td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Leave Deductions Amount</strong><span class="float-right"><strong>{{number_format($payslip->total_leave_deduction_amount, 2)}}</strong></span></td>
                                                </tr>
                                                <tr>
                                                <td>
                                                    <h5 class="m-t-10 tot"><strong class="tot">NET PAY</strong><span class="float-right">{{number_format($payslip->net_salary, 2)}}</span></h5>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </main>

</body>
</html>