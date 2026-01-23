@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>Leave Types</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Masters</li>
                            <li class="breadcrumb-item active">Leave Types</li>
                        </ol>
                    </nav>
                </div>
            </div>
           
        </div>
    </div> 
    <!-- /Page Header -->

    <!-- Search Filter -->
    @if ($edit_masters)
    <form action="{{ route('leavetypes.update', $edit_masters->id ) }}" method="post">
        {{ method_field('PUT') }}
        @else
        <form action="{{ route('leavetypes.store') }}" method="post">
            @endif
            @csrf
            @csrf
        <div class="row filter-row mb-30">
            <h4 class="mb-2 mt-2 bgh4">{{$edit_masters ? 'Edit' : 'Create'}}</h4>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Leave Type</label>
                        <input name="leave_type_name" placeholder="Enter Leave Type" value="{{$edit_masters ? $edit_masters->name : ''}}" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group">
                        <label class="form-label">Code</label>
                        <input name="leave_type_code" placeholder="Enter Code" value="{{$edit_masters ? $edit_masters->code : ''}}" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group">
                        <label class="form-label">No. Of Leave Days</label>
                        <input name="leave_days" placeholder="Enter No. Of Days" value="{{$edit_masters ? $edit_masters->leave_days : ''}}" type="number" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group">
                        <label class="form-label">Color</label>
                        <select name="bg_color" placeholder="Add color" class="form-control">
                            <option value="#b4b2b2">Select</option>
                            <option value="#b4b2b2" {{$edit_masters && $edit_masters->bg_color=='#b4b2b2' ? 'selected' : '' }} style="background-color:#b4b2b2">[#b4b2b2]</option>
                            <option value="#cfe2ff" {{$edit_masters && $edit_masters->bg_color=='#cfe2ff' ? 'selected' : '' }} style="background-color:#cfe2ff">[#cfe2ff]</option>
                            <option value="#2e75b5" {{$edit_masters && $edit_masters->bg_color=='#b4b2b2' ? 'selected' : '' }} style="background-color:#2e75b5">[#2e75b5]</option>
                            <option value="#d1e7dd" {{$edit_masters && $edit_masters->bg_color=='#d1e7dd' ? 'selected' : '' }} style="background-color:#d1e7dd">[#d1e7dd]</option>
                            <option value="#cff4fc" {{$edit_masters && $edit_masters->bg_color=='#cff4fc' ? 'selected' : '' }} style="background-color:#cff4fc">[#cff4fc]</option>
                            <option value="#7798d9" {{$edit_masters && $edit_masters->bg_color=='#7798d9' ? 'selected' : '' }} style="background-color:#7798d9">[#7798d9]</option>
                            <option value="#0dcaf0" {{$edit_masters && $edit_masters->bg_color=='#0dcaf0' ? 'selected' : '' }} style="background-color:#0dcaf0">[#0dcaf0]</option>
                            <option value="#fff3cd" {{$edit_masters && $edit_masters->bg_color=='#fff3cd' ? 'selected' : '' }} style="background-color:#fff3cd">[#fff3cd]</option>
                            <option value="#f5c2c7" {{$edit_masters && $edit_masters->bg_color=='#f5c2c7' ? 'selected' : '' }} style="background-color:#f5c2c7">[#f5c2c7]</option>
                            <option value="#f7d1af" {{$edit_masters && $edit_masters->bg_color=='#f7d1af' ? 'selected' : '' }} style="background-color:#f7d1af">[#f7d1af]</option>
                            <option value="#f56371" {{$edit_masters && $edit_masters->bg_color=='#f56371' ? 'selected' : '' }} style="background-color:#f56371">[#f56371]</option>
                            <option value="#b4b2b2" {{$edit_masters && $edit_masters->bg_color=='#b4b2b2' ? 'selected' : '' }} style="background-color:#b4b2b2">[#b4b2b2]</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12 hidee">
                    <div class="form-group">
                    <label class="form-label">Year</label>
                    <select id="inputEmail5" name="academic_year" class="form-select" style="color: #8D8D8D;">
                        <option selected>Choose...</option>
                        <option value="2" {{$edit_masters && $edit_masters->academic_year==2 ? 'selected' : '' }}>2024</option>
                        <option value="1" {{$edit_masters && $edit_masters->academic_year==1 ? 'selected' : '' }}>2023</option>
                        <!--{!--@forelse (masterDropdown('academic_year') as $academic_year)
                        <option value="{{$academic_year->id}}" {{$edit_masters && $edit_masters->academic_year==$academic_year->id ? 'selected' : '' }}>{{$academic_year->title}}</option>
                        @empty
                        <option>No data available</option>
                        @endforelse --} -->
                    </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group">
                        <label class="form-label">Applicable</label>
                        <select name="applicable_to" class="form-control">
                            <option value="" selected>Choose...</option>
                            <option value="0" {{$edit_masters && $edit_masters->applicable_to==0 ? 'selected' : '' }}>All</option>
                            <option value="1" {{$edit_masters && $edit_masters->applicable_to==1 ? 'selected' : '' }}>Staff</option>
                            <option value="2" {{$edit_masters && $edit_masters->applicable_to==2 ? 'selected' : '' }}>Administration</option> 
                        </select>
                    </div>
                </div>                
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="" selected>Choose...</option>
                            <option value="1" {{$edit_masters && $edit_masters->active==1 ? 'selected' : '' }}>Enable</option>
                            <option value="0" {{$edit_masters && $edit_masters->active==0 ? 'selected' : '' }}>Disable</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-8 col-md-6 col-lg-6 col-xl-4 col-12">
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" type="text" placeholder="Enter Description" class="form-control txt-high">{{$edit_masters ? $edit_masters->description : ''}}</textarea>
                    </div>
                </div>
                <div class="col-md-2" style="padding-top: 33px;">
                    <button type="submit" class="btn btn-block btn-alpha">{{$edit_masters ? 'Update' : 'Save'}}</button>
                </div>
                @if ($edit_masters)
                <div class="col-md-1" style="padding-top: 33px;">
                    <a href="{{ url('leavetypes') }}" class="btn btn-block btn-danger">Cancel</a>
                </div>
                @endif
            </div>
                @if (session()->has('success'))
                <div class="alert alert-success al-sign" style="margin-left: 15px; width: 97.5%;">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 97.5%;">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
        </form>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped custom-table dataTable-selector"
                        style="display: inline-table; padding: 5px;">
                        <thead>
                            <tr>
                                <th>Leave Type</th>
                                <th>Code</th>
                                <th>Leave Days</th>
                                <th>Color</th>
                                <!-- <th>Academic Year</th> -->
                                <th>Applicable To</th>                                
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($masters_data as $leave_type)
                            <tr role="row" class="odd">
                                <td>
                                    <h2 class="table-avatar">
                                        <a>{{$leave_type->name}}</a>
                                    </h2>
                                </td>
                                <td>{{$leave_type->code}}</td>
                                <td>{{$leave_type->leave_days}}</td>
                                <td><span style="padding:4px 12px;border-radius:4px;background-color:{{$leave_type->bg_color}}">&nbsp;</span></td>
                                <!-- <td>{!--academicYear($leave_type->academic_year)--}
                                    {!--@if('1'==$leave_type->academic_year) 2023 @else 2024 @endif--}
                                </td>-->
                                <td>
                                    @switch($leave_type->applicable_to)
                                    @case(1)
                                        Staff
                                    @break
                                    @case(2)
                                        Administration
                                    @break
                                    @default
                                        All
                                    @endswitch
                                </td>                                
                                <td>{{$leave_type->description}}</td>
                                <td>
                                    <a href="{{ route('leavetypes.status', ['id' => $leave_type->id, 'status' => $leave_type->active]) }}" class="badge rounded-pill badg-actv btn-{{$leave_type->active ? 'success' : 'danger'}}">
                                        {{getStatus($leave_type->active)}}
                                    </a>
                                </td>
                                <td>
                                    <div class="action-btn bg-cyan-500 ms-2">
                                        <a href="{{route('leavetypes.show', $leave_type->id)}}">
                                            <i class="bi bi-pencil"
                                                style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                        </a>
                                    </div>
                                    <!--<div class="action-btn bg-red-500 ms-3">
                                        <a data-toggle="modal" data-target="#delete_{{ $leave_type->id }}">
                                            <i class="bi bi-trash"
                                                style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                        </a>
                                    </div>-->
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
    <!-- Delete Modal -->
    @forelse ($masters_data as $leave_type)
    <div class="modal custom-modal fade" id="delete_{{$leave_type->id}}" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Leave Type</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('leavetypes.delete', $leave_type->id)}}"
                                    class="btn bg-red-500 continue-btn">Delete</a>
                            </div>
                            <div class="col-md-6">
                                <a href="javascript:void(0);" data-dismiss="modal"
                                    class="btn bg-cyan-500 cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    @endforelse
    <!-- /Delete Modal -->
</main>
@endsection