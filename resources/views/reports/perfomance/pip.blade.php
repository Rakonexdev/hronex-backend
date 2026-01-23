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
    @php
        $improvements = json_decode($pip->improment_goals);
        $managements = json_decode($pip->management_support);
        $activity = json_decode($pip->activity);
        $check_date = json_decode($pip->check_point_date);
        $type_of_follow_up = json_decode($pip->type_of_follow_up);
        $progress_expected = json_decode($pip->progress_expected);
        $notes = json_decode($pip->notes);
    @endphp
        <table border='1' class="table table-bordered">
            <tbody>
                <tr class="main-table">
                    <td colspan="6">
                        <h4>{{$thiscompany}}</h4> 
                        <p><strong>{{$thiscomparea}}</strong></p>
                    </td>
                </tr>
                <tr class="main-table"><td colspan="6"><h6>Performance Improvement Plan (PIP)</h6><br>(Confidential)</td></tr>
                <tr>
                    <td colspan="2">STAFF MEMBER:</td>
                    <td colspan="4">{{$pip->staff_member}}</td>
                </tr>
                <tr>
                    <td colspan="2">DATE:</td>
                    <td colspan="4">{{$pip->date}}</td>
                </tr>
                <tr>
                    <td colspan="6">The purpose of this Performance Improvement Plan (PIP) is to define serious areas of concern, gaps in your work performance, reiterate First Assalam School’s expectations, and allow you the opportunity to demonstrate improvement and commitment.</td>
                </tr>
                <tr>
                    <td colspan="6"><strong>Areas of Concern:</strong></td>
                </tr>
                <tr>
                    <td colspan="6">{{$pip->area_of_concern}}</td>
                </tr>
                <tr>
                    <td colspan="6"><strong>Observations, Previous Discussions or Counselling:</strong></td>
                </tr>
                <tr>
                    <td colspan="6">{{$pip->Observations}}</td>
                </tr>
                <tr>
                    <td colspan="6"><strong>Improvement Goals:</strong></br>(These are the goals related to areas of concern to be improved and addressed:)</td>
                </tr>
                @foreach($improvements as $improvement)
                    
                        <tr>
                            <td colspan="6">{{$loop->iteration}}.&nbsp;{{$improvement}}</td>
                        </tr>
                    
                @endforeach
                <tr>
                    <td colspan="6"><strong>Management Support:</strong></br>(Listed below are ways in which your manager will support your Improvement activities.)</td>
                </tr>
                @foreach($managements as $management)
                    <tr>
                        <td colspan="6">{{$loop->iteration}}.&nbsp;{{$management}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6"><strong>Progress Checkpoints:</strong></br>(The following schedule will be used to evaluate your progress in meeting your Improvement activities.)</td>
                </tr>
                <tr>
                    <td>Goal #</td>
                    <td>Activity</td>
                    <td>Checkpoint Date</td>
                    <td>Type of Follow-up
                    (email/call/meeting)</td>
                    <td>Progress Expected</td>
                    <td>Notes</td>
                </tr>
                @foreach($activity as $key => $act)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $act }}</td>
                        <td>{{ $check_date[$key] }}</td>
                        <td>{{ $type_of_follow_up[$key] }}</td>
                        <td>{{ $progress_expected[$key] }}</td>
                        <td>{{ $notes[$key] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6">
                        You are placed on a Performance Improvement Plan, with follow-up update(s) scheduled.<br>
                        During this time you will be expected to make regular progress on the plan outlined above. Failure to meet or exceed these expectations, or any display of gross misconduct will result in further disciplinary action, up to and including termination.<br>
                        In addition, if there is no significant improvement to indicate that the expectations and goals will be met within the timeline indicated in this Performance Improvement Plan, your employment may be terminated. Furthermore, failure to maintain performance expectations after the completion of the Performance Improvement Plan may also result in additional disciplinary action up to and including termination.
                    </td>
                </tr>
                <tr>
                    <td colspan="6"><strong>Signatures:</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Employee Name: </td>
                    <td colspan="4">{{$employee->name}}&nbsp;{{$employee->lname}}</td>
                </tr>
                <!-- <tr>
                    <td colspan="2">Employee Signature:</td>
                    <td colspan="2"></td>
                    <td colspan="1">Date:</td>
                    <td colspan="1"></td>
                </tr>
                <tr>
                    <td colspan="2">Principal’s name:</td>
                    <td colspan="4"></td>
                </tr> -->
                <tr>
                    <td colspan="2">Principal’s Signature:</td>
                    <td colspan="2">{{$pip->principal_ackn == 1 ? "Yes" : "No"}}</td>
                    <td colspan="1">Date:</td>
                    <td colspan="1">{{$pip->principal_date}}</td>
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
