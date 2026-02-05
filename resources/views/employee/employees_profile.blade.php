@extends('home.partial.layout')

@section('content')
  @can('employee_link')
  <main id="main" class="main">

    <div class="pagetitle">
      <div class="row align-items-center">

        <div class="col">
          <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Profile Details</li>
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
    <div class="card col-md-5" style="padding: 0px;">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="profile-view">
              <div class="profile-img-wrap">
                <div class="profile-img">
                  <a href="#"><img alt="" src="{{ asset('uploads/users/profile/' . $data->avatar) }}"></a>
                </div>
              </div>
              <div class="profile-basic">
                <div class="row">
                  <div class="col-md-12">
                    <div class="profile-info-left">
                      <h3 class="user-name m-t-0 mb-0" style="color: #012970;">{{$data->name}} {{$data->lname}}</h3>
                      <h6 class="text-muted">{{$data->designation_name ? $data->designation_name : 'Designation missing'}}</h6>
                      <small class="text-muted">{{$data->department_name ? $data->department_name : 'Department name missing'}}</small>
                      <div class="staff-id" style="color: #012970;">Employee ID : {{$data->employee_no}}</div>
                      <div class="small doj text-muted">Date of Join : {{$data->joiningdate ? date('jS M Y',
                        strtotime($data->joiningdate)): 'Date not added'}}</div>
                    </div>
                  </div>
                </div>
              </div>
              @can('profile-update')
              <div class="pro-edit"><a data-target="#profile_info_modal" data-toggle="modal" class="edit-icon" href="#"><i
                class="fa fa-pencil"></i></a></div>
              @endcan
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card tab-box">
      <div class="row user-tabs">
        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
          <ul class="nav nav-tabs nav-tabs-bottom">
            <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">Profile</a></li>
            @can('view_attachments')
            <li class="nav-item"><a href="#emp_attaches" data-toggle="tab" class="nav-link">Attachments</a></li>
            @endcan
            @can('master')
            <!-- <li class="nav-item"><a href="#emp_cred" data-toggle="tab" class="nav-link">Credentials</a></li> -->
            @endcan
          </ul>
        </div>
      </div>
    </div>

    <div class="tab-content">

      <!-- Profile Info Tab -->

      <div id="emp_profile" class="pro-overview tab-pane fade show active">
        <div class="row">

          <div class="col-lg-6">
            <div class="row">

              <div class="col-md-12 d-flex">
                <div class="card profile-box flex-fill">
                  <div class="card-body">
                    <h3 class="card-title">Employee Information
                    @can('profile-update')
                    <a href="#" class="edit-icon" data-toggle="modal"
                        data-target="#emp_info_modal"><i class="fa fa-pencil"></i></a>
                    @endcan
                    </h3>
                    <ul class="personal-info">
                      <li>
                        <div class="title">Employee No.</div>
                        <div class="text">{{$data->employee_id ? $data->employee_no : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Employee Name</div>
                        <div class="text">{{$data->employee_id ? $data->name : '----------'}} {{$data->lname}}</div>
                      </li>
                      <li>
                        <div class="title">QID</div>
                        <div class="text"><a>{{$data->qidno ? $data->qidno : '----------'}}</a></div>
                      </li>
                      <li>
                        <div class="title">QID Expiry</div>
                        <div class="text">{{$data->qidexpiry ? date('jS M Y', strtotime($data->qidexpiry)): '----------'}}
                        </div>
                      </li>
                      <li>
                        <div class="title">Passport No.</div>
                        <div class="text">{{$data->passportno ? $data->passportno : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Passport Expiry</div>
                        <div class="text">{{$data->passportexpiry ? date('jS M Y', strtotime($data->passportexpiry)):
                          '----------'}}</div>
                      </li>
                      <!--Visa details -->
                     <li>
                        <div class="title">Visa Type</div>
                        <div class="text">{{$data->visa_type ? $data->visa_type : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Visa No.</div>
                        <div class="text">{{$data->visa_number ? $data->visa_number : '----------'}}</div>
                      </li>
                       <li>
                        <div class="title">Visa Issue Date</div>
                        <div class="text">{{$data->visa_issue_date ? $data->visa_issue_date : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Visa Expiry Date</div>
                        <div class="text">{{$data->visa_expiry_date ? $data->visa_expiry_date : '----------'}}</div>
                      </li>
                      <!--Visa details end-->
                      <li>
                        <div class="title">Gender</div>
                        <div class="text">{{$data->gender ? $data->gender : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">DOB</div>
                        <div class="text">{{$data->dob ? date('jS M Y', strtotime($data->dob)): '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Age</div>
                        <div class="text">{{$data->age ? \Carbon\Carbon::parse($data->dob)->diff(date('Y-m-d'))->format('%y') : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Marital Satus</div>
                        <div class="text">{{$data->marital_status ? $data->marital_status : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Email Address</div>
                        <div class="text"><a>{{$data->email ? $data->email : '----------'}}</a></div>
                      </li>
                      <li>
                        <div class="title">School Shift</div>
                        <div class="text">{{$data->shift_name ? $data->shift_name : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Date of Joining</div>
                        <div class="text">{{$data->joiningdate ? date('jS M Y', strtotime($data->joiningdate)):
                          '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">End of Probation</div>
                        <div class="text">{{$data->end_probation ? date('jS M Y', strtotime($data->end_probation)):
                          '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Contract Type</div>
                        <div class="text">{{$data->contract_type_name ? $data->contract_type_name : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Contract Length</div>
                        <div class="text">{{$data->contract_length ? $data->contract_length : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">End of Contract Date</div>
                        <div class="text">{{$data->end_contract ? date('jS M Y', strtotime($data->end_contract)):
                          '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Service Years</div>
                        <div class="text"><a>{{$data->service_years ? $data->service_years : '----------'}}</a></div>
                      </li>
                      <li>
                        <div class="title">Current Position</div>
                        <div class="text">{{$data->designation_name ? $data->designation_name : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Current Department</div>
                        <div class="text">{{$data->department_name ? $data->department_name : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Nationality</div>
                        <div class="text">{{$data->country_name ? $data->country_name : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Primary Contact No:</div>
                        <div class="text">{{$data->mobile1_code ? '+'. $data->mobile1_code : ''}} {{$data->mobile1 ? $data->mobile1 : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Secondary Contact No:</div>
                        <div class="text">{{$data->mobile2_code ? '+'. $data->mobile1_code : ''}} {{$data->mobile2 ? $data->mobile2 : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Sponsorship Status</div>
                        <div class="text"><a>{{$data->sponsorship_status_name ? $data->sponsorship_status_name :
                            '----------'}}</a></div>
                      </li>
                      <li>
                        <div class="title">Relevent Degree</div>
                        <div class="text">{{$data->relevant_degree_name ? $data->relevant_degree_name : '----------'}}
                        </div>
                      </li>
                      <li>
                        <div class="title">Degree Details</div>
                        <div class="text">{!! $data->degree_details ? nl2br($data->degree_details) : '----------' !!}
                        </div>
                      </li>
                      <li>
                        <div class="title">Degree Attestation Status</div>
                        <div class="text">{{$data->degree_attest_status ?
                          degreeAttestationStatus($data->degree_attest_status) : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Other Qualifications</div>
                        @if($data->other_qualifications)
                        <div class="text">
                        @foreach(unserialize($data->other_qualifications) as $other_qualification)
                        {{$other_qualification}} <br>
                        @endforeach
                        </div>
                        @else
                        <div class="text">----------</div>
                        @endforelse
                      </li>
                      <li>
                        <div class="title">Disclaimer Letter (MOE)</div>
                        <div class="text">{{$data->disclaimer_ltr_moe ? $data->disclaimer_ltr_moe : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Declaration Letter (MOE)</div>
                        <div class="text">{{$data->declaration_ltr_moe ? $data->declaration_ltr_moe : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">HR Comments</div>
                        <div class="text">{{$data->hrcomment ? $data->hrcomment : '----------'}}</div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="col-lg-6">
            <div class="row">

            @can('view_payroll_basics')
              <div class="col-md-12 d-flex">
                <div class="card profile-box flex-fill">
                  <div class="card-body">
                    <h3 class="card-title">Payroll Information
                      @can('profile-update')
                      <a href="#" class="edit-icon" data-toggle="modal"
                        data-target="#payroll_info_modal"><i class="fa fa-pencil"></i></a>
                      @endcan
                      </h3>
                    <ul class="personal-info">
                      <li>
                        <div class="title">Basic Salary</div>
                        <div class="text">{{$data->basic_salary ? $data->basic_salary : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Accomodation Allowance</div>
                        <div class="text">{{$data->accomodation_allowance ? $data->accomodation_allowance : '----------'}}
                        </div>
                      </li>
                      <li>
                        <div class="title">Transport Allowance</div>
                        <div class="text"><a>{{$data->transport_allowance ? $data->transport_allowance : '----------'}}</a></div>
                      </li>
                      <li>
                        <div class="title">Continuous Allowance</div>
                        <div class="text">{{$data->continuous_allowance ? $data->continuous_allowance : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Temporary Allowance</div>
                        <div class="text">{{$data->temp_allowance ? $data->temp_allowance : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Other Allowance</div>
                        <div class="text">{{$data->other_allowance ? $data->other_allowance : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Gross Total</div>
                        <div class="text">{{$data->gross_total ? $data->gross_total : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Bank Name</div>
                        <div class="text">{{$data->bank_name ? $data->bank_name : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Account No:</div>
                        <div class="text">{{$data->account_no ? $data->account_no : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">IBAN No:</div>
                        <div class="text">{{$data->iban_no ? $data->iban_no : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Salary Payment Effective From</div>
                        <div class="text">{{$data->salary_effective_from ? date('jS M Y',
                          strtotime($data->salary_effective_from)): '----------'}}</div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              @endcan

              <div class="col-md-12 d-flex">
                <div class="card profile-box flex-fill">
                  <div class="card-body">
                    <h3 class="card-title">Health Information
                      @can('profile-update')
                      <a href="#" class="edit-icon" data-toggle="modal"
                        data-target="#health_info_modal"><i class="fa fa-pencil"></i></a>
                      @endcan
                      </h3>
                    <ul class="personal-info">
                      <li>
                        <div class="title">HMC Card No:</div>
                        <div class="text">{{$data->hmc_card_no ? $data->hmc_card_no : '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Health Insurance Status</div>
                        <div class="text">{{(1==$data->health_insurance_status) ? 'Yes' : 'No'}}</div>
                      </li>
                      <li>
                        <div class="title">Mention the name of your health insurance (if any)</div>
                        <div class="text"><a>{{$data->health_insurance_name ? $data->health_insurance_name :
                            '----------'}}</a></div>
                      </li>
                      <li>
                        <div class="title">Does the employee suffer from any medical conditions</div>
                        <div class="text">{{(1==$data->medical_ailment_physical) ? 'Yes' : 'No'}}</div>
                      </li>
                      <li>
                        <div class="title">Mention Details (if any)</div>
                        @if($data->physical_details)
                        @foreach(unserialize($data->physical_details) as $physical_detail)
                        <div class="text">{{$physical_detail}}</div>
                        @endforeach
                        @else
                        <div class="text">----------</div>
                        @endif
                      </li>
                      <li>
                        <div class="title">Does the employee suffer from any mental health</div>
                        <div class="text">{{(1==$data->medical_ailment_mental) ? 'Yes' : 'No'}}</div>
                      </li>
                      <li>
                        <div class="title">Mention Details (if any)</div>
                        @if($data->mental_details)
                        @foreach(unserialize($data->mental_details) as $mental_detail)
                        <div class="text">{{$mental_detail}}</div>
                        @endforeach
                        @else
                        <div class="text">----------</div>
                        @endforelse
                      </li>
                      <li>
                        <div class="title">Mention the name of medication taken (if any)</div>
                        <div class="text">{{$data->medication_details ? $data->medication_details : '----------'}}</div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-md-12 d-flex">
                <div class="card profile-box flex-fill">
                  <div class="card-body">
                    <h3 class="card-title">Emergency Details
                      @can('profile-update')
                      <a href="#" class="edit-icon" data-toggle="modal"
                        data-target="#emerg_detail_modal"><i class="fa fa-pencil"></i></a>
                      @endcan
                      </h3>
                    <ul class="personal-info">
                      <li>
                        <div class="title">Primary Emergency Contact Name</div>
                        <div class="text">{{$data->emergency_primary_name ? $data->emergency_primary_name : '----------'}}
                        </div>
                      </li>
                      <li>
                        <div class="title">Relationship</div>
                        <div class="text">{{$data->relationship_primary_name ? $data->relationship_primary_name :
                          '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Primary Emergency Contact No:</div>
                        <div class="text"><a>{{$data->emergency_primary_contact ? $data->emergency_primary_contact :
                            '----------'}}</a></div>
                      </li>
                      <li>
                        <div class="title">Secondary Emergency Contact Name</div>
                        <div class="text">{{$data->emergency_secondary_name ? $data->emergency_secondary_name :
                          '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Relationship</div>
                        <div class="text">{{$data->relationship_secondary_name ? $data->relationship_secondary_name :
                          '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Secondary Emergency Contact No:</div>
                        <div class="text">{{$data->emergency_secondary_contact ? $data->emergency_secondary_contact :
                          '----------'}}</div>
                      </li>
                      <li>
                        <div class="title">Employee Remarks</div>
                        <div class="text">{{$data->comment ? $data->comment : '----------'}}</div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
      <div id="emp_attaches" class="pro-overview tab-pane fade show">
        <div class="row">

          <div class="col-lg-12 d-flex">

            <div class="card profile-box flex-fill">
              <div class="card-body">
                <h3 class="card-title">Attachments</h3>


                  <div class="col-sm-8 tab-content no-bg no-border">
                    <div class="tab-pane active documents documents-panel">

                        <!-- Add attachment Informations -->
                        @include("employee.partials.attaches")

                      </div>
                    </div>

                  </div>
            </div>
            
          </div>

        </div> <!-- row -->
      </div> <!-- emp_attaches -->

      <!-- /Profile Info Tab -->
    @can('master')
      <div id="emp_cred" class="pro-overview tab-pane fade">
        <div class="row">
          <div class="col-lg-6">
            <div class="row">
              
                <div class="card profile-box flex-fill">
                  <div class="card-body">
                    <h3 class="card-title">Update Credentials</h3>

                        <form class="row g-3" action="{{route('reset.employee.password')}}" method="post">
                          @csrf
                          <div class="col-md-12">
                              <input type="hidden" name="user_id_pass" id="user_id_pass" value="{{$data->userid}}">
                              <label for="password" class="form-label">Password</label>
                              <input type="password" name="password" class="form-control" id="password" style="color: #8D8D8D;" required>
                          </div>
                          <div class="col-md-12">
                              <label for="password_confirmation" class="form-label">Confirm Password</label>
                              <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" style="color: #8D8D8D;" required>
                          </div>
                          <div class="col-md-6" style="width: 100%; margin-top: 25px;">
                              <button type="submit" class="btn btn-primary" style="width: 50%;">Save</button>
                          </div>
                      </form>
                  </div>
                </div>

              
            </div>
          </div>
        </div>
      </div>    
    @endcan
    </div>

    <!-- Modals -->

    <div id="profile_info_modal" class="modal custom-modal fade" role="dialog" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Profile Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{route('employees.update', $data->userid)}}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-md-12">
                  <div class="profile-img-wrap edit-img">
                    <img class="inline-block" id="profileUpload" src="{{ asset('uploads/users/profile/' . $data->avatar) }}" alt="user">
                    <div class="fileupload btn">
                      <span class="btn-text">Edit</span>
                      <input class="upload" name="avatar" id="profileImg" accept="image/*" type="file">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="name" class="form-label">First Name</label>
                        <input type="text" name="name" value="{{$data->name}}" class="form-control" id="name"
                          style="color: #8D8D8D;">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" name="lname" value="{{$data->lname}}" class="form-control" id="lname"
                          style="color: #8D8D8D;">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="department" class="form-label">Department</label>
                    <select id="department" name="department" class="form-select" style="color: #8D8D8D;">
                      <option value="0" {{$data->department ? '' : 'selected' }}>Choose Department...</option>
                      @foreach(masterDropdown('departments') as $department)
                      <option value="{{$department->id}}" {{$data->department == $department->id ? 'selected' : '' }}>
                        {{$department->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="designation" class="form-label">Designation</label>
                    <select id="designation" name="designation" class="form-select" style="color: #8D8D8D;">
                      <option value="0" {{$data->designation ? '' : 'selected' }}>Choose Department...</option>
                      @foreach(masterDropdown('designations', 'status') as $designation)
                      <option value="{{$designation->id}}" {{$data->designation == $designation->id ? 'selected' : '' }}>
                        {{$designation->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="submit-section">
                <button type="submit" class="btn btn-primary submit-btn">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div id="emp_info_modal" class="modal custom-modal fade" role="dialog" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Employee Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="row g-3" id="employee_data" action="{{route('employees-information.update', $data->userid)}}" method="post"
              data-csrf-token="{{ csrf_token() }}" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="col-md-12">
                <label for="employee_id" class="form-label">Employee No.</label>
                <input type="text" name="temp_employee_id" value="{{employeeIdMaker($data->employee_id)}}" class="form-control hidee" id="temp_employee_id" readonly
                  style="color: #8D8D8D;">
                <input type="text" name="employee_no" value="@if(NULL!=$data){{$data->employee_no}}@endif" class="form-control"
              id="employee_no" required>
                <input type="hidden" name="employee_id" value="{{ $data->employee_id }}" class="form-control" id="employee_id" readonly
                  style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="name" class="form-label">Employee Name (as per QID) *</label>
                <input type="text" name="name" value="{{ $data->name}}" class="form-control" id="name"
                  placeholder="First Name" style="color: #8D8D8D;">
              </div>
              <div class="col-md-6" style="padding-top: 31px;">
                <input type="text" name="lname" value="{{$data->lname}}" class="form-control" id="lname"
                  placeholder="Last Name" style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="dob" class="form-label">DOB *</label>
                <input type="date" name="dob" value="{{$data->dob}}" class="form-control" id="dob"
                  style="color: #8D8D8D;" onchange="cust.calculateAge();">
              </div>
              <div class="col-md-6">
                <label for="age" class="form-label">Age</label>
                <input type="number" name="age" value="{{\Carbon\Carbon::parse($data->dob)->diff(date('Y-m-d'))->format('%y');}}" class="form-control" id="age"
                  style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="gender" class="form-label">Gender *</label>
                <select id="gender" name="gender" class="form-select" style="color: #8D8D8D;">
                  <option {{$data->gender ? '' : 'selected' }}>Choose Gender...</option>
                  <option value="Male" {{$data->gender =='Male' ? 'selected' : '' }}>Male</option>
                  <option value="Female" {{$data->gender =='Female' ? 'selected' : '' }}>Female
                  </option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="nationality" class="form-label">Nationality *</label>
                <select id="nationality" name="nationality" class="form-select" style="color: #8D8D8D;">
                  <option {{$data->nationality ? '' : 'selected' }}>Choose Nationality...</option>
                  @foreach(masterDropdown('countries', 'status') as $country)
                  <option value="{{$country->id}}" {{$data->nationality == $country->id ? 'selected' : '' }}>
                    {{$country->country_name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12">
                <label for="email" class="form-label">Email Address *</label>
                <input type="email" name="email" value="{{$data->email}}" class="form-control" id="email"
                  style="color: #8D8D8D; box-shadow: none;">
              </div>
              <div class="col-md-6">
                <label for="qidno" class="form-label">QID *</label>
                <input type="number" name="qidno" value="{{$data->qidno}}" class="form-control" id="qidno"
                  style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="qidexpiry" class="form-label">QID Expiry *</label>
                <input type="date" name="qidexpiry" value="{{$data->qidexpiry}}" class="form-control" id="qidexpiry"
                  style="color: #8D8D8D;">
              </div>
              <div class="col-12">
                <label for="qid_attaches" class="form-label">Attach QID Documents</label>
                <input type="file" name="qid_attaches" value="{{$data->qid_attaches}}" class="form-control"
                  id="qid_attaches">
              </div>
              <div class="col-md-6">
                <label for="passportno" class="form-label">Passport No:</label>
                <input type="text" name="passportno" value="{{$data->passportno}}" class="form-control" id="passportno"
                  style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="passportexpiry" class="form-label">Passport Expiry</label>
                <input type="date" name="passportexpiry" value="{{$data->passportexpiry}}" class="form-control"
                  id="passportexpiry" style="color: #8D8D8D;">
              </div>
              <!--visa details-->
                <div class="col-md-6">
                <label for="visa_type" class="form-label">Visa Type *</label>
                <select id="visa_type" name="visa_type" class="form-select" style="color: #8D8D8D;">
                  <option {{$data->visa_type ? '' : 'selected' }}>Choose Visa Type...
                  </option>
                  <option value="Employment" {{$data->visa_type =='Employment' ? 'selected' : '' }}>Employment
                  </option>
                  <option value="Family" {{$data->visa_type =='Family' ? 'selected' : '' }}>
                    Family</option>
                  <option value="Business" {{$data->visa_type =='Business' ? 'selected' : '' }}>
                    Business</option>
                  <option value="Student" {{$data->visa_type=='Student' ? 'selected' : '' }}>
                    Student</option>
                </select>
              </div>

               <div class="col-md-6">
                <label for="visano" class="form-label">Visa Number:</label>
                <input type="text" name="visa_number" value="{{$data->visa_number}}" class="form-control" id="visa_number"
                  style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="visa_issue_date" class="form-label">Visa Issue Date</label>
                <input type="date" name="visa_issue_date" value="{{$data->visa_issue_date}}" class="form-control"
                  id="visa_issue_date" style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="visa_expiry_date" class="form-label">Visa Expiry Date</label>
                <input type="date" name="visa_expiry_date" value="{{$data->visa_expiry_date}}" class="form-control"
                  id="visa_expiry_date" style="color: #8D8D8D;">
              </div>
              <!--Visa details end-->
              <div class="col-12">
                <label for="passport_attaches" class="form-label">Attach Passport Documents</label>
                <input type="file" name="passport_attaches" value="{{$data->passport_attaches}}" class="form-control"
                  id="passport_attaches">
              </div>
              
              
              <div class="col-md-6">
                <label for="marital_status" class="form-label">Marital Satus *</label>
                <select id="marital_status" name="marital_status" class="form-select" style="color: #8D8D8D;">
                  <option {{$data->marital_status ? '' : 'selected' }}>Choose Marital Status...
                  </option>
                  <option value="Single" {{$data->marital_status =='Single' ? 'selected' : '' }}>Single
                  </option>
                  <option value="Married" {{$data->marital_status =='Married' ? 'selected' : '' }}>
                    Married</option>
                  <option value="Seperated" {{$data->marital_status =='Seperated' ? 'selected' : '' }}>
                    Seperated</option>
                  <option value="Widowed" {{$data->marital_status =='Widowed' ? 'selected' : '' }}>
                    Widowed</option>
                </select>
              </div>
              
              <div class="col-md-6">
                <label for="school_shift" class="form-label">School Shift *</label>
                <select id="school_shift" name="school_shift" class="form-select" style="color: #8D8D8D;">
                  <option {{$data->school_shift ? '' : 'selected' }}>Choose School Shift...</option>
                  @foreach(masterDropdown('school_shift') as $school_shift)
                  <option value="{{$school_shift->id}}" {{$data->school_shift ==  $school_shift->id ? 'selected' : '' }}>
                    {{$school_shift->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="joiningdate" class="form-label">Date of Joining (as per offer letter)
                  *</label>
                <input type="date" name="joiningdate" value="{{$data->joiningdate}}" class="form-control" id="joiningdate"
                  style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="end_probation" class="form-label">End of Probation *</label>
                <input type="date" name="end_probation" value="{{$data->end_probation}}" class="form-control"
                  id="end_probation" style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="contract_type" class="form-label">Contract Type *</label>
                <select id="contract_type" name="contract_type" class="form-select" style="color: #8D8D8D;">
                  <option {{$data->contract_type ? '' : 'selected' }}>Choose Contract Type...</option>
                  @foreach(masterDropdown('contract_type') as $contract_type)
                  <option value="{{$contract_type->id}}" {{$data->contract_type == $contract_type->id ? 'selected' : '' }}>
                    {{$contract_type->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="contract_length" class="form-label">Contract Length *</label>
                <input type="text" name="contract_length" value="{{$data->contract_length}}" class="form-control"
                  id="contract_length" placeholder="No.of Years" style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="end_contract" class="form-label">End of Contract Date</label>
                <input type="date" name="end_contract" value="{{$data->end_contract}}" class="form-control"
                  id="end_contract" style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="service_years" class="form-label">Service Years (as of today)</label>
                <input type="text" name="service_years" value="{{$data->service_years}}" class="form-control"
                  id="service_years" style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="designation" class="form-label">Current Position *</label>
                <select id="designation" name="designation" class="form-select" style="color: #8D8D8D;">
                  <option {{$data->designation ? '' : 'selected' }}>Choose Current Position...
                  </option>
                  @foreach(masterDropdown('designations', 'status') as $designation)
                  <option value="{{$designation->id}}" {{$data->designation == $designation->id ? 'selected' : '' }}>
                    {{$designation->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="department" class="form-label">Current Department *</label>
                <select id="department" name="department" class="form-select" style="color: #8D8D8D;">
                  <option {{$data->department ? '' : 'selected' }}>Choose Curent Department...
                  </option>
                  @foreach(masterDropdown('departments') as $department)
                  <option value="{{$department->id}}" {{$data->department == $department->id ? 'selected' : '' }}>
                    {{$department->name}}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="col-md-6">
                <label for="mobile1" class="form-label">Primary Contact No: *</label>
                <input type="number" name="mobile1" value="{{$data->mobile1}}" class="form-control" id="mobile1"
                  style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="mobile2" class="form-label">Secondary Contact No:</label>
                <input type="number" name="mobile2" value="{{$data->mobile2}}" class="form-control" id="mobile2"
                  style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                <label for="sponsorship_status" class="form-label">Sponsorship Status *</label>
                <select id="sponsorship_status" name="sponsorship_status" class="form-select" style="color: #8D8D8D;">
                  <option {{$data->sponsorship_status ? '' : 'selected' }}>Choose Sponsorship
                    Status...</option>
                  @foreach(masterDropdown('sponsorship_status') as $sponsorship_status)
                  <option value="{{$sponsorship_status->id}}" {{$data->sponsorship_status == $sponsorship_status->id ? 'selected' : '' }}>
                    {{$sponsorship_status->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="relevant_degree" class="form-label">Relevent Degree *</label>
                <select id="relevant_degree" name="relevant_degree" class="form-select" style="color: #8D8D8D;">
                  <option {{$data->relevant_degree ? '' : 'selected' }}>Choose Relevent Degree...
                  </option>
                  @foreach(masterDropdown('relevant_degree') as $relevant_degree)
                  <option value="{{$relevant_degree->id}}" {{$data->relevant_degree == $relevant_degree->id ? 'selected' : '' }}>
                    {{$relevant_degree->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-12">
                <label for="degree_attaches" class="form-label">Attach Degree Documents</label>
                <input type="file" name="degree_attaches" value="{{$data->degree_attaches}}" class="form-control"
                  id="degree_attaches">
              </div>
              <div class="col-12">
                <label for="degree_attest_status" class="form-label">Degree Attestation Status *</label>
                <select id="degree_attest_status" name="degree_attest_status" class="form-select" style="color: #8D8D8D;">
                  <option {{$data->degree_attest_status ? '' : 'selected' }}>Choose Degree Attestation
                    Status...</option>
                  <option value="1" {{$data->degree_attest_status =='1' ? 'selected' : '' }}>
                    Completely Attested</option>
                  <option value="2" {{$data->degree_attest_status =='2' ? 'selected' : '' }}>Not Attested</option>
                  <option value="3" {{$data->degree_attest_status =='3' ? 'selected' : '' }}>
                    Attestation in Progress</option>
                </select>
              </div>

              <div class="col-12">
                <label for="other-qualifications" class="form-label">Other Qualifications</label>
                <div class="qualifications-container">
                    <?php
                      $all_qualification = $data->other_qualifications ? unserialize($data->other_qualifications) : ["Add more Qualifications"];
                    ?>
                    @foreach($all_qualification as $index => $qualification)
                    <div class="input-group mb-3">
                        <input type="text" name="other_qualifications[]" value="{{$qualification}}" class="form-control"
                            id="other-qualifications-{{ $index }}" aria-describedby="other-qualifications-help">
                        <button class="btn btn-outline-secondary remove-qualification" type="button">Remove</button>
                    </div>
                    @endforeach
                </div>
                <button class="btn btn-outline-primary add-qualification" type="button">Add More Qualification</button>
              </div>

              <div class="col-md-6">
                <label for="disclaimer_ltr_moe" class="form-label">Disclaimer Letter (MOE)</label>
                <select id="disclaimer_ltr_moe" name="disclaimer_ltr_moe" class="form-select" style="color: #8D8D8D;">
                  <option value="NA" selected>NA
                  </option>
                  <option value="Yes" {{$data->disclaimer_ltr_moe =='Yes' ? 'selected' : '' }}>Yes
                  </option>
                  <option value="No" {{$data->disclaimer_ltr_moe =='No' ? 'selected' : '' }}>No
                  </option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="disclaimer_ltr_moe_atch" class="form-label">Attach Disclaimer Letter</label>
                <input type="file" name="disclaimer_ltr_moe_atch" value="{{$data->disclaimer_ltr_moe_atch}}"
                  class="form-control" id="disclaimer_ltr_moe_atch">
              </div>
              <div class="col-md-6">
                <label for="declaration_ltr_moe" class="form-label">Declaration Letter (MOE)</label>
                <select id="declaration_ltr_moe" name="declaration_ltr_moe" class="form-select" style="color: #8D8D8D;">
                  <option value="NA" selected>NA
                  </option>
                  <option value="Yes" {{$data->declaration_ltr_moe =='Yes' ? 'selected' : '' }}>Yes
                  </option>
                  <option value="No" {{$data->declaration_ltr_moe =='No' ? 'selected' : '' }}>No
                  </option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="declaration_ltr_moe_atch" class="form-label">Attach Declaration Letter</label>
                <input type="file" name="declaration_ltr_moe_atch" class="form-control" id="declaration_ltr_moe_atch">
              </div>
              <div class="col-12">
                <label for="avatar" class="form-label">Profile Picture Upload</label>
                <input type="file" name="avatar" value="{{$data->avatar}}" class="form-control" id="avatar">
              </div>
              <div class="col-12">
                <label for="hrcomment" class="form-label">HR Comments</label>
                <div class="col-12" style="padding: 0px;">
                  <textarea class="form-control" name="hrcomment" id="hrcomment"
                    style="height: 100px; color: #8D8D8D;">{{$data->hrcomment}}</textarea>
                </div>
              </div>
              <div class="col-md-2 hidee">
                <button type="button" class="btn btn-alpha" data-toggle="popover" title="Uploaded Documents"
                  data-content="You gotta go through it to see there ain't nothing to it. Listen to the silence. And when the silence is deafening, you're in the center of your own universe."
                  style="width: max-content;" id="fileUploadButton">Documnet
                  Checklist</button>
                <div id="loadingIcon" style="display: none;">Uploading...</div>
              </div>
              <div class="col-md-12" style="width: 100%; margin-top: 20px;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Save &
                  Continue</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div id="payroll_info_modal" class="modal custom-modal fade" role="dialog" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Payroll Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="row g-3" action="{{route('payroll_information.update', $data->userid)}}" method="post">
              @csrf
              @method('PUT')

              <input type="hidden" name="user_id" value="{{$data->userid}}">
              @can('profile-update')
              <div class="col-md-6">
                  <label for="basic_salary" class="form-label">Basic Salary *</label>
                  <input type="number" name="basic_salary" value="{{$data->basic_salary}}" class="form-control" id="basic_salary" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
              </div>
              <div class="col-md-6">
                  <label for="accomodation_allowance" class="form-label">Accomodation Allowance *</label>
                  <input type="number" name="accomodation_allowance" value="{{$data->accomodation_allowance}}" class="form-control" id="accomodation_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
              </div>
              <div class="col-md-6">
                  <label for="transport_allowance" class="form-label">Transport Allowance *</label>
                  <input type="number" name="transport_allowance" value="{{$data->transport_allowance}}" class="form-control" id="transport_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
              </div>
              <div class="col-md-6">
                  <label for="continuous_allowance" class="form-label">Continuous Allowance</label>
                  <input type="number" name="continuous_allowance" value="@if(NULL!=$data && !$data->employeePayrollInformation->isEmpty()){{$data->employeePayrollInformation[0]->continuous_allowance}}@else{{0}}@endif" class="form-control" id="continuous_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
              </div>
              <div class="col-md-6">
                  <label for="temp_allowance" class="form-label">Temporary Allowance</label>
                  <input type="number" name="temp_allowance" value="@if(NULL!=$data && !$data->employeePayrollInformation->isEmpty()){{$data->employeePayrollInformation[0]->temp_allowance}}@else{{0}}@endif" class="form-control" id="temp_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
              </div>
              <div class="col-md-6">
                  <label for="other_allowance" class="form-label">Other Allowance</label>
                  <input type="number" name="other_allowance" value="{{$data->other_allowance}}" class="form-control" id="other_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
              </div>
              <div class="col-md-12">
                  <label for="gross_total" class="form-label">Gross Total</label>
                  <input type="number" name="gross_total" value="{{$data->gross_total}}" class="form-control" id="gross_total" style="color: #8D8D8D;">
              </div>  
              <div class="col-md-12">
                  <label for="bank_name" class="form-label">Bank Name</label>
                  <input type="text" name="bank_name" value="{{$data->bank_name}}" class="form-control" id="bank_name"
                      placeholder="Enter Your Bank Name" style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                  <label for="account_no" class="form-label">Account No:</label>
                  <input type="text" name="account_no" value="{{$data->account_no}}" class="form-control" id="account_no"
                      placeholder="Enter Your Account No:" style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                  <label for="iban_no" class="form-label">IBAN No:</label>
                  <input type="text" name="iban_no" value="{{$data->iban_no}}" class="form-control" id="iban_no"
                      placeholder="Enter Your IBAN No:" style="color: #8D8D8D;">
              </div>            
              <div class="col-md-6">
                  <label for="salary_effective_from" class="form-label">Salary Payment Effective From</label>
                  <input type="date" name="salary_effective_from" value="{{$data->salary_effective_from}}" class="form-control" id="salary_effective_from" style="color: #8D8D8D;">
              </div>
              @endcan
              <div class="col-md-6" style="width: 100%; margin-top: 100px;">
                  <button type="submit" class="btn btn-primary" style="width: 50%;">Save & Continue</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div id="health_info_modal" class="modal custom-modal fade" role="dialog" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Health Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="row g-3" action="{{route('health_information.update', $data->userid)}}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="col-md-6">
                  <label for="hmc_card_no" class="form-label">HMC Card No:</label>
                  <input type="text" name="hmc_card_no" value="{{$data->hmc_card_no}}" class="form-control" id="hmc_card_no" style="color: #8D8D8D;">
                  <input type="hidden" name="user_id" value="{{$data->userid}}">
              </div>
              <div class="col-md-6">
                  <label for="health_insurance_status" class="form-label">Health Insurance Status</label>
                  <select id="health_insurance_status" name="health_insurance_status" class="form-select" style="color: #8D8D8D;">
                      <option {{$data->health_insurance_status ? '' : 'selected' }}>Choose Insurance Status...</option>
                      <option value="1" {{$data->health_insurance_status == '1' ? 'selected' : '' }}>Yes</option>
                      <option value="0" {{$data->health_insurance_status == '0' ? 'selected' : '' }}>No</option>
                  </select>
              </div>
              <div class="col-md-12">
                  <label for="health_insurance_name" class="form-label">Mention the name of your health insurance (if
                      any)</label>
                  <input type="text" name="health_insurance_name" value="{{$data->health_insurance_name}}" class="form-control" id="health_insurance_name"
                      placeholder="Name of Health Insurance" style="color: #8D8D8D;">
              </div>
              <div class="col-md-12">
                  <label for="medical_ailment_physical" class="form-label">Does the employee suffer from any medical
                      conditions</label>
                  <select id="medical_ailment_physical" name="medical_ailment_physical" class="form-select" style="color: #8D8D8D;">
                      <option {{$data->medical_ailment_physical ? '' : 'selected' }}>Choose...</option>
                      <option value="1" {{$data->medical_ailment_physical == '1' ? 'selected' : '' }}>Yes</option>
                      <option value="0" {{$data->medical_ailment_physical == '0' ? 'selected' : '' }}>No</option>
                  </select>
              </div>

              <div class="col-12">
                <label for="physical_details" class="form-label">Mention Details (if any)</label>
                <div class="medical-conditions-container">
                  <?php
                    $all_physical_details = $data->physical_details ? unserialize($data->physical_details) : ["Add more details"];
                  ?>
                  @if($all_physical_details)
                    @foreach($all_physical_details as $index => $physical_details)
                    <div class="input-group mb-3">
                        <input type="text" name="physical_details[]" value="{{ $physical_details }}" class="form-control"
                            id="medical-conditions-{{ $index }}" aria-describedby="medical-conditions-help">
                        <button class="btn btn-outline-secondary remove-medical-condition" type="button">Remove</button>
                    </div>
                    @endforeach
                  @endif
                </div>
                <button class="btn btn-outline-primary add-medical-conditions" type="button">Add More</button>
              </div>

              <div class="col-md-12" id="physical_details_container"></div>
              <div class="col-md-12">
                  <label for="medical_ailment_mental" class="form-label">Does the employee suffer from any mental
                      health</label>
                  <select id="medical_ailment_mental" name="medical_ailment_mental" class="form-select" style="color: #8D8D8D;">
                      <option {{$data->medical_ailment_mental ? '' : 'selected' }}>Choose...</option>
                      <option value="1" {{$data->medical_ailment_mental == '1' ? 'selected' : '' }}>Yes</option>
                      <option value="0" {{$data->medical_ailment_mental == '0' ? 'selected' : '' }}>No</option>
                  </select>
              </div>

              <div class="col-12">
                <label for="mental-details" class="form-label">Mention Details (if any)</label>
                <div class="mental-details-container">
                  <?php
                    $all_mental_details = $data->mental_details ? unserialize($data->mental_details) : ["Add more details"];
                  ?>
                  @if($all_mental_details)
                    @foreach($all_mental_details as $index => $mental_details)
                    <div class="input-group mb-3">
                        <input type="text" name="mental_details[]" value="{{ $mental_details }}" class="form-control"
                            id="mental-details-{{ $index }}" aria-describedby="mental-details-help">
                        <button class="btn btn-outline-secondary remove-mental-details" type="button">Remove</button>
                    </div>
                    @endforeach
                  @endif
                </div>
                <button class="btn btn-outline-primary add-mental-details" type="button">Add More</button>
              </div>
              <div class="col-md-12">
                  <label for="medication_details" class="form-label">Mention the name of medication taken (if
                      any)</label>
                  <input type="text" name="medication_details" value="{{$data->medication_details}}" class="form-control" id="medication_details"
                      placeholder="Name of Medication Taken" style="color: #8D8D8D;">
              </div>
              <div class="col-md-6" style="width: 100%; margin-top: 100px;">
                  <button type="submit" class="btn btn-primary" style="width: 50%;"
                      >Save & Continue</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>

    @can('profile-update')
    <div id="emerg_detail_modal" class="modal custom-modal fade" role="dialog" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Emergency Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="row g-3" action="{{route('emergency_details.update', $data->userid)}}" method="post">
              @csrf
              @method('PUT')
              <div class="col-md-6">
                  <label for="emergency_primary_name" class="form-label">Primary Emergency Contact Name *</label>
                  <input type="text" name="emergency_primary_name" value="{{$data->emergency_primary_name}}" class="form-control" id="emergency_primary_name" placeholder="Full Name"
                      style="color: #8D8D8D;">
                  <input type="hidden" name="user_id" value="{{$data->userid}}">
              </div>
              <div class="col-md-6">
                  <label for="relationship_primary" class="form-label">Relationship</label>
                  <select id="relationship_primary" name="relationship_primary" class="form-select" style="color: #8D8D8D;">
                      <option {{$data->relationship_primary ? '' : 'selected' }}>Choose Relationship...</option>
                      @foreach(masterDropdown('relationship') as $relation)
                      <option value="{{$relation->id}}" {{$data->relationship_primary == $relation->id ? 'selected' : '' }}>
                          {{$relation->name}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col-md-6">
                  <label for="emergency_primary_contact" class="form-label">Primary Emergency Contact No: *</label>
                  <input type="numner" name="emergency_primary_contact" value="{{$data->emergency_primary_contact}}" class="form-control" id="emergency_primary_contact"
                      placeholder="Enter Contact Number" style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                  <label for="emergency_secondary_name" class="form-label">Secondary Emergency Contact Name *</label>
                  <input type="text" name="emergency_secondary_name" value="{{$data->emergency_secondary_name}}" class="form-control" id="emergency_secondary_name" placeholder="Full Name"
                      style="color: #8D8D8D;">
              </div>
              <div class="col-md-6">
                  <label for="relationship_secondary" class="form-label">Relationship</label>
                  <select id="relationship_secondary" name="relationship_secondary" class="form-select" style="color: #8D8D8D;">
                      <option {{$data->relationship_secondary ? '' : 'selected' }}>Choose Relationship...</option>
                      @foreach(masterDropdown('relationship') as $relation)
                      <option value="{{$relation->id}}" {{$data->relationship_secondary == $relation->id ? 'selected' : '' }}>
                          {{$relation->name}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col-md-6">
                  <label for="emergency_secondary_contact" class="form-label">Secondary Emergency Contact No: *</label>
                  <input type="numner" name="emergency_secondary_contact" value="{{$data->emergency_secondary_contact}}" class="form-control" id="emergency_secondary_contact"
                      placeholder="Enter Contact Number" style="color: #8D8D8D;">
              </div>
              <div class="col-md-12">
                  <label for="comment" class="form-label">Employee Remarks</label>
                  <div class="col-md-12" style="padding: 0px;">
                      <textarea class="form-control" id="comment" name="comment"
                          style="height: 100px; color: #8D8D8D;">{{$data->comment}}</textarea>
                  </div>
              </div>
              <div class="col-md-6" style="width: 100%; margin-top: 100px;">
                  <button type="submit" class="btn btn-primary" style="width: 50%;"
                      >Save</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
    @endcan

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>
  @endsection

  @section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    profileImg.onchange = evt => {
      const [file] = profileImg.files
      if (file) {
        profileUpload.src = URL.createObjectURL(file)
      }
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(function() {
        const maxQualifications = 5;
        const $qualificationsContainer = $('.qualifications-container');
        const $addButton = $('.add-qualification');

        function updateQualificationButtons() {
            const $qualifications = $qualificationsContainer.find('.input-group');
            $addButton.prop('disabled', $qualifications.length >= maxQualifications);
            $qualifications.find('.remove-qualification').prop('disabled', $qualifications.length <= 1);
        }

        function addQualification() {
            const $lastQualification = $qualificationsContainer.find('.input-group:last-child');
            const $newQualification = $lastQualification.clone();
            $newQualification.find('input').val('');
            $newQualification.insertAfter($lastQualification);
            updateQualificationButtons();
        }

        function removeQualification(event) {
            $(event.currentTarget).closest('.input-group').remove();
            updateQualificationButtons();
        }

        $addButton.on('click', addQualification);
        $qualificationsContainer.on('click', '.remove-qualification', removeQualification);
        updateQualificationButtons();
    });
  </script>
  <script>
    $(function() {
        const maxInputFields = 5;
        const $medicalConditionsContainer = $('.medical-conditions-container');
        const $addButton = $('.add-medical-conditions');

        function updateMedicalConditionButton() {
            const $medicalConditions = $medicalConditionsContainer.find('.input-group');
            $addButton.prop('disabled', $medicalConditions.length >= maxInputFields);
            $medicalConditions.find('.remove-medical-condition').prop('disabled', $medicalConditions.length <= 1);
        }

        function addMedicalCondition() {
            const $lastQualification = $medicalConditionsContainer.find('.input-group:last-child');
            const $newQualification = $lastQualification.clone();
            $newQualification.find('input').val('');
            $newQualification.insertAfter($lastQualification);
            updateMedicalConditionButton();
        }

        function removeMedicalCondition(event) {
            $(event.currentTarget).closest('.input-group').remove();
            updateMedicalConditionButton();
        }

        $addButton.on('click', addMedicalCondition);
        $medicalConditionsContainer.on('click', '.remove-medical-condition', removeMedicalCondition);
        updateMedicalConditionButton();
    });
  </script>

  <script>
    $(function() {
        const maxInputFields = 5;
        const $mentalDetailsContainer = $('.mental-details-container');
        const $addButton = $('.add-mental-details');

        function updateMentalDetailsButtons() {
            const $mentalConditions = $mentalDetailsContainer.find('.input-group');
            $addButton.prop('disabled', $mentalConditions.length >= maxInputFields);
            $mentalConditions.find('.remove-mental-details').prop('disabled', $mentalConditions.length <= 1);
        }

        function addMentalDetails() {
            const $lastMentalDetails = $mentalDetailsContainer.find('.input-group:last-child');
            const $newMentalDetails = $lastMentalDetails.clone();
            $newMentalDetails.find('input').val('');
            $newMentalDetails.insertAfter($lastMentalDetails);
            updateMentalDetailsButtons();
        }

        function removeMentalDetails(event) {
            $(event.currentTarget).closest('.input-group').remove();
            updateMentalDetailsButtons();
        }

        $addButton.on('click', addMentalDetails);
        $mentalDetailsContainer.on('click', '.remove-mental-details', removeMentalDetails);
        updateMentalDetailsButtons();
    });
  </script>
  @endcan
@endsection