@php
use Carbon\Carbon;

$endDate = $endDate;
$endday = \Carbon\Carbon::parse($endDate);
$day = $endday->day;
$dayInt = (int)$day;
$startDate = $startDate;
@endphp

@foreach($acadmic_employees as $acadmic_employee)
    <tr>
        <td style="position:sticky;left:0;top:0;background-color:#C2E0AB;z-index: 22; ">
            <h2 class="table-avatar">
                <!--<a href="Profile-FAS HRMS.html"><img src="assets/img/profile-img.jpg" class="avatar avatar-xs"></a>-->
                <a href="{{route('employees.show', $acadmic_employee->user_id)}}">{{$acadmic_employee->name}}&nbsp;{{$acadmic_employee->lname}}</a>
            </h2>
        </td>
        
        @php
            $startDateCarbon = Carbon::parse($startDate);
            $endDateCarbon = Carbon::parse($endDate);
        @endphp

        @for ($currentDate = $startDateCarbon->copy(); $currentDate->lte($endDateCarbon); $currentDate->addDay())
            @php
                $checkin = null;
                $leaveApplication = null;
                
                if ($acadmic_employee->attendance()) {
                    $checkin = $acadmic_employee->attendance()
                        ->whereDate('check_in', $currentDate->format('Y-m-d'))
                        ->first();
                }
                
                if ($acadmic_employee->leaveApplication) {
                    $leaveApplication = $acadmic_employee->leaveApplication
                        ->where('date_from', '<=', $currentDate->format('Y-m-d'))
                        ->where('date_to', '>=', $currentDate->format('Y-m-d'))
                        ->first();
                }
            @endphp
            
            <td @if($currentDate->isFriday()|| $currentDate->isSaturday()) style="background-color: #dce0e1;" @endif>
                @if ($checkin && $leaveApplication)
                    <div class="half-day" style="display: grid;">
                        <span class="first-off">
                            <a href="javascript:void(0);" class="attendance-link" onclick="attendance(event,'{{ $currentDate->format('Y-m-d') }}', {{$acadmic_employee->id}})" data-toggle="modal" data-target="#attendance_info" data-id="{{ $currentDate->format('Y-m-d') }}">
                                <i class="fa fa-check text-success"></i>
                            </a>
                        </span> 
                        <span class="first-off">
                        <a href="javascript:void(0);" class="attendance-link" onclick="leave(event,'{{ $currentDate->format('Y-m-d') }}', {{$acadmic_employee->id}})" data-toggle="modal" data-target="#leave_info" data-id="{{ $currentDate->format('Y-m-d') }}">
                            <i class="fa fa-close text-danger"></i></a>
                        </span>
                    </div>
                @elseif ($checkin)
                    <a href="javascript:void(0);" class="attendance-link" onclick="attendance(event,'{{ $currentDate->format('Y-m-d') }}', {{$acadmic_employee->id}})" data-toggle="modal" data-target="#attendance_info" data-id="{{ $currentDate->format('Y-m-d') }}">
                        <i class="fa fa-check text-success"></i>
                    </a>
                @elseif ($leaveApplication)
                <a href="javascript:void(0);" class="attendance-link" onclick="leave(event,'{{ $currentDate->format('Y-m-d') }}', {{$acadmic_employee->id}})" data-toggle="modal" data-target="#leave_info" data-id="{{ $currentDate->format('Y-m-d') }}">

                    <i class="fa fa-close text-danger"></i></a>
                @else
                    <!-- Empty cell -->    
                @endif
            </td>
        @endfor
    </tr>
@endforeach