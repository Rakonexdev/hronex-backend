@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>Shifts</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Masters</li>
                            <li class="breadcrumb-item active">Shifts</li>
                        </ol>
                    </nav>
                </div>
            </div>
           
        </div>
    </div> 
    <!-- /Page Header -->

    <!-- Search Filter -->
    @if ($edit_masters)
    <form action="{{ route('schoolshift.update', $edit_masters->id ) }}" method="post">
    {{ method_field('PUT') }}
    @else
    <form action="{{ route('schoolshift.store') }}" method="post">
    @endif
        @csrf
        <div class="row filter-row mb-30">
            <h4 class="mb-2 mt-2 bgh4">{{$edit_masters ? 'Edit' : 'Create'}}</h4>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-4 col-12">
                <div class="form-group">
                    <label class="form-label">Shift</label>
                    <input name="schoolshift_name" value="{{$edit_masters ? $edit_masters->name : ''}}" type="text" class="form-control" placeholder="Enter Shift">
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-4 col-12">
                <div class="form-group">
                    <label class="form-label">Start Time</label>
                    <input type="time" name="start_time" value="{{$edit_masters ? $edit_masters->start_time : ''}}" class="form-control">
                </div>
                
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-4 col-12">
                <div class="form-group">
                    <label class="form-label">End Time</label>
                    <input type="time" name="end_time" value="{{$edit_masters ? $edit_masters->end_time : ''}}" class="form-control">
                </div>
                
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-4 col-12">
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" type="text" placeholder="Enter Description" class="form-control txt-high">{{$edit_masters ? $edit_masters->description : ''}}</textarea>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="" selected>Choose...</option>
                        <option value="1" {{ ($edit_masters && $edit_masters->active == 1) ? 'selected' : '' }}>Enable</option>
                        <option value="0" {{ ($edit_masters && $edit_masters->active == 0) ? 'selected' : '' }}>Disable</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2" style="padding-top: 33px;">
                <button type="submit" class="btn btn-block btn-alpha">{{$edit_masters ? 'Update' : 'Save'}}</button>
            </div>
            @if ($edit_masters)
            <div class="col-md-2 " style="padding-top: 10px;">
                <br><a href="{{ url('schoolshift') }}" class="btn btn-block btn-danger">Cancel</a>
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
                <table class="table table-striped custom-table datatable dataTable-selector"
                    style="display: inline-table; padding: 5px;">
                    <thead>
                        <tr>
                            <th>Shift</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($masters_data as $schoolshift)
                        <tr role="row" class="odd">
                            <td>
                                <h2 class="table-avatar">
                                    <a>{{$schoolshift->name}}</a>
                                </h2>
                            </td>
                            <td>{{$schoolshift->start_time}}</td>
                            <td>{{$schoolshift->end_time}}</td>
                            <td>{{$schoolshift->description}}</td>
                            <td>
                                <a href="{{ route('schoolshift.status', ['id' => $schoolshift->id, 'status' => $schoolshift->active]) }}" class="badge rounded-pill badg-actv btn-{{$schoolshift->active ? 'success' : 'danger'}}">
                                    {{getStatus($schoolshift->active)}}
                                </a>
                            </td>
                            <td>
                                <div class="action-btn bg-cyan-500 ms-2">
                                    <a href="{{route('schoolshift.show', $schoolshift->id)}}">
                                        <i class="bi bi-pencil"
                                            style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                    </a>
                                </div>
                                <!--<div class="action-btn bg-red-500 ms-3">
                                    <a data-toggle="modal" data-target="#delete_{{ $schoolshift->id }}">
                                        <i class="bi bi-trash"
                                            style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                    </a>
                                </div>-->
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">
                                There are no records to display!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Delete School shift Modal -->
    @forelse ($masters_data as $schoolshift)
    <div class="modal custom-modal fade" id="delete_{{$schoolshift->id}}" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete School Shift</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('schoolshift.delete', $schoolshift->id)}}"
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
    <!-- /Delete School shift Modal -->
</main>
@endsection