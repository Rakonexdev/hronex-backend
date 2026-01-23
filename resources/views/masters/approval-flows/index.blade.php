@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>Leave Approval Flow</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Masters</li>
                            <li class="breadcrumb-item active">Leave Approval Flow</li>
                        </ol>
                    </nav>
                </div>
            </div>
           
        </div>
    </div> 
    <!-- /Page Header -->
    
    <div class="row">
        <div class="col-lg-12 text-end">
            <a href="{{ route('approval-flows.create') }}" class="btn btn-primary mb-3"> + </a>
        </div>
        <div class="col-lg-12">
            <div class="table-responsive">
                
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="background-color: #fbfdff;">
                            <th>Flow Name</th>
                            <th>Hierarchy</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($flows as $flow)
                        <tr>
                            <td class='fw-bold'>{{ $flow->name }}</td>
                            <td>
                                @foreach($flow->steps as $step)
                                    {{ $step->step_order }}.
                                    @if($step->role=='Vp')
                                        Executive Manager
                                    @elseif($step->role=='Principal')
                                        Manager
                                    @else
                                        {{ $step->role }}
                                    @endif
                                    <br>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('approval-flows.edit',$flow->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    
</main>
@endsection