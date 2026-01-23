
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


  <form action="{{route('probation-period-review.update',$ppr_form->id)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">

        <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Date *</label>
          <input type="date" class="form-control" id="date" style="color: #8D8D8D;" name="date" value="{{$ppr_form->review_date}}">
        </div>
        <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Review Period *</label>
          <!-- <input type="text" class="form-control" id="review_period" style="color: #8D8D8D;" name="review_period" value="{{$ppr_form->review_period}}"> -->
          <select id="review_period" name="review_period" class="form-control" style="color: #8D8D8D;">
            <option value="1" @if($ppr_form->review_period == 1) selected @endif>1 - Month</option>
            <option value="2" @if($ppr_form->review_period == 2) selected @endif>2 - Month</option>
            <option value="3" @if($ppr_form->review_period == 3) selected @endif>3 - Month</option>
            <option value="4" @if($ppr_form->review_period == 4) selected @endif>4 - Month</option>
            <option value="5" @if($ppr_form->review_period == 5) selected @endif>5 - Month</option>
            <option value="6" @if($ppr_form->review_period == 6) selected @endif>6 - Month</option>
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
                            <input type="number" class="form-control no-border" id="inputEmpId" style="color: #8D8D8D;" value="{{$employee->employee_no}}">
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
                            @php
                              $objectives = json_decode($ppr_form->objectives);
                              $discussion = json_decode($ppr_form->discussion_points);
                            @endphp 
                            <pre>
                              
                            </pre> 
                            <tr>
                                <th colspan="2">
                                    <input type="text" class="form-control" id="objectives" name="objectives[]" style="color: #8D8D8D;"  value="{{$objectives[0]}}">
                                </th>
                                <th>
                                    <input type="text" class="form-control" id="discussions" name="discussions[]" style="color: #8D8D8D;"  value="{{$discussion[0]}}">
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <input type="text" class="form-control" id="objectives" name="objectives[]" style="color: #8D8D8D;"  value="{{$objectives[1]}}">
                                </th>
                                <th>
                                    <input type="text" class="form-control" id="discussions" name="discussions[]" style="color: #8D8D8D;"  value="{{$discussion[1]}}">
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <input type="text" class="form-control" id="objectives" name="objectives[]" style="color: #8D8D8D;"  value="{{$objectives[2]}}">
                                </th>
                                <th>
                                    <input type="text" class="form-control" id="discussions" name="discussions[]" style="color: #8D8D8D;"  value="{{$discussion[2]}}">
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
                            @php
                            $rating = json_decode($ppr_form->performance_review_rating);
                            @endphp   
                              @foreach($review_data as $index=>$review)
                                @php
                                    $ans = $rating[$index];
                                @endphp
                              <tr>
                                <th colspan="2">
                                  {{$review->performance_review}}
                                  <input type="hidden" name="performance_review[]" id="performance_review" value="{{$review->id}}">
                                </th>
                                <th>
                                  <select class="form-control" name="ratings[]">
                                    <option value="">Choose Rating</option>
                                    <option value="4" @if($ans == 4) selected @endif>4</option>
                                    <option value="3" @if($ans == 3) selected @endif>3</option>
                                    <option value="2" @if($ans == 2) selected @endif>2</option>
                                    <option value="1" @if($ans == 1) selected @endif>1</option>
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
                              <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="performance_review_feedback" value="" placeholder="Enter Performance  Feedback">{{$ppr_form->performance_review_feedback ?? ''}}</textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-wrap">
                            Where any areas require improvement give details below:
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="require_improvement" value="" placeholder="Enter Performance  Feedback">{{$ppr_form->require_improvement ?? ''}}</textarea>
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
                              <textarea class="form-control" id="areas_improvement" style="height: 100px; color: #8D8D8D;" name="areas_improvement" value="" >{{$ppr_form->areas_improvement ?? ''}}</textarea>
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="areas_discussion_points" style="height: 100px; color: #8D8D8D;" name="areas_discussion_points" value="" placeholder="Enter Areas Discussion Points">{{$ppr_form->areas_discussion_points ?? ''}}</textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-wrap">
                                Outline the employee's views on the job, work environment and working conditions:                            
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="work_environment" style="height: 100px; color: #8D8D8D;" name="work_environment" value="" placeholder="Enter Work Environment">{{$ppr_form->work_environment ?? ''}}</textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-wrap">
                              Managers Action Points:                            
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="manager_action_points" style="height: 100px; color: #8D8D8D;" name="manager_action_points" value="" placeholder="Enter Manager Action Points">{{$ppr_form->manager_action_points ?? ''}}</textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2" class="text-wrap">
                              Summary of employee's overall performance:                            
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="over_all_perfamance" style="height: 100px; color: #8D8D8D;" name="over_all_perfamance" value="" placeholder="Enter Over All Perfamance">{{$ppr_form->over_all_perfamance ?? ''}}</textarea>
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
                                  <input class="form-check-input" type="checkbox" name="conformed" id="conformed" @if($ppr_form->appointment_conformed == 1) checked @endif>
                                  <label class="form-check-label" for="changesMade">
                                    Is the employee's appointment to be confirmed?
                                  </label><br>
                                  (If No, give details of the concerns and schedule a Probation Period Hearing date below:)                 
                                  <br>
                                  <textarea class="form-control" id="no_conformed" style="height: 100px; color: #8D8D8D;" name="no_conformed" value="" placeholder="if No metion comment">{{$ppr_form->no_conformed ?? ''}}</textarea>
                                </div>                            
                              </th>
                            </tr>
                            <!-- <tr>
                              <th colspan="2" class="text-wrap">
                              </th>
                              <th colspan="2">
                               
                              </th>
                            </tr> -->
                            <tr>
                              <th colspan="2">
                                Extension of Probationary Period:
                              </th>
                              <th colspan="2">
                                <!-- <textarea class="form-control" id="extension_period" style="height: 100px; color: #8D8D8D;" name="extension_period" value="" placeholder="Extension Period">{{$ppr_form->extension_period ?? ''}}</textarea> -->
                                <select id="extension_period" name="extension_period" class="form-control" style="color: #8D8D8D;" >
                                  <option value="">Choose ..</option>
                                  <option value="1" @if($ppr_form->extension_period == 1) selected @endif>1 - Month</option>
                                  <option value="2" @if($ppr_form->extension_period == 2) selected @endif>2 - Month</option>
                                  <option value="3" @if($ppr_form->extension_period == 3) selected @endif>3 - Month</option>
                                  <option value="4" @if($ppr_form->extension_period == 4) selected @endif>4 - Month</option>
                                  <option value="5" @if($ppr_form->extension_period == 5) selected @endif>5 - Month</option>
                                  <option value="6" @if($ppr_form->extension_period == 6) selected @endif>6 - Month</option>
                                </select>
                              </th>
                            </tr>
                            <!-- <tr>
                              <th>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="employee_ack" id="employee_ack" @if($ppr_form->employee_ack == 1) checked @endif>
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
                                  <input class="form-check-input" type="checkbox" name="hod_ack" id="hod_ack" @if($ppr_form->hod_ack == 1) checked @endif>
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
                                  <input class="form-check-input" type="checkbox" name="principla_ack" id="principla_ack" @if($ppr_form->principla_ack == 1) checked @endif>
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
      <button type="submit" class="btn btn-primary submit-btn">Update</button>
    </div>
   

  </form>

