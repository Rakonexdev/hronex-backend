<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>FAS-HRMS</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{asset('/img/favicon.png')}}" />

    <!-- Bootstrap CSS -->
  <link href="{{asset('css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Calendar CSS-->
  <link href="{{asset('css/fullcalendar.min.css') }}" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Extra Fonts & Line CSS -->
  <link href="{{asset('css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{asset('css/line-awesome.min.css') }}" rel="stylesheet">
  <link href="{{asset('fonts/fontawesome.css') }}" rel="stylesheet">
  <link href="{{asset('fonts/material.css') }}" rel="stylesheet">
  <link href="{{asset('fonts/feather.css') }}" rel="stylesheet">
  <link href="{{asset('fonts/tabler-icons.min.css') }}" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{asset('css/style.css') }}" rel="stylesheet">

  <!-- Extra CSS File -->
  <link href="{{asset('css/style(2).css') }}" rel="stylesheet">
  <link href="{{asset('css/style(3).css') }}" rel="stylesheet">

  <link href="{{asset('css/custom.css') }}" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.css">
  @yield('page_css')

</head>

<style>
.table-bordered td, .table-bordered th {
    border: 1px solid #e4e1e1 !important;
}
</style>

<!-- /Page Header -->

<!-- Search Filter -->
<!--<div class="row">

  <div class="col-md-5">  
    <div class="form-group">
     <label for="inputName5" class="form-label">From Date</label>
     <input type="date" class="form-control" id="inputName5" style="color: #8D8D8D;" placeholder="Enter Emp ID">
    </div>
   </div>

   <div class="col-md-5">  
     <div class="form-group">
       <label for="inputName5" class="form-label">Until Date</label>
       <input type="date" class="form-control" id="inputName5" style="color: #8D8D8D;" placeholder="Enter Emp Name">
     </div>
    </div>
   
    <div class="col-md-2" style="padding-top: 33px;"> 
     <button type="button" class="btn btn-block btn-alpha">Search</button>  
    </div>

</div>-->
<!-- /Search Filter -->
@foreach($payslip as $payslip)
<div class="row" style="margin-top: 30px;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="payslip-title">Salary Slip for the Month of {{$payslip->month_year}}</h4>
                <div class="row">
                    <div class="col-sm-6 m-b-20">                        
                        <img src="{{ asset('img/FAS Logo.png') }}" alt="" class="inv-logo" alt="" style="max-height: 50px;">
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
                            <h5 class="m-b-10"><strong>EMOLUMENTS</strong><span class="float-right">QAR</span></h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Current Monthly Salary</strong><span class="float-right">{{$gratuity->current_month_salary}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Notice Pay</strong><span class="float-right">{{$gratuity->notice_pay}}</span></td>
                                    </tr>  

                                    <tr>
                                      <td><strong></strong><span class="float-right"></span></td>
                                  </tr>
                                 
                              <tr>
                                <td>
                                  <h5 class="m-t-10"><strong>GROSS PAY</strong><span class="float-right">{{number_format($payslip->total_gross_salary, 2)}}</span></h5>
                                </td>
                              </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div>
                            <h5 class="m-b-10"><strong>ADDITIONS &DEDUCTIONS</strong><span class="float-right">QAR</span></h5>
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
                                        <td>                                                        
                                                <strong>  Other Additions- Gratuity</strong> <span class="float-right">{{ number_format($payslip->total_gratuity_amount, 2) }}<br></span>   
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>                                                        
                                                <strong>  Other Additions- Leave Accrual</strong> <span class="float-right">{{ number_format($payslip->total_leave_accural_amount, 2) }}<br></span>   
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Additions Amount</strong><span class="float-right"><strong>{{number_format($payslip->total_addtional_amount+$payslip->total_gratuity_amount+$payslip->total_leave_accural_amount, 2)}}</strong></span></td>
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
                                        <h5 class="m-t-10"><strong>NET PAY</strong><span class="float-right">{{number_format($payslip->net_salary, 2)}}</span></h5>
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