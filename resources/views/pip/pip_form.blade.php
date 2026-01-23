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


  <form action="{{route('pip.store')}}" method="POST" onsubmit="return validateForm()">
    @csrf
    <div class="row">
      <div class="col-sm-12">
          <label for="inputEmail5" class="form-label">Date *</label>
          <input type="date" class="form-control" id="date" style="color: #8D8D8D;" name="date" value="">
        </div>
        <!-- <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Staff member *</label> -->
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
                    <li class="nav-item"><a href="#appr_organizational1" data-toggle="tab" class="nav-link">Areas of Concern & Observations</a></li>
                    <li class="nav-item"><a href="#appr_technical2" data-toggle="tab" class="nav-link">Improvement Goals & Management support</a></li>
                    <li class="nav-item"><a href="#appr_organizational2" data-toggle="tab" class="nav-link">Progress Checkpoints</a></li>
                    <li class="nav-item"><a href="#appr_organizational3" data-toggle="tab" class="nav-link">Acknowledge</a></li>
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
              <div id="appr_organizational1" class="pro-overview tab-pane fade  show">
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
                            <th colspan="2">
                            Areas of Concern:
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="area_of_concern" style="height: 100px; color: #8D8D8D;" name="area_of_concern" value="" placeholder="Area of Concern"></textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">
                            Observations, Previous Discussions or Counselling:
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="Observations" style="height: 100px; color: #8D8D8D;" name="Observations" value="" placeholder="Observations, Previous Discussions or Counselling:"></textarea>
                            </th>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div id="appr_technical2" class="pro-overview tab-pane fade  show">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="bg-white">
                      <table class="table">
                        <thead>
                          <tr>
                            <th colspan="5">
                              Improvement Goals:
                                <br>
                                <h6>(These are the goals related to areas of concern to be improved and addressed)</h6>
                            </th>
                          </tr> 
                        </thead>
                        <tbody>
                          <tr>
                            <th colspan="2">1.</th>
                            <th colspan="2">
                              <input type="text" name="improment_goals[]" id="improment_goals" class="form-control">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">2.</th>
                            <th colspan="2">
                              <input type="text" name="improment_goals[]" id="improment_goals" class="form-control">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">3.</th>
                            <th colspan="2">
                              <input type="text" name="improment_goals[]" id="improment_goals" class="form-control">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="5">
                            Management Support:
                                <br>
                                <h6>(Listed below are ways in which your manager will support your Improvement activities.)</h6>
                            </th>
                          </tr> 
                          <tr>
                            <th colspan="2">1.</th>
                            <th colspan="2">
                              <input type="text" name="management_support[]" id="improment_goals" class="form-control">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">2.</th>
                            <th colspan="2">
                              <input type="text" name="management_support[]" id="improment_goals" class="form-control">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">3.</th>
                            <th colspan="2">
                              <input type="text" name="management_support[]" id="improment_goals" class="form-control">
                            </th>
                          </tr>
                          <tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div id="appr_organizational2" class="pro-overview tab-pane fade  show">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="bg-white">
                      <table class="table">
                        <thead>
                          <tr>
                            <th colspan="5" >
                              Progress Checkpoints:
                              <br>
                              <h6 class="text-wrap">(The following schedule will be used to evaluate your progress in meeting your Improvement activities.)</h6>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">Goal #</th>
                            <th colspan="2">Activity</th>
                            <th colspan="2">Checkpoint Date</th>
                            <th colspan="2">
                              Type of Follow-up<br>
                              (memo/call/meeting)
                            </th>
                            <th colspan="2">Progress Expected</th>
                            <th colspan="2">Notes</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th colspan="2">
                              1.
                            </th>
                            <th colspan="2">
                              <input type="text" name="activity[]" id="activity" class="form-control">
                            </th>
                            <th colspan="2">
                              <input type="date" name="check_point_date[]" id="check_point_date" class="form-control">
                            </th>
                            <th colspan="2">
                              <!-- <input type="text" name="type_of_follow_up[]" id="type_of_follow_up" class="form-control"> -->
                              <select class="form-control" name="type_of_follow_up[]" id="type_of_follow_up">
                                <option value="">Choose..</option>
                                <option value="Email">E-mail</option>
                                <option value="CALL">CALL</option>
                                <option value="MEETING">MEETING</option>
                              </select>
                            </th>
                            <th colspan="2">
                              <input type="text" name="progress_expected[]" id="progress_expected" class="form-control">
                            </th>
                            <th colspan="2">
                              <input type="text" name="notes[]" id="notes" class="form-control">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">
                              2.
                            </th>
                            <th colspan="2">
                              <input type="text" name="activity[]" id="activity" class="form-control">
                            </th>
                            <th colspan="2">
                              <input type="date" name="check_point_date[]" id="check_point_date" class="form-control">
                            </th>
                            <th colspan="2">
                              <!-- <input type="text" name="type_of_follow_up[]" id="type_of_follow_up" class="form-control"> -->
                              <select class="form-control" name="type_of_follow_up[]" id="type_of_follow_up">
                                <option value="">Choose..</option>
                                <option value="Email">E-mail</option>
                                <option value="CALL">CALL</option>
                                <option value="MEETING">MEETING</option>
                              </select>
                            </th>
                            <th colspan="2">
                              <input type="text" name="progress_expected[]" id="progress_expected" class="form-control">
                            </th>
                            <th colspan="2">
                              <input type="text" name="notes[]" id="notes" class="form-control">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">
                              3.
                            </th>
                            <th colspan="2">
                              <input type="text" name="activity[]" id="activity" class="form-control">
                            </th>
                            <th colspan="2">
                              <input type="date" name="check_point_date[]" id="check_point_date" class="form-control">
                            </th>
                            <th colspan="2">
                              <!-- <input type="text" name="type_of_follow_up[]" id="type_of_follow_up" class="form-control"> -->
                              <select class="form-control" name="type_of_follow_up[]" id="type_of_follow_up" >
                                <option value="">Choose..</option>
                                <option value="Email">E-mail</option>
                                <option value="CALL">CALL</option>
                                <option value="MEETING">MEETING</option>
                              </select>
                            </th>
                            <th colspan="2">
                              <input type="text" name="progress_expected[]" id="progress_expected" class="form-control">
                            </th>
                            <th colspan="2">
                              <input type="text" name="notes[]" id="notes" class="form-control">
                            </th>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              <div id="appr_organizational3" class="pro-overview tab-pane fade  show">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="bg-white">
                      <table class="table">
                        <thead>
                          <!-- <tr>
                            <th colspan="5">Signatures:</th>
                          </tr> -->
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <div class="form-check">
                                <input class="form-check-input my-2" type="radio" name="pip_status" value="1" id="satisfactoryRadio" onclick="toggleSatisfaction('satisfactoryButton')" >
                                <label class="form-check-label btn btn-success" id="satisfactoryButton" for="satisfactoryRadio">Satisfactory</label>
                              </div>
                            </td>
                            <td>
                              <div class="form-check">
                              <input class="form-check-input my-2" type="radio" name="pip_status" value="0" id="notSatisfactoryRadio" onclick="toggleSatisfaction('notSatisfactoryButton')">
                              <label class="form-check-label btn btn-danger" id="notSatisfactoryButton" for="notSatisfactoryRadio">Not Satisfactory</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <!-- <label for="status">Status</label>
                              <select class="form-control" name="pip_status" id="pip_status">
                                <option value="">Choose..</option>
                                <option value="1">Satisfied</option>
                                <option value="0">Not Satisfied</option>
                              </select>-->
                              <br> 
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="principal_ackn" id="principal_ackn">
                                <label class="form-check-label" for="changesMade">
                                  I have Acknowledged.                                 
                                </label>
                              </div>       
                            </th>
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
    // var reviewPeriod = document.getElementById('review_period').value;
    document.querySelectorAll('.text-danger').forEach(function(element) {
        element.remove();
    });
    if (evaluationDate === '') {
        var errorMessage = 'Please enter  Date';
        document.getElementById('date').insertAdjacentHTML('afterend', '<div class="text-danger">' + errorMessage + '</div>');
        isValid = false;
    }
    // if (reviewPeriod === '') {
    //   // alert("type");
    //     var errorMessage = 'Please enter Review Period';
    //     document.getElementById('review_period').insertAdjacentHTML('afterend', '<div class="text-danger">' + errorMessage + '</div>');
    //     isValid = false;
    // }
   
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