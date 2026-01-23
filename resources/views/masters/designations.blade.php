@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>Designations</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Masters</li>
                            <li class="breadcrumb-item active">Designations</li>
                        </ol>
                    </nav>
                </div>
            </div>
           
        </div>
    </div> 
    <!-- /Page Header -->

    <!-- Search Filter -->
    @if ($edit_masters)
    <form action="{{ route('designations.update', $edit_masters->id ) }}" method="post">
    {{ method_field('PUT') }}
    @else
    <form action="{{ route('designations.store') }}" method="post">
    @endif
        @csrf
        <div class="row filter-row mb-30">
            <h4 class="mb-2 mt-2 bgh4">{{$edit_masters ? 'Edit' : 'Create'}}</h4>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col-12">
                <div class="form-group">
                    <label class="form-label">Designation</label>
                    <input name="designations_name" placeholder="Enter Designation" value="{{$edit_masters ? $edit_masters->name : ''}}" type="text" class="form-control">
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group">
                <label class="form-label">Department</label>
                <select id="inputEmail5" name="department_id" class="form-select" style="color: #8D8D8D;">
                    <option selected>Choose...</option>
                    @forelse ($departments as $department)
                    <option value="{{$department->id}}" {{($edit_masters &&  $edit_masters->department_id==$department->id)? 'selected' : ''}} >{{$department->name}}</option>
                    @empty
                    <option>No data available</option>
                    @endforelse
                </select>
                </div>
            </div>
            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-3 col-12">
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
                        <option value="1" {{($edit_masters &&  $edit_masters->status==1)? 'selected' : ''}}>Enable</option>
                        <option value="0" {{($edit_masters &&  $edit_masters->status==0)? 'selected' : ''}}>Disable</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2" style="padding-top: 33px;">
                <button type="submit" class="btn btn-block btn-alpha">{{$edit_masters ? 'Update' : 'Save'}}</button>
            </div>
            @if ($edit_masters)
            <div class="col-md-1" style="padding-top: 7px;">
                <a href="{{ url('designations') }}" class="btn btn-block btn-danger">Cancel</a>
            </div>
            @endif
        </div>
            @if (session()->has('success'))
                <div class="alert alert-success al-sign" style="margin-left: 15px; width: 81%;">
                   {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 81%;">
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
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($masters_data as $designation)
                        <tr role="row" class="odd">
                            <td>
                                <h2 class="table-avatar">
                                    <a>{{$designation->name}}</a>
                                </h2>
                            </td>
                            <td>{{$designation->department_name}}</td>
                            <td>{{$designation->description}}</td>
                            <td>
                                <a href="{{ route('designations.status', ['id' => $designation->id, 'status' => $designation->status]) }}" class="badge rounded-pill badg-actv btn-{{$designation->status ? 'success' : 'danger'}}">
                                    {{getStatus($designation->status)}}
                                </a>
                            </td>
                            <td>
                                <div class="action-btn bg-cyan-500 ms-2">
                                    <a href="{{route('designations.show', $designation->id)}}">
                                        <i class="bi bi-pencil"
                                            style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                    </a>
                                </div>
                                <!--<div class="action-btn bg-red-500 ms-3">
                                    <a data-toggle="modal" data-target="#delete_{{ $designation->id }}">
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
    <!-- Delete Modal -->
    @forelse ($masters_data as $designation)
    <div class="modal custom-modal fade" id="delete_{{$designation->id}}" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Designation</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('designations.delete', $designation->id)}}"
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