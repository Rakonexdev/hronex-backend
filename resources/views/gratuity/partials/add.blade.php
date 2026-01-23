<div id="add_gratuity" class="modal custom-modal fade" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">{{trans('messages.lbl_academic_emp').' '.trans('messages.grat_head')}} & {{trans('messages.lbl_final').' '.trans('messages.lbl_settle')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <div class="modal-body">  

        	<form action="{{route('addgratuity')}}" id="add-grat-form" class="grat-form" method="post">
        		@csrf
	          <div class="row" id="add-filter">
	            	<div class="col-sm-6 data-list-div">        
				        <label for="empList" class="form-label">{{trans('messages.lbl_academic_emp').' '.trans('messages.lbl_id')}}</label>
								<input class="form-control" list="emplistOp" id="empList" placeholder="Type to search..." oninput='onInput()' autocomplete="off">
								<datalist id="emplistOp" onclick="" autocomplete="off">
									@if(0 < count($emp_list))
					       		@foreach($emp_list as $eachemps)
					       			@if(null == $eachemps->gratuity)
										  	<option value="{{$eachemps->employee_no}}"></option>
										  @endif							  
										@endforeach
							        @endif
								</datalist>				    
							</div>
							<div class="col-sm-6"></div>
							<div class="col-sm-12">&nbsp;</div>
						</div>

				<div class="col-sm-12" id="grat-data"> </div>

				<div class="submit-section ss-grat hidee">
          <button type="button" class="btn btn-primary submit-btn" id="add-grat-btn">{{trans('messages.btn_submit')}}</button>
        </div>

          </form>       

        </div>

      </div>
    </div>
  </div>