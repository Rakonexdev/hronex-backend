@php 
if(365 <= $emp_data->total_days_employment){ 
  $eligible_grat = 'Yes'; 
  //if(1825 <=  $emp_data->total_days_employment)
    //$gratuity_check_days = 30;
  //else
    $gratuity_check_days = 21;
}else{ 
  $eligible_grat = 'No'; 
  $gratuity_check_days = 0;
}
@endphp
          <div class="row">

                <div class="col-sm-6">               
                  <label class="form-label">{{trans('messages.lbl_academic_emp').' '.trans('messages.lbl_id')}}</label> <br />
                  <span id="empid-sp" class="form-label fw-bold">{{$emp_data->employee->employee_no}}</span>
                  <input type="hidden" id="employee_id" name="employee_id" value="{{$emp_data->employee_id}}">
                  <input type="hidden" id="id" name="id" value="{{$emp_data->id}}">
                  <input type="hidden" id="gratuity_status_id" name="gratuity_status_id" value="{{$emp_data->gratuitystatus->id}}">
                  <input type="hidden" name="gratuity_check_days" id="gratuity_check_days" value="{{$gratuity_check_days}}" >
                </div>

                <div class="col-sm-6">               
                  <label class="form-label">{{trans('messages.lbl_academic_emp').' '. trans('messages.lbl_name')}}</label><br />
                  <span id="empname-sp" class="form-label fw-bold">{{$emp_data->employee->name.' '.$emp_data->employee->lname}}</span>
                </div>

                <div class="col-sm-12">&nbsp;</div>

                <div class="col-sm-6">               
                  <label class="form-label">{{trans('messages.lbl_joining').' '.trans('messages.lbl_date')}}</label> <br />
                  <label class="form-label fw-bold">{{date('d-M-Y', strtotime($emp_data->employee->joiningdate))}}</label>
                  <input type="hidden" id="joining_date" name="joining_date" value="{{$emp_data->employee->joiningdate}}">
                </div>                

                <div class="col-sm-6">               
                  <label class="form-label">Unpaid Leave</label> <br />              
                  <label class="form-label fw-bold">{{$leavedata->unpaid_leave}}</label>
                  <input type="hidden" id="unpaid_leave" name="unpaid_leave" value="{{$leavedata->unpaid_leave}}" class="form-control" readonly>
                </div>                

                <div class="col-sm-12">&nbsp;</div>                

                <div class="col-sm-6">               
                  <label class="form-label">Basic Salary</label> <br />               
                  <label class="form-label fw-bold">{{$emp_data->employee->employeePayrollInformation[0]->basic_salary}}</label>
                  <input type="hidden" id="basic_sal" name="basic_sal" value="{{$emp_data->employee->employeePayrollInformation[0]->basic_salary}}">
                </div>

                <div class="col-sm-6">               
                  <label class="form-label">Gross Salary</label> <br />              
                  <label class="form-label fw-bold">{{$emp_data->employee->employeePayrollInformation[0]->gross_total}}</label>
                  <input type="hidden" id="gross_sal" name="gross_sal" value="{{$emp_data->employee->employeePayrollInformation[0]->gross_total}}">
                </div> 

                <div class="col-sm-12">&nbsp;</div>
                 
                <div class="col-sm-6">               
                  <label class="form-label">Notice Period</label> <br />              
                  <label class="form-label fw-bold"><span id="notice_period_label">{{$leavedata->notice_period}}</span></label>
                  <input type="hidden" name="actual_np" id="actual_np" value="{{$leavedata->notice_period}}">
                </div> 
                <div class="col-sm-6">
                  <label class="form-label">Eligibility Of Gratuity</label> <br />
                  <label class="form-label fw-bold">
                    {{$eligible_grat}}
                  </label>
                </div>

            </div>

            <div class="row">

                <div class="col-sm-12" style="margin-top: 20px;">
                  <div class="card">
                    <div class="card-body">

                     <div class="tab-box">
                        <div class="row user-tabs">
                          <div class="col-lg-12 line-tabs">
                            <ul class="nav nav-tabs nav-tabs-solid">
                            <li class="nav-item"><a href="#gen" data-toggle="tab" class="nav-link active">General</a></li>
                            <li class="nav-item"><a href="#grat" data-toggle="tab" class="nav-link">Gratuity</a></li>
                            <li class="nav-item"><a href="#leav" data-toggle="tab" class="nav-link">Leave Accrual</a></li>
                            <li class="nav-item"><a href="#addi" data-toggle="tab" class="nav-link">Other Additions</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>

                    <div class="tab-content">

                      <div id="gen" class="pro-overview tab-pane fade active show">
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
                                    <td scope="row" colspan="2">Last Working Day</td>
                                    <td scope="row" colspan="2">
                                      <input type="date" class="form-control" id="last_working_day" name="last_working_day" value="{{$emp_data->last_working_day}}" onkeyup="cust.calculateNetPay();" style="color: #8D8D8D;">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Total Days Of Employment</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="total_days_employment" name="total_days_employment" value="{{$emp_data->total_days_employment}}" style="color: #8D8D8D;" readonly>                                      
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Net Days Worked</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="net_days_worked" name="net_days_worked" value="{{$emp_data->net_days_worked}}" readonly style="color: #8D8D8D;">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Notice Period Served</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="notice_period" name="notice_period" value="{{$emp_data->notice_period}}" onkeyup="cust.calculateNetPay();" style="color: #8D8D8D;">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Remarks (Notice Period)</td>
                                    <td scope="row" colspan="2">
                                      <textarea class="form-control" id="notice_period_remarks" name="notice_period_remarks" style="color: #8D8D8D;">{!!$emp_data->notice_period_remarks!!}</textarea>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Total Days Last Month</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="total_days_last_month" name="total_days_last_month" value="{{$emp_data->total_days_last_month}}" onkeyup="cust.calculateNetPay();" style="color: #8D8D8D;">
                                    </td>
                                  </tr>
                                  <tr style="display:none;">
                                    <td scope="row" colspan="2">Notice Pay</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="notice_pay" name="notice_pay" value="{{$emp_data->notice_pay}}" style="color: #8D8D8D;" readonly> <br />
                                      <small></small>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Current Monthly Salary</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="current_month_salary" name="current_month_salary" value="{{$emp_data->current_month_salary}}" onchange="cust.calculateNetPay();" style="color: #8D8D8D;">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row">Include Last Payroll</td>
                                    <td scope="row" style="padding-bottom: 52px; text-align:right;">
                                      <input type="checkbox" class="form-check-input" id="last_payroll_chk" name="last_payroll_chk" 
                                                             onchange="cust.calculateNetPay();" 
                                                             style="color: #8D8D8D;" 
                                                             value="1"
                                                             @if(1==$emp_data->last_payroll_chk) checked @endif>
                                    </td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="last_payroll" name="last_payroll" style="color: #8D8D8D;" value="{{$last_payroll_amount}}" readonly>
                                      <small></small>
                                      <br />
                                    </td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div id="grat" class="pro-overview tab-pane fade show">
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
                                    <th colspan="2">Gratuity</th>
                                    <th colspan="2">Value</th>
                                  </tr> -->
                                  <tr>
                                    <td scope="row" colspan="2">Eligible Days</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="eligible_days" name="eligible_days" value="{{$emp_data->eligible_days}}" style="color: #8D8D8D;" readonly>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Gratuity Amount</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="gratuity_add" name="gratuity_add" value="{{$emp_data->gratuity_add}}" style="color: #8D8D8D;" readonly>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Gratuity Deductions</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="gratuity_ded" name="gratuity_ded" value="{{$emp_data->gratuity_ded}}" onchange="cust.calculateNetPay();" style="color: #8D8D8D;" @if($eligible_grat=='No') readonly @endif>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Gratuity Total</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="gratuity_total" name="gratuity_total" value="{{$emp_data->gratuity_total}}" style="color: #8D8D8D;" readonly>
                                    </td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div id="leav" class="pro-overview tab-pane fade show">
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
                                    <th colspan="2">Gratuity</th>
                                    <th colspan="2">Value</th>
                                  </tr> -->
                                  <tr>
                                    <td scope="row" colspan="2">Annual Leave (Entitled annual)</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="annual_leave_entitled" name="annual_leave_entitled" value="{{$emp_data->annual_leave_entitled}}" readonly onchange="cust.calculateNetPay();" style="color: #8D8D8D;">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Accrued Annual Leave</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="accrued_annual_leave" name="accrued_annual_leave" value="{{$emp_data->accrued_annual_leave}}" onchange="cust.calculateNetPay();" style="color: #8D8D8D;">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Annual Leave Availed</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="annual_leave_availed" name="annual_leave_availed" value="{{$emp_data->annual_leave_availed}}" onchange="cust.calculateNetPay();" style="color: #8D8D8D;">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Annual Leave Balance</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="annual_leave_balance" name="annual_leave_balance" value="{{$emp_data->annual_leave_balance}}" onchange="cust.calculateNetPay();" style="color: #8D8D8D;" readonly>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td scope="row" colspan="2">Leave Accrual Amount</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="leave_accrual_amount" name="leave_accrual_amount" value="{{$emp_data->leave_accrual_amount}}" onchange="cust.calculateNetPay();" style="color: #8D8D8D;" readonly>
                                    </td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div id="addi" class="pro-overview tab-pane fade show">
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
                                    <th colspan="2">Deductions</th>
                                    <th colspan="2">Value</th>
                                  </tr> -->
                                  <!-- <tr>
                                    <td scope="row" colspan="2">Additions Type</td>
                                    <td scope="row" colspan="2">
                                      <select id="inputEmail5" class="form-select" style="color: #8D8D8D;">
                                        <option>Ticket Accural</option>
                                      </select>
                                    </td>
                                  </tr> -->
                                  <tr>
                                    <td scope="row" colspan="2">Ticket Accrual Amount</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="ticket_accrual_amount" name="ticket_accrual_amount" value="{{$emp_data->ticket_accrual_amount}}" onchange="cust.calculateNetPay();" style="color: #8D8D8D;">
                                    </td>
                                  </tr>
                                  <!-- <tr>
                                    <td scope="row" colspan="2">Additions Type</td>
                                    <td scope="row" colspan="2">
                                      <select id="inputEmail5" class="form-select" style="color: #8D8D8D;">
                                        <option>Return Ticket</option>
                                      </select>
                                    </td>
                                  </tr> -->
                                  <tr>
                                    <td scope="row" colspan="2">Return Ticket Amount</td>
                                    <td scope="row" colspan="2">
                                      <input type="text" class="form-control" id="return_ticket_amount" name="return_ticket_amount" value="{{$emp_data->return_ticket_amount}}" onchange="cust.calculateNetPay();" style="color: #8D8D8D;">
                                    </td>
                                  </tr>
                                  
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

            <div class="row">

                <div class="col-md-6">
                  <div class="form-groups">
                  <label for="inputEmail5" class="form-label">Net Pay</label>
                  <input type="text" class="form-control" id="net_pay" name="net_pay" value="{{$emp_data->net_pay+$emp_data->last_payroll}}" style="color: #8D8D8D;">
                </div></div>
                <div class="col-md-6">
                  <div class="form-groups">
                  <label for="inputEmail5" class="form-label">Net Pay without Roundup</label>
                  <input type="text" class="form-control" id="net_pay_round_off" name="net_pay_round_off" value="{{$emp_data->net_pay_round_off+$emp_data->last_payroll}}" style="color: #8D8D8D;">
                </div></div>                
                <div class="col-md-12">
                  <div class="form-group">
                  <label for="inputEmail5" class="form-label">Remarks</label>
                  <div class="col-12" style="padding: 0px;">
                    <textarea class="form-control" id="remarks" name="remarks" style="height: 100px; color: #8D8D8D;">{!!$emp_data->remarks!!}</textarea>
                  </div>
                </div></div>

            </div>