@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>Budget Type</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Masters</li>
                            <li class="breadcrumb-item active">Budget Type</li>
                        </ol>
                    </nav>
                </div>
            </div>
           
        </div>
    </div> 
    <!-- /Page Header -->

    <!-- Search Filter -->
    @if ($edit_masters)
    <form action="{{ route('budgettype.update', $edit_masters->id ) }}" method="post">
        {{ method_field('PUT') }}
        @else
        <form action="{{ route('budgettype.store') }}" method="post">
        @endif
        @csrf
        <div class="row filter-row mb-30">
            <h4 class="mb-2 mt-2 bgh4">{{$edit_masters ? 'Edit' : 'Create'}}</h4>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Budget Type</label>
                        <select name="budget_type" class="form-control">
                            <option value="" selected>Choose...</option>
                            <option value="year_wise" @if($edit_masters){{$edit_masters->budget_type == 'year_wise' ? 'selected': ''}} @endif> Year wise </option>
                            <option value="month_wise" @if($edit_masters){{$edit_masters->budget_type == 'month_wise' ? 'selected': ''}} @endif> Month wise </option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col-12">
                    <div class="form-group">
                        <label class="form-label">Amount</label>
                        <input name="amount" placeholder="Enter Amount" value="{{$edit_masters ? $edit_masters->amount : ''}}" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="form-label">From</label>
                        <input name="year_from" value="{{$edit_masters ? $edit_masters->start_from : ''}}" type="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="form-label">To</label>
                        <input name="year_to" value="{{$edit_masters ? $edit_masters->start_to : ''}}" type="date" class="form-control">
                    </div>
                </div>
                <div class="col-md-2" style="padding-top: 33px;">
                    <button type="submit" class="btn btn-block btn-alpha">{{$edit_masters ? 'Update' : 'Save'}}</button>
                </div>
                @if ($edit_masters)
                <div class="col-md-1" style="padding-top: 7px;">
                    <a href="{{ url('budgettype') }}" class="btn btn-block btn-danger">Cancel</a>
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
                                <th>Budget Type</th>
                                <th>Amount</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($masters_data as $budget_type)
                            <tr role="row" class="odd">
                                <td>
                                    <h2 class="table-avatar">
                                        <a>{{ ucwords(str_replace('_', ' ', $budget_type->budget_type)) }}</a>
                                    </h2>
                                </td>
                                <td>{{$budget_type->amount}}</td>
                                <td>{{$budget_type->start_from}}</td>
                                <td>{{$budget_type->start_to}}</td>
                                <td>
                                    <div class="action-btn bg-cyan-500 ms-2">
                                        <a href="{{route('budgettype.show', $budget_type->id)}}">
                                            <i class="bi bi-pencil"
                                                style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                        </a>
                                    </div>
                                    <!--<div class="action-btn bg-red-500 ms-3">
                                        <a data-toggle="modal" data-target="#delete_{{ $budget_type->id }}">
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
        @forelse ($masters_data as $budget_type)
        <div class="modal custom-modal fade" id="delete_{{$budget_type->id}}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Budget Type</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{route('budgettype.delete', $budget_type->id)}}"
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