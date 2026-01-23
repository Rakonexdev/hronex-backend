@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>Appraisal Applicable</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Masters</li>
                            <li class="breadcrumb-item active">Appraisal Applicable</li>
                        </ol>
                    </nav>
                </div>
            </div>
           
        </div>
    </div> 
    <!-- /Page Header -->

    <!-- Search Filter -->
    @if ($edit_masters)
        <form action="{{ route('appraisal_applicable.update', $edit_masters->id ) }}" method="post">
        {{ method_field('PUT') }}
    @else
        <form action="{{ route('appraisal_applicable.store') }}" method="post">
    @endif
            @csrf
         <div class="row filter-row mb-30">
            <h4 class="mb-2 mt-2 bgh4">{{$edit_masters ? 'Edit' : 'Create'}}</h4>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 col-12">
                    <div class="form-group">                       
                        <label class="form-label">Appraisal Applicable</label>
                        <input type="text" name="appraisal_applicable" id="appraisal_applicable" value="{{$edit_masters ? $edit_masters->applicable : ''}}" class="form-control">                            
                    </div>
                </div>                
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="">Choose...</option>
                            <option value="1" {{($edit_masters && $edit_masters->status==1) ? 'selected' : ''}}>Enable</option>
                            <option value="0" {{($edit_masters && $edit_masters->status==0) ? 'selected' : ''}}>Disable</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2" style="padding-top: 33px;">
                    <button type="submit"
                        class="btn btn-block btn-alpha">{{$edit_masters ? 'Update' : 'Save'}}</button>
                </div>
                @if ($edit_masters)
                <div class="col-md-2" style="padding-top: 33px;">
                    <a href="{{ url('appraisal_applicable') }}" class="btn btn-block btn-danger">Cancel</a>
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
                            @forelse ($masters_data as $appraisal_applicable)
                            
                                <tr role="row" class="odd">
                                    <td>
                                        <h2 class="table-avatar">
                                            <a>{{$appraisal_applicable->applicable}}</a>
                                        </h2>
                                    </td>                                
                                    <td>
                                        <a href="{{ route('appraisal_applicable.status', ['id' => $appraisal_applicable->id, 'status' => $appraisal_applicable->status]) }}"
                                            class="badge rounded-pill badg-actv btn-{{$appraisal_applicable->status ? 'success' : 'danger'}}">
                                            {{getStatus($appraisal_applicable->status)}}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="action-btn bg-cyan-500 ms-2">
                                            <a href="{{route('appraisal_applicable.show', $appraisal_applicable->id)}}">
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
        
        <!-- /Delete Modal -->
</main>
@endsection