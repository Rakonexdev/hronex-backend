
<!DOCTYPE html>
<html>
<head>
    <title>Payroll Details </title>
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
        table {
        width: 80%;
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
    <h1>Payroll Details</h1>

    <table>
        <thead>
            <tr>
            <th>Emp Name</th>
                <th>Joining Date</th>
                <th>Designations</th>
                <th>Basic</th>
                <th>Gross</th>
                <th>Others</th>
                <th>Total</th>
                <th>Gratuity</th>
                <!--<th>Additional</th>-->
                <th>Total</th>
                <th>Deduction</th>
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
            </tr>
        </thead>
        <tbody>
        @foreach($payroll_details as $payroll_detail)               
            <tr>
                <td>
                    {{$payroll_detail->employee_name}}
                </td>
                <td>
                    {{$payroll_detail->employee_joiningdate}}
                </td>
                <td>
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
                <!--<td>
                    {{$payroll_detail->addtional_amount}}
                </td>-->
                <td>
                    {{$payroll_detail->total_addtional_amount}}
                </td>
                <td>
                    {{$payroll_detail->deduction_amount}}
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
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>