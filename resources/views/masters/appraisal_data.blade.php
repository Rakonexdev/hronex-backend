@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>Appraisal Data</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Masters</li>
                            <li class="breadcrumb-item active">Appraisal Data</li>
                        </ol>
                    </nav>
                </div>
            </div>
           
        </div>
    </div> 
    <!-- /Page Header -->

    <!-- Search Filter -->
    @if ($edit_masters)
    <form action="{{ route('appraisaldata.update', $edit_masters->id ) }}" method="post">
        {{ method_field('PUT') }}
        @else
        <form action="{{ route('appraisaldata.store') }}" method="post">
            @endif
            @csrf
        <div class="row filter-row mb-30">
            <h4 class="mb-2 mt-2 bgh4">{{$edit_masters ? 'Edit' : 'Create'}}</h4>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 col-12">
                    <div class="form-group">
                       <!-- <input name="appraisal_data_name" value="{{$edit_masters ? $edit_masters->type : ''}}" type="text"
                            class="form-control floating">-->
                        <label class="form-label">Appraisal Type</label>
                        <select name="appraisal_data_name" class="form-control">
                            <option value="">Choose...</option>
                            @if($appr_types->isNotEmpty())
                                @foreach($appr_types as $aprtype)
                                <option value="{{$aprtype->id}}" {{($edit_masters && $edit_masters->type==$aprtype->id) ? 'selected' : ''}}>
                                    {{$aprtype->type_name}}
                                </option>
                                @endforeach
                            @endif
                            <option value="0" {{($edit_masters && $edit_masters->type==0) ? 'selected' : ''}}>Others</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group">
                        <label class="form-label">Applicable To</label>
                        <select name="applicable_to" class="form-control">
                            <option value="" selected>Choose...</option>
                            <option value="1" {{($edit_masters && $edit_masters->applicable_to==1) ? 'selected' : ''}}>Academic</option>
                            <option value="2" {{($edit_masters && $edit_masters->applicable_to==2) ? 'selected' : ''}}>Admin</option>
                            <option value="3" {{($edit_masters && $edit_masters->applicable_to==3) ? 'selected' : ''}}>SLT</option>
                            <option value="0" {{($edit_masters && $edit_masters->applicable_to==0) ? 'selected' : ''}}>All</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-8 col-md-6 col-lg-6 col-xl-4 col-12">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <textarea name="details" type="text" placeholder="Enter Details" class="form-control txt-high">{{$edit_masters ? $edit_masters->details : ''}}</textarea>
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
                            <option value="">Choose...</option>
                            <option value="1" {{($edit_masters && $edit_masters->active==1) ? 'selected' : ''}}>Enable</option>
                            <option value="0" {{($edit_masters && $edit_masters->active==0) ? 'selected' : ''}}>Disable</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2" style="padding-top: 33px;">
                    <button type="submit"
                        class="btn btn-block btn-alpha">{{$edit_masters ? 'Update' : 'Save'}}</button>
                </div>
                @if ($edit_masters)
                <div class="col-md-1" style="padding-top:33px;">
                    <a href="{{ url('appraisaldata') }}" class="btn btn-block btn-danger">Cancel</a>
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
                                <th>Appraisal Type</th>
                                <th>Applicable To</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($masters_data as $appraisal_data)
                            <tr role="row" class="odd">
                                <td>
                                    <h2 class="table-avatar">
                                        <a>{{$appraisal_data->type_name}}</a>
                                    </h2>
                                </td>
                                <td>
                                    @switch($appraisal_data->applicable_to)
                                    @case(1)
                                        Academic
                                    @break
                                    @case(2)
                                        Admin
                                    @break
                                    @case(3)
                                        SLT
                                    @break
                                    @default
                                        Others
                                    @endswitch
                                </td>
                                <td>{{$appraisal_data->details}}</td>
                                <td>{{$appraisal_data->description}}</td>
                                <td>
                                    <a href="{{ route('appraisaldata.status', ['id' => $appraisal_data->id, 'status' => $appraisal_data->active]) }}"
                                        class="badge rounded-pill badg-actv btn-{{$appraisal_data->active ? 'success' : 'danger'}}">
                                        {{getStatus($appraisal_data->active)}}
                                    </a>
                                </td>
                                <td>
                                    <div class="action-btn bg-cyan-500 ms-2">
                                        <a href="{{route('appraisaldata.show', $appraisal_data->id)}}">
                                            <i class="bi bi-pencil"
                                                style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                        </a>
                                    </div>
                                    <!--<div class="action-btn bg-red-500 ms-3">
                                        <a data-toggle="modal" data-target="#delete_{{ $appraisal_data->id }}">
                                            <i class="bi bi-trash"
                                                style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                        </a>
                                    </div>-->
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">
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
        @forelse ($masters_data as $appraisal_data)
        <div class="modal custom-modal fade" id="delete_{{$appraisal_data->id}}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Appraisal Data</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{route('appraisaldata.delete', $appraisal_data->id)}}"
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