@extends('home.partial.layout')
@section('content')
    <main id="main" class="main">
    <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Employee Performance Report's</h1>
                        <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Employee Performance Report's</li>
                        </ol>
                        </nav>
                    </div>
                </div>
            </div> 
        </div>
       

        <!-- /Page Header -->

        <!-- Search Filter -->
       

        <!-- /Search Filter -->
        <div class="row">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="table-responsive">
                    <table class="table table-striped custom-table datatable dataTable-selector" style="display: inline-table; padding: 5px;">
                        <thead>
                        <tr>
                            <th>Emp Name</th>
                            <th>Emp No.</th>
                            <!-- <th>Contact.</th> -->
                            <th>Email</th>
                            <th>Department</th>
                            <th>Designations</th>
                            <th>Reports</th>
                        </tr>
                        </thead>
                     
                        <tbody>
                            @foreach($employees as $employee)
                           
                            <tr>
                                <td>
                                    {{$employee->name}} {{$employee->lname}}
                                </td>
                                <td>
                                    {{$employee->employee_no}}
                                </td>
                                <!-- <td>
                                {{$employee->mobile1}}
                                </td> -->
                                <td>
                                    {{$employee->email}}
                                </td>
                                <td>
                                    {{$employee->department}}
                                </td>
                                <td>
                                    {{$employee->designation}}
                                </td>
                                <td>
                                <button href="#" class="btn btn-primary" data-target=".perfomance_report" data-toggle="modal" onclick="get_performance_report({{$employee->employee_id}},event)" >
                                    View
                                </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!--Model Starts-->
    <div id="pip_modal" class="modal perfomance_report   custom-modal fade" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md"  role="document">
            <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title">
                    Performance Reports
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="update-content">

            </div>
            

            </div>

        </div>
    </div>
    <!--/Model Ends-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function get_performance_report(employeeNo,event) {
        event.preventDefault();
        $.ajax({
            url: "{{ route('perfomancereportsdata')}}", 
            type: 'GET',
            data: { employee_no: employeeNo },
            success: function(response) {
                // updateModalContent(response);
                $('#update-content').empty();
                $('#update-content').append(response);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching performance report:', error);
            }
        });
    }
    </script>
@endsection