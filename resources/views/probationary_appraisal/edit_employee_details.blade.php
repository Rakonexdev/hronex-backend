@php
    $user = Auth::user();
    $role = $user->role;
@endphp
<form action="{{url('pip-appraisal/update')}}/{{$appraisal_datas->id}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
 
      <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Evaluation Date *</label>
          <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="evaluation_date" value="{{$appraisal_datas->evaluation_date}}">
        </div>
        <div class="col-sm-6">
          <label for="inputEmail5" class="form-label">Evaluation Type *</label>
          <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="evaluation_type" value="{{$appraisal_datas->evaluation_type}}">
            <option <?php echo ($appraisal_datas->evaluation_type == 'Probationary') ? 'selected' : ''; ?>>Probationary</option>
            <option <?php echo ($appraisal_datas->evaluation_type == 'Annual') ? 'selected' : ''; ?>>Annual</option>
            <option <?php echo ($appraisal_datas->evaluation_type == 'General') ? 'selected' : ''; ?>>General</option>
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
                    <li class="nav-item"><a href="#appr_organizational1" data-toggle="tab" class="nav-link">COMPETENCIES (Ratings and weightages entered by appraiser)</a></li>
                    <li class="nav-item"><a href="#appr_technical2" data-toggle="tab" class="nav-link">Employee Characteristics</a></li>
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
                              <input type="number" class="form-control no-border" id="inputEmpId" style="color: #8D8D8D;"  value="{{$appraisal_datas->employee->employee_no}}">
                              <input type="hidden" class="form-control no-border" id="inputEmpId" style="color: #8D8D8D;" name="employee_id" value="{{$appraisal_datas->employee_id}}">

                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Employee Name</td>
                            <td scope="row" colspan="2">
                              <input type="text" class="form-control" id="inputName5" style="color: #8D8D8D;" value="{{$appraisal_datas->employee->name}}&nbsp;{{$appraisal_datas->employee->lname}}">
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Designation</td>
                            <td scope="row" colspan="2">
                              <select id="inputEmail5" class="form-control" style="color: #8D8D8D;">
                                <option selected>{{$appraisal_datas->employee->designations->name}}</option>
                                <!--<option>Class Teacher</option>
                                <option>Office Assistant</option>-->
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Department</td>
                            <td scope="row" colspan="2">
                              <select id="inputEmail5" class="form-control" style="color: #8D8D8D;">
                                <option selected>{{$appraisal_datas->employee->departments->name}}</option>
                                <!--<option>Academics</option>
                                <option>Administration</option>-->
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">Date of Joining</td>
                            <td scope="row" colspan="2">
                              <input type="date" class="form-control" id="inputName5" style="color: #8D8D8D;" value="{{$appraisal_datas->employee->dob}}">
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
                            @if($user->hasRole(VP_ROLE))
                              <th colspan="2">HOD Rating</th>
                            @endif
                            @if($user->hasRole('Principal'))
                              <th colspan="2">Principal Rating</th>
                            @endif
                          </tr>
                          @foreach ($appraisalFeedback as $appraisalData)
                            @php
                                $hodRatings = json_decode($appraisal_datas->hod_rating);
                                $principalRatings = json_decode($appraisal_datas->principal_rating);
                                $index = array_search($appraisalData->id, $appraisalDataIds);
                                $hodRating = isset($hodRatings[$index]) ? $hodRatings[$index] : null;
                                $principalRating = isset($principalRatings[$index]) ? $principalRatings[$index] : null;
                            @endphp
                                @if($appraisalData->appriasal_type->type_name == "COMPETENCIES (Ratings and weightages entered by appraiser)")
                                    <tr>
                                        <td scope="row" colspan="2">
                                          {{$appraisalData->details}}
                                          <input type="hidden" name="appraisal_data[]" value="{{$appraisalData->id}}">
                                        </td>
                                        @if($user->hasRole(VP_ROLE))
                                        <td scope="row" colspan="2">
                                          <select id="hod_rating_{{$appraisalData->id}}" class="form-select" style="color: #8D8D8D;" name="hod_rating[]" value="">
                                              <option selected></option>
                                              <option>NA</option>
                                              <option {{ $hodRating == 1 ? 'selected' : '' }}>1</option>
                                              <option {{ $hodRating == 2 ? 'selected' : '' }}>2</option>
                                              <option {{ $hodRating == 3 ? 'selected' : '' }}>3</option>
                                              <option {{ $hodRating == 4 ? 'selected' : '' }}>4</option>
                                              <option {{ $hodRating == 5 ? 'selected' : '' }}>5</option>
                                          </select>
                                        </td>
                                        @endif
                                        @if($user->hasRole('Principal'))
                                        <td scope="row" colspan="2">
                                          <select id="principal_rating_{{$appraisalData->id}}" class="form-select" style="color: #8D8D8D;" name="principal_rating[]" value="">
                                              <option selected></option>
                                              <option>NA</option>
                                              <option {{ $principalRating == 1 ? 'selected' : '' }}>1</option>
                                              <option {{ $principalRating == 2 ? 'selected' : '' }}>2</option>
                                              <option {{ $principalRating == 3 ? 'selected' : '' }}>3</option>
                                              <option {{ $principalRating == 4 ? 'selected' : '' }}>4</option>
                                              <option {{ $principalRating == 5 ? 'selected' : '' }}>5</option>
                                          </select>
                                        </td>
                                        @endif
                                    </tr>
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
                            @if($user->hasRole(VP_ROLE))
                              <th colspan="2">HOD Rating</th>
                            @endif
                            @if($user->hasRole('Principal'))
                              <th colspan="2">Principal Rating</th>
                            @endif
                          </tr>
                          @foreach ($appraisalFeedback as $appraisalData)
                          
                            @php
                                $hodRatings = json_decode($appraisal_datas->hod_rating);
                                $principalRatings = json_decode($appraisal_datas->principal_rating);
                                $index = array_search($appraisalData->id, $appraisalDataIds);
                                $hodRating = isset($hodRatings[$index]) ? $hodRatings[$index] : null;
                                $principalRating = isset($principalRatings[$index]) ? $principalRatings[$index] : null;
                            @endphp
                                @if($appraisalData->appriasal_type->type_name === "Employee Characteristics")
                                    
                                    <tr>
                                        <td scope="row" colspan="2">
                                          {{$appraisalData->details}}
                                          <input type="hidden" name="appraisal_data[]" value="{{$appraisalData->id}}">
                                        </td>
                                        @if($user->hasRole(VP_ROLE))
                                        <td scope="row" colspan="2">
                                          <select id="hod_rating_{{$appraisalData->id}}" class="form-select" style="color: #8D8D8D;" name="hod_rating[]" value="">
                                              <option selected></option>
                                              <option>NA</option>
                                              <option {{ $hodRating == 1 ? 'selected' : '' }}>1</option>
                                              <option {{ $hodRating == 2 ? 'selected' : '' }}>2</option>
                                              <option {{ $hodRating == 3 ? 'selected' : '' }}>3</option>
                                              <option {{ $hodRating == 4 ? 'selected' : '' }}>4</option>
                                              <option {{ $hodRating == 5 ? 'selected' : '' }}>5</option>
                                          </select>
                                        </td>
                                        @endif
                                        @if($user->hasRole('Principal'))
                                        <td scope="row" colspan="2">
                                          <select id="principal_rating_{{$appraisalData->id}}" class="form-select" style="color: #8D8D8D;" name="principal_rating[]" value="">
                                              <option selected></option>
                                              <option>NA</option>
                                              <option {{ $principalRating == 1 ? 'selected' : '' }}>1</option>
                                              <option {{ $principalRating == 2 ? 'selected' : '' }}>2</option>
                                              <option {{ $principalRating == 3 ? 'selected' : '' }}>3</option>
                                              <option {{ $principalRating == 4 ? 'selected' : '' }}>4</option>
                                              <option {{ $principalRating == 5 ? 'selected' : '' }}>5</option>
                                          </select>
                                        </td>
                                        @endif
                                    </tr>
                                    
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
                            <th colspan="2">Recommended By</th>
                          </tr>
                            @php
                                $future_target         = json_decode($appraisal_datas->future_targets_data);
                                $future_target_date    = json_decode($appraisal_datas->future_target_review_date);
                                $future_recommended    = json_decode($appraisal_datas->future_targets_recommended);
                            @endphp
                            <tr>
                            <td scope="row" colspan="2">
                              @if(isset($future_target[0]) && !empty($future_target[0] && $future_target[0] !=null))
                                <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]"value="{{ $future_target[0] }} ">
                              @else
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]" value=" ">
                              @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($future_target_date[0]) && !empty($future_target_date[0] && $future_target_date[0] !=null))
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" value="@if(isset($future_target_date[0]) && !empty($future_target_date[0])){{ date('Y-m-d', strtotime($future_target_date[0])) }}@endif">
                            @else 
                            <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" value="">
                            @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($future_recommended[0]) && !empty($future_recommended[0] && $future_recommended[0] !=null))

                              <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="future_recommended[]" value="">
                                <option  @if(isset($future_recommended[0]) && $future_recommended[0] == 'Choose...') selected @endif>Choose...</option>
                                <option  @if(isset($future_recommended[0]) && $future_recommended[0] == 'Principal') selected @endif>Principal</option>
                                <option @if(isset($future_recommended[0]) && $future_recommended[0] == 'Vice-Principal') selected @endif>Vice-Principal</option>
                                <option @if(isset($future_recommended[0]) && $future_recommended[0] == 'HOD') selected @endif>HOD</option>
                              </select>
                            @else
                              <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="future_recommended[]" value="">
                                <option >Choose...</option>
                                <option value="Principal">Principal</option>
                                <option value="Vice-Principal">Vice-Principal</option>
                                <option value="HOD">HOD</option>
                              </select>

                            @endif
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                              @if(isset($future_target[1]) && !empty($future_target[1] && $future_target[1] !=null))
                                <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]"value="{{ $future_target[1] }} ">
                              @else
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]" value=" ">
                              @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($future_target_date[1]) && !empty($future_target_date[1] && $future_target_date[1] !=null))
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" value="@if(isset($future_target_date[0]) && !empty($future_target_date[0])){{ date('Y-m-d', strtotime($future_target_date[0])) }}@endif">
                            @else 
                            <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" value="">
                            @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($future_recommended[1]) && !empty($future_recommended[1] && $future_recommended[1] !=null))

                              <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="future_recommended[]" value="">
                                <option  @if(isset($future_recommended[1]) && $future_recommended[1] == 'Choose...') selected @endif>Choose...</option>
                                <option  @if(isset($future_recommended[1]) && $future_recommended[1] == 'Principal') selected @endif>Principal</option>
                                <option @if(isset($future_recommended[1]) && $future_recommended[1] == 'Vice-Principal') selected @endif>Vice-Principal</option>
                                <option @if(isset($future_recommended[1]) && $future_recommended[1] == 'HOD') selected @endif>HOD</option>
                              </select>
                            @else
                              <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="future_recommended[]" value="">
                                <option >Choose...</option>
                                <option value="Principal">Principal</option>
                                <option value="Vice-Principal">Vice-Principal</option>
                                <option value="HOD">HOD</option>
                              </select>

                            @endif
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                              @if(isset($future_target[2]) && !empty($future_target[2] && $future_target[2] !=null))
                                <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]"value="{{ $future_target[2] }} ">
                              @else
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target[]" value=" ">
                              @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($future_target_date[2]) && !empty($future_target_date[2] && $future_target_date[2] !=null))
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" value="@if(isset($future_target_date[2]) && !empty($future_target_date[2])){{ date('Y-m-d', strtotime($future_target_date[2])) }}@endif">
                            @else 
                            <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="future_target_date[]" value="">
                            @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($future_recommended[2]) && !empty($future_recommended[2] && $future_recommended[2] !=null))

                              <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="future_recommended[]" value="">
                                <option  @if(isset($future_recommended[2]) && $future_recommended[2] == 'Choose...') selected @endif>Choose...</option>
                                <option  @if(isset($future_recommended[2]) && $future_recommended[2] == 'Principal') selected @endif>Principal</option>
                                <option @if(isset($future_recommended[2]) && $future_recommended[2] == 'Vice-Principal') selected @endif>Vice-Principal</option>
                                <option @if(isset($future_recommended[2]) && $future_recommended[2] == 'HOD') selected @endif>HOD</option>
                              </select>
                            @else
                              <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="future_recommended[]" value="">
                                <option >Choose...</option>
                                <option value="Principal">Principal</option>
                                <option value="Vice-Principal">Vice-Principal</option>
                                <option value="HOD">HOD</option>
                              </select>

                            @endif
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
                            <th colspan="2">Recommended By</th>
                          </tr>
                       
                            @php
                                $training_titles         = json_decode($appraisal_datas->training_title);
                                $training_date          = json_decode($appraisal_datas->training_due_date);
                                $training_recomended    = json_decode($appraisal_datas->training_recommended);
                            @endphp
                          <tr>
                            <td scope="row" colspan="2">
                            @if(isset($training_titles[0]) && !empty($training_titles[0] && $training_titles[0] !=null))
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_title[]" value="@if(isset($training_titles[0])){{ $training_titles[0] }} @endif">
                            @else
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_title[]" value="">
                            @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($training_date[0]) && !empty($training_date[0] && $training_date[0] !=null))
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_date[]" value="@if(isset($training_date[0] )  && !empty($training_date[0])){{$training_date[0] }}@endif">
                            @else
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_date[]" value="">
                            @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($training_recomended[0]) && !empty($training_recomended[0] && $training_recomended[0] !=null))
                              <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="training_recomended[]" >
                              <option  @if(isset($training_recomended[0]) && $training_recomended[0] == 'Choose...') selected @endif>Choose...</option>
                                <option @if(isset($training_recomended[0]) && $training_recomended[0] == 'Principal') selected @endif>Principal</option>
                                <option @if(isset($training_recomended[0]) && $training_recomended[0] == 'Vice-Principal') selected @endif>Vice-Principal</option>
                                <option @if(isset($training_recomended[0]) && $training_recomended[0] == 'HOD') selected @endif>HOD</option>
                              </select>
                            @else
                            <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="training_recomended[]" >
                                <option >Choose...</option>
                                <option value="Principal">Principal</option>
                                <option value="Vice-Principal">Vice-Principal</option>
                                <option value="HOD">HOD</option>
                              </select>
                            @endif
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                            @if(isset($training_titles[1]) && !empty($training_titles[1] && $training_titles[1] !=null))
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_title[]" value="@if(isset($training_titles[1])){{ $training_titles[1] }} @endif">
                            @else
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_title[]" value="">
                            @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($training_date[1]) && !empty($training_date[1] && $training_date[1] !=null))
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_date[]" value="@if(isset($training_date[1] )  && !empty($training_date[1])){{$training_date[1] }}@endif">
                            @else
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_date[]" value="">
                            @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($training_recomended[1]) && !empty($training_recomended[1] && $training_recomended[1] !=null))
                              <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="training_recomended[]" >
                              <option  @if(isset($training_recomended[1]) && $training_recomended[1] == 'Choose...') selected @endif>Choose...</option>
                                <option @if(isset($training_recomended[1]) && $training_recomended[1] == 'Principal') selected @endif>Principal</option>
                                <option @if(isset($training_recomended[1]) && $training_recomended[1] == 'Vice-Principal') selected @endif>Vice-Principal</option>
                                <option @if(isset($training_recomended[1]) && $training_recomended[1] == 'HOD') selected @endif>HOD</option>
                              </select>
                            @else
                               <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="training_recomended[]" >
                                <option >Choose...</option>
                                <option value="Principal">Principal</option>
                                <option value="Vice-Principal">Vice-Principal</option>
                                <option value="HOD">HOD</option>
                              </select>
                            @endif
                            </td>
                          </tr>
                          <tr>
                            <td scope="row" colspan="2">
                            @if(isset($training_titles[2]) && !empty($training_titles[2] && $training_titles[2] !=null))
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_title[]" value="@if(isset($training_titles[2])){{ $training_titles[2] }} @endif">
                            @else
                              <input type="text" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_title[]" value="">
                            @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($training_date[2]) && !empty($training_date[2] && $training_date[2] !=null))
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_date[]" value="@if(isset($training_date[2] )  && !empty($training_date[2])){{$training_date[2] }}@endif">
                            @else
                              <input type="date" class="form-control" id="inputEmail5" style="color: #8D8D8D;" name="training_date[]" value="">
                            @endif
                            </td>
                            <td scope="row" colspan="2">
                            @if(isset($training_recomended[2]) && !empty($training_recomended[2] && $training_recomended[2] !=null))
                              <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="training_recomended[]" >
                              <option  @if(isset($training_recomended[2]) && $training_recomended[2] == 'Choose...') selected @endif>Choose...</option>
                                <option @if(isset($training_recomended[2]) && $training_recomended[2] == 'Principal') selected @endif>Principal</option>
                                <option @if(isset($training_recomended[2]) && $training_recomended[2] == 'Vice-Principal') selected @endif>Vice-Principal</option>
                                <option @if(isset($training_recomended[2]) && $training_recomended[2] == 'HOD') selected @endif>HOD</option>
                              </select>
                            @else
                              <select id="inputEmail5" class="form-select" style="color: #8D8D8D;" name="training_recomended[]" >
                                <option >Choose...</option>
                                <option value="Principal">Principal</option>
                                <option value="Vice-Principal">Vice-Principal</option>
                                <option value="HOD">HOD</option>
                              </select>
                            @endif
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
                        @php
                          $employee_comments         = $appraisal_datas->employee_comments;
                          $hod_comments              = $appraisal_datas->hod_comments;
                          $principal_comments        = $appraisal_datas->principal_comments;
                        @endphp
                        
                          <!-- <tr>
                            <td scope="row" colspan="2">Employee Comments</td>
                            <td scope="row" colspan="2">
                              <div class="col-12" style="padding: 0px;">
                                <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="employee_comments[]" >{{$employee_comments[0] ?? ''}}</textarea>
                              </div>
                            </td>
                          </tr> -->
                          @if($user->hasRole(VP_ROLE))
                          <tr>
                            <td scope="row" colspan="2">Head of Department Comments</td>
                            <td scope="row" colspan="2">
                              <div class="col-12" style="padding: 0px;">
                                <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="hod_comments" value="">{{$hod_comments ?? ''}}</textarea>
                              </div>
                            </td>
                          </tr>
                          @endif
                          @if($user->hasRole('Principal'))
                          <tr >
                            <td scope="row" colspan="2">Principal's Comments</td>
                            <td scope="row" colspan="2">
                              <div class="col-12" style="padding: 0px;">
                                <textarea class="form-control" id="inputAddress2" style="height: 100px; color: #8D8D8D;" name="principal_comments" value=""  >{{$principal_comments ?? ''}}</textarea>
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

