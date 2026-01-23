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
                <tr class="main-table">
                    <td colspan="4">
                        <h5>PERFORMANCE REVIEW</h5> 
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <h6>SECTION A - EMPLOYEE DETAILS</h6> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>EMPLOYEE NO.</p> 
                    </td>
                    <td>
                        <p>{{ $appraisal->employee->employee_no }}</p> 
                    </td>
                    <td>
                        <p>Department</p> 
                    </td>
                    <td>
                        <p>{{ $appraisal->employee->departments->name }}</p> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Name</p> 
                    </td>
                    <td>
                        <p>{{ $appraisal->employee->name }} {{ $appraisal->employee->lname }}</p> 
                    </td>
                    <td>
                        <p>Date of Joining</p> 
                    </td>
                    <td>
                        <p>{{ $appraisal->employee->joiningdate }}</p> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Designation	</p> 
                    </td>
                    <td>
                        <p>{{ $appraisal->employee->designations->name }}</p> 
                    </td>
                    <td>
                        <p>Designation Period</p> 
                    </td>
                    <td>
                        <p>{{ $appraisal->employee->departments->name }}</p> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Review Period</p> 
                    </td>
                    <td>
                    {{ $appraisal->evaluation_period }}
                    </td>
                     <td>
                        <p>Evalution Date</p> 
                    </td>
                    <td>
                    {{ $appraisal->evaluation_date }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Instructions</p> 
                    </td>
                    <td colspan="3">
                    Form to be completed by immediate Reporting Head / Principal, during performance review. Two way open discussion between Reporting Head / Principal is encouraged. Employee is to acknowledge by signing. DO NOT leave blanks, write 'NA' where not applicable .
Review and Signed by Head of Department/ Principal and  HR officer. Copy of Form will be filed in the Employee file. Completed Report to be returned to HR within 10 days.	
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Objectives</p> 
                    </td>
                    <td colspan="3">
                    To review the employees performance during the review and to discuss the training needs, goals and measurement till next Performance Review.
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <h6>SECTION B - COMPETENCIES (Ratings and Weightages entered by Appraiser)</h6> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>No</p> 
                    </td>
                    <td>
                        <p>TASKS / COMPETENCIES	</p> 
                    </td>
                    <td>
                        <p>HOD Rating</p> 
                    </td>
                    <td>
                        <p>Principal Rating</p> 
                    </td>
                </tr>
                <tr>
                    @foreach ($appraisalFeedback as $appraisalData)
                        @php
                            $hodRatings = json_decode($appraisal->hod_rating);
                            $principalRatings = json_decode($appraisal->principal_rating);
                            $index = array_search($appraisalData->id, $appraisalDataIds);
                            $hodRating = isset($hodRatings[$index]) ? $hodRatings[$index] : null;
                            $principalRating = isset($principalRatings[$index]) ? $principalRatings[$index] : null;
                        @endphp
                            @if($appraisalData->appriasal_type->type_name == "COMPETENCIES (Ratings and weightages entered by appraiser)")
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        {{$appraisalData->details}}
                                    </td>
                                    <td >
                                        {{$hodRating}}
                                    </td>
                                   
                                    <td>
                                        {{$principalRating}}
                                    </td>
                                </tr>
                            @endif
                    @endforeach
                </tr>
                <tr>
                    <td colspan="4">
                        <h6>SECTION C - Employee Characteristics</h6> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>No</p> 
                    </td>
                    <td>
                        <p>Communication skills</p> 
                    </td>
                    <td>
                        <p>HOD Rating</p> 
                    </td>
                    <td>
                        <p>Principal Rating</p> 
                    </td>
                </tr>
                <tr>
                @foreach ($appraisalFeedback as $appraisalData)
                    @php
                        $hodRatings = json_decode($appraisal->hod_rating);
                        $principalRatings = json_decode($appraisal->principal_rating);
                        $index = array_search($appraisalData->id, $appraisalDataIds);
                        $hodRating = isset($hodRatings[$index]) ? $hodRatings[$index] : null;
                        $principalRating = isset($principalRatings[$index]) ? $principalRatings[$index] : null;
                    @endphp
                        @if($appraisalData->appriasal_type->type_name == "Employee Characteristics")
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$appraisalData->details}}
                                </td>
                                <td >
                                    {{$hodRating}}
                                </td>
                                
                                <td>
                                    {{$principalRating}}
                                </td>
                            </tr>
                        @endif
                @endforeach
                </tr>
                <tr>
                    <td colspan="4">
                        <h6>SECTION D - Employee Future Targets</h6> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>No</p> 
                    </td>
                    <td>
                        <p>Areas of Improvement/Tasks/Goals</p> 
                    </td>
                    <td>
                        <p>Review By Date</p> 
                    </td>
                    <td>
                        <p>Recommended by</p> 
                    </td>
                </tr>
                @php
                    $future_target         = json_decode($appraisal->future_targets_data);
                    $future_target_date    = json_decode($appraisal->future_target_review_date);
                    $future_recommended    = json_decode($appraisal->future_targets_recommended);
                @endphp
                @if(isset($future_target[0]) && !empty($future_target[0] && $future_target[0] !=null))
                <tr>
                    <td>
                    @if(isset($future_target[0]) && !empty($future_target[0] && $future_target[0] !=null))
                        1                    
                    @endif
                    </td>
                    <td>
                    @if(isset($future_target[0]) && !empty($future_target[0] && $future_target[0] !=null))
                    {{$future_target[0]}}
                    @endif
                    </td>
                    <td>
                        @if(isset($future_target_date[0]) && !empty($future_target_date[0] && $future_target_date[0] !=null))
                        {{$future_target_date[0]}}
                        @endif
                    </td>
                    <td>
                        @if(isset($future_recommended[0]) && !empty($future_recommended[0] && $future_recommended[0] !=null))
                        {{$future_recommended[0]}}
                        @endif
                    </td>
                </tr>
                @endif
                @if(isset($future_target[1]) && !empty($future_target[1] && $future_target[1] !=null))
                <tr>
                    <td>
                    @if(isset($future_target[1]) && !empty($future_target[1] && $future_target[1] !=null))
                        2                    
                    @endif
                    </td>
                    <td>
                    @if(isset($future_target[1]) && !empty($future_target[1] && $future_target[1] !=null))
                    {{$future_target[1]}}
                    @endif
                    </td>
                    <td>
                        @if(isset($future_target_date[1]) && !empty($future_target_date[1] && $future_target_date[1] !=null))
                        {{$future_target_date[1]}}
                        @endif
                    </td>
                    <td>
                        @if(isset($future_recommended[1]) && !empty($future_recommended[1] && $future_recommended[1] !=null))
                        {{$future_recommended[1]}}
                        @endif
                    </td>
                </tr>
                @endif
                @if(isset($future_target[2]) && !empty($future_target[2] && $future_target[2] !=null))
                <tr>
                    <td>
                    @if(isset($future_target[2]) && !empty($future_target[2] && $future_target[2] !=null))
                        3                    
                    @endif
                    </td>
                    <td>
                        @if(isset($future_target[2]) && !empty($future_target[2] && $future_target[2] !=null))
                            {{$future_target[2]}}
                        @endif
                    </td>
                    <td>
                        @if(isset($future_target_date[2]) && !empty($future_target_date[2] && $future_target_date[2] !=null))
                        {{$future_target_date[2]}}
                        @endif
                    </td>
                    <td>
                        @if(isset($future_recommended[2]) && !empty($future_recommended[2] && $future_recommended[2] !=null))
                        {{$future_recommended[2]}}
                        @endif
                    </td>
                </tr>
                @endif
                <tr>
                    <td colspan="4">
                        <h6>SECTION E -Training Needs</h6> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>No</p> 
                    </td>
                    <td>
                        <p>Training Title</p> 
                    </td>
                    <td>
                        <p>Due By</p> 
                    </td>
                    <td>
                        <p>Recommended by</p> 
                    </td>
                </tr>
                @php
                    $training_titles         = json_decode($appraisal->training_title);
                    $training_date          = json_decode($appraisal->training_due_date);
                    $training_recomended    = json_decode($appraisal->training_recommended);
                @endphp
                @if(isset($training_titles[0]) && !empty($training_titles[0] && $training_titles[0] !=null))
                <tr>
                    <td>
                       1
                    </td>
                    <td>
                        @if(isset($training_titles[0]) && !empty($training_titles[0] && $training_titles[0] !=null))
                            {{$training_titles[0]}}
                        @endif
                    </td>
                    <td>
                        @if(isset($training_date[0]) && !empty($training_date[0] && $training_date[0] !=null))
                            {{$training_date[0]}}
                        @endif
                    </td>
                    <td>
                        @if(isset($training_recomended[0]) && !empty($training_recomended[0] && $training_recomended[0] !=null))
                            {{$training_recomended[0]}}
                        @endif
                    </td>
                </tr>
                @endif
                
                @if(isset($training_titles[1]) && !empty($training_titles[1] && $training_titles[1] !=null))
                <tr>
                    <td>
                       2
                    </td>
                    <td>
                        @if(isset($training_titles[1]) && !empty($training_titles[1] && $training_titles[1] !=null))
                            {{$training_titles[1]}}
                        @endif
                    </td>
                    <td>
                        @if(isset($training_date[1]) && !empty($training_date[1] && $training_date[1] !=null))
                            {{$training_date[1]}}
                        @endif
                    </td>
                    <td>
                        @if(isset($training_recomended[1]) && !empty($training_recomended[1] && $training_recomended[1] !=null))
                            {{$training_recomended[1]}}
                        @endif
                    </td>
                </tr>
                @endif
                @if(isset($training_titles[2]) && !empty($training_titles[2] && $training_titles[2] !=null))
                <tr>
                    <td>
                       3
                    </td>
                    <td>
                        @if(isset($training_titles[2]) && !empty($training_titles[2] && $training_titles[2] !=null))
                            {{$training_titles[2]}}
                        @endif
                    </td>
                    <td>
                        @if(isset($training_date[2]) && !empty($training_date[2] && $training_date[2] !=null))
                            {{$training_date[2]}}
                        @endif
                    </td>
                    <td>
                        @if(isset($training_recomended[2]) && !empty($training_recomended[2] && $training_recomended[2] !=null))
                            {{$training_recomended[2]}}
                        @endif
                    </td>
                </tr>
                @endif
                <tr>
                    <td colspan="4">
                        <h6>SECTION F - COMMENTS AND SIGN OFF</h6> 
                    </td>
                </tr>
                @php
                    $employee_comments         = $appraisal->employee_comments;
                    $hod_comments              = $appraisal->hod_comments;
                    $principal_comments        = $appraisal->principal_comments;
                @endphp
                        
                <tr>
                    <td colspan="4">
                        <p>EMPLOYEE COMMENTS</p> 
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        {{$employee_comments ?? ''}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <p> HEAD OF DEPARTMENT COMMENTS</p> 
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        {{$hod_comments ?? ''}}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <p>PRINCIPAL'S  COMMENTS</p> 
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        {{$principal_comments ?? ''}}
                    </td>
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
