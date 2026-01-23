@extends('home.partial.layout')

@section('content')
<style>
    .table-wrapper {
    max-height: 450px; /* Set the max height as needed */
    overflow-y: scroll;
}
thead.fixed-top{
        position: sticky;
        top:0;
    }
</style>
<main id="main" class="main">
    <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Shift Assign</h1>
                        <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Shift Assign</li>
                        </ol>
                        </nav>
                        
                    </div>
                </div>
            

                <!--<div class="col-auto float-right ml-auto" style="margin-bottom: 30px;">
                <a href="#" data-toggle="modal" data-target="#add_appraisal" class="btn btn-primary add-btn" style="padding-bottom: 8px;"><i class="bi bi-plus-lg"></i>Add Appraisal</a>
                </div>-->

            </div>
           
           
        </div>
       

        <!-- /Page Header -->

        <!-- Search Filter -->
        <form action="#" id="employee-searched-form">
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
                                <select id="dept" name="dept" class="form-control" style="color: #8D8D8D;">                
                                <option value="0" selected>Choose Department...</option>
                                    @forelse (masterDropdown('departments') as $designation)
                                    <option value="{{$designation->id}}">{{$designation->name}}</option>
                                    @empty
                                    <option>No data available</option>
                                    @endforelse
                                </select>
                    </div>
                </div>
                <!-- <div class="col-md-2">  
                    <div class="form-group">
                        <label for="inputName5" name="doj" class="form-label">Joining Date</label>
                        <input type="date" class="form-control" id="inputName5" style="color: #8D8D8D;" placeholder="Enter Date">
                    </div>
                </div> -->
                <div class="col-md-2" style="padding-top: 33px;"> 
                    <button type="submit" class="btn btn-block btn-alpha">Search</button>  
                </div>
            </div>
        </form>

    <!-- /Search Filter -->
    <div class="row">
        <div class="col-md-12" style="margin-top: 20px;">
            <div class="table-container" style="overflow-x: auto;">
                <div class="table-responsive" style="max-height: 600px; overflow-y: scroll;">
                
                <table class="table table-striped custom-table datatable dataTable-selector" style="display: inline-table; padding: 5px;">
                        <thead class="fixed-top" style="background-color: #8D8D8D;">
                            <tr>
                                <th>Emp Name</th>
                                <th>Designations</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th style="padding-right: 40px;padding-left: 40px;">Shift</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody id="employee-list-container">
                            @foreach($employees as $employee)
                                <tr data-employee-id="{{ $employee->employee_id }}">
                                    <td>
                                        {{ $employee->name }} {{ $employee->lname }}
                                        <input  type="hidden" name="emp_id" value="{{$employee->employee_id}}">
                                    </td>
                                    <td>
                                        {{ $employee->designations }}
                                    </td>
                                    <td>
                                        {{$employee->start_date}}
                                    </td>
                                    <td>
                                        {{$employee->end_date}}
                                    </td>
                                    <td>
                                        {{$employee->shift}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function () {
    
    $('#employee-searched-form').submit(function (e) {
     
        e.preventDefault(); 
        var formData = $(this).serialize();
        $.ajax({
                type: 'POST',
                url: '{{ route("shift-assigned.filter") }}',
                data: formData,
                success: function (response) {
                    console.log(response);
                    var $employeeListContainer = $('#employee-list-container');
                    $employeeListContainer.empty(); // Clear existing content

                    $.each(response, function (index, employee) {
                        var $employeeRow = $('<tr data-employee-id="' + employee.employee_id + '"></tr>');
                        $employeeRow.append('<td>' + employee.name + ' ' + employee.lname + '</td>');
                        $employeeRow.append('<td>' + employee.designations + '</td>');
                        $employeeRow.append('<td>' + employee.start_date + '</td>');
                        $employeeRow.append('<td>' + employee.end_date + '</td>');
                        $employeeRow.append('<td>' + employee.shift + '</td>');

                    //     // Append shift dropdown
                    //     $.ajax({
                    //         type: 'GET',
                    //         url: '{{ route("get-shift-data") }}',
                    //         success: function (shiftData) {
                    //             var shiftSelectHtml = '<select name="shift" class="form-control shift-select" data-empid="' + employee.employee_id + '">' +
                    //                 '<option value="">choose..</option>';

                    //             $.each(shiftData, function (valId, valName) {
                    //                 var selected = (valName === employee.shift) ? 'selected' : '';
                    //                 shiftSelectHtml += '<option value="' + valName + '" ' + selected + '>' + valId + '</option>';
                    //             });

                    //             shiftSelectHtml += '</select>';
                    //             $employeeRow.append('<td>' + shiftSelectHtml + '</td>');

                    //             // Append buttons after the shift dropdown
                    //             $employeeRow.append('<td>' +
                    //                 '<button type="button" class="btn btn-sm btn-primary assign-btn">Assign</button>' +
                    //                 '<button type="button" class="btn btn-sm btn-warning edit-btn" onclick="edit_assign(' + employee.employee_id + ')">' +
                    //                 '<i class="bi bi-pencil"></i>' +
                    //                 '</button>' +
                    //                 '</td>');

                    //             // Append the entire row to the table
                    //             $employeeListContainer.append($employeeRow);
                    //         },
                    //         error: function (xhr, status, error) {
                    //             console.error(xhr.responseText);
                    //         }
                    //     });
                    $employeeListContainer.append($employeeRow);
                    });
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
    });
});
</script>
@endsection