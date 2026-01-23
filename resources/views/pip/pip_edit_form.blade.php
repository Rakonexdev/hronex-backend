@php
    $improvement = json_decode($pip->improment_goals);
    $management = json_decode($pip->management_support);
    $activity = json_decode($pip->activity);
    $check_date = json_decode($pip->check_point_date);
    $type_of_follow_up = json_decode($pip->type_of_follow_up);
    $progress_expected = json_decode($pip->progress_expected);
    $notes = json_decode($pip->notes);
@endphp
<form action="{{route('pip.update',$pip->id)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
      <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Date *</label>
          <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="date" value="{{$pip->date}}">
        </div>
        <!-- <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Staff member *</label>
          <input type="text" class="form-control" id="staff_member" style="color: #8D8D8D;" name="staff_member" value="{{$pip->staff_member}}">
        </div> -->
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
                              <textarea class="form-control" id="area_of_concern" style="height: 100px; color: #8D8D8D;" name="area_of_concern" value="" placeholder="Area of Concern">{{$pip->area_of_concern}}</textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">
                            Observations, Previous Discussions or Counselling:
                            </th>
                            <th colspan="2">
                              <textarea class="form-control" id="Observations" style="height: 100px; color: #8D8D8D;" name="Observations" value="" placeholder="Observations, Previous Discussions or Counselling:">{{$pip->Observations}}</textarea>
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
                              <input type="text" name="improment_goals[]" id="improment_goals" class="form-control" value="{{$improvement[0]}}">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">2.</th>
                            <th colspan="2">
                              <input type="text" name="improment_goals[]" id="improment_goals" class="form-control" value="{{$improvement[1]}}">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">3.</th>
                            <th colspan="2">
                              <input type="text" name="improment_goals[]" id="improment_goals" class="form-control" value="{{$improvement[2]}}">
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
                              <input type="text" name="management_support[]" id="improment_goals" class="form-control" value="{{$management[0]}}">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">2.</th>
                            <th colspan="2">
                              <input type="text" name="management_support[]" id="improment_goals" class="form-control" value="{{$management[1]}}">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">3.</th>
                            <th colspan="2">
                              <input type="text" name="management_support[]" id="improment_goals" class="form-control" value="{{$management[2]}}">
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
                              <input type="text" name="activity[]" id="activity" class="form-control" value="{{$activity[0]}}">
                            </th>
                            <th colspan="2">
                              <input type="date" name="check_point_date[]" id="check_point_date" class="form-control" value="{{$check_date[0]}}">
                            </th>
                            <th colspan="2">
                              
                              <!-- <input type="text" name="type_of_follow_up[]" id="type_of_follow_up" class="form-control" value="{{$type_of_follow_up[0]}}"> -->
                              <select class="form-control" name="type_of_follow_up[]" id="type_of_follow_up">
                                <option value="">Choose..</option>
                                <option value="Email" @if($type_of_follow_up[0] == "Email")  selected @endif>E-mail</option>
                                <option value="CALL" @if($type_of_follow_up[0] == "CALL")  selected @endif>CALL</option>
                                <option value="MEETING" @if($type_of_follow_up[0] == "MEETING")  selected @endif>MEETING</option>
                              </select>
                            </th>
                            <th colspan="2">
                              <input type="text" name="progress_expected[]" id="progress_expected" class="form-control" value="{{$progress_expected[0]}}">
                            </th>
                            <th colspan="2">
                              <input type="text" name="notes[]" id="notes" class="form-control" value="{{$notes[0]}}">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">
                              2.
                            </th>
                            <th colspan="2">
                              <input type="text" name="activity[]" id="activity" class="form-control"  value="{{$activity[1]}}">
                            </th>
                            <th colspan="2">
                              <input type="date" name="check_point_date[]" id="check_point_date" class="form-control" value="{{$check_date[1]}}">
                            </th>
                            <th colspan="2">
                              <!-- <input type="text" name="type_of_follow_up[]" id="type_of_follow_up" class="form-control" value="{{$type_of_follow_up[0]}}"> -->
                              <select class="form-control" name="type_of_follow_up[]" id="type_of_follow_up">
                                <option value="">Choose..</option>
                                <option value="Email" @if($type_of_follow_up[1] == "Email")  selected @endif>E-mail</option>
                                <option value="CALL" @if($type_of_follow_up[1] == "CALL")  selected @endif>CALL</option>
                                <option value="MEETING" @if($type_of_follow_up[1] == "MEETING")  selected @endif>MEETING</option>
                              </select>

                            </th>
                            <th colspan="2">
                              <input type="text" name="progress_expected[]" id="progress_expected" class="form-control" value="{{$progress_expected[1]}}">
                            </th>
                            <th colspan="2">
                              <input type="text" name="notes[]" id="notes" class="form-control" value="{{$notes[1]}}">
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">
                              3.
                            </th>
                            <th colspan="2">
                              <input type="text" name="activity[]" id="activity" class="form-control"  value="{{$activity[2]}}">
                            </th>
                            <th colspan="2">
                              <input type="date" name="check_point_date[]" id="check_point_date" class="form-control" value="{{$check_date[2]}}">
                            </th>
                            <th colspan="2">
                              <!-- <input type="text" name="type_of_follow_up[]" id="type_of_follow_up" class="form-control" value="{{$type_of_follow_up[2]}}"> -->
                              <select class="form-control" name="type_of_follow_up[]" id="type_of_follow_up" >
                                <option value="">Choose..</option>
                                <option value="Email" @if($type_of_follow_up[2] == "Email")  selected @endif>E-mail</option>
                                <option value="CALL" @if($type_of_follow_up[2] == "CALL")  selected @endif>CALL</option>
                                <option value="MEETING" @if($type_of_follow_up[2] == "MEETING")  selected @endif>MEETING</option>
                              </select>
                            </th>
                            <th colspan="2">
                              <input type="text" name="progress_expected[]" id="progress_expected" class="form-control" value="{{$progress_expected[2]}}">
                            </th>
                            <th colspan="2">
                              <input type="text" name="notes[]" id="notes" class="form-control" value="{{$notes[2]}}"> 
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
                                <input class="form-check-input my-2" type="radio" name="pip_status" value="1" id="satisfactoryRadio" onclick="toggleSatisfaction('satisfactoryButton')" @if($pip->pip_status === 1) checked @endif>
                                <label class="form-check-label btn btn-success" id="satisfactoryButton" for="satisfactoryRadio">Satisfactory</label>
                              </div>
                            </td>
                            <td>
                              <div class="form-check">
                              <input class="form-check-input my-2" type="radio" name="pip_status" value="0" id="notSatisfactoryRadio" onclick="toggleSatisfaction('notSatisfactoryButton')" @if($pip->pip_status === 0) checked @endif>
                              <label class="form-check-label btn btn-danger" id="notSatisfactoryButton" for="notSatisfactoryRadio">Not Satisfactory</label>
                              </div>
                            </td>
                          </tr>
                        
                            <tr>
                              <th>
                              
                                
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="principal_ackn" id="principal_ackn" @if($pip->principal_ackn == 1) checked checked @endif>
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
      <button type="submit" class="btn btn-primary submit-btn">Update</button>
    </div>
   

  </form>