@extends('home.partial.layout')

@section('content')
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
        <form action="#" method="post" id="employee-search-form">
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
                <div class="table-responsive">
                
                <table class="table table-striped custom-table datatable" style="display: inline-table; padding: 5px;">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th style="padding-right: 40px;padding-left: 40px;">Shift</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="employee-list-container">
                        @foreach($employes as $employee)
                            <tr data-employee-id="{{ $employee->employee_id }}">
                                <td>
                                    {{ $employee->employee_no }}
                                </td>
                                <td>
                                    {{ $employee->name }} {{ $employee->lname }}
                                    <input  type="hidden" name="emp_id" value="{{$employee->employee_id}}">
                                </td>
                                <td>
                                    {{ $employee->designations }}
                                </td>
                                <td>
                                    <input type="date" name="start_date" class="form-control" data-empid="{{ $employee->employee_id }}">
                                </td>
                                <td>
                                    <input type="date" name="end_date" class="form-control" data-empid="{{ $employee->employee_id }}">
                                </td>
                                <td>
                                    <select name="shift" class="form-control shift-select" data-empid="{{ $employee->employee_id }}">
                                        <option value="">choose..</option>
                                        @foreach(get_shift_data() as $valId => $valName)
                                            <option value="{{ $valName }}">{{ $valId }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary assign-btn">Assign</button>
                                    <button type="button" class="btn btn-sm btn-warning edit-btn" onclick="edit_assign({{ $employee->employee_id }})">
                                        <i class="bi bi-pencil"></i>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    // jQuery script to handle form submission for the clicked row
    // Use event delegation for dynamically added elements
    $('#employee-list-container').on('click', '.assign-btn', function() {
        var row = $(this).closest('tr');
        var empId = row.data('employee-id');
        var startDate = row.find('[name="start_date"]').val();
        var endDate = row.find('[name="end_date"]').val();
        var shift = row.find('[name="shift"]').val();

        // Prepare data for AJAX request
        var formData = {
            '_token': '{{ csrf_token() }}',
            'emp_id': empId,
            'start_date': startDate,
            'end_date': endDate,
            'shift': shift
        };

        $.post('{{ route('shift-assign.store') }}', formData, function (response) {
            // Handle the response from the server if needed
            console.log(response);
            alert('Assignment successful!');
            location.reload();
        })
        .fail(function (xhr, status, error) {
            // Handle the failure if needed
            console.error(xhr.responseText);
            alert('Assignment failed! Please try again.');
        });
    });

   //
    $('.assign-btn').click(function () {
        var row = $(this).closest('tr');
        var empId = row.find('[data-empid]').data('empid');
        var startDate = row.find('[name="start_date"]').val();
        var endDate = row.find('[name="end_date"]').val();
        var shift = row.find('[name="shift"]').val();

        // Prepare data for AJAX request
        var formData = {
            '_token': '{{ csrf_token() }}',
            'emp_id': empId,
            'start_date': startDate,
            'end_date': endDate,
            'shift': shift
        };

        $.post('{{ route('shift-assign.store') }}', formData, function (response) {
            // Handle the response from the server if needed
            console.log(response);
            alert('Assignment successful!');
            location.reload();
            })
            .fail(function (xhr, status, error) {
            // Handle the failure if needed
            console.error(xhr.responseText);
            alert('Assignment failed! Please try again.');
            });
    });

    
        
    
   /* function edit_assign(employeeId){
        var url = '{{ route("shift-assign.show", ":id") }}';
        url = url.replace(':id', employeeId);
        var $row = $('tr[data-employee-id="' + employeeId + '"]');

        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
                // Handle the success response
                console.log(response);
                var dateFrom = response.date_from;
                var dateEnd = response.date_end;
                var shift = response.shift_id;
                var $startDateTd = $row.find('[name="start_date"]');
                var $endDateTd = $row.find('[name="end_date"]');
                var $shiftSelect = $row.find('.shift-select[data-empid="' + employeeId + '"]');
                var $assign = $row.find('.assign-btn');
                console.log(shift);
                // Append date values to the <td> elements
                $startDateTd.val(dateFrom);
                $endDateTd.val(dateEnd);
                $shiftSelect.find('option[value="'+shift+'"]').prop('selected', true);
                $assign.text('Reassign');
                $assign.removeClass('assign-btn').addClass('reassign-btn');
                $assign.removeClass('btn-primary').addClass('btn-warning');
                // if (response.someCondition) {
                //     $assignBtn.text('Reassign');
                //     $assignBtn.removeClass('btn-primary').addClass('btn-warning');
                // } else {
                //     $assignBtn.text('Assign');
                //     $assignBtn.removeClass('btn-warning').addClass('btn-primary');
                // }
            },
            error: function(xhr, status, error) {
                // Handle the error response
                console.error(xhr.responseText);
            }
        });
    }
    */
    function edit_assign(employeeId) {
    var url = '{{ route("shift-assign.show", ":id") }}';
    url = url.replace(':id', employeeId);
    var $row = $('tr[data-employee-id="' + employeeId + '"]');
    var $reassignBtn = $row.find('.assign-btn'); // Updated class name

    $.ajax({
        type: 'GET',
        url: url,
        success: function(response) {
            // Handle the success response
            console.log(response);
            var assignId = response.id;
            var dateFrom = response.date_from;
            var dateEnd = response.date_end;
            var shift = response.shift_id;
            var $startDateTd = $row.find('[name="start_date"]');
            var $endDateTd = $row.find('[name="end_date"]');
            var $shiftSelect = $row.find('.shift-select[data-empid="' + employeeId + '"]');
            console.log(shift);

            
            $startDateTd.val(dateFrom);
            $endDateTd.val(dateEnd);
            $shiftSelect.find('option[value="'+shift+'"]').prop('selected', true);

            $reassignBtn.text('Update'); 
            $reassignBtn.removeClass('reassign-btn').addClass('update-btn'); 
            $reassignBtn.removeClass('btn-warning').addClass('btn-primary');

            $reassignBtn.off('click');
            $reassignBtn.on('click', function() {
                update_assign(employeeId,assignId);
            });
        },
        error: function(xhr, status, error) {
            // Handle the error response
            console.error(xhr.responseText);
        }
    });
}

function update_assign(employeeId,assignId) {
   // alert(employeeId);
    
    var row = $('tr[data-employee-id="' + employeeId + '"]');
    var empId = row.find('[data-empid]').data('empid');
    var startDate = row.find('[name="start_date"]').val();
    var endDate = row.find('[name="end_date"]').val();
    var shift = row.find('[name="shift"]').val();

    // Prepare data for AJAX request
    var formData = {
        '_token': '{{ csrf_token() }}',
        '_method': 'PUT', 
        'emp_id': empId,
        'assign_id': assignId,
        'start_date': startDate,
        'end_date': endDate,
        'shift': shift
    };

    $.ajax({
        type: 'POST', // You can use POST or PUT based on your Laravel routes
        url: '{{ route('shift-assign.update', ':id') }}'.replace(':id', assignId),
        data: formData,
        success: function(response) {
            // Handle the response from the server if needed
            console.log(response);
            alert('Update successful!');
            location.reload();
        },
        error: function(xhr, status, error) {
            // Handle the failure if needed
            console.error(xhr.responseText);
            alert('Update failed! Please try again.');
        }
    });
}
    $(document).ready(function () {
       
        $('#employee-search-form').submit(function (e) {
            e.preventDefault(); 
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route("shift-assign.filter") }}',
                data: formData,
                success: function (response) {
                    console.log(response);
                    var $employeeListContainer = $('#employee-list-container');
                    $employeeListContainer.empty(); // Clear existing content

                    $.each(response, function (index, employee) {
                        var $employeeRow = $('<tr data-employee-id="' + employee.employee_id + '"></tr>');
                        $employeeRow.append('<td>' + employee.employee_no + '</td>');
                        $employeeRow.append('<td>' + employee.name + ' ' + employee.lname + '</td>');
                        $employeeRow.append('<td>' + employee.designations + '</td>');
                        $employeeRow.append('<td>' + '<input type="date" name="start_date" class="form-control" >' + '</td>');
                        $employeeRow.append('<td>' + '<input type="date" name="end_date" class="form-control" >' + '</td>');

                        // Append shift dropdown
                        $.ajax({
                            type: 'GET',
                            url: '{{ route("get-shift-data") }}',
                            success: function (shiftData) {
                                var shiftSelectHtml = '<select name="shift" class="form-control shift-select" data-empid="' + employee.employee_id + '">' +
                                    '<option value="">choose..</option>';

                                $.each(shiftData, function (valId, valName) {
                                    var selected = (valName === employee.shift) ? 'selected' : '';
                                    shiftSelectHtml += '<option value="' + valName + '" ' + selected + '>' + valId + '</option>';
                                });

                                shiftSelectHtml += '</select>';
                                $employeeRow.append('<td>' + shiftSelectHtml + '</td>');

                                // Append buttons after the shift dropdown
                                $employeeRow.append('<td>' +
                                    '<button type="button" class="btn btn-sm btn-primary assign-btn">Assign</button>' +
                                    '<button type="button" class="btn btn-sm btn-warning edit-btn" onclick="edit_assign(' + employee.employee_id + ')">' +
                                    '<i class="bi bi-pencil"></i>' +
                                    '</button>' +
                                    '</td>');

                                // Append the entire row to the table
                                $employeeListContainer.append($employeeRow);
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
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