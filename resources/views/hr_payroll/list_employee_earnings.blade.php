@extends('home.partial.layout')
@php
$remarks				= $data->remarks ?? '';
$id				        = $data->id ?? '';
use Carbon\Carbon;

$startDate = Carbon::now();
$endDate = $startDate->copy()->addYears(1);

$months = [];
$currentDate = $startDate->copy();
while ($currentDate->lte($endDate)) {
    $months[$currentDate->format('F-Y')] = $currentDate->format('F Y');
    $currentDate->addMonth();
}

@endphp

@section('content')


<main id="main" class="main">

<!-- Page Header -->

<div class="pagetitle">
<div class="row align-items-center">

    <div class="col">
        <div class="pagetitle">
            <h1>Earnings</h1>
            <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Payroll</li>
                <li class="breadcrumb-item active">Earnings</li>
            </ol>
            </nav>
        </div>
    </div>
    <div class="col-auto float-right ml-auto" style="margin-bottom: 30px;">
        <a href="{{url('earnings-employees')}}" class="btn btn-primary add-btn" onclick="location.href='Employee Information-FAS HRMS.html'"
                style="padding-bottom: 8px;"><i class="bi bi-plus-lg"></i>Add Earnings</a>
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

    <!-- Search Filter -->

    <form action="{{route('earnings.search')}}" method="post">
        @csrf
  
        <div class="row">
            
            <div class="col-md-2">
                <div class="form-group">
                    <input type="month" name="earning_month" class="form-control" title="Earning Month">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" name="emp_id" class="form-control" placeholder="Emp ID">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" name="emp_name" class="form-control" placeholder="Employee Name">
                </div>
            </div>

            <div class="col-md-2">
                <select id="department" name="department" class="form-select form-group" style="color: #8D8D8D;">
                    <option value="0" selected>Department...</option>
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
            <div class="col-md-1" style="padding-top: 7px;">
                <a href="{{url('earnings')}}"><button type="button" class="btn btn-block btn-alpha">Clear</button></a>
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
            <th>Additional
                <br> Reason</th>
            <th>Additional
                <br> Amount</th>
            <th>Total Additional
                <br> Amount</th>
            <th>Remarks</th>
          
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($earnings as $earning)
            <tr>
                <td>
                    <h2 class="table-avatar">
                    <!--<a href="Profile-FAS HRMS.html"><img class="avatar avatar-xs" src="assets/img/profile-img.jpg"></a>-->
                    <a href="Profile-FAS HRMS.html">{{$earning->employee->name}}&nbsp;{{$earning->employee->lname}}<span>@if($earning->employee->designations){{$earning->employee->designations->name}}@else @endif</span></a>
                    </h2>
                </td>
                <td>{{employeeIdMaker($earning->employee_id)}}</td>
                <td>{{$earning->month_year}}</td>
                <td>{{$earning->employee->employeeDepartment->name}}</td>
                <td>@foreach(json_decode($earning->additional_reason) as $reasons){{$reasons}}<br>@endforeach</td>
                <td>@foreach(json_decode($earning->additional_amount) as $amount){{$amount}}<br>@endforeach</td>
                <td>{{$earning->total_addtional_amount  }}</td>
                <td>{{$earning->remarks}}</td>
               
                <td>
                    <!--<div class="action-btn bg-cyan-500 ms-2">
                    <a href="#" data-toggle="modal" data-target="#view_payroll">
                        <i class="bi bi-eye" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                    </a>
                    </div>-->
                    <div class="action-btn bg-yellow-500 ms-2" style="margin-left: 0px !important;">
                        <a href="#" class="additions" id="additions" onclick="earnings('{{$earning->id}}')" data-toggle="modal" data-target="#edit_payroll">
                         <i class="bi bi-pencil-square" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                        </a>
                    </div>
                    <div class="action-btn bg-red-500 ms-2">
                    <a href="{{url('/earnings/delete')}}/{{$earning->id}}" >
                        <i class="bi bi-trash" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                    </a>
                    </div>
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
<!--<div class="modal fade add_payroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->

<div id="edit_payroll" class="modal  custom-modal fade" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

        <div class="modal-header">
        <h5 class="modal-title">Edit Employee Additions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>

        <div class="modal-body">
            
            <form id="edit_payroll" method="POST" data-csrf-token="{{ csrf_token() }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="row">

                        <div class="col-sm-12" style="margin-top: 20px; margin-bottom: 20px;">
                        <div class="card">
                            <div class="card-body">
                            <input type="hidden" name="emp_id" id="emp_id" value=""/>
                            <input type="hidden" name="earning_month" id="earning_month" value=""/>
                            <div class="row">
                                    <div class="col-sm-12">
                                        <div class="bg-white">
                                       
                                        <table class="table-field table table-striped table-bordered table-condensed tab_logic turf" id="turf">
                                            <thead>
                                                <tr class="headings">
                                                    <td class="heading">Additions Type</td>
                                                    <td class="heading">Amount</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id='addr1' class="calculation visible">
                                                    <td><select id="inputEmail5" class="form-select " style="color: #8D8D8D;" name="additional_type[]">
                                                                                                                <option selected>Choose Additions Type...</option>
                                                                                                                <option>Fuel</option>
                                                                                                                <option>Additional Task</option>
                                                                                                            </select></td>
                                                    <td class="length">
                                                    <input type="number" class="form-control " id="inputEmail5" style="color: #8D8D8D;" name="additional_amount[]"value="">
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
                        <textarea class="form-control" id="remarks" style="height: 100px; color: #8D8D8D;" name="remarks" value="$remarks"></textarea>
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

<script>
//sending ajax request

    $.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

  function earnings(e) {
    var earningId = $(this).data('id'); // Get the employee ID from the data-id attribute
    
    $.ajax({
      url: 'earnings/' + e,
      type: "POST",
      data: {
        "_token": "{{ csrf_token() }}",
        id: e,
      },
      dataType: 'json',
      success: function (data) {          

            var empID = JSON.parse(data.employee_id);
            var kp = JSON.parse(data.additional_reason);
            var kv = JSON.parse(data.additional_amount);
   
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
                +"<select id='inputEmail5' class='form-select' style='color: #8D8D8D;' name='additional_type[]'>"
                +"<option>Choose Additions Type...</option>"
                +"<option" + (i === "Fuel" ? " selected" : "") + ">Fuel</option>"
                +"<option"  + (i === "Additional Task" ? " selected" : "") + ">Additional Task</option>"
                +"<option"  + (i === "Ticket Accrual" ? " selected" : "") + ">Ticket Accrual</option>"
                +"<option"  + (i === "Return Ticket" ? " selected" : "") + ">Return Ticket</option>"
                +"<option"  + (i === "Continuous Allowance" ? " selected" : "") + ">Continuous Allowance</option>"
                +"<option"  + (i === "Temporary Allowance" ? " selected" : "") + ">Temporary Allowance</option></select>"
                +"</td><td class='width'><input type='number' class='form-control' id='inputEmail5' style='color: #8D8D8D;' name='additional_amount[]' value="+j+"></td></tr>";
                $('.table-field').append(content);
            });
            $(".card-body #emp_id").val(empID);
            $("#remarks").val(data.remarks);
            $('#edit_payroll form').attr('action', "{{url('earnings/update')}}" + '/' + data.id);

          
      }
    });
  }

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

    $('#addr' + numRows).html("<td class='length'><select id='inputEmail5' class='form-select' style='color: #8D8D8D;' name='additional_type[]'><option selected>Choose Additions Type...</option><option>Fuel</option><option>Additional Task</option><option>Ticket Accrual</option><option>Return Ticket</option><option>Continuous Allowance</option><option>Temporary Allowance</option></select></td><td class='width'><input type='number' class='form-control' id='inputEmail5' style='color: #8D8D8D;' name='additional_amount[]' value=''></td>");
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
</script>
@endsection