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
                    <td colspan="4">
                        <h4>{{$thiscompany}}</h4> 
                        <p><strong>{{$thiscomparea}}</strong></p>
                    </td>
                </tr>
               <tr>
                    <td>
                    Employee Name
                    </td>
                    <td>{{$employee->name}} {{$employee->lname}}</td>
               </tr>
               <tr>
                    <td>
                    Employee ID
                    </td>
                    <td>{{$employee->employee_no}}</td>
               </tr>
               <tr>
                    <td>
                    Designation
                    </td>
                    <td>{{ $employee->designations->name }}</td>
               </tr>
               <tr>
                    <td>
                        Date of Joining
                    </td>
                    <td>{{ $employee->joiningdate }}</td>
               </tr>
               <tr>
                    <td>
                    Review Period
                    </td>
                    <td></td>
               </tr>
               <tr>
                    <td>
                    Review Date
                    </td>
                    <td></td>
               </tr>
               <tr>
                <td colspan="2"><h6>SECTION 1 – Objectives Review</h6></td>
               </tr>
               <tr>
                <td>Objectives</td>
                <td>Discussion Points/ Action Agreed</td>
               </tr>
                @php
                    $objectives = json_decode($ppr_form->objectives);
                    $discussion = json_decode($ppr_form->discussion_points);
                @endphp 
                @foreach($objectives as $index => $objective)
                    <tr>
                        <td>{{$objective}}</td>
                        <td>{{$discussion[$index]}}</td>
                    </tr>
                @endforeach
               <tr>
                <td colspan="2"><h6>SECTION 2 – Performance  Review</h6></td>
               </tr>
               <tr>
                <td></td>
                <td>Rating</td>
               </tr>
                @php
                    $rating = json_decode($ppr_form->performance_review_rating);
                @endphp   
                @foreach($review_data as $index=>$review)
                    @php
                        $ans = $rating[$index];
                    @endphp
                    <tr>
                        <td>{{$review->performance_review}}</td>
                        <td>{{$ans}}</td>
                    </tr>
                @endforeach
               <tr>
                <td colspan="2"><strong>Performance  Feedback  -  Outline  of  areas  where  employee  is  performing  well  against  objectives  and standards set:</strong></td>
               </tr>
               <tr>
                <td colspan="2">{{$ppr_form->performance_review_feedback ?? ''}}</td>
               </tr>
               <tr>
                <td colspan="2"><strong>Where any areas require improvement give details below:</strong></td>
               </tr>
               <tr>
                <td colspan="2">{{$ppr_form->require_improvement ?? ''}}</td>
               </tr>
               <tr>
                <td><strong>Areas for Improvement</strong></td>
                <td><strong>Discussion Points / Action Agreed</strong></td>
               </tr>
               <tr>
                <td>{{$ppr_form->areas_improvement ?? ''}}</td>
                <td>{{$ppr_form->areas_discussion_points ?? ''}}</td>
               </tr>
               <tr>
                <td><strong>Outline the employee's views on the job, work environment and working conditions:</strong> </td>
                <td><strong>Managers Action Points:</strong></td>
               </tr>
               <tr>
                
                <td>{{$ppr_form->work_environment ?? ''}}</td>
                <td>{{$ppr_form->manager_action_points ?? ''}}</td>
               </tr>
               <tr>
                <td colspan="2"><strong>Where any areas require improvement give details below:</strong></td>
               </tr>
               <tr>
                <td colspan="2">{{$ppr_form->require_improvement ?? ''}}</td>
               </tr>
               <tr>
                <td colspan="2"><strong>Summary of employee's overall performance:</strong></td>
               </tr>
               <tr>
                <td colspan="2">{{$ppr_form->over_all_perfamance ?? ''}}</td>
               </tr>
               <tr>
                <td colspan="2"><h6>SECTION 3 – Final Review</h6></td>
               </tr>
               <tr>
                <td>Is the employee's appointment to be confirmed?<br>
            (If Yes, confirmation of successful Probation Period letter/email to be sent to employee)</td>
                <td>{{$ppr_form->appointment_conformed == 1 ? "Yes" : "No"}}</td>
               </tr>
               <tr>
                    <td colspan="2">If No, give details of the concerns and schedule a Probation Period Hearing date below:</td>
               </tr>
               <tr>
                <td colspan="2">{{$ppr_form->no_conformed ?? ''}}</td>
               </tr>
               <tr>
                <td>Extension of Probationary Period:</td>
                <td>{{$ppr_form->extension_period}} - {{$ppr_form->extension_period == 1 ? "Month" : "Month's"}}</td>
               </tr>
               <tr>
                <td colspan="2">Where an extension of the probation period is determined as part of the Probationary Review or Performance Review, a new probationary review form must be completed.</td>
               </tr>
               <tr>
                <td>Employee's Signature</td>
                <td>{{$ppr_form->employee_ack == 1 ? "Yes" : "No"}}</td>
               </tr>
               <tr>
                <td>HOD's Signature</td>
                <td>{{$ppr_form->hod_ack == 1 ? "Yes" : "No"}}</td>
               </tr>
               <tr>
                <td>Principal's Signature</td>
                <td>{{$ppr_form->principla_ack == 1 ? "Yes" : "No"}}</td>
               </tr>
               <tr>
                <td>Date</td>
                <td>{{$ppr_form->ack_date}}</td>
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
