@extends('home.partial.layout')
@php
use Carbon\Carbon;

@endphp

@section('content')


<main id="main" class="main">

<!-- Page Header -->

<div class="pagetitle">
<div class="row align-items-center">

    <div class="col">
        <div class="pagetitle">
            <h1>Monthly Deduction</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Monthly Deduction</li>
            </ol>
            </nav>
        </div>
    </div>
        @if (session()->has('success'))
            <div class="alert alert-success al-sign" style="margin-left: 15px; width: 97.5%;">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 97.5%;">
                {{ session('error') }}
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

    
    </div>

</div>
</div>

    <!-- Search Filter -->

    <form action="{{route('deduction.emploees_filter')}}" method="post">
        @csrf
        <div class="row">

      
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group form-focus">
                    <label class="focus-label">Emp ID</label>
                    <input type="text" name="emp_id" class="form-control floating">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group form-focus">
                    <input type="text" name="emp_name" class="form-control floating">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>

            <div class="col-md-2">
                <select id="inputEmail5" name="department" class="form-select form-group form-focus" style="color: #8D8D8D;">
                    <option value="0" selected>Choose Department...</option>
                    @forelse (masterDropdown('departments') as $designation)
                    <option value="{{$designation->id}}">{{$designation->name}}</option>
                    @empty
                    <option>No data available</option>
                    @endforelse
                </select>
            </div>


            <div class="col-md-2" style="padding-top: 7px;">
                <button type="submit" class="btn btn-block btn-alpha">Search</button>
            </div>

        </div>
    </form>

    <!-- /Search Filter -->

<div class="row">
    <div class="col-md-12" style="margin-top: 30px;">
    <div class="table-responsive">
        <table class="table table-striped custom-table datatable dataTable-selector" style="display: inline-table; padding: 5px;">
        <thead>
            <tr>
            <th>Emp
                <br> Name</th>
            <th>Emp ID</th>
            <th>Month </th>
            <th>Department</th>
            <th>Deduction
                <br> Reason</th>
            <th>Deduction
                <br> Amount</th>
            <th>Remarks</th>
          
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
               
            <tr>
                <td>
                    <h2 class="table-avatar">
                    <!--<a href="Profile-FAS HRMS.html"><img class="avatar avatar-xs" src="assets/img/profile-img.jpg"></a>-->
                    <a href="#">{{$employee->name}}{{$employee->lname}}<span>@if($employee->designations){{$employee->designations->name}}@else @endif</span></a>
                    </h2>
                </td>
                <td>{{$employee->employee_no}}</td>
                <td>
                @if ($employee->employeeDeduction)
                    {{$employee->employeeDeduction->month_year}}
                @else

                @endif
                </td>
                <td>{{ $employee->employeeDepartment->name }}</td>
                <td>
                @if ($employee->employeeDeduction)
                    @foreach(json_decode($employee->employeeDeduction->deduction_reason) as $reason) {{$reason}}<br> @endforeach
                @else
                    0
                @endif
                </td>
                <td>
                @if ($employee->employeeDeduction)
                    @foreach(json_decode($employee->employeeDeduction->deduction_amount) as $amount) {{$amount}}<br> @endforeach
                @else
                 0
                @endif
                </td>
                <td>
                @if ($employee->employeeDeduction)
                    {{ $employee->employeeDeduction->remarks }}
                @else
                 
                @endif
                </td>
               
                <td>
                    <!--<div class="action-btn bg-cyan-500 ms-2">
                    <a href="#" data-toggle="modal" data-target="#view_payroll">
                        <i class="bi bi-eye" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                    </a>
                    </div>-->
                    @if ($employee->employeeDeduction)
                        <div class="action-btn bg-yellow-500 ms-2" style="margin-left: 0px !important;">
                        <a href="#" data-toggle="modal" onclick="deduction('{{$employee->employeeDeduction->id}}')"  data-target=".add_payroll" data-id="{{$employee->id}}" class="earinings">
                            <i class="bi bi-pencil-square" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                        </a>
                        </div>
                    @else
                        <div class="action-btn bg-green-500 ms-2" style="margin-left: 0px !important;">
                            <a href="#" data-toggle="modal" data-target=".add_payroll" data-id="{{$employee->id}}" class="earinings">
                                <i class="bi bi-plus-lg" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                            </a>
                        </div>
                    @endif
                    <!--<div class="action-btn bg-red-500 ms-2">
                    <a href="#" data-toggle="modal" data-target="#delete_payroll">
                        <i class="bi bi-trash" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                    </a>
                    </div>-->
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    </div>
</div>

<!-- /Page Content -->

<!-- Add Payroll Modal -->

<div id="add_payroll" class="modal add_payroll  custom-modal fade" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

        <div class="modal-header">
        <h5 class="modal-title">Add Employee Deduction</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>

        <div class="modal-body">

            <form action="{{route('deduction.store')}}" id="edit_payroll" method="post"  data-csrf-token="{{ csrf_token() }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="row">

                        <div class="col-sm-12" style="margin-top: 20px;">
                            <label class="form-label fw-bold">Month</label>
                            <select class="form-select" name="chose_month" id="chose_month" required>
                                <option value="">Choose Month...</option>
                                @if(''!=$last_payroll_date && ''!=$months)
                                    @foreach($months as $value => $month)
                                        <option value="{{ $value }}" {{ $value !== $nextMonth->format('F-Y') ? 'disabled' : "style=font-weight:bold;" }}>{{ $month }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-12" style="margin-top: 20px; margin-bottom: 20px;">
                        <div class="card">
                            <div class="card-body">
                            <input type="hidden" name="emp_id" id="emp_id" value=""/>
                            <!--<input type="hidden" name="deduction_month" id="deduction_month" value=""/>-->
                            <div class="row">
                                    <div class="col-sm-12">
                                        <div class="bg-white">
                                       
                                        <table class="table-field table table-striped table-bordered table-condensed tab_logic turf" id="turf">
                                            <thead>
                                                <tr class="headings">
                                                    <td class="heading">Deduction Type</td>
                                                    <td class="heading">Amount</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id='addr1' class="calculation visible">
                                                    <td><select id="inputEmail5" class="form-select " style="color: #8D8D8D;" name="deduction_type[]">
                                                                                                                @foreach($options as $option)
                                                                                                                    <option>{{ $option }}</option>
                                                                                                                @endforeach
                                                                                                            </select></td>
                                                    <td class="length">
                                                    <input type="number" class="form-control " id="inputEmail5" style="color: #8D8D8D;" name="deduction_amount[]"value="">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table><br>
                                        <div><button type="button" id="add_row" class="btn btn-primary pull-left"><span class="glyphicon glyphicon-plus-sign"></span>  Add Row</button></div>
                                        <div><button type="button" id='delete_row' class="pull-right btn btn-danger"><span class="glyphicon glyphicon-minus-sign"></span>  Delete Row</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                    <label for="inputEmail5" class="form-label">Remarks</label>
                    <div class="col-12" style="padding: 0px;">
                        <textarea class="form-control" id="remarks" style="height: 100px; color: #8D8D8D;" name="remarks"></textarea>
                    </div>
                    </div></div>

                </div>

                <div class="submit-section">
                <button class="btn btn-primary submit-btn">Submit</button>
                </div>

            </form>

        </div>

    </div>
    </div>
</div>

<!-- /Add Payroll Modal -->

<!-- Delete Payroll Modal -->

<div class="modal custom-modal fade" id="delete_payroll" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-body">
            <div class="form-header">
            <h3>Delete Payroll Information</h3>
            <p>Are you sure want to delete?</p>
            </div>
            <div class="modal-btn delete-action">
            <div class="row">
                <div class="col-6">
                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                </div>
                <div class="col-6">
                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- /Delete Payroll Modal -->

</main><!-- End #main -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">

    $(document).on("click", ".earinings", function () {

        var empID = $(this).data('id');
        //var month_date = $('#month_date').val();
        $(".card-body #emp_id").val(empID);
        //$(".card-body #deduction_month").val(month_date);
        // $('.add_payroll').modal('show');
    });


$('.add_payroll').each(function() {
    var $wrapper = $('.multi-fields', this);
    $(".add-field", $(this)).click(function(e) {
        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('tr').val('').focus();
        $('.multi-field1:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
    });
    $('.multi-field .remove-field', $wrapper).click(function() {
        alert("delete");
        if ($('.multi-field1', $wrapper).length > 1)
            $(this).parent('.multi-field1').remove();
    });
});

var numRows = 2, ti = 5;

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function recalc() {
    var lt = 0,
        wt = 0,
        tt = 0;
    $("#turf").find('tr').each(function () {
        var l = $(this).find('input.length').val();
        var w = $(this).find('input.width').val();
        var dateTotal = (l * w);
        $(this).find('input.row-total').val(dateTotal ? dateTotal : "");
        wt += isNumber(w) ? parseInt(w, 10) : 0;
        lt += isNumber(l) ? parseInt(l, 10) : 0;
        tt += isNumber(dateTotal) ? dateTotal : 0;
    }); //END .each
    $("#length-grand-total").html(lt);
    $("#width-grand-total").html(wt);
    $("#table-grand-total").html(tt);
}

function addRow() {

    $('#addr' + numRows).html("<td class='length'><select id='inputEmail5' class='form-select' style='color: #8D8D8D;' name='deduction_type[]'>@foreach($options as $option)<option>{{ $option }}</option>@endforeach</select</td><td class='width'><input type='number' class='form-control' id='inputEmail5' style='color: #8D8D8D;' name='deduction_amount[]' value=''></td>");
    $('#turf tr:last').after('<tr id="addr' + (numRows + 1) + '" class="calculation visible"></tr>');
    numRows++;
}

function delRow() {
    if (numRows > 1) {
        $("#addr" + (numRows - 1)).remove();
        numRows--;
    }
}
$(function () {
    $("#turf").on("click", ".calculation", recalc);
    $("#turf").on("keyup blur", ".form-control", recalc);
    $("#turf").on("keyup", ".length:last", function () {
        if (!$(this).data("done")) { // only do this once per field
            $(this).data("done", true);
            addRow();
        }
    });
    $("#add_row").on("click",function() {addRow()});
    $("#delete_row").on("click",function() {delRow()});
});

function deduction(e) {
   
   var deductionId = $(this).data('id'); // 
   // Do something with the employee ID, such as pass it to a function or use it in an AJAX call
   //console.log("deduction ID:", e);
   $.ajax({
     url: 'deduction/' + e,
     type: "POST",
     data: {
       "_token": "{{ csrf_token() }}",
       id: e,
     },
     dataType: 'json',
     success: function (data) {
         console.log(data.remarks);

           var empID = JSON.parse(data.employee_id);
           var kp = JSON.parse(data.deduction_reason);
           var kv = JSON.parse(data.deduction_amount);
           var form = $('#edit_payroll');

           const array_combine = (keys, values) => {
           const result = {};
 
           for (const [index, key] of keys.entries()) {
               result[key] = values[index];
           }
               return result;
           }; 
           var res = array_combine(kp, kv);
           $('.table-field').html('');
           $.each(res,function(i,j){
               content = "<tr><td class='length'>"
               +"<select id='inputEmail5' class='form-select' style='color: #8D8D8D;' name='deduction_type[]'>"
               +"<option >Choose Deduction Type...</option>"
               +"<option" + (i === "Unpaid" ? " selected" : "") + ">Unpaid</option>"
               +"<option" + (i === "Disciplinary" ? " selected" : "") + ">Disciplinary</option>"
               +"<option"  + (i === "Continuous Allowance" ? " selected" : "") + ">Continuous Allowance</option>"
                +"<option"  + (i === "Temporary Allowance" ? " selected" : "") + ">Temporary Allowance</option></select>"
               +"</td><td class='width'><input type='number' class='form-control' id='inputEmail5' style='color: #8D8D8D;' name='deduction_amount[]' value="+j+"></td></tr>";
               $('.table-field').append(content);

               //$('#addr' + i).html("<td class='length'><select id='inputEmail5' class='form-select' style='color: #8D8D8D;' name='deduction_type[]'><option selected>Choose Additions Type...</option><option>Unpaid</option><option>Disciplinary</option></select></td><td class='width'><input type='number' class='form-control' id='inputEmail5' style='color: #8D8D8D;' name='additional_amount[]' value=''></td>");
           });
           $(".card-body #emp_id").val(empID);
           $("#remarks").val(data.remarks);
           $('#edit_payroll').removeAttr('action');
            form.append('<input type="hidden" name="_method" value="PUT">');
            form.attr('action', "{{url('deduction/update')}}" + '/' + data.id);
           //$('#edit_payroll').attr('action', "{{url('deduction/update')}}" + '/' + data.id);
     }
   });
 }

</script>
@endsection