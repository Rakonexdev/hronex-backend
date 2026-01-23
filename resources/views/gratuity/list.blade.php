@php

 /*echo '<pre>'; print_r($resig_data); exit; */

@endphp

@extends('home.partial.layout')

@section('content')

<main id="main" class="main">

<!-- Page Header -->

<div class="pagetitle">
	<div class="row align-items-center">

	    <div class="col">
	        <div class="pagetitle">
	            <h1>{{trans('messages.lbl_academic_emp').' '.trans('messages.grat_head')}}</h1>
	            <nav>
	            <ol class="breadcrumb">
	                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">{{trans('messages.lbl_home')}}</a></li>
	                <li class="breadcrumb-item active">{{trans('messages.grat_head')}}</li>
	            </ol>
	            </nav>
	        </div>
	    </div>
	    @if(Auth::user()->hasRole(HR_ROLE))
	    <div class="col-auto float-right ml-auto" style="margin-bottom: 30px;">
	        <a href="#" data-toggle="modal" data-target="#add_gratuity" data-id="" title="Add Gratuity" class="btn btn-primary add-btn" style="padding-bottom: 8px;" onclick="cust.clearData(); document.querySelector('#empList').value='';"><i class="bi bi-plus-lg"></i>{{trans('messages.btn_add').' '.trans('messages.grat_head')}}</a>
	    </div>
	    @endif	    
	</div>
</div>

<!-- Search Filter -->

<form action="{{route('gratuity.search')}}" method="post">
    @csrf

    <div class="row">        
        <div class="col-md-2">
            <div class="form-group form-focus">
                <label class="focus-label">{{trans('messages.emp_short').' '.trans('messages.lbl_id')}}</label>
                <input type="text" name="emp_id" class="form-control floating" value="{{request('emp_id')}}" autocomplete="off">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group form-focus">
                <input type="text" name="emp_name" class="form-control floating" value="{{request('emp_name')}}" autocomplete="off">
                <label class="focus-label">{{trans('messages.lbl_academic_emp').' '.trans('messages.lbl_name')}}</label>
            </div>
        </div>

        <div class="col-md-2">
            <select id="inputEmail5" name="department" class="form-select form-group form-focus" style="color: #8D8D8D;">
                <option value="0" selected>{{trans('messages.lbl_choose').' '.trans('messages.lbl_depart')}}...</option>
                @forelse (masterDropdown('departments') as $department)
                <option value="{{$department->id}}" @if(request('department')==$department->id) selected @endif >{{$department->name}}</option>
                @empty
                <option>{{trans('messages.no_data')}}</option>
                @endforelse
            </select>
        </div>


        <div class="col-md-2" style="padding-top: 7px;">
            <button type="submit" class="btn btn-block btn-alpha">{{trans('messages.btn_search')}}</button>
        </div>

    </div>
</form>

<!-- /Search Filter -->
	<div class="col-lg-12 msg-div">	    

        @if($errors->any())
        <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 97.5%;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif 

        @if(Session::has('success'))
		    <div class="alert alert-success alert-dismissible show">
		        {{ session('success') }}		        
		    </div>
		@endif  

		@if(Session::has('error'))
		    <div class="alert alert-danger alert-dismissible show">
		        {{ session('error') }}		        
		    </div>
		@endif      

	</div>

	<div class="row">
		 <div class="col-md-12"> <!-- style="margin-top: 20px;" -->
		   <div class="table-responsive">
		     <table class="table table-striped custom-table datatable dataTable-selector" style="display: inline-table; padding: 5px;">
		       <thead>
		         <tr>
		           <th>{{trans('messages.emp_short').' '.trans('messages.lbl_name')}}</th>
		           <th>{{trans('messages.emp_short').' '.trans('messages.lbl_id')}}</th>
		           <th>{{trans('messages.lbl_joining').' '.trans('messages.lbl_date')}}</th>
		           <th>{{trans('messages.lbl_last').' '.trans('messages.lbl_working').' '.trans('messages.lbl_day')}}</th>	
		           <th>{{trans('messages.grat_head').' '.trans('messages.lbl_total')}}</th>	 
		           <th>{{trans('messages.lbl_final').' '.trans('messages.lbl_settle')}}</th>
		           <th style="text-align: center;">{{trans('messages.lbl_status')}}</th>	            
		           <th>{{trans('messages.lbl_action')}}</th>
		         </tr>
		       </thead>
		       <tbody>
		       	@if(0 < count($gratuity_data))
		       		@foreach($gratuity_data as $grat)
						<tr>
							<td>
							 <h2 class="table-avatar">
							  <a href="{{route('employees.show', $grat->employee->user_id)}}"><img class="avatar avatar-xs"
                                            src="@if($grat->employee->avatar){{asset("uploads/".$grat->employee->avatar)}}@else {{asset('img/profile-img.jpg')}} @endif"></a>
							  <a href="{{route('employees.show', $grat->employee->user_id)}}">
							  	{{$grat->employee->name.' '.$grat->employee->lname}}
							  	<span>
							  		@if(isset($grat->designations))
									    {{ $grat->designations->name }}
									@endif
							  	</span></a>
							 </h2>
							</td>
							<td>{{$grat->employee->employee_no}}</td>
							<td>{{date('d-m-Y', strtotime($grat->employee->joiningdate))}}</td>							
							<td>{{date('d-m-Y', strtotime($grat->last_working_day))}}</td>
							<td>{{$grat->gratuity_total}}</td>	
							<td>{{number_format(($grat->net_pay+$grat->last_payroll), 2)}}</td>	
							<td style="text-align: center;">
								@php
									$badge = "bg-light";

									if($gratuity_status[3]==$grat->status){
										$badge = "bg-success";
									}else if($gratuity_status[2]==$grat->status || $gratuity_status[1]==$grat->status){
										$badge = "bg-warning ";
									}else if($gratuity_status[0]==$grat->status){
										$badge = "bg-primary";
									}else{
										$badge = "bg-secondary";
									}

									if($gratuity_status[2]==$grat->status){ 
										$grat->status =  trans('messages.lbl_fnl_apr_pnd');
									}
								@endphp
								<span class="badge {{$badge}} fw-bold" style="padding:6px;">
									@if($gratuity_status[3]==$grat->status)
										<i class="bi bi-check-circle me-1"></i>
									@endif
									{{$grat->status}}
								</span>
							</td>					
							<td>
							<div class="action-btn bg-green-500 ms-2" style="margin-left: 0px !important;">
							    <a href="#" data-toggle="modal" data-target="#update_gratuity" data-id="" title="{{trans('messages.btn_update').' '.trans('messages.grat_head')}}" onclick="cust.getGratuityDetails({{$grat->id}}, '{{$grat->status}}');" class="earinings">
							        <!-- <i class="bi bi-plus-lg" style="font-size: 15px; display: flex; color: #ffffff;"></i> -->
							        <i class="bi bi-pencil-square" style="font-size: 12px; display: flex; color: #ffffff;"></i>
							    </a>
							</div>
							@if(Auth::user()->id==$grat->active_decider)
							<div class="action-btn bg-green-500 ms-2" style="margin-left: 0px !important;">
							    <a href="#" data-toggle="modal" data-target="#update_gratuity_status" data-id="" title="{{trans('messages.btn_update').' '.trans('messages.lbl_status')}}" onclick="cust.getGratuityForStatus({{$grat->id}});" class="earinings">
							        <i class="bi bi-three-dots-vertical" style="font-size: 12px; display: flex; color: #ffffff;"></i>
							    </a>
							</div>
							@endif
							</td>
						</tr>
					@endforeach
		         @endif
		       </tbody>
		     </table>
		    <div class="col-md-12" style="display:flex; justify-content: right;">{!! $gratuity_data->links() !!}</div>
		   </div>
		 </div>
   </div>   

    <!-- Add Gratuity Modal -->
   	@include("gratuity.partials.add")

   	<!-- Update Gratuity Modal -->
   	@include("gratuity.partials.update")

   	<!-- Update Gratuity status Modal -->
   	@include("gratuity.partials.status")
   	

  <!-- /Page Content -->

 <!-- /Add Gratuity Modal -->

   </main><!-- End #main -->

  @endsection

  <script>

  	function onInput() {
	    var val = document.getElementById("empList").value;
	    var opts = document.getElementById('emplistOp').childNodes;

	    for (var i = 0; i < opts.length; i++) {
	      if (opts[i].value === val) {
	        // An item was selected from the list!
	        // yourCallbackHere()     
	        cust.getEmployeeDetails(opts[i].value);
	        break;
	      }
	    }
    }

    document.addEventListener("DOMContentLoaded",function(){
    	document.querySelector('.dataTable-top').style.display = 'none';
		document.querySelector('.dataTable-info').style.display = 'none';
	});

    
  </script>