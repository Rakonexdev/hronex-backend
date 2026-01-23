@extends('home.partial.layout')
@php
use Carbon\Carbon;

    // Get the start date of the current month
    $startDate = Carbon::now()->startOfMonth();
    //$start_Date = Carbon::now()->startOfMonth()->subMonth()->setDay(26);

    // Get the end date of the current month
    $endDate = Carbon::now()->endOfMonth();
    //$end_Date = Carbon::now()->endOfMonth()->setDay(25);
    $currentDate = Carbon::now();
   // $currentDate = Carbon::parse('2023-10-24');
    if ($currentDate->day >= 26) {
        $startDate = $currentDate;
        //$endDate = $startDate->addMonth()->startOfMonth();
        $end_Date = $currentDate->addMonthsNoOverflow(1)->startOfMonth()->setDay(25);
        //$startDate = $startDate->copy()->setDay(25);
        $start_Date = $currentDate->copy()->subMonthNoOverflow()->setDay(26);
    } else {
        $start_Date = $currentDate->copy()->subMonthNoOverflow()->setDay(26);
        $end_Date = $currentDate->copy()->setDay(25);
    }


    $endday = \Carbon\Carbon::parse($endDate);
    $day = $endday->day;
    $dayInt = (int)$day;

    // Get the start and end dates of the previous month
    //$prevStartDate = $startDate->copy()->subMonth()->startOfMonth();
    //$prevEndDate = $prevStartDate->copy()->endOfMonth();
    $prevStartDate = Carbon::parse($startDate)->subMonth()->startOfMonth();
    $prevEndDate = $prevStartDate->copy()->endOfMonth();

    // Get the start and end dates of the next month
    $nextStartDate = $endDate->copy()->addDay()->startOfMonth();
    $nextEndDate = $nextStartDate->copy()->endOfMonth();

    $numDays = $endDate->daysInMonth;

@endphp
@section('page_css')
<style>
   
 
    .time{
        width: auto; /*950px;*/
        height: 500px;
        overflow: auto;
        }
        .table-container {
    overflow-x: auto;
}

.freeze-table {
    border-collapse: collapse;
    width: 100%;
}

.freeze-th {
    position: sticky;
    left: 0;
    background-color: #FFF600; /* Set the background color as needed */
}

.freeze-td {
    position: sticky;
    left: 0;
    z-index: 1;
    background-color: #43629F; /* Set the background color as needed */
}

</style>
@endsection
@section('content')


<main id="main" class="main">

<div class="pagetitle">
  <div class="row align-items-center">

    <div class="col">
      <div class="pagetitle">
        <h1>Academic Attendance</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Academic Attendance</li>
          </ol>
        </nav>
      </div>
    </div>

  </div>
</div>

<!-- Search Filter -->
@if(Auth::user()->hasRole(HR_ROLE))
    <div class="row">
        <div class="col-md-10"></div>
        <div class="col-md-2" style="padding-top: 7px;">  
            <a href="#" class="btn btn-block btn-alpha" data-toggle="modal" data-target="#add-attendance">Add</a>  
        </div>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 97.5%;">
        <ul>
            <li style="margin-left: 15px; width: 97.5%;">{{ Session::get('error') }}</li>
        </ul>
    </div>
@endif
@if (Session::has('success'))
    <div class="alert alert-success al-sign" style="margin-left: 15px; width: 97.5%;">
        <ul>
            <li>{{ Session::get('success') }}</li>
        </ul>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 97.5%;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- /Search Filter -->
<div class="row">
    <div class="col-md-6 weekly-dates-div pt-1">
        <a href="#" class="previous action-item "><i class="bi bi-caret-left-fill"></i></a>
        <span id="weekly-dates">{{$start_Date->format('M d')}} - {{$end_Date->format('M d, Y')}}</span>
        <input type="hidden" id="weeknumber" value="{{$start_Date->format('Y-m-d')}}">
        <input type="hidden" id="selected_dates" value="{{$start_Date->format('Y-m-d')}} - {{$end_Date->format('Y-m-d')}}">
        <a href="#" class="action-item next"><i class="bi bi-caret-right-fill"></i></a>
    </div>
</div>
<div class="row">
<div class="col-lg-12">
    <div class="table-responsive time">
        <table class="table table-striped table-bordered custom-table table-nowrap mb-0">
            <thead style="position:sticky;top: 0;">
               
            </thead>
            <tbody id="attendance-table-body">
             
                @php
                    $start_date = Carbon::now()->subMonth()->startOfMonth()->setDay(26);
                   // $end_date = Carbon::now();
                   $end_date = $end_Date
                @endphp
                
                @foreach($acadmic_employees as $acadmic_employee)
                    <tr>
                        <td class="freeze-td" style="background-color:#C2E0AB;">
                            <h2 class="table-avatar">
                                <a href="{{ route('employees.show', $acadmic_employee->user_id) }}">{{ $acadmic_employee->name }}&nbsp;{{ $acadmic_employee->lname }}</a>
                            </h2>
                        </td>

                        @php
                            $loop_date = clone $start_date;
                        @endphp
                        @while($loop_date <= $end_date)
                            @php
                                $checkin = null;
                                $leaveApplication = null;

                                // Filter attendance for the current employee and date
                                if ($acadmic_employee->attendance()) {
                                    $checkin = $acadmic_employee->attendance()
                                        ->whereDate('check_in', $loop_date->format('Y-m-d'))
                                        ->first();
                                }

                                // Filter leave application for the current employee and date
                                if ($acadmic_employee->leaveApplication) {
                                    $leaveApplication = $acadmic_employee->leaveApplication
                                        ->where(function ($query) use ($loop_date) {
                                            $query->where('date_from', '<=', $loop_date->format('Y-m-d'))
                                                ->where('date_to', '>=', $loop_date->format('Y-m-d'));
                                        })->where('employee_id',$acadmic_employee->id)
                                        ->where('status',6)
                                        ->first();
                                }
                            @endphp

                            <td @if(date('N', strtotime($loop_date->format('Y-m-d'))) == 5 || date('N', strtotime($loop_date->format('Y-m-d'))) == 6) style="background-color: grey;" @endif style="z-index:-9999;">
                                @if($checkin && $leaveApplication)
                                    <div class="half-day" style="display: grid;">
                                        <span class="first-off">
                                            <a href="javascript:void(0);" class="attendance-link" onclick="attendance(event,'{{ $loop_date->format('Y-m-d') }}', {{ $acadmic_employee->id }})" data-toggle="modal" data-target="#attendance_info" data-id="{{ $loop_date->format('Y-m-d') }}">
                                                <i class="fa fa-check text-success"></i>
                                            </a>
                                        </span> 
                                        <span class="first-off">
                                        <a href="javascript:void(0);" class="leave-link" onclick="leave(event,'{{ $loop_date->format('Y-m-d') }}', {{ $acadmic_employee->id }})" data-toggle="modal" data-target="#leave_info" data-id="{{ $loop_date->format('Y-m-d') }}">
                                            <i class="fa fa-close text-danger"></i></a>
                                        </span>
                                    </div>
                                @elseif($checkin)
                                    <a href="javascript:void(0);" class="attendance-link" onclick="attendance(event,'{{ $loop_date->format('Y-m-d') }}', {{ $acadmic_employee->id }})" data-toggle="modal" data-target="#attendance_info" data-id="{{ $loop_date->format('Y-m-d') }}">
                                        <i class="fa fa-check text-success"></i>
                                    </a>
                                @elseif($leaveApplication)
                                    <a href="javascript:void(0);" class="attendance-link" onclick="leave(event,'{{ $loop_date->format('Y-m-d') }}', {{ $acadmic_employee->id }})" data-toggle="modal" data-target="#leave_info" data-id="{{ $loop_date->format('Y-m-d') }}">
                                        <i class="fa fa-close text-danger"></i>
                                    </a>
                                @else
                                    <!-- Empty cell -->    
                                @endif
                            </td>
                            @php
                                $loop_date->addDay();
                            @endphp
                        @endwhile
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Attendance Modal -->

<div class="modal custom-modal fade" id="attendance_info" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attendance Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card punch-status">
                            <div class="card-body">
                                <h5 class="card-title">Timesheet <small class="text-muted"><!--11 Mar 2019--></small></h5>
                                <div class="punch-det">
                                    <h6>Punch In at</h6>
                                    <p>Nil</p>
                                </div>
                                <div class="punch-info">
                                    <div class="punch-hours">
                                        <span>0 hrs</span>
                                    </div>
                                </div>
                                <div class="punch-det">
                                    <h6>Punch Out at</h6>
                                    <p>Nil</p>
                                </div>
                                <div class="statistics">
                                    <div class="row">
                                        <div class="col-md-6 col-6 text-center">
                                            <div class="stats-box" id ="break">
                                                <p>Break</p>
                                                <h6 style="margin-bottom: 0px;" >0 hrs</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 text-center">
                                            <div class="stats-box">
                                                <p>Overtime</p>
                                                <h6 style="margin-bottom: 0px;">0 hrs</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card recent-activity">
                            <div class="card-body">
                                <h5 class="card-title">Activity</h5>
                                <ul class="res-activity-list">
                                    <li>
                                        <p class="mb-0">Punch In at</p>
                                        <p class="res-activity-time">
                                            <i class="fa fa-clock-o"></i>
                                            Nil
                                        </p>
                                    </li>
                                    <li>
                                        <p class="mb-0">Punch Out at</p>
                                        <p class="res-activity-time">
                                            <i class="fa fa-clock-o"></i>
                                            Nil
                                        </p>
                                    </li>                                
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /Attendance Modal -->
<!-- Leave Modal -->

<div class="modal custom-modal fade" id="leave_info" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Leave Info<span id="leaveDate"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card punch-status">
                            <div class="card-body">
                                <h5>Leave Type: <small class="text-muted" id="leaveType"><!--11 Mar 2019--></small></h5>
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card recent-activity">
                            <div class="card-body">
                                <h5 >Reason:<small class="text-muted" id="reason"><!--11 Mar 2019--></small></h5>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /Leav Modal -->

<!-- Add attendance by HR : modal -->
<div class="modal custom-modal fade" id="add-attendance" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_attendance_form" action="{{route('add_attendance')}}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="employee_id">Employee</label>
                        <select class="form-control" name="employee_id" id="employee_id">
                            @foreach($acadmic_employees as $eachemployee)
                                <option value="{{$eachemployee->employee_id}}">{{$eachemployee->employee_no.'. '.$eachemployee->name.' '.$eachemployee->lname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status"> 
                            <option value="check-in">check-in</option>
                            <option value="check-out">check-out</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="existing_id" value="">
                        <label for="start_date">Date</label>
                        <input type="date" name="check_date" class="form-control" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="form-group">
                        <label for="end_date">Time</label>
                        <input type="time" name="check_time" class="form-control" value="07:00">
                    </div>                    
                    <div class="form-group">
                        <label for="comment">Comment </label>
                        <textarea class="form-control" name="comment" placeholder="comment" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="float-end">
                    <button type="submit" class="btn btn-primary" form="add_attendance_form">submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- Add attendance by HR : modal -->

</main><!-- End #main -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


    // Get the initial start and end dates
    //let startDate = moment("{{$startDate->format('Y-m-d')}}");
    let startDate = moment("{{$start_Date->format('Y-m-d')}}");
    let endDate = moment("{{$end_Date->format('Y-m-d')}}");
    // alert(startDate);
    let prestartDate = moment("{{$prevStartDate }}");
    let preendDate = moment("{{$prevEndDate}}");

    // Update the dates when the previous or next icons are clicked
    $(".previous").click(function(e) {
        e.preventDefault();
        document.querySelector('#loader').classList.remove('hidden');
        startDate.subtract(1, 'months').date(26);
        // alert(startDate);
        endDate = startDate.clone().add(1, 'months').date(25);
    
        updateDates();
    
        $('thead').empty();
        let numDays = endDate.diff(startDate, 'days') + 1;

        // Create a new table row with the dates of the month
        let row = $('<tr></tr>');
        row.append($('<th style="position: sticky;top:0;left:0;background-color:#C2E0AB;z-index:22;"></th>').text('Employees'));

        let currentDate = startDate.clone().date(26);
        //let currentDate = startDate.clone();

        if (currentDate.date() <= 25) {
            currentDate.date(26);
        }
        //alert(currentDate);
        for (let i = 1; i <= numDays; i++) {
        
            const cell = $('<th style="position: sticky;top:0;left:0;background-color:#F6F9FF;"></th>').text(currentDate.format('D'));

            if (currentDate.day() === 5) { 
                cell.css('background-color', 'grey');
                fridayCount++;
            /* if (fridayCount === 5) { 
                    cell.css('background-color', 'grey');
                }*/
            
        }
        if (currentDate.day() === 6) { 
                cell.css('background-color', 'grey');
                fridayCount++;
            }
        row.append(cell);
        currentDate.add(1, 'day');
    }

        // Add the table days 
        $('thead').append(row);
        setTimeout(function() { document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden'); }, 1500);

    });

    $(".next").click(function(e) {
        e.preventDefault();
        document.querySelector('#loader').classList.remove('hidden');
        endDate.add(1, 'months').date(25);
        // alert(endDate);
        startDate = endDate.clone().subtract(1, 'months').date(26);
        updateDates();

        $('thead').empty();
        let numDays = endDate.diff(startDate, 'days') + 1;

        // Create a new table row with the dates of the month
        let row = $('<tr></tr>');
        row.append($('<th style="position: sticky;top:0;left:0;background-color:#C2E0AB;z-index:22;"></th>').text('Employees'));

        let currentDate = startDate.clone().date(26);

        if (currentDate.date() <= 25) {
            currentDate.date(26);
        }

        for (let i = 1; i <= numDays; i++) {
            
            const cell = $('<th style="position: sticky;top:0;background-color:#F6F9FF;"></th>').text(currentDate.format('D'));

            if (currentDate.day() === 5) { 
                cell.css('background-color', 'grey');
                fridayCount++;
            }
            if (currentDate.day() === 6) { 
                cell.css('background-color', 'grey');
                fridayCount++;
            }
            row.append(cell);
            currentDate.add(1, 'day');
        }


        $('thead').append(row);
        setTimeout(function() { document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden'); }, 1500);

    });

    function updateDates() {
        $("#weekly-dates").text(startDate.format("MMM DD") + " - " + endDate.format("MMM DD, YYYY"));
        $("#selected_dates").val(startDate.format("YYYY-MM-DD") + " - " + endDate.format("YYYY-MM-DD"));  
        
                
    }

    //current month
    // const lastMonthStartDate = startDate.clone().subtract(1, 'month');
    const lastMonthStartDate = startDate.clone();
    const lastMonthDays = lastMonthStartDate.daysInMonth();
    //let numDays = endDate.diff(startDate, 'days') + 1;

    let row = $('<tr></tr>');
    const emp = $('<th style="position:sticky;left:0;top:0;background-color:#C2E0AB;z-index: 22; "></th>').text('Employees');
    row.append(emp);
    //let currentDate = startDate.clone().subtract(1, 'month').date(26);
    let currentDate = startDate.clone().date(26);
    let fridayCount = 0; // Variable to count Fridays
    let saturdayCount = 0;
    for (let i = 1; i <= lastMonthDays; i++) {
        const cell = $('<th style="position: sticky;top:0;background-color:#F6F9FF;"></th>').text(currentDate.format('D'));

        if (currentDate.day() === 5) { 
            cell.css('background-color', 'grey');
            fridayCount++;
        
        }
        if (currentDate.day() === 6) { 
            cell.css('background-color', 'grey');
            saturdayCount++;
        
        }

        row.append(cell);
        currentDate.add(1, 'day');
    }



    // Add the table days 
    $('thead').append(row);

    //modal data 

    function attendance(event, check_in, employee_id) {
        event.preventDefault();
        $('.modal').modal('hide');
        var modal = $(event.target);
        //alert(check_in);
        if (check_in) {
            $.ajax({
                url: 'attendance/getcheckin/'+check_in +'/'+employee_id,
                type: 'GET',
                dataType: 'json',
                success: function(responseData) {
                    //alert(responseData);
                    if (responseData.data.length > 0) {
                        let punch_list = '';
                        let date = moment(responseData.data[0].check_in.split(' ')[0]).format('DD MMM YYYY');
                        let dateTime = responseData.data[0].check_in;
                        let dateTime_checkout = responseData.lastCheckoutTime;
                        
                        //format data
                        const date_Time = new Date(dateTime);
                        const date_day_time = date_Time.toLocaleDateString('en-US', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric', hour: 'numeric', minute: 'numeric' });
                        const date_out_Time = new Date(dateTime_checkout);
                        const date_day_cheeckout_time = date_out_Time.toLocaleDateString('en-US', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric', hour: 'numeric', minute: 'numeric' });

                        //display data
                        $.each(responseData.data, function (index, attendance) {
                            let check_in_time = '';
                            let check_out_time = '';

                        
                        if (attendance.status === 'check-in' && attendance.check_in != null) {
                                const check_in_parts = attendance.check_in.split(' ');
                                if (check_in_parts.length > 1) {
                                    const check_in_time_parts = check_in_parts[1].split(':');
                                    let hour = parseInt(check_in_time_parts[0]);
                                    let suffix = hour >= 12 ? 'pm' : 'am';
                                    hour = hour % 12;
                                    hour = hour ? hour : 12; // handle midnight
                                    check_in_time = hour + ':' + check_in_time_parts[1] + ':' + check_in_time_parts[2] + ' ' + suffix;
                                }
                            } else if (attendance.status === 'check-out' && attendance.check_out != null) {
                                const check_out_parts = attendance.check_out.split(' ');
                                if (check_out_parts.length > 1) {
                                    const check_out_time_parts = check_out_parts[1].split(':');
                                    let hour = parseInt(check_out_time_parts[0]);
                                    let suffix = hour >= 12 ? 'pm' : 'am';
                                    hour = hour % 12;
                                    hour = hour ? hour : 12; // handle midnight
                                    check_out_time = hour + ':' + check_out_time_parts[1] + ':' + check_out_time_parts[2] + ' ' + suffix;
                                }
                            }

                            punch_list += '<li>';
                            punch_list += '<p class="mb-0">' + attendance.status + ' at</p>';
                            punch_list += '<p class="res-activity-time">';
                            punch_list += '<i class="fa fa-clock-o"></i> ' + (attendance.status === 'check-in' ? check_in_time : check_out_time);
                            punch_list += '</p>';
                            punch_list += '</li>';
                        });
                        
                        $('.modal-body .recent-activity .res-activity-list').html(punch_list);
                        $('.modal-body .punch-status .card-title').html('Timesheet <small class="text-muted">' + date + '</small>');
                        $('.modal-body .card-body .punch-det:eq(0)').html(date_day_time);
                        $('.modal-body .card-body .punch-det:eq(1)').html(date_day_cheeckout_time);
                        // Append the date to the "Punch In at" section
                    

                        // Calculate the total hours worked
                        let total_hours = 0;
                    
                        //let totalWorkingHours = responseData.working_hours.reduce((acc, cur) => acc + cur.working_hours, 0);
                        let total_Working_Hours = responseData.working_hours;
                        let totalBreakTime = responseData.totalBreakTime;
                        let otHours = responseData.otHours;
                        //console.log(responseData.working_hours.working_hours);
                                                
                        $('.modal-body .card-body .punch-hours').html(total_Working_Hours.toFixed(2) + ' hrs');
                        $('.modal-body .statistics .stats-box:last-child h6').html(otHours.toFixed(2)+'hrs');
                        $('.modal-body .statistics #break h6').html(totalBreakTime.toFixed(2)+'hrs');                  
                        // Show the modal
                        $('#punch-modal').modal('show');
                    }else {
                        console.log('No data available');
                    }
                    
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
    };

    function leave(event,leave_date,employee_id) {
        event.preventDefault();
        $('.modal').modal('hide');
        var modal = $(event.target);
        const url = 'attendance/getleave/'+leave_date +'/'+employee_id;
        // alert(leave_date);
        if (leave_date) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(responseData) {
                    // alert(responseData.reason);
                    // $('#leaveDate').text(leave_date);
                    $('#leaveType').text(responseData.leavetypes.name);
                    $('#reason').text(responseData.reason);
                   
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
    };
    
    // month wise filter 
    function updateDates() {
        var startDateFormatted = startDate.format('YYYY-MM-DD');
        var endDateFormat = endDate.format("YYYY-MM-DD");
        $("#weekly-dates").text(startDate.format("MMM DD") + " - " + endDate.format("MMM DD, YYYY"));
        $("#selected_dates").val(startDate.format("YYYY-MM-DD") + " - " + endDate.format("YYYY-MM-DD"));
        $('thead').empty();
        // Get the number of days in the selected month
        let numDays = endDate.daysInMonth();
        // Create a new table row with the dates of the month
        let row = $('<tr></tr>');
        row.append($('<th></th>').text('Employees'));
        for (let i = 1; i <= numDays; i++) {
            row.append($('<th></th>').text(i));
        }
        $('thead').append(row);
       
        $.ajax({
            url: 'attendance/getdata/'+startDateFormatted,
            type: 'GET',
        
            data:{
                endDate:endDateFormat,
                startDate:startDateFormatted
            },
            success: function(response) {
                $("#attendance-table-body").html(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

</script>


@endsection