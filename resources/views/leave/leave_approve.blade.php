@extends('home.partial.layout')

@section('content')

@php
    $user_role = Auth::user();
@endphp
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Leave Approval</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Leave Approval</li>
                            </ol>
                        </nav>
                    </div>
                </div>

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

            </div>
        </div>

        <!-- /Page Header -->

        <!-- Search Filter -->

        <form action="{{route('leave.search')}}" method="post">
        @csrf
        <div class="row">

            <div class="col-md-2">
                <div class="form-group">
                    <label for="employee_no" class="form-label">Emp ID</label>
                    <input type="number" class="form-control" name="employee_no" id="employee_no" style="color: #8D8D8D;"
                        placeholder="Emp ID [digits only]" value="{{$search_empno}}">
                </div>
            </div>

            <!--<div class="col-md-2">
                <div class="form-group">
                    <label for="inputName5" class="form-label">Emp Name</label>
                    <input type="text" class="form-control" id="inputName5" style="color: #8D8D8D;"
                        placeholder="Enter Emp Name">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="inputEmail5" class="form-label">Department</label>
                    <select id="inputEmail5" class="form-control" style="color: #8D8D8D;">
                        <option selected>Choose Department...</option>
                        <option>Administration</option>
                        <option>Academics</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="strtend_date" class="form-label">Start / End Date</label>
                    <input type="date" class="form-control" name="strtend_date" id="strtend_date" style="color: #8D8D8D;"
                        placeholder="Enter Date">
                </div>
            </div>-->

            <div class="col-md-2" style="padding-top: 33px;">
                <button type="submit" class="btn btn-block btn-alpha">Search</button>
            </div>
            <div class="col-md-7"></div>
            @if ($user_role->hasRole('Hr'))
            <div class="col-md-1" style="padding-top: 33px;">
                <button type="button" class="btn btn-block btn-primary fw-bold" data-toggle="modal" data-target="#add_leave">+</button>
            </div>
            @endif

        </div>
        </form>

        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="table-responsive">
                    <table class="table table-striped custom-table smt-tabl"
                        style="padding: 5px; overflow-y: scroll;"> <!-- datatable dataTable-selector    padding: 5px; height:402px; overflow-y: scroll; -->
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>ID</th>
                                <th>Department</th>
                                <th style="text-align: center;">Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center;">Mode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leave_applications as $leave_application)
                            @php
                                $badge = "bg-light";
                                $label = "";

                                if($leave_application->status == $leave_approval_status['applied']){
                                    $badge = "bg-secondary";
                                    $label = "Applied";
                                }else if(($leave_application->status == $leave_approval_status['verified'])&&
                                        ( in_array($leave_application->forward_from, $vp_role_ids) ) 
                                ){
                                    $badge = "bg-info";
                                    $label = "Assigned To HR";                                            
                                }else if(($leave_application->status == $leave_approval_status['hold'])&&
                                        ( in_array($leave_application->forward_from, $vp_role_ids) ) 
                                ){
                                    $badge = "bg-warning";
                                    $label = "Hold under Vp";                                            
                                }else if(($leave_application->status == $leave_approval_status['verified'])&&
                                        ( in_array($leave_application->forward_from, $exad_role_ids) ) 
                                ){
                                    $badge = "bg-info";
                                    $label = "Assigned To HR";                                            
                                }else if(($leave_application->status == $leave_approval_status['hold'])&&
                                        ( in_array($leave_application->forward_from, $exad_role_ids) ) 
                                ){
                                    $badge = "bg-warning";
                                    $label = "Hold under Exe.Admin";                                            
                                }else if(($leave_application->status == $leave_approval_status['verified'])&&
                                        (in_array($leave_application->forward_from, $hr_role_ids) )
                                ){
                                    $badge = "bg-primary";
                                    $label = "Assigned To Manager";                                            
                                }else if(($leave_application->status == $leave_approval_status['hold'])&&
                                        (in_array($leave_application->forward_from, $hr_role_ids) )
                                ){
                                    $badge = "bg-warning";
                                    $label = "Hold under HR";                                            
                                }else if($leave_application->status == $leave_approval_status['approved']){
                                    $badge = "bg-success";
                                    $label = "Approved";                                            
                                }else if($leave_application->status == $leave_approval_status['rejected']){
                                    $badge = "bg-danger";
                                    $label = "Rejected";                                            
                                }else if($leave_application->status == $leave_approval_status['hold']){
                                    $badge = "bg-warning";
                                    $label = "Holding";                                            
                                }else if($leave_application->status == $leave_approval_status['cancelled']){
                                    $badge = "bg-danger";
                                    $label = "Retracted";                                            
                                }

                                if(Auth::user()->id == $leave_application->forward_to &&
                                                ($leave_application->status != $leave_approval_status['approved'] && 
                                                $leave_application->status != $leave_approval_status['rejected'] &&
                                                $leave_application->status!=$leave_approval_status['cancelled'])
                                            ){
                                    $icondiv = 'green';
                                    $icon = 'bi-chevron-double-up blink';
                                    $title = "Awaiting your action";
                                }else{
                                    $icondiv = 'cyan';
                                    $icon = 'bi-eye';
                                    $title = "View";
                                }

                                if(NULL!=$leave_application->single_leave_data){
                                    foreach($leave_application->single_leave_data as $leavetrack){
                                        $remaining_leaves = $leavetrack->leave_days-$leavetrack->taken_days;
                                    }
                                }
                                if(0>=$remaining_leaves){
                                    $brdrS = "bordS";
                                    $title="Leave limit exceeded";
                                }else{
                                    $brdrS = "";
                                    $title="";
                                }
                                
                            @endphp
                                <tr  role="row" class="odd-{{$leave_application->id}}" data-leave-type="{{$leave_application->leave_type}}" data-ext-id="{{$leave_application->id}}" data-start-date="{{ $leave_application->date_from }}" data-end-date="{{ $leave_application->date_to }}" data-time-from="{{ $leave_application->time_from }}" data-time-end="{{ $leave_application->time_end }}" data-status="{{ $leave_application->status }}" data-paidstatus="{{ $leave_application->paid_status }}" data-reason="{{ $leave_application->reason }}">
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="{{route('employees.show', $leave_application->employee->user_id)}}"><img class="avatar avatar-xs"
                                                    src="{{asset("uploads/users/profile/".$leave_application->avatar)}}"></a>
                                            <a href="{{route('employees.show', $leave_application->employee->user_id)}}">{{ $leave_application->employee->name }}
                                                {{ $leave_application->employee->lname }}<span>{{ $leave_application->employee->designations->name }}</span></a>
                                        </h2>
                                    </td>
                                    <td class="sorting_1">{{$leave_application->employee->employee_no}}</td>
                                    <td>{{ $leave_application->employee->departments->name }}</td>
                                    <td style="text-align: center;">
                                        <span class="badge rounded-pill fw-bold {{$brdrS}}" style='padding:12px; background-color: {{ $leave_application->leavetypes->bg_color }};color:#383c41;' title="{{$title}}">
                                            {{ $leave_application->leavetypes->name }}
                                        </span>
                                    </td>
                                    <td>
                                        {{date('d-m-Y', strtotime($leave_application->date_from)) }}
                                        @php
                                            $startDate = date('d-m-Y', strtotime($leave_application->date_from));
                                        @endphp
                                    </td>
                                    <td>
                                        {{date('d-m-Y', strtotime($leave_application->date_to))}}
                                        @php
                                            $toDate = date('d-m-Y', strtotime($leave_application->date_to));
                                        @endphp
                                    </td>
                                    <td style="text-align: center;">                                        
                                        <span class="badge {{$badge}} fw-bold badg-rad">
                                            @if($leave_application->status == $leave_approval_status['approved'])
                                                <i class="bi bi-check-circle me-1"></i>
                                            @elseif($leave_application->status == $leave_approval_status['rejected'])
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                            @endif
                                            {{$label}}
                                        </span>
                                    </td>
                                    <td  style="text-align: center;"> <!-- //$leave_application->status == $leave_approval_status['approved'] && -->
                                        @if(  
                                           ( Auth::user()->hasRole(HR_ROLE) || Auth::user()->hasRole(PRINCIPAL_ROLE) ) 
                                        )
                                            @php
                                                $actionButtonClass = (0!=$leave_application->paid_status) ? 'bg-danger' : 'bg-success';
                                                $actionButtonText = (0!=$leave_application->paid_status) ? 'Unpaid' : 'Paid';
                                            @endphp

                                            <span class="badge {{$actionButtonClass}} fw-bold">
                                                {{$actionButtonText}}
                                            </span>

                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-btn bg-{{$icondiv}}-500 ms-2">
                                            <a href="#" data-toggle="modal"
                                                data-target="#edit_leave_{{ $leave_application->id }}" title="{{$title}}">
                                                <i class="bi {{$icon}}"
                                                    style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                            </a>
                                          
                                        </div>
                                           
                                        @if ($user_role->hasRole('Hr') && !in_array($leave_application->status, [$leave_approval_status['cancelled'], $leave_approval_status['rejected']]) )
                                        <div class="action-btn bg-yellow-500 ms-2">
                                            <a href="#" data-toggle="modal" data-target="#delete_leave" onclick="editLeave({{$leave_application->id}})">
                                                <i class="bi bi-pencil-square"
                                                    style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                            </a>
                                        </div>
                                       @endif

                                       @if ($user_role->hasRole('Hr') && $leave_application->status==$leave_approval_status['applied'])
                                        <div class="action-btn bg-red-500 ms-2">
                                            <a href="#" onclick="cust.deleteLeave({{$leave_application->id}})">
                                                <i class="bi bi-trash"
                                                    style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                            </a>
                                        </div>
                                       @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center;">
                                        There are no records to display!
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Edit Approval Modal -->
        @foreach ($leave_applications as $leave_application)             
            <div id="edit_leave_{{ $leave_application->id }}" class="modal custom-modal fade" role="dialog"
                style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Leave Approval & Assign</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="tab-box">

                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link active" id="actions-{{ $leave_application->id }}-tab" data-bs-toggle="pill" data-bs-target="#actions-{{ $leave_application->id }}" type="button" role="tab" aria-controls="actions" aria-selected="true">Leave Application Action</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="details-{{ $leave_application->id }}-tab" data-bs-toggle="pill" data-bs-target="#details-{{ $leave_application->id }}" type="button" role="tab" aria-controls="details" aria-selected="false" tabindex="-1">Leave Request Details</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="status-{{ $leave_application->id }}-tab" data-bs-toggle="pill" data-bs-target="#status-{{ $leave_application->id }}" type="button" role="tab" aria-controls="status" aria-selected="false" tabindex="-1">Leave Tracker</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="attach-{{ $leave_application->id }}-tab" data-bs-toggle="pill" data-bs-target="#attach-{{ $leave_application->id }}" type="button" role="tab" aria-controls="attach" aria-selected="false" tabindex="-1">Attachment</button>
                                </li>
                                @if(Auth::user()->hasRole(HR_ROLE) && 
                                    $leave_application->status!=$leave_approval_status['cancelled'] &&
                                    0==$leave_application->retract_data)
                                    <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="retract-{{ $leave_application->id }}-tab" data-bs-toggle="pill" data-bs-target="#retract-{{ $leave_application->id }}" type="button" role="tab" aria-controls="retract" aria-selected="false" tabindex="-1">Retract</button>
                                    </li>
                                @endif
                            </ul>

                            </div>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade active show" id="actions-{{ $leave_application->id }}" role="tabpanel" aria-labelledby="actions-{{ $leave_application->id }}-tab">    

                                    <div class="row">                            
                                        <div class="col-sm-12 pt-4">
                                            <div class="bg-white">
                                                <table class="table fw-bold" style="font-size: 0.75rem;">
                                                    <thead></thead>
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row" colspan="2">Forwarded From/Decided By</th>
                                                            <td scope="row" colspan="2" class="wd-2">-</td>
                                                            <td scope="row" colspan="2" class="fnt-8">
                                                                @if($leave_application->status==$leave_approval_status['applied'])
                                                                    {{$leave_application->employee->name}} 
                                                                @else
                                                                    {{$leave_application->name}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row" colspan="2">Comment</th>
                                                            <td scope="row" colspan="2" class="wd-2">-</td>
                                                            <td scope="row" colspan="2" class="fnt-8">
                                                                {!! nl2br($leave_application->comment) !!}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row" colspan="2">Status</th>
                                                            <td scope="row" colspan="2" class="wd-2">-</td>
                                                            <td scope="row" colspan="2" class="fnt-8">
                                                                {{ucfirst($leave_stat[$leave_application->status-1])}}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @if(Auth::user()->id == $leave_application->forward_to &&
                                                ($leave_application->status != $leave_approval_status['approved'] && 
                                                $leave_application->status != $leave_approval_status['rejected'] && 
                                                $leave_application->status!=$leave_approval_status['cancelled'])
                                            )
                                        <div class="col-sm-12 pt-2" style="display: flex;flex-wrap: wrap;flex-shrink: 0;align-items: center;justify-content: center;padding: 0 20px 20px;">
                                            <form
                                                action="{{ route('leave-approve', [
                                                    'approver_id' => auth()->user()->id,
                                                    'id' => $leave_application->statusid,
                                                    'status' => '',
                                                    'employee_id' => $leave_application->employee_id,
                                                    'leave_id' => $leave_application->id,
                                                ]) }}"
                                                method="POST">
                                                @csrf
                                                <div class="pb-5">
                                                    <label>Comment/Reason</label>
                                                    <textarea name="comment" id="comment-{{$leave_application->id}}" class="form-control" required></textarea>
                                                </div>
                                                @foreach ($leave_approval_action as $action => $color)
                                                    @if($leave_stat[$leave_application->status-1] != $action)
                                                        <input type="submit" name="approval_action" class="btn btn-{{ $color }}" data-bs-dismiss="modal" value="{{ucfirst($action)}}"> 
                                                    @endif
                                                    &nbsp;
                                                @endforeach
                                                
                                            </form>
                                        </div>
                                        @endif
                                        
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="details-{{ $leave_application->id }}" role="tabpanel" aria-labelledby="details-{{ $leave_application->id }}-tab">
                                  
                                    <div class="col-sm-12 pt-4">
                                        <div class="bg-white">
                                            <table class="table fw-bold" style="font-size: 0.75rem;"> <!-- background-color: #d6d6d6; -->
                                                <thead></thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" colspan="2">Employee ID</th>
                                                        <td scope="row" colspan="2" class="wd-2">-</td>
                                                        <td scope="row" colspan="2" class="fnt-8">{{ $leave_application->employee->employee_no }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" colspan="2">Employee Name</th>
                                                        <td scope="row" colspan="2" class="wd-2">-</td>
                                                        <td scope="row" colspan="2" class="fnt-8">{{ $leave_application->employee->name }}{{ $leave_application->employee->lname }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" colspan="2">Department</th>
                                                        <td scope="row" colspan="2" class="wd-2">-</td>
                                                        <td scope="row" colspan="2" class="fnt-8">{{ $leave_application->employee->departments->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" colspan="2">Designation</th>
                                                        <td scope="row" colspan="2" class="wd-2">-</td>
                                                        <td scope="row" colspan="2" class="fnt-8">{{ $leave_application->employee->designations->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" colspan="2">Type of Leave</th>
                                                        <td scope="row" colspan="2" class="wd-2">-</td>
                                                        <td scope="row" colspan="2" class="fnt-8">{{ $leave_application->leavetypes->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" colspan="2">Leave Start Date</th>
                                                        <td scope="row" colspan="2" class="wd-2">-</td>
                                                        <td scope="row" colspan="2" class="fnt-8">{{date('d-M-Y', strtotime($leave_application->date_from))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" colspan="2">Leave End Date</th>
                                                        <td scope="row" colspan="2" class="wd-2">-</td>
                                                        <td scope="row" colspan="2" class="fnt-8">{{date('d-M-Y', strtotime($leave_application->date_to))}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" colspan="2">No.of Leaves (Days/Hrs)</th>
                                                        <td scope="row" colspan="2" class="wd-2">-</td>
                                                        <td scope="row" colspan="2" class="fnt-8">
                                                            @php
                                                            if('null' == $leave_application->time_from &&
                                                                'null' == $leave_application->time_end){ @endphp
                                                                {{ $leave_application->no_days }}
                                                                Day{{ $leave_application->no_days > 1 ? 's' : '' }}
                                                            @php }else{ 
                                                                    $startTime = date("H:i:s", strtotime($leave_application->time_from));
                                                                    $startTimeC = Carbon\Carbon::parse($startTime);

                                                                    $endTime = date("H:i:s", strtotime($leave_application->time_end));
                                                                    $endTimeC = Carbon\Carbon::parse($endTime);

                                                                    $duration = $startTimeC->diff($endTimeC);    
                                                            @endphp
                                                                {{$duration->format('%h').' Hrs'}} 
                                                                {{$duration->format('%i').' Mts'}}
                                                                {{$duration->format('%s').' Secs'}} 
                                                                {{' [ '.$startTime.' - '.$endTime.' ]'}}
                                                            @php } @endphp
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" colspan="2">Reason for Leave</th>
                                                        <td scope="row" colspan="2" class="wd-2">-</td>
                                                        <td scope="row" colspan="2" class="fnt-8">{!!nl2br($leave_application->reason)!!}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="status-{{ $leave_application->id }}" role="tabpanel" aria-labelledby="status-{{ $leave_application->id }}-tab">
                                    <div class="col-sm-12 pt-4">
                                        <div class="bg-white">
                                            <!-- Add Leave tracker -->
                                            @include("leave.partials.leave-tracker")
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="attach-{{ $leave_application->id }}" role="tabpanel" aria-labelledby="attach-{{ $leave_application->id }}-tab">
                                    <div class="col-sm-12 pt-4">
                                        <div class="bg-white">
                                            <!-- Add Leave tracker -->
                                            @include("leave.partials.leave-docs")
                                        </div>
                                    </div>
                                </div>

                                @if(Auth::user()->hasRole(HR_ROLE) && 
                                $leave_application->status!=$leave_approval_status['cancelled'] &&
                                0==$leave_application->retract_data)
                                <div class="tab-pane fade" id="retract-{{ $leave_application->id }}" role="tabpanel" aria-labelledby="retract-{{ $leave_application->id }}-tab">
                                    <div class="col-sm-12 pt-4">
                                        <div class="bg-white">
                                            <!-- Add Leave retract section -->
                                            <h5 class="pb-3 leav-h5">Retract Section</h5>
                                            <div class="col-md-4 m-auto">
                                                <label>Cancel Reason <sup>*</sup></label>
                                                <textarea name="canel-reason" id="canel-reason-{{$leave_application->id}}" class="form-control" required></textarea>
                                                <br>
                                                <input type="button" 
                                                        name="cancel_action"
                                                        class="btn btn-primary"
                                                        data-bs-dismiss="modal"
                                                        data-id="{{$leave_application->id}}"
                                                        data-eid="{{$leave_application->employee_id}}"
                                                        value="Retract this leave request"
                                                        onclick="cust.sendCancelRequest(this);">
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                            
                        </div>

                        <!-- <div class="modal-footer">
                            
                        </div> -->

                    </div>
                </div>
            </div>
        @endforeach

        <!-- /Edit Approval Modal -->

        <!-- Edit Leave Application Modal -->

        <div class="modal custom-modal fade" id="delete_leave" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Leave Approval Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form id="delete_leave_form" name="delete_leave_form">
                        <div class="form-group">
                            <input type="hidden" name="existing_id" value="">

                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="">
                        </div> 
                        <div class="form-group">
                            <label for="status">Leave Type</label>
                            <select class="form-control" name="leaveType" id="leaveType">
                                @foreach(get_leave_type() as $valID=>$valName)
                                    <option value="{{$valName}}">{{$valID}}</option>
                                @endforeach
                            </select>
                        </div>   
                        <div class="form-group" id="start_timeFields" style="display:none;">
                            <label for="start_time">Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="form-control" value="">
                        </div>
                        <div class="form-group" id="end_timeFields" style="display:none;">
                            <label for="end_time">End Time</label>
                            <input type="time" id="end_time" name="end_time" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <textarea class="form-control" name="reason" placeholder="reason"></textarea>
                        </div>
                        <div class="form-group">&nbsp;
                            <input type="checkbox" class="form-check-input ms-2" name="paid_status" id="paid_status" placeholder="paid_status" value="1">
                            <label for="paid_status">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mark as unpaid</label>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                        <div class="float-end">
                            <button type="button" class="btn btn-primary" onclick="reassignLeave()" >submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- /Edit Leave Application Modal -->


        <!-- Add Leave Application Modal -->

        <div class="modal custom-modal fade" id="add_leave" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Employee Leave</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form id="add_leave_form" name="add_leave_form">

                      <div class="form-group">
                            <label for="add_employee_id">Employee</label>
                            <select class="form-control" name="add_employee_id" id="add_employee_id">
                                @foreach($employees as $employee)
                                    <option value="{{$employee->employee_id}}">{{$employee->employee_no.'. '.$employee->name.' '.$employee->lname}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="add_LeaveType">Leave Type</label>
                            <select class="form-control" name="add_LeaveType" id="add_LeaveType">
                                @foreach(get_leave_type() as $valID=>$valName)
                                    <option value="{{$valName}}">{{$valID}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="add_start_date">Start Date</label>
                            <input type="date" name="add_start_date" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="add_end_date">End Date</label>
                            <input type="date" name="add_end_date" class="form-control" value="">
                        </div> 
                           
                        <div class="form-group" id="add_start_timeFields" style="display:none;">
                            <label for="add_start_time">Start Time</label>
                            <input type="time" id="add_start_time" name="add_start_time" class="form-control" value="">
                        </div>
                        <div class="form-group" id="add_end_timeFields" style="display:none;">
                            <label for="add_end_time">End Time</label>
                            <input type="time" id="add_end_time" name="add_end_time" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="add_reason">Reason</label>
                            <textarea class="form-control" name="add_reason" placeholder="reason"></textarea>
                        </div>
                        <div class="form-group">&nbsp;
                            <input type="checkbox" class="form-check-input ms-2" name="add_paid_status" id="add_paid_status" placeholder="paid status" value="1">
                            <label for="add_paid_status">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mark as unpaid</label>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                        <div class="float-end">
                            <button type="button" class="btn btn-primary" onclick="addLeave()" >submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- /Add Leave Application Modal -->

    </main>
    <script>
        document.getElementById("leaveType").addEventListener("change", function() {
            var leaveType = this.value;
            changeLeaveType(leaveType, 1);
        });

        document.getElementById("add_LeaveType").addEventListener("change", function() {
            var leaveType = this.value;
            changeLeaveType(leaveType, 0);
        });

        function editLeave(id)
        {
            var startDate = $('#delete_leave_form input[name="start_date"]');
            var endDate = $('#delete_leave_form input[name="end_date"]');
            var startTime = $('#delete_leave_form input[name="start_time"]');
            var endTime = $('#delete_leave_form input[name="end_time"]');
            var status = $('#delete_leave_form select[name="status"]');
            var existid = $('#delete_leave_form input[name="existing_id"]');
            var type = $('#delete_leave_form select[name="leaveType"]');
            var reason = $('#delete_leave_form textarea[name="reason"]');
            var startTimeFields = document.getElementById("start_timeFields");
            var EndTimeFields = document.getElementById("end_timeFields");

            var selectedRow = $('.odd-'+id); 
            var startDateValue = selectedRow.data('start-date');
            var endDateValue = selectedRow.data('end-date');
            var startTimeValue = selectedRow.data('time-from');
            var endTimeValue = selectedRow.data('time-end');
            var statusValue = selectedRow.data('status');
            var leaveTypeValue = selectedRow.data('leave-type');
            var paidstatusValue = selectedRow.data('paidstatus');
            var reasonValue = selectedRow.data('reason');
            
            startDate.val(startDateValue);
            endDate.val(endDateValue);
            status.val(statusValue);
            existid.val(id);
            type.val(leaveTypeValue);
            reason.val(reasonValue);
            if(1==paidstatusValue){
                document.forms.delete_leave_form.paid_status.checked = 'checked';
            }else{
                document.forms.delete_leave_form.paid_status.checked = false;
            }

            if(leaveTypeValue==6 || leaveTypeValue==10){
                startTimeFields.style.display = "block";
                EndTimeFields.style.display = "block";
            }else {
                startTimeFields.style.display = "none";
                EndTimeFields.style.display = "none";
            }

            if(null!=startTimeValue) startTime.val(startTimeValue);
            if(null!=endTimeValue) endTime.val(endTimeValue);

        }

        function reassignLeave()
        {
            
            var startDate = $('#delete_leave_form input[name="start_date"]').val();
            var endDate = $('#delete_leave_form input[name="end_date"]').val();
            var status = $('#delete_leave_form select[name="status"]').val();
            var existid = $('#delete_leave_form input[name="existing_id"]').val();
            var reason = $('#delete_leave_form textarea[name="reason"]').val();
            var leaveType = $('#delete_leave_form select[name="leaveType"]').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var startTime = $('#delete_leave_form input[name="start_time"]').val();
            var endTime = $('#delete_leave_form input[name="end_time"]').val();
            var paid_status = 0;
            
            if(document.forms.delete_leave_form.paid_status.checked){
                paid_status = 1;
            }else{
                paid_status = 0;
            }
            
            var data ={
                'status':status,
                'id':existid,
                'date_from':startDate,
                'date_to':endDate,
                'reason':reason,
                'leaveType':leaveType,
                'startTime':startTime,
                'endTime':endTime,
                'paid_status':paid_status,
                '_token': csrfToken
            }
            $.ajax({
                url: "{{route('re-assign')}}",
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#delete_leave').modal('hide');
                    location.reload();
                },
                error: function(error) {
           
                    alert('Error occurred while reassigning leave');
                }
            });
        }

        function changeLeaveType(leaveType, mode)
        {
            if(1==mode){
                var startTimeFields = document.getElementById("start_timeFields");
                var EndTimeFields = document.getElementById("end_timeFields");
            }else{
                var startTimeFields = document.getElementById("add_start_timeFields");
                var EndTimeFields = document.getElementById("add_end_timeFields");
            }

            if (leaveType == 6 || leaveType == 10) {
                startTimeFields.style.display = "block";
                EndTimeFields.style.display = "block";
            } else {
                startTimeFields.style.display = "none";
                EndTimeFields.style.display = "none";
            }
        }

        function addLeave()
        {            
            var startDate = $('#add_leave_form input[name="add_start_date"]').val();
            var endDate = $('#add_leave_form input[name="add_end_date"]').val();
            var employeeid = $('#add_leave_form select[name="add_employee_id"]').val();
            var reason = $('#add_leave_form textarea[name="add_reason"]').val();
            var leaveType = $('#add_leave_form select[name="add_LeaveType"]').val();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var startTime = $('#add_leave_form input[name="add_start_time"]').val();
            var endTime = $('#add_leave_form input[name="add_end_time"]').val();
            var paid_status = 0;

            if(document.forms.add_leave_form.add_paid_status.checked){
                paid_status = 1;
            }else{
                paid_status = 0;
            }
            
            var data ={
                'employee_id':employeeid,
                'date_from':startDate,
                'date_to':endDate,
                'reason':reason,
                'leave_type':leaveType,
                'time_from':startTime,
                'time_end':endTime,
                'paid_status':paid_status,
                '_token': csrfToken
            }
            $.ajax({
                url: "{{route('add-leave')}}",
                type: 'POST',
                data: data,
                success: function(response) {
                    if(1==response){
                        $('#add_leave').modal('hide');
                        location.reload();
                    }else{
                        alert('Error occurred while add new leave');
                    }
                },
                error: function(error) {
                    alert('Error occurred while add new leave');
                }
            });
        }
        
    </script>
@endsection