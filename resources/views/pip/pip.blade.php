@extends('home.partial.layout')
@auth
    @php
        $user = Auth::user();
        $role = $user->role;
    @endphp
@endauth
@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<main id="main" class="main">

<div class="pagetitle">
  <div class="row align-items-center">

    <div class="col">
      <div class="pagetitle">
        <h1>Performance Improvement Plan</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Performance Improvement Plan</li>
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


<!-- /Search Filter -->

<div class="row">
  <div class="col-md-12" style="margin-top: 20px;">
    <div class="table-responsive">
      <table class="table table-striped custom-table datatable dataTable-selector" style="display: inline-table; padding: 5px;">
        <thead>
          <tr>
            <th>Emp Name</th>
            <th>Emp No.</th>
            <th>Designation</th>
            <th>D.O.J</th>
            <!-- <th>Department</th> -->
            <th>Pip Date</th>
            <th>Scf Status</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        @foreach($employees as $employee)    
          <tbody>
            <tr role="row" class="odd">
              <td>
                <h2 class="table-avatar">
                  <!--<a href="Profile-FAS HRMS.html"><img class="avatar avatar-xs" src="assets/img/profile-img.jpg"></a>-->
                  <a href="{{route('employees.show', $employee->user_id)}}">{{$employee->name}}&nbsp;{{$employee->lname}}<span>@if($employee->designations){{$employee->designations->name}}@else @endif</span></a>
                </h2>
              </td>
              <td class="sorting_1">{{$employee->employee_no}}</td>
              <td>@if($employee->designations){{$employee->designations->name}}@else @endif</td>
              <td>@if(NULL!=$employee->joiningdate) {{date('d-m-Y', strtotime($employee->joiningdate))}} @endif</td>
              <!-- <td>{--@if($employee->departments){{$employee->departments->name}}@else @endif--}</td> -->
              <td>
                @if($employee->scf != null)
                 {{ $employee->scf->pip_required == 1 ? "SCF Intiated" : "" }}
                @else
                @endif
              </td>
              <td>
              @if($employee->pip) {{date('d-m-Y', strtotime($employee->pip->date))}} @endif
              </td>
              <td>            
                @if($user->hasRole('Principal') ||$user->hasRole('Vp') || $user->hasRole('Hr') )
                    @if($employee->pip)
                      <i class="fa fa-dot-circle-o text-success" title="Reviewed"></i>
                    @endif
                @endif
              </td>
              <td>               
                <?php
                  $employeeJson = json_encode($employee);
                ?>              
                @if($user->hasRole(VP_ROLE) || $user->hasRole('Principal')|| $user->hasRole('Executive-Admin'))
                  @if($employee->pip)
                    <div class="action-btn bg-yellow-500 ms-2" style="margin-left: 0px !important;">
                      <a href="#" data-target=".pip_modal" data-toggle="modal" onclick="editEmployeeDetails('{{$employee->pip->id}}')"  data-id="{{$employee->id}}" >
                        <i class="bi bi-pencil" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                      </a>
                    </div>
                  @else
                    <div class="action-btn bg-green-500 ms-2" style="margin-left: 0px !important;">
                      <a href="#" data-target=".pip_modal" data-toggle="modal" onclick="getEmployeeDetails('{{$employee->id}}')"  data-id="{{$employee->id}}" >
                                <i class="bi bi-plus-lg" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                      </a>
                    </div> 
                  @endif
                @endif
                  <!--<a href="#" data-toggle="modal" data-target="#edit_appraisal" data-employee="{{ $employee }}">-->
                
                  @if($employee->pip)
                  <div class="action-btn bg-blue-500 ms-2" style="margin-left: 0px !important;">
                  <a href="#" data-target=".pip_modal" data-toggle="modal" onclick="viewEmployeeDetails('{{$employee->pip->id}}')"  data-id="{{$employee->id}}">
                        <i class="bi bi-eye"
                            style="font-size: 15px; display: flex; color: #ffffff;"></i>
                    </a>
                    </div> 
                  @endif
                  @if($user->hasRole(SUPER_ADMIN_ROLE))
                    @if($employee->pip)
                    <div class="action-btn bg-red-500 ms-2">
                      <a href="{{route('pip.delete',$employee->pip->id)}}" >
                        <i class="bi bi-trash" style="font-size: 15px; display: flex; color: #ffffff;"></i>
                      </a>
                    </div>
                    @endif
                  @endif
              </td>
            </tr>
          </tbody>
        @endforeach
      </table>
    </div>
  </div>
</div>

<!-- /Page Content -->

<!-- Add Performance Appraisal Modal -->
<!-- /Add Performance Appraisal Modal -->

<div id="pip_modal" class="modal pip_modal   custom-modal fade" role="dialog" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl"  role="document">
    <div class="modal-content" >
      <div class="modal-header">
        <h5 class="modal-title">
            Performance Improvement Plan (PIP)
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
<!-- Edit Performance Appraisal Modal -->
<!--<div class="modal fade" class="edit_appraisal" tabindex="-1" role="dialog" aria-labelledby="edit_appraisalLabel" aria-hidden="true">-->

 <!--content start-->



<!-- /Edit Performance Appraisal Modal -->

<!-- Delete Performance Appraisal Modal -->

<div class="modal custom-modal  fade" id="delete_appraisal" role="dialog">
<div class="modal-dialog  modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-body">
      <div class="form-header">
        <h3>Delete Performance Appraisal</h3>
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

<!-- /Delete Performance Appraisal Modal -->

  </div>

</main><!-- End #main -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 
//get appraisal modal
function getEmployeeDetails(employeeId) {
        $.ajax({
            url: 'pip/get-employee-details',
            method: 'POST',
            data: {
                employee_id: employeeId,
                _token:"{{csrf_token()}}",
            },
            success: function(response) {
                // do something with the response, e.g. open a modal window
                console.log(response);
                  $('#update-content').html(response);
                  //$('#edit_appraisal').modal('show'); // Display the modal

                   
            },
            error: function(xhr, status, error) {
                // handle any errors
                console.error(error);
            }
        });
    }
//Appraisal edit modal
    function editEmployeeDetails(employeeId) {
        $.ajax({
            url: 'pip/edit-employee-details',
            method: 'POST',
            data: {
                employee_id: employeeId,
                _token:"{{csrf_token()}}",
            },
            success: function(response) {
                // do something with the response, e.g. open a modal window
                console.log(response);
                  $('#update-content').html(response);
                  //$('#edit_appraisal').modal('show'); // Display the modal

                   
            },
            error: function(xhr, status, error) {
                // handle any errors
                console.error(error);
            }
        });
    }

//Appraisal edit modal
function viewEmployeeDetails(employeeId) {
        $.ajax({
            url: 'pip/show',
            method: 'POST',
            data: {
                employee_id: employeeId,
                _token:"{{csrf_token()}}",
            },
            success: function(response) {
                // do something with the response, e.g. open a modal window
                console.log(response);
                  $('#update-content').html(response);
                  //$('#edit_appraisal').modal('show'); // Display the modal

                   
            },
            error: function(xhr, status, error) {
                // handle any errors
                console.error(error);
            }
        });
    }

</script>

@endsection