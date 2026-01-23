@extends('home.partial.layout')

@section('content')
<main id="main" class="main">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Approval status</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Masters</li>
                    <li class="breadcrumb-item active">Approval status</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Search Filter -->
    @if ($edit_masters)
    <form action="{{ route('approvalstatus.update', $edit_masters->id ) }}" method="post">
    {{ method_field('PUT') }}
    @else
    <form action="{{ route('approvalstatus.store') }}" method="post">
    @endif
        @csrf
        <div class="row filter-row">
            <h6 class="mb-2 mt-2">{{$edit_masters ? 'Edit' : 'Create'}}</h6>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-4 col-12">
                <div class="form-group form-focus">
                    <input name="approval_status_name" value="{{$edit_masters ? $edit_masters->name : ''}}" type="text" class="form-control floating">
                    <label class="focus-label">Approval status Name</label>
                </div>
            </div>
            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-2 col-12">
                <div class="form-group form-focus">
                    <textarea name="description" type="text" class="form-control floating">{{$edit_masters ? $edit_masters->description : ''}}</textarea>
                    <label class="focus-label">Description</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                <div class="form-group form-focus select-focus">
                    <select name="status" class="form-control select floating">
                        <option value="1"> Enable </option>
                        <option value="0"> Disable </option>
                    </select>
                    <label class="focus-label">Status</label>
                </div>
            </div>
        </div>
        <div class="row filter-row mb-5">
            <div class="col-md-2 mb-5" style="padding-top: 7px;">
                <button type="submit" class="btn btn-block btn-success">{{$edit_masters ? 'Update' : 'Save'}}</button>
            </div>
            @if ($edit_masters)
                <div class="col-md-1" style="padding-top: 7px;">
                    <a href="{{ url('approvalstatus') }}" class="btn btn-block btn-danger">Cancel</a>
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
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable dataTable-selector"
                    style="display: inline-table;">
                    <thead>
                        <tr>
                            <th>Designation Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($masters_data as $approval_status)
                        <tr>
                            <td>
                                <h2 class="table-avatar">
                                    <a>{{$approval_status->name}}</a>
                                </h2>
                            </td>
                            <td>{{$approval_status->description}}</td>
                            <td>
                                <a href="{{ route('approvalstatus.status', ['id' => $approval_status->id, 'status' => $approval_status->active]) }}" class="btn btn-sm btn-{{$approval_status->active ? 'primary' : 'danger'}}">
                                    {{getStatus($approval_status->active)}}
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="action-btn bg-green-500 ms-2">
                                    <a href="{{route('approvalstatus.show', $approval_status->id)}}">
                                        <i class="bi bi-pencil"
                                            style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                    </a>
                                </div>
                                <!--<div class="action-btn bg-red-500 ms-2">
                                    <a data-toggle="modal" data-target="#delete_{{ $approval_status->id }}">
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
    @forelse ($masters_data as $approval_status)
    <div class="modal custom-modal fade" id="delete_{{$approval_status->id}}" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Approval status</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{route('approvalstatus.delete', $approval_status->id)}}"
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
    @empty
    @endforelse
    <!-- /Delete Modal -->
</main>
@endsection