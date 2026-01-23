
<!DOCTYPE html>
<html>
<head>
    <title>Timesheet </title>
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
    <h1>Timesheet Report</h1>

    <table>
    <thead>
        <tr>
            <th>Name</th>
            @foreach ($dates as $date)
                <th>{{ $date }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($attendanceData as $record)
            <tr>
                <td>{{ $record['name'] }}</td>
                @foreach ($dates as $date)
                    <td>
                        @if (isset($record['attendance'][$date]))
                            @if ($record['attendance'][$date]['checkin'] === 'H' && $record['attendance'][$date]['leave'] === 'L')
                                HD
                            @elseif ($record['attendance'][$date]['checkin'] === 'H')
                                H
                            @elseif ($record['attendance'][$date]['leave'] === 'L')
                                L
                            @endif
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
    </table>
</body>
</html>