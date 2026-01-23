
@php
  $role = Auth::user();
  $hrRole = Spatie\Permission\Models\Role::where('name', HR_ROLE)->first();
  $user = $employee->user;
  $dept = "";
  
@endphp


  <form action="{{route('appraisal.store')}}" method="POST" onsubmit="return validateForm()">
    @csrf
    <div class="row">

      <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Evaluation Date *</label>
          <input type="date" class="form-control" id="evalution_date" style="color: #8D8D8D;" name="evaluation_date" value="">
        </div>
        <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Evaluation Type *</label>
          <select id="evalution_type" class="form-select" style="color: #8D8D8D;" name="evaluation_type" value="">
            <option value="" selected>Choose Evaluation Type...</option>
            <!--<option value="Probationary">Probationary</option>-->
            <option value="Annual">Annual</option>
            <option value="General">General</option>
          </select>
        </div>
        <div class="col-sm-6" style="margin-top: 20px;">
          <label for="inputEmail5" class="form-label">Evaluation Period *</label>
          <select id="evalution_period" class="form-select" style="color: #8D8D8D;" name="evaluation_period" value="">
            <option value="" selected>Choose Evaluation Period...</option>
            <option value="1 Year">1 Year</option>
            <option value="6 Months">6 Months</option>
            <option value="3 Months">3 Months</option>
          </select>
        </div>
        <div class="col-sm-6" style="margin-top: 20px;">
          <label for="inputEmail5" class="form-label">Select Form *</label>
          <select id="dept" class="form-select" style="color: #8D8D8D;" name="dept" value="">
            <option value="" selected>Choose Applicable...</option>
            @foreach(get_appraisal_applicable() as $ID=>$Name)
              <option value="{{$Name}}">{{$ID}}</option>
            @endforeach
          </select>
          <div id="deptError" style="display: none; color: red;">Please select a Applicable.</div>

        </div>
    </div>

    <div class="row">

        <div class="col-sm-12" style="margin-top: 30px;">
          <div class="card">
            <div class="card-body">

             <div class="tab-box">
                <div class="row user-tabs">
                  <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                    <ul class="nav nav-tabs nav-tabs-solid">
                    <li class="nav-item"><a href="#appr_technical1" data-toggle="tab" class="nav-link active">Employee Details</a></li>
                      @foreach(get_appraisal_type() as $valId=>$valName)
                        <li class="nav-item"><a href="#appr_technical-{{$valName}}" data-toggle="tab" class="nav-link" onclick="get_appraisalData({{$valName}})">{{$valId}}</a></li>
                      @endforeach
                    <!-- 
                    <li class="nav-item"><a href="#appr_organizational1" data-toggle="tab" class="nav-link">Competencies</a></li>
                    <li class="nav-item"><a href="#appr_technical2" data-toggle="tab" class="nav-link">Employee Characteristics</a></li> -->
                    <li class="nav-item"><a href="#appr_organizational2" data-toggle="tab" class="nav-link">Employee Future Targets</a></li>
                    <li class="nav-item"><a href="#appr_technical3" data-toggle="tab" class="nav-link">Training Needs</a></li>
                    <li class="nav-item"><a href="#appr_organizational3" data-toggle="tab" class="nav-link">Comments & Sign-Off</a></li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="tab-content">

              <div id="appr_technical1" class="pro-overview tab-pane fade active show">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="bg-white">
                      <table class="table">
                        <thead>
                          <tr>
                            <th colspan="5"></th>
                          </tr>
                        </thead>
                        <tbody>
                          
                          <tr>
                            <td scope="row" colspan="2">Emp ID</td>
                            <td scope="row" colspan="2">
                              <input type="number" class="form-control no-border"  style="color: #8D8D8D;" value="{{$employee->employee_no}}">
                              <input type="hidden" class="form-control no-border" id="inputEmpId" style="color: #8D8D8D;" name="employee_id" value="{{$employee->employee_id}}">
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Employee Name</td>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputName5" style="color: #8D8D8D;" value="{{$employee->name}}&nbsp;{{$employee->lname}}">
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Designation</td>
                            <td scope="row" colspan="2">
                              <select id="inputEmail5" class="form-control" style="color: #8D8D8D;">
                                <option selected>@if($employee->designations){{$employee->designations->name}}@endif</option>
                                <!--<option>Class Teacher</option>
                                <option>Office Assistant</option>-->
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Department</td>
                            <td scope="row" colspan="2">
                              <select id="inputEmail5" class="form-control" style="color: #8D8D8D;">
                                <option selected>@if($employee->departments){{$employee->departments->name}} @endif</option>
                                <!--<option>Academics</option>
                                <option>Administration</option>-->
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Date of Joining</td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputName5" style="color: #8D8D8D;" value="{{$employee->joiningdate}}">
                            </td>
                          </tr>
                          <!--<tr>
                            <td scope="row" colspan="2">Designation Period</td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputName5" style="color: #8D8D8D;">
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Review Period</td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputName5" style="color: #8D8D8D;">
                            </td>
                          </tr>-->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!--dynamic data-->
              @foreach(get_appraisal_type() as $valueId=>$valueName)
                <div id="appr_technical-{{$valueName}}" class="pro-overview tab-pane fade show">
                 
                        <!-- <div id="fecthAppriasal{{$valueName}}"></div> -->
                          <!--Appended data-->
                          
                      
                </div>
              @endforeach
              <!--/dynamic data-->
              <div id="appr_organizational1" class="pro-overview tab-pane fade show">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="bg-white">
                      <table class="table">
                        <thead>
                          <tr>
                            <th colspan="5"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th colspan="2">Tasks / Competencies</th>
                            <th colspan="2">HOD Rating</th>
                            <th colspan="2">Principal Rating</th>
                          </tr>
                         
                          @foreach($appraisal_datas as $appraisal_data)
                            @if($appraisal_data->type == "COMPETENCIES (Ratings and Weightages entered by Appraiser)")
                              
                              @if($appraisal_data->applicable_to == $employee->department)
                              
                                  <tr>
                                    <td scope="row" colspan="2">
                                    {{$appraisal_data->details}}
                                      <input type="hidden" name="appraisal_data[]" value="{{$appraisal_data->id}}">

                                    </td>
                                    <td scope="row" colspan="2">
                                      <select id="hod_rating_{{$appraisal_data->id}}" class="form-select" style="color: #8D8D8D;" name="hod_rating[]" value="">
                                        <option selected></option>
                                        <option>NA</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                      </select>
                                    </td>
                                    <td scope="row" colspan="2">
                                      <select id="principal_rating_{{$appraisal_data->id}}" class="form-select" style="color: #8D8D8D;" name="principal_rating[]" value="">
                                        <option selected></option>
                                        <option>NA</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                      </select>
                                    </td>
                                    <td style="display: none;">
                                      <input type="hidden" name="type[]" value="COMPETENCIES (Ratings and Weightages entered by Appraiser)">
                                    </td>
                                  </tr>
                              @endif
                              @endif
                          @endforeach
                     
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div id="appr_technical2" class="pro-overview tab-pane fade show">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="bg-white">
                      <table class="table">
                        <thead>
                          <tr>
                            <th colspan="5"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th colspan="2">Communication Skills</th>
                            <th colspan="2">HOD Rating</th>
                            <th colspan="2">Principal Rating</th>
                          </tr>
                          @foreach($appraisal_datas as $appraisal_data)
                            @if($appraisal_data->type == "Employee Characteristics")
                              @if($appraisal_data->applicable_to == $employee->department)
                                  <tr>
                                    <td scope="row" colspan="2">
                                      {{$appraisal_data->details}}
                                      <input type="hidden" name="appraisal_data[]" value="{{$appraisal_data->id}}">
                                    </td>
                                    <td scope="row" colspan="2">
                                      <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="hod_rating[]" value="">
                                        <option selected></option>
                                        <option>NA</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                      </select>
                                    </td>
                                    <td scope="row" colspan="2">
                                      <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="principal_rating[]" value="">
                                        <option selected></option>
                                        <option>NA</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                      </select>
                                    </td>
                                    <td style="display: none;">
                                      <input type="hidden" name="type[]" value="Employee Characteristics">
                                    </td>
                                  </tr>
                              @endif
                              @endif
                          @endforeach
                       
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div id="appr_organizational2" class="pro-overview tab-pane fade show">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="bg-white">
                      <table class="table">
                        <thead>
                          <tr>
                            <th colspan="5"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th colspan="2">Areas of Improvement/Tasks/Goals</th>
                            <th colspan="2">Review By Date</th>
                            <!-- <th colspan="2">Recommended By</th> -->
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]" >
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" >
                            </td>
                            
                            
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]" >
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" >
                            </td>
                           
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]">
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" >
                            </td>
                           
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]">
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" >
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]">
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" >
                            </td>
                          </tr>
                           <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]">
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" >
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div id="appr_technical3" class="pro-overview tab-pane fade show">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="bg-white">
                      <table class="table">
                        <thead>
                          <tr>
                            <th colspan="5"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th colspan="2">Training Title</th>
                            <th colspan="2">Due By</th>
                            <!-- <th colspan="2">Recommended By</th> -->
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_title[]">
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_date[]">
                            </td>
                           
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_title[]" >
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_date[]" >
                            </td>
                            
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="training_title" style="color: #8D8D8D;" name="training_title[]">
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="training_date" style="color: #8D8D8D;" name="training_date[]" >
                            </td>
                           
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_title[]">
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_date[]" >
                            </td>
                            
                          </tr>
                           <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="training_title" style="color: #8D8D8D;" name="training_title[]">
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="training_date" style="color: #8D8D8D;" name="training_date[]" >
                            </td>
                           
                          </tr>
                           <tr>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="training_title" style="color: #8D8D8D;" name="training_title[]">
                            </td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="training_date" style="color: #8D8D8D;" name="training_date[]" >
                            </td>
                           
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div id="appr_organizational3" class="pro-overview tab-pane fade show">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="bg-white">
                      <table class="table">
                        <thead>
                          <tr>
                            <th colspan="5"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- <tr>
                            <td scope="row" colspan="2">Employee Comments</td>
                            <td scope="row" colspan="2">
                              <div class="col-12" style="padding: 0px;">
                                <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="employee_comments[]" value=""></textarea>
                              </div>
                            </td>
                          </tr> -->
                          <tr>
                            <td scope="row" colspan="2">Head of Department Comments</td>
                            <td scope="row" colspan="2">
                              <div class="col-12" style="padding: 0px;">
                                <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="hod_comments" value=""></textarea>
                              </div>
                            </td>
                          </tr>
                          @if($role->hasRole('Principal'))
                          <tr>
                            <td scope="row" colspan="2">Principal's Comments</td>
                            <td scope="row" colspan="2">
                              <div class="col-12" style="padding: 0px;">
                                <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="principal_comments" value=""  ></textarea>
                              </div>
                            </td>
                          </tr>
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>

    </div>
  
    <div class="submit-section">
      <button type="submit" class="btn btn-primary submit-btn">Save</button>
    </div>
   

  </form>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script> 
    function validateForm() {
      var isValid = true;

      var evaluationDate = document.getElementById('evalution_date').value;
      var evaluationType = document.getElementById('evalution_type').value;
      var evaluationPeriod = document.getElementById('evalution_period').value;
      document.querySelectorAll('.text-danger').forEach(function(element) {
          element.remove();
      });
      if (evaluationDate === '') {
          var errorMessage = 'Please enter Evaluation Date';
          document.getElementById('evalution_date').insertAdjacentHTML('afterend', '<div class="text-danger">' + errorMessage + '</div>');
          isValid = false;
      }
      if (evaluationType === '') {
        // alert("type");
          var errorMessage = 'Please enter Evaluation Type';
          document.getElementById('evalution_type').insertAdjacentHTML('afterend', '<div class="text-danger">' + errorMessage + '</div>');
          isValid = false;
      }
      if (evaluationPeriod === '') {
          var errorMessage = 'Please enter Evaluation Period';
          document.getElementById('evalution_period').insertAdjacentHTML('afterend', '<div class="text-danger">' + errorMessage + '</div>');
          isValid = false;
      }
      return isValid;
    }

    function get_appraisalData(Value){
      var isValid = true;
           var selectedDept = $('#dept').val();
      if (selectedDept === '') {
              // $('#deptError').show();
              var errorMessage = 'Please select appilcable to';
              document.getElementById('dept').insertAdjacentHTML('afterend', '<div class="text-danger">' + errorMessage + '</div>');
              isValid = false;
          } 

      $.ajax({
            url: 'appraisal_applicable/assign_applicable_filter',
            method: 'POST',
            data: {
                dept: selectedDept,
                value:Value,
                _token:"{{csrf_token()}}",
            },
            success: function(response) {
                console.log(response);
                  $('#appr_technical-'+Value).html(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
      
    }
   
  </script>
