@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>Employee Notice Period</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Masters</li>
                            <li class="breadcrumb-item active">Employee Notice Period</li>
                        </ol>
                    </nav>
                </div>
            </div>
           
        </div>
    </div> 
    <!-- /Page Header -->

    <!-- Search Filter -->
    @if ($edit_masters)
    <form action="{{ route('noticeperiod.update', $edit_masters->id ) }}" method="post">
    {{ method_field('PUT') }}
    @else
    <form action="{{ route('noticeperiod.store') }}" method="post">
    @endif
        @csrf
        <div class="row filter-row mb-30">
            <h4 class="mb-2 mt-2 bgh4">{{$edit_masters ? 'Edit' : 'Create'}}</h4>
            <div class="col-sm-8 col-md-6 col-lg-6 col-xl-4 col-12">
                <div class="form-group">
                <label class="form-label">Employee</label>
                <select id="employee_id" name="employee_id" class="form-select" required>
                    <option value=''>Choose...</option>
                    @if(null!=$employees)
                        @foreach($employees as $emps)
                            <option value="{{$emps->id}}" {{($edit_masters &&  $edit_masters->employee_id==$emps->id)? 'selected' : ''}} >{{$emps->employee_no.' - '.$emps->name.' '.$emps->lname}}</option>
                        @endforeach
                    @endif
                </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4 col-xl-2 col-12">
                <div class="form-group">
                    <label class="form-label">Notice Period Days</label>
                    <input name="np_days" value="{{$edit_masters ? $edit_masters->np_days : ''}}" type="number" class="form-control" placeholder="Enter Days" required>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 col-12">
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="np_description" type="text" placeholder="Enter Description" class="form-control txt-high">{{$edit_masters ? $edit_masters->np_description : ''}}</textarea>
                </div>
            </div>            
            <div class="col-md-1" style="padding-top: 33px;">
                <button type="submit" class="btn btn-block btn-alpha">{{$edit_masters ? 'Update' : 'Save'}}</button>
            </div>
            @if ($edit_masters)
            <div class="col-md-1" style="padding-top: 33px;">
                <a href="{{ url('noticeperiod') }}" class="btn btn-block btn-danger">Cancel</a>
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
                            <th>Id</th>
                            <th>Name</th>
                            <th>Notice Period</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($masters_data as $np)
                        <tr role="row" class="odd">
                            <td>
                                <h2 class="table-avatar">
                                    {{$np->employee_no}}
                                </h2>
                            </td>
                            <td>
                                <h2 class="table-avatar">
                                    {{$np->employee_name}}
                                </h2>
                            </td>
                            <td>{{$np->np_days}}</td>
                            <td>{{$np->np_description}}</td>
                            <td>
                                <div class="action-btn bg-cyan-500 ms-2">
                                    <a href="{{route('noticeperiod.show', $np->id)}}">
                                        <i class="bi bi-pencil"
                                            style="font-size: 15px; display: flex; color: #ffffff;"></i>
                                    </a>
                                </div>
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
</main>
@endsection