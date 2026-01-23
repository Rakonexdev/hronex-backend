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
                    <td colspan="2">
                        <h4>{{$thiscompany}}</h4> 
                        <p><strong>{{$thiscomparea}}</strong></p>
                    </td>
                </tr>
                <tr class="main-table">
                    <td colspan="2">
                    <h6>Staff Concern Form</h6>
                    </td>
                </tr>
                <tr>
                    <td>Date of concern:</td>
                    <td>{{$scf->date_of_concern}}</td>
                </tr>
                <tr>
                    <td>Concern form number</td>
                    <td>{{$scf->id}}</td>
                </tr>
                <tr>
                    <td>Employee #</td>
                    <td>{{$employee->employee_no}}</td>
                </tr>
                <tr>
                    <td>Name of staff member:</td>
                    <td>{{$scf->staff_member}}</td>
                </tr>
                @php
                    $scf_ans = json_decode($scf->scf_ans_data);
                @endphp
                @foreach($scf_datas as $index => $concern)
                    @php
                        $ans = $scf_ans[$index];
                    @endphp
                <tr>
                    <td>{{$concern->scf}}</td>
                    <td>{{$ans}}</td>
                </tr>
                @endforeach
                <!-- <tr>
                    <td>Who else is aware of the situation?</td>
                    <td></td>
                </tr>
                <tr>
                    <td>When and where was this observed?</td>
                    <td></td>
                </tr> -->
                <tr>
                    <td colspan="2"><strong>Brief description of the concern and how it was addressed:</strong></td>
                </tr>
                <tr>
                    <td colspan="2">{{$scf->breif_description}}</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Suggestions made:</strong></td>
                </tr>
                <tr>
                    <td colspan="2">{{$scf->suggestions_made}}</td>
                </tr>
                <!-- <tr>
                    <td colspan="2"><strong>What was the response of the staff member?</strong> </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Has the staff member acted upon what was decided?</strong> </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr> -->
                <tr>
                    <td colspan="2"><strong>Update/follow-up:</strong> </td>
                </tr>
                <tr>
                    <td colspan="2">{{$scf->follow_up}}</td>
                </tr>
                <tr>
                    <td><strong>Name of the staff member raising the concern:</strong> </td>
                    <td>{{$scf->raising_concern}}</td>
                </tr>
                <tr>
                    <td>SLT member:</td>
                    <td>{{$staff_member->name}}</td>
                </tr>
                <tr>
                    <td>Signed:</td>
                    <td> {{$staff_member->slt_member_ack == 1 ? "Yes" : "No"}} </td>
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
