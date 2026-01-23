@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>Appraisal Type</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Masters</li>
                            <li class="breadcrumb-item active">Appraisal Type</li>
                        </ol>
                    </nav>
                </div>
            </div>
           
        </div>
    </div> 
    <!-- /Page Header -->

    <!-- Search Filter -->
    @if ($edit_masters)
        <form action="{{ route('appraisaltype.update', $edit_masters->id ) }}" method="post">
        {{ method_field('PUT') }}
    @else
        <form action="{{ route('appraisaltype.store') }}" method="post">
    @endif
            @csrf
        <div class="row filter-row mb-30">
            <h4 class="mb-2 mt-2 bgh4">{{$edit_masters ? 'Edit' : 'Create'}}</h4>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 col-12">
                    <div class="form-group">                       
                        <label class="form-label">Appraisal Type</label>
                        <input type="text" name="appraisal_type_name" id="appraisal_type_name" value="{{$edit_masters ? $edit_masters->type_name : ''}}" class="form-control">                            
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
                <div class="col-md-1" style="padding-top: 33px;">
                    <a href="{{ url('appraisaltype') }}" class="btn btn-block btn-danger">Cancel</a>
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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($masters_data as $appraisal_type)
                            <tr role="row" class="odd">
                                <td>
                                    <h2 class="table-avatar">
                                        <a>{{$appraisal_type->type_name}}</a>
                                    </h2>
                                </td>                                
                                <td>
                                    <a href="{{ route('appraisaltype.status', ['id' => $appraisal_type->id, 'status' => $appraisal_type->active]) }}"
                                        class="badge rounded-pill badg-actv btn-{{$appraisal_type->active ? 'success' : 'danger'}}">
                                        {{getStatus($appraisal_type->active)}}
                                    </a>
                                </td>
                                <td>
                                    <div class="action-btn bg-cyan-500 ms-2">
                                        <a href="{{route('appraisaltype.show', $appraisal_type->id)}}">
                                            <i class="bi bi-pencil"
                                                style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                        </a>
                                    </div>                                    
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
        @forelse ($masters_data as $appraisal_type)
        <div class="modal custom-modal fade" id="delete_{{$appraisal_type->id}}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Appraisal Type</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{route('appraisaltype.delete', $appraisal_type->id)}}"
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