<html>
<head>
    <meta charset="UTF-8" />
    <title>Employee Leave Sheet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" />   
    <!-- <link rel="stylesheet" href="{{asset('css/report.css')}}" /> -->

    <style>
        
        .report-container table tr td, .report-container table tr th {
    font-size: 12px;
}
.main-table td {
    text-align: center;
}

.child-table-f {
    border-color: #cdcdcd;
}
.child-table-f-p th {
    text-align: center;
}
.child-table-f-p {
    background-color: #339;
    color: #fff;
}
.child-table-f-i {
    background-color: #deeaf6;
}
.child-table-f-i th, .child-table-f-i td {
    text-align: center;
}

.child-table-s-p {
    background-color: #ff0;
    color: #000;
}
.child-table-s-p th {
    text-align: center;
}
.child-table-s-p-0 {
    background-color: #339;
    color: #fff;
}
.child-table-s-i th, .child-table-s-i td {
    text-align: center;
}
.bottom-ln {
    text-align: right;
    font-size: 12px;
}

sup {
    color: #ff0000 !important;
}


    </style>



</head>
<body>
    <div class="container report-container">
        <table border='1' class="table table-bordered">
            <tbody>
                <tr class="main-table">
                    <td>
                        <h4>{{$thiscompany}}</h4> 
                        <p><strong>{{$thiscomparea}}</strong></p>
                    </td>
                </tr>
                <tr class="main-table">
                    <td><strong>Employee Leave Sheet</strong></td>
                </tr>
                <tr>
                    <td>
                        <div class="col-xl-12 d-flex">
                            <div class="col-xl-2 fw-bold">Employee No.</div>
                            <div class="col-xl-4"> : {{$employee->employee_no}} </div>
                        </div>
                        <div class="col-xl-12 d-flex">
                            <div class="col-xl-2 fw-bold">Employee Name</div>
                            <div class="col-xl-4"> : {{$employee->name.' '.$employee->lname}} </div>
                        </div>
                        <div class="col-xl-12 d-flex">
                            <div class="col-xl-2 fw-bold">Date of Joining</div>
                            <div class="col-xl-4"> : {{date('d-M-Y', strtotime($employee->joiningdate))}} </div>
                        </div>
                        <div class="col-xl-12 d-flex">
                            <div class="col-xl-2 fw-bold">Designation</div>
                            <div class="col-xl-4"> : {{$employee->designations->name}} </div>
                        </div>
                        <div class="col-xl-12 d-flex">
                            <div class="col-xl-2 fw-bold">Department</div>
                            <div class="col-xl-4"> : {{$employee->departments->name}} </div>
                        </div>
                    </td>
                </tr>


                <tr>
                    <td style="padding: 0;">
                        <table class="table table-bordered child-table-f">
                            <tbody>
                                <tr class="child-table-f-p">
                                    <th style='text-align: left;'>Leave Utilization(Summary)</th>
                                    @foreach($leavetypes as $eachlt)
                                        <th>{{str_replace('Leave', '', $eachlt->name)}}</th>
                                    @endforeach                                    
                                    <th>Unpaid</th>
                                </tr>
                                <tr class="child-table-f-i">
                                    <td style='text-align: left;'>Carryforward Balance</td>
                                    @foreach($leavetypes as $eachlt)
                                        <td></td>
                                    @endforeach
                                    <td>0</td>
                                </tr>                                
                                <tr class="child-table-f-i">
                                    <td style='text-align: left;'>Entitlemnt For the Year</td>
                                    @foreach($leavetypes as $eachlt)
                                        <td>{{$eachlt->leave_days}}</td>
                                    @endforeach 
                                    <td>{{$unpaid->avail}}</td>
                                </tr>
                                <tr class="child-table-f-i">
                                    <td style='text-align: left;'>Utilised During the Year</td>
                                    @foreach($leavetypes as $eachlt)
                                        <td>{{$eachlt->used_count}}</td>
                                    @endforeach 
                                    <td>{{$unpaid->used}}</td>
                                </tr>
                                <tr class="child-table-f-i">
                                    <td style='text-align: left;'>Balance</td>
                                    @foreach($leavetypes as $eachlt)
                                        <td>{{$eachlt->balance}}</td>
                                    @endforeach 
                                    <td>{{$unpaid->balance}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td style="padding: 0;">
                        <table class="table table-bordered child-table-s">
                            <tbody>
                                <tr class="child-table-s-p-0">
                                    <th colspan="5">Leave Utilization(Detail)</th>
                                </tr>
                                <tr class="child-table-s-p">
                                    <th>Sl No.</th>
                                    <th style='text-align: left;'>Leave Type</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>No. of Days</th>
                                </tr>
                                @if($all_leaves->isNotEmpty())
                                    @foreach($all_leaves as $eachal)
                                        <tr class="child-table-s-i">
                                            <td>{{$loop->iteration}}</td>
                                            <td style='text-align: left;'>{{$eachal->leavetypes->name}}</td>
                                            <td>{{date('d-M-Y', strtotime($eachal->date_from))}}</td>
                                            <td>{{date('d-M-Y', strtotime($eachal->date_to))}}</td>
                                            <td>{{$eachal->no_days}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="child-table-s-i"><td colspan='5'>{{trans('messages.no_data')}}</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style='text-align: center;'>{{$systemsignature}}</td>
                </tr>
            </tbody>
        </table>
        <div class="col-xl-12 bottom-ln">Date Printed: {{date('d-M-Y')}} </div>       

        <!-- <div class="row">
            <div class="d-flex justify-content-center">
                <form action="{{route('employee_leave_sheet_report')}}" method="post">
                    @csrf 
                    <input type="hidden" name="date_from" value="{{isset($request->date_from)?$request->date_from:''}}" />
                    <input type="hidden" name="date_to" value="{{isset($request->date_to)?$request->date_to:''}}" />
                    <input type="hidden" name="employee_id" value="{{isset($request->employee_id)?$request->employee_id:''}}" />
                    <input type="hidden" name="doc" value="1" />
                    <button type="submit" class="btn btn-danger ">
                        Download Word
                    </button>
                </form>               
            </div>
        </div> -->

        <!-- Print this page -->
        @include("reports.partial.print")

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>    

</body>
</html>
