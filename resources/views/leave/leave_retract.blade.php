@extends('home.partial.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Leave Retraction Requests</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active">Leave Retraction</li>
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

        <div class="row">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable dataTable-selector smt-tabl"
                        style="display: inline-table; padding: 5px;">
                        <thead>
                            <tr>
                                <th>Emp Name</th>
                                <th>Emp ID</th>
                                <th style="text-align: center;">Type of Leave</th>
                                <th>Date(Start / End)</th>
                                <th style="text-align: center;">Retract Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cancel_applications as $leave_application)
                            @php
                            
                                $badge = "bg-light";
                                $label = "";

                                if($leave_application->status == 0){
                                    $badge = "bg-secondary";
                                    $label = "Requested";
                                }else if($leave_application->status == 1){
                                    $badge = "bg-success";
                                    $label = "Approved";
                                }else if($leave_application->status == 2){
                                    $badge = "bg-danger";
                                    $label = "Rejected";
                                }else{
                                    $badge = "bg-warning";
                                    $label = "Pending";
                                }

                                if('H' == $leave_application->request_from){
                                    $row_bg = 'background-color: #0080ff2e';
                                }else{
                                    $row_bg = '';
                                }
                               
                            @endphp
                                <tr role="row" class="odd" style="{{$row_bg}}">
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="#"><img class="avatar avatar-xs"
                                                    src="{{asset("uploads/users/profile/".$leave_application->avatar)}}"></a>
                                            <a href="#">{{ $leave_application->name }}
                                                {{ $leave_application->lname }}</a>
                                        </h2>
                                    </td>
                                    <td class="sorting_1">{{$leave_application->employee_no}}</td>
                                    <td style="text-align: center;">
                                        <span class="badge rounded-pill fw-bold" style='padding:12px; background-color: {{ $leave_application->bg_color }};color:#383c41;'>
                                            {{ $leave_application->ltype }}
                                        </span>
                                    </td>
                                    <td>{{date('d-m-Y', strtotime($leave_application->date_from)).' / '.date('d-m-Y', strtotime($leave_application->date_to)) }}</td>
                                    <td style="text-align: center;">                                        
                                        <span class="badge {{$badge}} fw-bold badg-rad">
                                            @if($leave_application->status == 1)
                                                <i class="bi bi-check-circle me-1"></i>
                                            @elseif($leave_application->status == 2)
                                                <i class="bi bi-exclamation-octagon me-1"></i>
                                            @endif
                                            {{$label}}
                                        </span>
                                    </td>                                    
                                    <td>
                                        @if(0==$leave_application->status)
                                            <button type="button" data-id="{{$leave_application->id}}" data-lid="{{$leave_application->leave_id}}" id="1" class="btn btn-success btn-sm retract-dec" onclick="cust.retractLeave(this);">Approve</button> &nbsp;
                                            <button type="button" data-id="{{$leave_application->id}}" data-lid="{{$leave_application->leave_id}}" id="2" class="btn btn-danger btn-sm retract-dec" onclick="cust.retractLeave(this);">Reject</button>
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
    </main>
@endsection