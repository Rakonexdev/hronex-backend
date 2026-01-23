<div class="row">

				<div class='st-head p-4' style="background-color: #edecef;border-radius: 8px;">
					<div class="col-xl-12 pb-2" style="display: flex;flex-direction: row;">
						<div class="col-xl-2">
							{{trans('messages.lbl_id')}}
						</div>
						<div class="col-xl-2">
							{{trans('messages.lbl_name')}}
						</div>
						<div class="col-xl-2">
							{{trans('messages.lbl_joining').' '.trans('messages.lbl_date')}}
						</div>
						<div class="col-xl-2">
							{{trans('messages.lbl_last').' '.trans('messages.lbl_working').' '.trans('messages.lbl_day')}}
						</div>
						<div class="col-xl-2">
							{{trans('messages.grat_head').' '.trans('messages.lbl_total')}}
						</div>
						<div class="col-xl-2">
							{{trans('messages.lbl_final').' '.trans('messages.lbl_settle')}}
						</div>
					</div>
					<div class="col-xl-12 p-4 fw-bold" style="display: flex;flex-direction: row; align-items: center; background-color: #fff;border-radius: 8px;">
						<div class="col-xl-2">
							{{$grat->employee->employee_no}}
						</div>
						<div class="col-xl-2">
							{{$grat->employee->name.' '.$grat->employee->lname}}
						</div>
						<div class="col-xl-2">
							{{date('d-M-Y', strtotime($grat->employee->joiningdate))}}
						</div>
						<div class="col-xl-2">
							{{date('d-M-Y', strtotime($grat->last_working_day))}}
						</div>
						<div class="col-xl-2">
							{{$grat->gratuity_total}}
						</div>
						<div class="col-xl-2">
							{{number_format(($grat->net_pay+$grat->last_payroll), 2)}}
						</div>
					</div>
				</div>

				@if($grat->status != $gratuity_status[3])

					<div class="col-xl-12 pt-4">
						<label class="form-label">{{trans('messages.lbl_status')}}</label> <br />
						<select name="grat_status" id="grat_status" class="form-select form-group form-focus" style="color: #8D8D8D;">
							<option value="0">Choose...</option>
							@foreach($curgratList as $eachstat)
								<option value="{{$eachstat}}" @if($eachstat == $latest_stat->gratuity_status) selected @endif @if($grat->status == $gratuity_status[3]) disabled @endif>{{$eachstat}}</option>
							@endforeach
						</select>
					</div>
					<div class="col-xl-12 @if(Auth::user()->hasRole(PRINCIPAL_ROLE)) hidee @endif">
						
						<label class="form-label">{{trans('messages.lbl_assign').' '.trans('messages.tml_msg_to')}}</label> <br />
						<select name="dest_id" id="dest_id" class="form-select form-group form-focus" style="color: #8D8D8D;">	
							@if(NULL != $toAssign)
								@foreach($toAssign as $eachAssign)
									<option value="{{$eachAssign->id}}">{{ $eachAssign->name }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="col-xl-12 pb-4">
						<label class="form-label">{{trans('messages.lbl_comment')}}</label> <br />
						<textarea name="comment" id="comment" class="form-control" style="color: #8D8D8D;" @if($grat->status == $gratuity_status[3]) readonly @endif></textarea>
					</div>
					@if($latest_stat->dest_id == Auth::user()->id)
					<div class="col-xl-12">
						<div class="submit-section ss-grat">						
								<input type="hidden" id="gratuity_id" name="gratuity_id" value="{{$grat->id}}">
							    <button class="btn btn-primary submit-btn" id="update-grat-stat-btn" onclick="cust.updateGratuityStatus();">{{trans('messages.btn_update')}}</button>						
					    </div>
					</div>
					@endif
				@else							
					<div class="col-xl-12 pt-4">
						<div class="submit-section ss-grat">
							<button class="btn btn-primary submit-btn">{{trans('messages.lbl_approve').' & '.trans('messages.lbl_payroll').' '.trans('messages.lbl_generate')}}</button>						
					    </div>
					</div>
				@endif
				
			</div>