
@php
  $role = Auth::user();
  $hrRole = Spatie\Permission\Models\Role::where('name', HR_ROLE)->first();
  $user = $employee->user;
  if($user->hasRole(HR_ROLE)){
    $dept = 3;
  }else{
    $dept = $employee->department;
  }
  
@endphp


  <form action="{{route('scf.store')}}" method="POST" onsubmit="return validateForm()">
    @csrf
    <div class="row">

        <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Date *</label>
          <input type="date" class="form-control" id="date" style="color: #8D8D8D;" name="date" value="" required>
        </div>
        <!-- <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Concern form number *</label>
          <input type="text" class="form-control" id="concern_form_number" style="color: #8D8D8D;" name="concern_form_number" value="">
          
        </div> -->
        <!-- <div class="col-sm-12" style="margin-top: 20px;"> -->
          <!-- <label for="inputEmail5" class="form-label">Staff Member *</label> -->
          <input type="hidden" class="form-control" id="staff_member" style="color: #8D8D8D;" name="staff_member" value="{{$employee->name}}&nbsp;{{$employee->lname}}">
        <!-- </div> -->
        
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
                    <li class="nav-item"><a href="#appr_organizational1" data-toggle="tab" class="nav-link">Concern</a></li>
                    <li class="nav-item"><a href="#appr_technical2" data-toggle="tab" class="nav-link">Description</a></li>
                    <!-- <li class="nav-item"><a href="#appr_organizational2" data-toggle="tab" class="nav-link">Employee Future Targets</a></li>
                    <li class="nav-item"><a href="#appr_technical3" data-toggle="tab" class="nav-link">Training Needs</a></li> -->
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
                            <th colspan="2">Concern</th>
                            <th colspan="2">Feedback</th>
                          </tr>
                            @foreach($concerns as $concern)
                            <tr>
                                <th colspan="2">
                                    {{$concern->scf}}
                                    <input type="hidden" name="concern_ids[]" value="{{$concern->id}}">
                                </th>
                                <th colspan="2">
                                    <textarea class="form-control" name="concerns[]" placeholder="Enter Your FeedBack"></textarea>
                                </th>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="2">Date of Concern</th>
                                <th>
                                    <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="concern_date" value="">
                                </div>
                                </th>
                            </tr>
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
                            <th colspan="2">Brief description of the concern and how it was addressed:</th>
                            <th colspan="2">
                                <textarea class="form-control" placeholder="Enter your Description" name="description"></textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">Suggestions made:</th>
                            <th colspan="2">
                                <textarea class="form-control" placeholder="Enter your Suggestion" name="suggestion"></textarea>
                            </th>
                          </tr>  
                          <tr>
                            <th colspan="2">Update/follow-up:</th>
                            <th colspan="2">
                                <textarea class="form-control" placeholder="Enter update/followup" name="followup"></textarea>
                            </th>
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
                          
                          <tr>
                            <td scope="row" colspan="2"> Comments</td>
                            <td scope="row" colspan="2">
                              <div class="col-12" style="padding: 0px;">
                                <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="comments" value="" placeholder="Enter Comment"></textarea>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2"> Name of the staff member raising the concern</td>
                            <td scope="row" colspan="2">
                              <div class="col-12" style="padding: 0px;">
                                <textarea class="form-control" id="slt_member" style="height: 100px; color: #8D8D8D;" name="raising_concern" value="" placeholder="Enter Name of the staff member raising the concern" required></textarea>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                <!-- <input class="form-check-input" type="checkbox" name="pip_required" id="pip_required">
                                <label class="form-check-label" for="changesMade">
                                  Is Performance Improvement Plan Required?
                                </label> -->
                                <input class="form-check-input my-2" type="radio" name="pip_required" value="0" id="satisfactoryRadio" onclick="toggleSatisfaction('satisfactoryButton')" >
                                <label class="form-check-label btn btn-success" id="satisfactoryButton" for="satisfactoryRadio">Satisfactory</label>

                                <!-- <label class="form-check-label" for="changesMade">
                                  Is Performance Improvement Plan Required?
                                </label>  -->
                              </div>
                             
                            </td>
                            <td>
                              <div class="form-check">
                              <input class="form-check-input my-2" type="radio" name="pip_required" value="1" id="notSatisfactoryRadio" onclick="toggleSatisfaction('notSatisfactoryButton')">
                              <label class="form-check-label btn btn-danger" id="notSatisfactoryButton" for="notSatisfactoryRadio">Not Satisfactory</label>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!--/dynamic data-->
              
            </div>

          </div>
        </div>
      </div>

    </div>
  
    <div class="submit-section">
      <button type="submit" class="btn btn-primary submit-btn">Save</button>
    </div>
   
   
  </form>
  <script>
  function validateForm(){
    var isValid = true;

    var evaluationDate = document.getElementById('date').value;
    var sltMember = document.getElementById('slt_member').value;
    document.querySelectorAll('.text-danger').forEach(function(element) {
        element.remove();
    });
    if (evaluationDate === '') {
        var errorMessage = 'Please enter  Date';
        document.getElementById('date').insertAdjacentHTML('afterend', '<div class="text-danger">' + errorMessage + '</div>');
        isValid = false;
    }
    if (sltMember === '') {
      // alert("type");
        var errorMessage = 'Please enter Slt Member';
        document.getElementById('slt_member').insertAdjacentHTML('afterend', '<div class="text-danger">' + errorMessage + '</div>');
        isValid = false;
    }
   
    return isValid;
  }
  function toggleSatisfaction(buttonId) {
        var button = document.getElementById(buttonId);
        var radios = document.getElementsByName('pip_required');
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                if (radios[i].id === 'satisfactoryRadio') {
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-success');
                } else if (radios[i].id === 'notSatisfactoryRadio') {
                    button.classList.remove('btn-success');
                    button.classList.add('btn-danger');
                }
            }
            button.checked = radio.checked;
        }
    }
</script>
