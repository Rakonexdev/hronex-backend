@extends('home.partial.layout')
@section('content')
    <main id="main" class="main">
    <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Employees Details Report</h1>
                        <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Employee Reports</li>
                        </ol>
                        </nav>
                        
                    </div>
                </div>
            

                <!--<div class="col-auto float-right ml-auto" style="margin-bottom: 30px;">
                <a href="#" data-toggle="modal" data-target="#add_appraisal" class="btn btn-primary add-btn" style="padding-bottom: 8px;"><i class="bi bi-plus-lg"></i>Add Appraisal</a>
                </div>-->

            </div>
             
                <!-- <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Search Filter</label>
                            <input type="type" name="filter" id="filter" value="" class="form-control" required>
                        </div>
                    </div>
                                 
                    <div class="col-md-2" style="padding-top: 2rem;">                    
                        <button type="button" class="btn btn-block btn-alpha" onclick="filterBy()">Search</button>                    
                    </div>
                    <div class="col-md-2" style="padding-top: 2rem;">                    
                        <button type="button" class="btn btn-block btn-danger" onclick="resetBy()">Reset</button>                    
                    </div>
                </div> -->
           
            <div class="row">
                <div class="float-end">
                    <button type="button" class="btn btn-danger "><a href="{{ route('employeereportsExport', 'excel') }}" class="text-light">Download Excel</a></button>
                <!--    <button type="button" class="btn btn-danger"><a href="{!-- route('employeereportsExport', 'pdf') --}"  class="text-light">Download PDF</a></button> -->
                </div>
            </div>
           
        </div>
       

        <!-- /Page Header -->

        <!-- Search Filter -->
       

        <!-- /Search Filter -->
        <div class="row">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-striped custom-table datatable dataTable-selector smt-tabl" style="display: inline-table; padding: 5px;">
                        <thead class="fixed-th" style="position: sticky; top: 0;z-index:999;">
                        <tr style="position: sticky;top:0;background:#c2e0ab;z-index:99;">
                            <th  style="position: sticky;left:0;background:#c2e0ab; z-index:999;">Emp Name</th>
                            <th>Emp No.</th>
                            <th>Contact.</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Designations</th>
                            <th>Gender</th>
                            <th>DoB</th>
                            <th>Age</th>
                            <th>Nationality</th>
                            <th>Marital Status</th>
                            <th>Qid No</th>
                            <th>Qid Expiry</th>
                            <th>Passport No</th>
                            <th>Passport Expiry</th>
                            <th>Joining Date</th>
                            <th>Contract Length</th>
                            <th>Service Year</th>
                            <th>Basic Salary</th>
                            <th>Accomodation Allowance</th>
                            <th>Transport Allowance</th>
                            <th>Gross Total</th>
                            <th>Bank Name</th>
                            <th>Download</th>
                        </tr>
                        </thead>
                     
                        <tbody id="indData">
                            @foreach($employees as $employee)    
                            <tr>
                                <td class="fixed-td fw-bold" style="position: sticky;left:0;background:#c2e0ab; ">
                                    {{$employee->name}} {{$employee->lname}}
                                </td>
                                <td>
                                    {{$employee->employee_no}}
                                </td>
                                <td>
                                {{$employee->mobile1}}
                                </td>
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
                                    {{$employee->gender}}
                                </td>
                                <td>
                                    {{$employee->dob}}
                                </td>
                                <td>
                                    {{$employee->age}}
                                </td>
                                <td>
                                    {{$employee->nationality}}
                                </td>
                                <td>
                                    {{$employee->marital_status}}
                                </td>
                                <td>
                                    {{$employee->qidno}}
                                </td>
                                <td>
                                    {{$employee->qidexpiry}}
                                </td>
                                <td>
                                    {{$employee->passportno}}
                                </td>
                                <td>
                                    {{$employee->passportexpiry}}
                                </td>
                                <td>
                                    {{$employee->joiningdate}}
                                </td>
                                <td>
                                    {{$employee->contract_length}}
                                </td>
                                <td>
                                    {{$employee->service_years}}
                                </td>
                                <td>
                                    {{$employee->basic_salary}}
                                </td>
                                <td>
                                    {{$employee->accomodation_allowance}}
                                </td>
                                <td>
                                    {{$employee->transport_allowance}}
                                </td>
                                <td>
                                    {{$employee->gross_total}}
                                </td>
                                <td>
                                    {{$employee->bank_name}}
                                </td>
                                <th><button type="button" class="btn btn-danger "><a href="{{ route('employeereportsExportId', ['excel', $employee->employee_no]) }}" class="text-light">Download Excel</a></button></th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script>
        var APP_URL = {!! json_encode(url('/')) !!}
        function filterBy()
        {
            var data = $('#filter').val();
            // alert(data);
            $.ajax({
                url: APP_URL+'/employee-report/filter', 
                type: 'get',
                data: { filterData: data }, 
                success: function(response) {
                    $('#indData').html(response)
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
        function resetBy()
        {
            $.ajax({
                url: APP_URL+'/employee-report/reset', 
                type: 'get',
                // data: { filterData: data }, 
                success: function(response) {
                    $('#indData').html(response)
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
@endsection