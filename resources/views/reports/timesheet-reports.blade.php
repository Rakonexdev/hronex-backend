@extends('home.partial.layout')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Timesheet Report</h1>
                        <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Timesheet Reports</li>
                        </ol>
                        </nav>
                        
                    </div>
                </div>
            

                <!--<div class="col-auto float-right ml-auto" style="margin-bottom: 30px;">
                <a href="#" data-toggle="modal" data-target="#add_appraisal" class="btn btn-primary add-btn" style="padding-bottom: 8px;"><i class="bi bi-plus-lg"></i>Add Appraisal</a>
                </div>-->

            </div>
            <div class="row">
                <div class="float-end">
                    <button type="button" class="btn btn-danger "><a href="{{ route('timesheetExport', 'excel') }}" class="text-light">Download Excel</a></button>
                    <button type="button" class="btn btn-danger"><a href="{{ route('timesheetExport', 'pdf') }}"  class="text-light">Download PDF</a></button>
                </div>
            </div>
            
        </div>
        

        <!-- /Page Header -->

        <!-- Search Filter -->
        <!--<form action="#" method="post">
                @csrf
        <div class="row">

            <div class="col-md-2">  
            <div class="form-group">
            <label for="inputName5" class="form-label">Emp ID</label>
            <input type="number" class="form-control" id="inputName5" name="emp_id" style="color: #8D8D8D;" placeholder="Enter Emp ID">
            </div>
            </div>

            <div class="col-md-2">  
            <div class="form-group">
                <label for="inputName5" class="form-label">Emp Name</label>
                <input type="text" class="form-control" id="inputName5" name="emp_name"  style="color: #8D8D8D;" placeholder="Enter Emp Name">
            </div>
            </div>

            <div class="col-md-4">  
            <div class="form-group">
                <label for="inputEmail5" name="department"  class="form-label">Department</label>
                        <select id="inputEmail5" class="form-control" style="color: #8D8D8D;">                
                        <option value="0" selected>Choose Department...</option>
                            @forelse (masterDropdown('departments') as $designation)
                            <option value="{{$designation->id}}">{{$designation->name}}</option>
                            @empty
                            <option>No data available</option>
                            @endforelse
                        </select>
            </div>
            </div>

            <div class="col-md-2">  
            <div class="form-group">
                <label for="inputName5" name="doj" class="form-label">Joining Date</label>
                <input type="date" class="form-control" id="inputName5" style="color: #8D8D8D;" placeholder="Enter Date">
            </div>
            </div>
            

            <div class="col-md-2" style="padding-top: 33px;"> 
            <button type="submit" class="btn btn-block btn-alpha">Search</button>  
            </div>

            </div>
        </form>-->

        <!-- /Search Filter -->
        <div class="row">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable dataTable-selector" style="display: inline-table; padding: 5px;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            @foreach ($dates as $date)
                                <th>{{ $date }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendanceData as $record)
                            <tr>
                                <td>{{ $record['name'] }}</td>
                                @foreach ($dates as $date)
                                    <td>
                                        @if (isset($record['attendance'][$date]))
                                            @if ($record['attendance'][$date]['checkin'] === 'H' && $record['attendance'][$date]['leave'] === 'L')
                                                HD
                                            @elseif ($record['attendance'][$date]['checkin'] === 'H')
                                                H
                                            @elseif ($record['attendance'][$date]['leave'] === 'L')
                                                L
                                            @endif
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
</main>
@endsection