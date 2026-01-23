<div class="row leave-card">

    <h5 class="pb-3 leav-h5">Remaining Leaves</h5>

    <div class="col-lg-8">
        <div class="row">
          
        </div>
    </div>
    <div class="col-lg-4">

    </div>

   
    @foreach($leave_application->full_leave_data as $leavetracker)
        <div class="col-6 col-md-2 col-lg-3">
          <div class="card ">
            <div class="card-body">
              <h6 class="card-title card-title-leave leav-h5">{{ucfirst($leavetracker->name)}}</h6>
              <div class="d-flex align-items-center justify-content-center">
                <div class="card-icon card-icon-leave rounded-circle d-flex align-items-center justify-content-center fw-bold" style="background-color: {{$leavetracker->bg_color}};color: #626264;">
                  {{$leavetracker->leave_days-$leavetracker->taken_days}}
                </div>
               
              </div>
               
             </div>
          </div>
        </div>
    @endforeach
 
        
</div>