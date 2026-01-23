
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


  <form action="{{route('probation-period-review.store')}}" method="POST" onsubmit="return validateForm()">
    @csrf
    <div class="row">

        <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Date *</label>
          <input type="date" class="form-control" id="date" style="color: #8D8D8D;" name="date" value="">
        </div>
        <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Review Period *</label>
          <!-- <input type="text" class="form-control" id="review_period" style="color: #8D8D8D;" name="review_period" value=""> -->
          <select id="review_period" name="review_period" class="form-control" style="color: #8D8D8D;">
            <option value="">Choose ..</option>
            <option value="1">1 - Month</option>
            <option value="2">2 - Month</option>
            <option value="3">3 - Month</option>
            <option value="4">4 - Month</option>
            <option value="5">5 - Month</option>
            <option value="6">6 - Month</option>
            <!--<option>Academics</option>
            <option>Administration</option>-->
          </select>
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
                    <li class="nav-item"><a href="#appr_organizational1" data-toggle="tab" class="nav-link">objectives</a></li>
                    <li class="nav-item"><a href="#appr_technical2" data-toggle="tab" class="nav-link">Performance Review</a></li>
                    <li class="nav-item"><a href="#appr_organizational2" data-toggle="tab" class="nav-link">FeedBack</a></li>
                    <li class="nav-item"><a href="#appr_technical3" data-toggle="tab" class="nav-link">Areas Of Improvement</a></li>
                    <li class="nav-item"><a href="#appr_organizational3" data-toggle="tab" class="nav-link">Final Review</a></li>
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
                                <th colspan="2">Objectives</th>
                                <th colspan="2">Discussion Points/ Action Agreed</th>
                            </tr>   
                            <tr>
                                <th colspan="2">
                                    <input type="text" class="form-control" id="objectives" name="objectives[]" style="color: #8D8D8D;"  value="">
                                </th>
                                <th>
                                    <input type="text" class="form-control" id="discussions" name="discussions[]" style="color: #8D8D8D;"  value="">
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <input type="text" class="form-control" id="objectives" name="objectives[]" style="color: #8D8D8D;"  value="">
                                </th>
                                <th>
                                    <input type="text" class="form-control" id="discussions" name="discussions[]" style="color: #8D8D8D;"  value="">
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <input type="text" class="form-control" id="objectives" name="objectives[]" style="color: #8D8D8D;"  value="">
                                </th>
                                <th>
                                    <input type="text" class="form-control" id="discussions" name="discussions[]" style="color: #8D8D8D;"  value="">
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
                                <th colspan="2">Performance Review</th>
                                <th colspan="2">Rating(4-Excellent ,1-Improvement Required)</th>
                            </tr>   
                              @foreach($performance_reviews as $review)
                              <tr>
                                <th colspan="2">
                                  {{$review->performance_review}}
                                  <input type="hidden" name="performance_review[]" id="performance_review" value="{{$review->id}}">
                                </th>
                                <th>
                                  <select class="form-control" name="ratings[]">
                                    <option value="">Choose Rating</option>
                                    <option value="4">4</option>
                                    <option value="3">3</option>
                                    <option value="2">2</option>
                                    <option value="1">1</option>
                                  </select>
                                </th>
                              </tr>
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
                            <th colspan="2" class="text-wrap">
                            Performance  Feedback  -  Outline  of  areas  where  employee  is  performing  well  against  objectives  and standards set:
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="performance_review_feedback" value="" placeholder="Enter Performance  Feedback"></textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-wrap">
                            Where any areas require improvement give details below:
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="require_improvement" value="" placeholder="Enter any areas require improvement"></textarea>
                            </th>
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
                            <th colspan="2">
                            Areas for Improvement
                            </th>
                            <th colspan="2">
                              Discussion Points / Action Agreed
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-wrap">
                              <textarea class="form-control" id="areas_improvement" style="height: 100px; color: #8D8D8D;" name="areas_improvement" value="" placeholder="Enter Areas Improvement"></textarea>
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="areas_discussion_points" style="height: 100px; color: #8D8D8D;" name="areas_discussion_points" value="" placeholder="Enter Areas Discussion Points"></textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-wrap">
                                Outline the employee's views on the job, work environment and working conditions:                            
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="work_environment" style="height: 100px; color: #8D8D8D;" name="work_environment" value="" placeholder="Enter Work Environment"></textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-wrap">
                              Managers Action Points:                            
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="manager_action_points" style="height: 100px; color: #8D8D8D;" name="manager_action_points" value="" placeholder="Enter Manager Action Points"></textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-wrap">
                              Summary of employee's overall performance:                            
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="over_all_perfamance" style="height: 100px; color: #8D8D8D;" name="over_all_perfamance" value="" placeholder="Enter Over All Perfamance"></textarea>
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
                              <th>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="conformed" id="conformed">
                                  <label class="form-check-label" for="changesMade">
                                    Is the employee's appointment to be confirmed?
                                  </label><br>
                                  (If No, give details of the concerns and schedule a Probation Period Hearing date below:)
                                  <br>
                                  <textarea class="form-control" id="no_conformed" style="height: 100px; color: #8D8D8D;" name="no_conformed" value="" placeholder="if No metion comment"></textarea>
                                </div>                            
                              </th>
                            </tr>
                            <tr>
                              <th colspan="2">
                                Extension of Probationary Period:
                              </th>
                              <th colspan="2">
                                <!-- <textarea class="form-control" id="extension_period" style="height: 100px; color: #8D8D8D;" name="extension_period" value="" placeholder="Extension Period"></textarea> -->
                                <select id="extension_period" name="extension_period" class="form-control" style="color: #8D8D8D;" >
                                  <option value="">Choose ..</option>
                                  <option value="1">1 - Month</option>
                                  <option value="2">2 - Month</option>
                                  <option value="3">3 - Month</option>
                                  <option value="4">4 - Month</option>
                                  <option value="5">5 - Month</option>
                                  <option value="6">6 - Month</option>
                                </select>
                              </th>
                            </tr>
                            <!-- <tr>
                              <th>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="employee_ack" id="employee_ack">
                                  <label class="form-check-label" for="changesMade">
                                    Employee Ackwonlege 
                                  </label>
                                </div>                            
                              </th>
                            </tr> -->
                            @if($role->hasRole('Vp')|| $role->hasRole('Executive-Admin') )
                            <tr>
                              <th>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="hod_ack" id="hod_ack">
                                  <label class="form-check-label" for="changesMade">
                                    I have acknowledged the above report. 
                                  </label>
                                </div>                            
                              </th>
                            </tr>
                            @endif
                            @if($role->hasRole('Principal'))
                            <tr>
                              <th>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="principla_ack" id="principla_ack">
                                  <label class="form-check-label" for="changesMade">
                                    I have acknowledged the above report.
                                  </label>
                                </div>                            
                              </th>
                            </tr>
                            @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!--/dynamic data performance_reviews-->
              
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
    var reviewPeriod = document.getElementById('review_period').value;
    document.querySelectorAll('.text-danger').forEach(function(element) {
        element.remove();
    });
    if (evaluationDate === '') {
        var errorMessage = 'Please enter  Date';
        document.getElementById('date').insertAdjacentHTML('afterend', '<div class="text-danger">' + errorMessage + '</div>');
        isValid = false;
    }
    if (reviewPeriod === '') {
      // alert("type");
        var errorMessage = 'Please enter Review Period';
        document.getElementById('review_period').insertAdjacentHTML('afterend', '<div class="text-danger">' + errorMessage + '</div>');
        isValid = false;
    }
   
    return isValid;
  }
</script>