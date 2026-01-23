<div id="update_gratuity" class="modal custom-modal fade" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">{{trans('messages.btn_update').': '.trans('messages.lbl_academic_emp').' '.trans('messages.grat_head')}} & {{trans('messages.lbl_final').' '.trans('messages.lbl_settle')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <div class="modal-body">  

        	<form action="{{route('addgratuity')}}" method="post" id="gratuity-update-form">
        		@csrf                  

							<div class="col-sm-12" id="grat-data-update"> </div>

							<div class="submit-section ss-grat">
				        <button class="btn btn-primary submit-btn updatebtn" id="add-grat-btn">{{trans('messages.btn_update')}}</button>
	            </div>
          </form>       

        </div>

      </div>
    </div>
  </div>