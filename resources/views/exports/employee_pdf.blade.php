
<!DOCTYPE html>
<html>
<head>
    <title>Employee Details </title>
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
        table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    @media print {
        thead {
            display: table-header-group;
        }
    }

    </style>
</head>
<body>
    <h1>Employee Details</h1>

    <table>
        <thead>
            <tr>
                <th>Emp Name</th>
                <th>Emp No.</th>
                <th>Contact.</th>
                <th>Email</th>
                <th>Department</th>
                <th>Designations</th>
                <th>Gender</th>
                <th>DOB</th>                
                <th>Nationality</th>
                <th>Marital Status</th>
                <th>Qid No</th>
                <th>Qid Expiry</th>
                <th>Passport No</th>
                <th>Passport Expiry</th>
                <th>Joining Date</th>
                <th>Contract Length</th>
                <th>Service Year</th>
                <th>Basic Salary</th>
                <th>Accomodation Allowance</th>
                <th>Transport Allowance</th>
                <th>Gross Total</th>
                <th>Bank Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $row)
                <tr>
                    <td>{{ $row->name }}{{$row->lname}}</td>
                    <td>{{$row->employee_no}}</td>
                    <td>{{$row->mobile1}}</td>
                    <td>{{$row->email}}</td>                    
                    <td> {{$row->department}}</td>
                    <td>{{$row->designation}}</td>
                    <td>{{$row->gender}}</td>
                    <td>{{$row->dob}}</td>
                    <td>{{$row->nationality}}</td>
                    <td>{{$row->marital_status}}</td>
                    <td>{{$row->qidno}}</td>
                    <td>{{$row->qidexpiry}}</td>
                    <td>{{$row->passportno}}</td>
                    <td>{{$row->passportexpiry}}</td>
                    <td>{{$row->joiningdate}}</td>
                    <td>{{$row->contract_length}}</td>
                    <td>{{$row->service_years}}</td>
                    <td>{{$row->basic_salary}}</td>
                    <td>{{$row->accomodation_allowance}}</td>
                    <td>{{$row->transport_allowance}}</td>
                    <td>{{$row->gross_total}}</td>
                    <td>{{$row->bank_name}}</td>

                    <!-- Add more columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>