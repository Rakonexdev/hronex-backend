@extends('home.partial.layout')

@section('content')

@can('employee_link')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>
                        Employee List
                        @if($request->has('type') && 'QE'==$request->type) 
                            <small>[Qid Expiry: within 30 days & already expired]</small> 
                        @elseif($request->has('type') && 'PE'==$request->type) 
                            <small>[Passport Expiry: within 30 days & already expired]</small> 
                        @endif
                    </h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Employee List</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @can('create-employee')
            <div class="col-auto float-right ml-auto" style="margin-bottom: 30px;">
                <a href="{{url('employees-information')}}" class="btn btn-primary add-btn" onclick="location.href='Employee Information-FAS HRMS.html'"
                    style="padding-bottom: 8px;"><i class="bi bi-plus-lg"></i>Add Employee</a>
            </div>
            @endcan

            @include("employee.partials.import")

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

    <form action="{{route('employee.search')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="form-label">Emp ID</label>
                    <input type="text" name="emp_id" class="form-control" placeholder="Enter Emp ID">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="form-label">Emp Name</label>
                    <input type="text" name="emp_name" class="form-control" placeholder="Enter Emp Name">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <select id="inputEmail5" name="department" class="form-control" style="color: #8D8D8D;">
                        <option value="0" selected>Choose...</option>
                        @forelse (masterDropdown('departments') as $designation)
                        <option value="{{$designation->id}}">{{$designation->name}}</option>
                        @empty
                        <option>No data available</option>
                        @endforelse
                    </select>
                </div>    
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label class="form-label">Joining Date</label>
                    <input type="date" name="doj" onfocus="(this.type='date')" class="form-control">
                </div>
            </div>

            <div class="col-md-2" style="padding-top: 33px;">
                <button type="submit" class="btn btn-block btn-alpha">Search</button>
            </div>

        </div>
    </form>

    <form action="{{route('employee.filter')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="form-label">Joining Date</label>
                    <select id="filterjd" name="filterjd" class="form-control" style="color: #8D8D8D;" required>
                        <option value="" selected>Choose...</option>
                        <option value="desc" @if(isset($request->filterjd) && "desc"==$request->filterjd) selected @endif>Date by latest first</option>
                        <option value="asc" @if(isset($request->filterjd) && "asc"==$request->filterjd) selected @endif>Date by oldest first</option>
                    </select>
                    <input type="hidden" name="statusval" id="statusval" value="@if(isset($employees) && isset($employees[0]) && 0==$employees[0]->status) 0 @else 1 @endif">
                </div>    
            </div>

            <div class="col-md-2" style="padding-top: 33px;">
                <button type="submit" class="btn btn-block btn-alpha">Filter</button>
            </div>

        </div>
    </form>

    <!-- /Search Filter -->
    @php
    $curDate = date('Y-m-d'); 
    $expiryDate = Carbon\Carbon::parse($curDate)->addDays(30);
    @endphp

    <div class="row">
        <div class="col-lg-12" style="margin-top: 20px;">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable dataTable-selector"
                    style="display: inline-table; padding: 5px;">
                    <thead>
                        <tr>
                            <th>Emp Name</th>
                            <th>Emp No.</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Date of Joining</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                        <tr role="row" class="odd">
                            <td>
                                <h2 class="table-avatar">
                                    <a href="{{route('employees.show', $employee->user_id)}}"><img class="avatar avatar-xs"
                                            src="@if($employee->avatar){{asset("uploads/users/profile/".$employee->avatar)}}@else {{asset("uploads/avatar.png")}} @endif"></a>
                                    <a href="{{route('employees.show', $employee->user_id)}}">{{$employee->name}} {{$employee->lname}}<span>{{$employee->designation_name}}</span></a>
                                </h2>
                                <input type="hidden" name="emp_stat_val" id="emp_stat_val_{{$employee->employee_id}}" value="@if(null!=$employee->employeeStatus){{json_encode($employee->employeeStatus)}}@endif">
                            </td>
                            <td class="sorting_1">{{$employee->employee_no}}</td>
                            <td>@if(NULL!=$employee->department_name){{$employee->department_name}}@endif</td>
                            <td>@if(NULL!=$employee->designation_name){{$employee->designation_name}}@endif</td>
                            <td>
                                @if(NULL!=$employee->joiningdate){{date('d-m-Y', strtotime($employee->joiningdate))}}@endif
                                
                                @if(
                                    ($expiryDate >= Carbon\Carbon::parse($employee->qidexpiry) && $expiryDate < Carbon\Carbon::parse($employee->passportexpiry))
                                )
                                <div class="action-btn bg-cyan-500 ms-3" title="Attention: Qid Expiry">
                                    <i class="bi bi-exclamation-triangle" style="font-size: 12px;"></i>
                                </div>
                                @elseif(                                     
                                    ($expiryDate >= Carbon\Carbon::parse($employee->passportexpiry) && $expiryDate < Carbon\Carbon::parse($employee->qidexpiry))
                                )
                                <div class="action-btn bg-teal-500 ms-3" title="Attention: Passport Expiry">
                                    <i class="bi bi-exclamation-triangle" style="font-size: 12px;"></i>
                                </div>
                                @elseif(
                                    $expiryDate >= Carbon\Carbon::parse($employee->qidexpiry) && $expiryDate >= Carbon\Carbon::parse($employee->passportexpiry)
                                )
                                <div class="action-btn bg-yellow-500 ms-3" title="Attention: Qid & Passport Expiry">
                                    <i class="bi bi-exclamation-triangle" style="font-size: 12px;"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                @if(1==$employee->status)
                                    <span class="badge rounded-pill bg-success badg-actv">Active</span>
                                @else
                                    <span class="badge rounded-pill bg-danger badg-actv">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <!-- <div class="action-btn bg-cyan-500 ms-2" style="margin-left: 0px !important;">
                                    <a href="{{route('employees.show', $employee->user_id)}}">
                                        <i class="bi bi-eye"
                                            style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                    </a>
                                </div> -->
                                <!-- <div class="action-btn bg-green-500 ms-2">
                                    <a href="{{route('employees.show', $employee->user_id)}}">
                                        <i class="bi bi-pencil"
                                            style="font-size: 12px; display: flex; color: #ffffff;"></i>
                                    </a>
                                </div> -->
                                @can('edit-employee')
                                <div class="action-btn bg-green-500 ms-2">
                                    <a href="{{route('editEmployee', $employee->user_id)}}">
                                        <i class="bi bi-pencil"
                                            style="font-size: 12px; display: flex; color: #ffffff;"></i>
                                    </a>
                                </div>
                                @endcan
                                
                                @can('update_employee_status')
                                <div class="action-btn bg-red-500 ms-3">
                                    <a href="#" data-toggle="modal" data-target="#update_employee_status" data-id="{{$employee->employee_id}}" title="{{trans('messages.btn_update').' '.trans('messages.lbl_status')}}" class="emp_stat_update" onclick="cust.loadEmployeeStatus({{$employee->employee_id}});">
                                        <i class="bi bi-three-dots-vertical" style="font-size: 12px; display: flex; color: #ffffff;"></i>
                                    </a>
                                </div>
                                @endcan
                                <!-- <div class="action-btn bg-red-500 ms-2">
                                    <a href="" data-toggle="modal" data-target="#delete_{{-- {{ $employee->user_id }} --}}">
                                        <i class="bi bi-trash"
                                            style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                    </a>
                                </div> -->
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">
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

    <!-- Delete Modal -->
    @forelse ($employees as $employee)
        <div class="modal fade" id="delete_{{$employee->user_id}}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Employee</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                @csrf
                                @method('DELETE')
                                <div class="col-md-6">
                                    <a href="{{route('employees.destroy', $employee->user_id)}}" onclick="event.preventDefault();
                                        document.getElementById('delete-post-form-{{ $employee->user_id }}').submit();"
                                        class="btn btn-primary continue-btn">Delete</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="javascript:void(0);" data-dismiss="modal"
                                        class="btn btn-primary cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form id="delete-post-form-{{ $employee->user_id }}" action="{{route('employees.destroy', $employee->user_id)}}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @empty
    @endforelse
    <!-- /Delete Modal -->


    <!-- Update Employee status Modal -->
    @include("employee.partials.status")

</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
@endcan
@endsection