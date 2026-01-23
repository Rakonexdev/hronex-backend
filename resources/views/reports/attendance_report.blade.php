@extends('home.partial.layout')
@section('content')

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<style>
    table,th,td{
        border: 1px solid #D8D8D8;
    }
</style>
    @php
        use App\Models\Leave\LeaveApplication;
        use Carbon\Carbon;    
    @endphp
<main id="main" class="main">
        <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Employees Monthly Attendance Report</h1>
                        <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Monthly Attendance Report</li>
                        </ol>
                        </nav>
                        
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="d-flex justify-content-end">                    
                <a id="dlink"  style="display:none;"></a>
                    <button type="button" class="btn btn-danger" onclick="return report.tableToExcel('table_result', 'EXCELREPORT', 'Attendance Report.xls');">
                        Download Excel
                    </button>
                </div>
            </div>

            <form action="{{route('attendance-report.post')}}" method="post">
            @csrf 
            <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                        <label>Month</label>
                            <select name="month" id="month" class="form-control">
                                @php
                                $months = [];
                                for ($i = 1; $i <= 12; $i++) {
                                    $month = Carbon::create(null, $i, 1, 0, 0, 0);
                                    $months[$month->format('m')] = $month->format('F');
                                }
                                @endphp

                                @foreach ($months as $value => $label)
                                    <option value="{{$value}}" @if($value==$currentMonth) selected @endif >{{$label}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2" style="padding-top: 2rem;">                    
                        <button type="submit" class="btn btn-block btn-alpha">Search</button>                    
                    </div>

                </div>
            </form>
        </div>

    <div class="row">
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="table-responsive" style="max-height: 600px; overflow-y: scroll;">
                <table class="table table-striped custom-table" style="display: inline-table; padding: 5px;" id="table_result">
                    <thead style="position: sticky;top:0;z-index:1;">
                    <tr style="background-color: #D8D8D8;">
                        <th colspan="{{(Carbon::now()->daysInMonth*2)+2}}">
                            <h4 style="text-align:center;">Employees Monthly Attendance Report [{{Carbon::create()->month($currentMonth)->format('F')}}]</h4>
                        </th>
                    </tr>
                    <tr style="background-color: #D8D8D8;">
                        <th colspan="2" style="position:sticky;left:1%;"></th>
                                                
                        @for ($day = 1; $day <= Carbon::now()->daysInMonth; $day++)
                            <th colspan="2" style="text-align: center; font-size:10px;" >{{ Carbon::create(null, $currentMonth, $day)->format('j-M-y') }}</th>
                        @endfor
                        
                    </tr>
                    <tr>
                        <th style="background-color: #92D050;position:sticky;left:0;">Id #</th>
                        <th style="background-color: #92D050;position:sticky;left:1%;">Name</th>
                        @for ($day = 1; $day <= Carbon::now()->daysInMonth; $day++)
                            @if (in_array(Carbon::create(null, $currentMonth, $day)->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY]))
                                <th colspan="2" style="background-color: #D8D8D8; font-size:9px;"> Weekend</th>
                            @else
                            <th style="font-size:9px;"> Check-In </th>
                            <th style="font-size:9px;">Check-Out</th>
                            @endif
                        @endfor
                    </tr>
                    </thead>
                 
                    <tbody>
                       @foreach($employees as $emp)
                       <tr>
                        <td style="background-color: #92D050;position:sticky;left:0;">{{$emp->employee_no}}</td>
                        <td style="background-color: #92D050;position:sticky;left:1%;">{{$emp->name}} &nbsp; {{$emp->lname}}</td>
                        
                       
                        @for ($day = 1; $day <= Carbon::now()->daysInMonth; $day++)
                        
                            @php
                            $check = null;
                            if($emp->attendance_data->isNotEmpty()){
                                foreach($emp->attendance_data as $att){
                                    if('check-in' == $att->status){
                                        if($day==Carbon::parse($att->check_in)->day)
                                            $check['in'][] = Carbon::parse($att->check_in);
                                    }else{
                                        if($day==Carbon::parse($att->check_out)->day)
                                            $check['out'][] = Carbon::parse($att->check_out);
                                    }
                                }
                            }                            
                            
                            $leaveRecords = LeaveApplication::where('employee_id', $emp->id)
                                ->whereMonth('date_from', $currentMonth)
                                ->whereDay('date_from', '<=', $day)
                                ->whereMonth('date_to', $currentMonth)
                                ->whereDay('date_to', '>=', $day)
                                ->where('status', $leave_approval_status['approved'])
                                ->get();

                            $leave = $leaveRecords->isNotEmpty() ? $leaveRecords->first() : null;
                            $empno = $emp->employee_id;
                            $date = Carbon::create(null, $currentMonth, $day)->format('Y-m-d');
                            $time = get_check_shift_time($empno,$date);
                            $timeDifference = 0;
                            @endphp

                            @if (in_array(Carbon::create(null, $currentMonth, $day)->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY]))
                                <td colspan="2" style="background-color: #D8D8D8;"></td>
                            @else
                            <td style="font-size:11px; @if ($leave != null)
                                @if($leave->leave_type == 6)
                                    background-color: #FF99FF;
                                @else
                                    background-color: #8EAADB;
                                @endif
                            @endif
                            @if (null!=$check && isset($check['in']) && $time)
                                @php
                                    $checkInTime = Carbon::parse($check['in'][0]); //Carbon::parse($attendance->check_in);
                                    $shiftTime = Carbon::parse($time);
                                    if ($checkInTime->gt($shiftTime)) {
                                        $timeDifference = $checkInTime->diffInMinutes($shiftTime);
                                    } else {
                                        $timeDifference = 0; 
                                    }
                                    
                                @endphp
                                @if ($timeDifference >= 1 && $timeDifference <= 5)
                                    background-color: #FFD965;
                                @elseif ($timeDifference > 5)
                                    background-color: red;
                                @else

                                @endif
                            @endif"
                            >   
                                @if ($leave != null)
                                    @if($leave->leave_type==6)
                                        @if(null!=$check && isset($check['in']))
                                            @foreach($check['in'] as $checkin)
                                                {{ $checkin->format('H:i') }}<br>
                                            @endforeach
                                        @endif
                                    @else
                                        A
                                    @endif
                                @elseif(null!=$check && isset($check['in']))
                                    @foreach($check['in'] as $checkin)
                                        {{ $checkin->format('H:i') }}<br>
                                    @endforeach
                                @else - @endif
                            </td>

                            <td style="font-size:11px; @if ($leave != null)
                                    @if($leave->leave_type == 6)
                                        background-color: #FF99FF;
                                    @else
                                        background-color: #8EAADB;
                                    @endif
                                @endif"> 
                                @if ($leave != null)
                                    @if($leave->leave_type==6)
                                        @if(null!=$check && isset($check['out']))
                                            @foreach($check['out'] as $checkout)
                                                {{ $checkout->format('H:i') }}<br>
                                            @endforeach
                                        @endif
                                    @else
                                        A
                                    @endif
                                @elseif(null!=$check && isset($check['out']))
                                    @foreach($check['out'] as $checkout)
                                        {{ $checkout->format('H:i') }}<br>
                                    @endforeach
                                @else - @endif
                            </td>
                            @endif
                        @endfor
                       </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
   

</main>
@endsection

<script src="{{ asset('js/export.js') }}"></script>

<script>

    /* function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('table_result');        
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });  
        return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
            XLSX.writeFile(wb, fn || ('Employees_Monthly_Attendance.' + (type || 'xlsx')));
    } */

</script>