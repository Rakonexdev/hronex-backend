<div id="update_employee_status" class="modal custom-modal fade" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">{{trans('messages.btn_update').': '.trans('messages.lbl_academic_emp').' '.trans('messages.lbl_status')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <div class="modal-body">
        	<div class="col-sm-12" id="emp-stat-div"> 

            <form name="employee_status_form" id="employee_status_form" action="{{route('employeeStatusUpdate')}}" method="post" enctype="multipart/form-data">
              @csrf

              <div class="col-xl-12">
                <label class="form-label">{{trans('messages.lbl_current').' '.trans('messages.lbl_status')}}</label> <br />
                <select name="current_status" id="current_status" class="form-select form-group form-focus" style="color: #8D8D8D;">
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
              
              <div class="col-xl-12 pt-4">
                <label class="form-label">{{trans('messages.lbl_inactive').' '.trans('messages.lbl_status')}}</label> <br />
                <select name="inactive_status" id="inactive_status" class="form-select form-group form-focus" style="color: #8D8D8D;" required>
                  <option value="">N.A</option>
                  @foreach(masterDropdown('inactive_status') as $inactive_status)
                  <option value="{{$inactive_status->id}}" {{old('inactive_status') == $inactive_status->id ? 'selected' : '' }}>
                  {{$inactive_status->name}}</option>
                  @endforeach
                  <!-- <option value="1">Resigned</option>
                  <option value="2">Terminated</option> -->
                </select>
              </div>

              <div class="col-xl-12">
                <label class="form-label">{{trans('messages.lbl_inactive').' '.trans('messages.lbl_date')}}</label> <br />
                <input type="date" name="inactive_date" id="inactive_date" class="form-control" />
              </div>

              <div class="col-xl-12 pt-4">
                <label class="form-label">{{trans('messages.lbl_comment').'/'.trans('messages.lbl_reason')}}</label> <br />
                <textarea name="inactive_reason" id="inactive_reason" class="form-control"></textarea>
              </div>           

              <div class="col-xl-12 pt-4">
                <label class="form-label">{{trans('messages.lbl_resig').' / '.trans('messages.lbl_termi') }}
                {{trans('messages.lbl_ltr').' '.trans('messages.lbl_if_any')}}</label> <br />
                <input type="file" name="inactive_attachment" id="inactive_attachment" class="form-control" />
              </div>

              <div class="col-xl-12 py-4" style="display:flex;justify-content: center;">
                <button type="button" class="btn btn-info submit-btn" id="update-emp-stat-btn" onclick="cust.updateEmployeeStatus();">
                  {{trans('messages.btn_update')}}
                </button>
                <input type="hidden" name="employee_id" id="employee_id" value="">
                <input type="hidden" name="user_id" id="user_id" value="">
              </div>

            </form>

          </div>		

		</div>

      </div>
    </div>
  </div>