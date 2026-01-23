@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>Performance Review</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Masters</li>
                            <li class="breadcrumb-item active">Performance Review</li>
                        </ol>
                    </nav>
                </div>
            </div>
           
        </div>
    </div> 
    <!-- /Page Header -->

    <!-- Search Filter -->
        @if ($edit_masters)
            <form action="{{ route('performance-review.update', $edit_masters->id ) }}" method="post">
            {{ method_field('PUT') }}
        @else
            <form action="{{ route('performance-review.store') }}" method="post">
                @endif
                @csrf
            <div class="row filter-row mb-30">
                <h4 class="mb-2 mt-2 bgh4">{{$edit_masters ? 'Edit' : 'Create'}}</h4>
                    
                    <div class="col-sm-8 col-md-6 col-lg-6 col-xl-4 col-12">
                        <div class="form-group">
                            <label class="form-label">Performance Review </label>
                            <textarea name="performance_review" type="text" placeholder="Enter Performance Review" class="form-control txt-high">
                            {{$edit_masters ? $edit_masters->performance_review : ''}}
                            </textarea>
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
                    <div class="col-md-1" style="padding-top:33px;">
                        <a href="{{ url('performance-review') }}" class="btn btn-block btn-danger">Cancel</a>
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
                                <th>#</th>
                                <th>Performance Review</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reivews as $review)
                            <tr role="row" class="odd">
                                <td>
                                    <h2 class="table-avatar">
                                        <a>{{$loop->iteration}}</a>
                                    </h2>
                                </td>
                                
                                <td>{{$review->performance_review}}</td>
                                <td>
                                    <span class="badge rounded-pill badg-actv btn-{{$review->status == 1 ? 'success' : 'danger'}}">{{$review->status == 1 ? 'Active' : 'In Active'}}</span>                                         
                                </td>
                                <td>
                                    <div class="action-btn bg-cyan-500 ms-2">
                                        <a href="{{route('performance-review.show', $review->id)}}">
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
        @forelse ($reivews as $reivew)
        <div class="modal custom-modal fade" id="delete_{{$reivew->id}}" role="dialog">
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
                                    <a href="#"
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