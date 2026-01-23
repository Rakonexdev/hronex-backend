
<form action="{{route('scf.update',$scf->id)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">

        <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Date *</label>
          <input type="date" class="form-control" id="date" style="color: #8D8D8D;" name="date" value="{{$scf->scf_date}}" readonly>
        </div>
        <!-- <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Concern form number *</label>
          <input type="text" class="form-control" id="concern_form_number" style="color: #8D8D8D;" name="concern_form_number" value="{{$scf->concern_from_number}}" readonly>
          
        </div>
        <div class="col-sm-12" style="margin-top: 20px;">
          <label for="inputEmail5" class="form-label">Staff Member *</label>
          <input type="text" class="form-control" id="staff_member" style="color: #8D8D8D;" name="staff_member" value="{{$scf->staff_member}}" readonly>
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
                              <input type="number" class="form-control no-border" id="inputEmpId" style="color: #8D8D8D;" name="employee_id" value="{{$employee->employee_no}}" readonly>
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Employee Name</td>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputName5" style="color: #8D8D8D;" value="{{$employee->name}}&nbsp;{{$employee->lname}}" readonly>
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Designation</td>
                            <td scope="row" colspan="2">
                              <select id="inputEmail5" class="form-control" style="color: #8D8D8D;" readonly>
                                <option selected>@if($employee->designations){{$employee->designations->name}}@endif</option>
                                <!--<option>Class Teacher</option>
                                <option>Office Assistant</option>-->
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Department</td>
                            <td scope="row" colspan="2">
                              <select id="inputEmail5" class="form-control" style="color: #8D8D8D;" readonly>
                                <option selected>@if($employee->departments){{$employee->departments->name}} @endif</option>
                                <!--<option>Academics</option>
                                <option>Administration</option>-->
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Date of Joining</td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputName5" style="color: #8D8D8D;" value="{{$employee->joiningdate}}" readonly>
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
                          @php
                            $scf_ans = json_decode($scf->scf_ans_data);
                          @endphp
                            @foreach($scf_datas as $index => $concern)
                                @php
                                    $ans = $scf_ans[$index];
                                @endphp
                                <tr>
                                    <th colspan="2">
                                        {{$concern->scf}}
                                        <input type="hidden" name="concern_ids[]" value="{{$concern->id}}" readonly>
                                    </th>
                                    <th colspan="2">
                                        <textarea class="form-control" name="concerns[]" placeholder="Enter Your FeedBack" readonly>{{$ans}}</textarea>
                                    </th>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="2">Date of Concern</th>
                                <th>
                                    <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="concern_date" value="{{$scf->date_of_concern}}" readonly>
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
                                <textarea class="form-control" placeholder="Enter your Description" name="description" readonly>{{$scf->breif_description}}</textarea>
                            </th>
                          </tr>
                          <tr>
                            <th colspan="2">Suggestions made:</th>
                            <th colspan="2">
                                <textarea class="form-control" placeholder="Enter your Suggestion" name="suggestion" readonly>{{$scf->suggestions_made}}</textarea>
                            </th>
                          </tr>  
                          <tr>
                            <th colspan="2">Update/follow-up:</th>
                            <th colspan="2">
                                <textarea class="form-control" placeholder="Enter your Suggestion" name="followup" readonly>{{$scf->follow_up}}</textarea>
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
                                <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="comments" value="" placeholder="Enter Comment" readonly>{{$scf->comment}}</textarea>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2"> Name of the staff member raising the concern</td>
                            <td scope="row" colspan="2">
                              <div class="col-12" style="padding: 0px;">
                                <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="raising_concern" value="" placeholder="Enter Concern" readonly>{{$scf->raising_concern}}</textarea>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check">
                                
                                <input class="form-check-input my-2" type="radio" name="pip_required" value="0" id="satisfactoryRadio" onclick="toggleSatisfaction('satisfactoryButton')" @if($scf->pip_required == 0) checked @endif>
                                <label class="form-check-label btn btn-success" id="satisfactoryButton" for="satisfactoryRadio">Satisfactory</label>

                               
                              </div>
                             
                            </td>
                            <td>
                              <div class="form-check">
                              <input class="form-check-input my-2" type="radio" name="pip_required" value="1" id="notSatisfactoryRadio" onclick="toggleSatisfaction('notSatisfactoryButton')" @if($scf->pip_required == 1) checked @endif>
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
  
    <!-- <div class="submit-section">
      <button type="submit" class="btn btn-primary submit-btn">Save</button>
    </div> -->
   

  </form>

