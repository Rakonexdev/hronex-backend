@extends('home.partial.layout')

@section('content')


<main id="main" class="main">



	<div class="pagetitle" style="margin-bottom: 0px;">
      <div class="row align-items-center">
  
        <div class="col">
          <div class="pagetitle">
            <h1>Calendar</h1>
            <nav>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Calendar</li>
              </ol>
            </nav>
          </div>
        </div>
  
        <div class="col-auto float-right ml-auto" style="margin-bottom: 30px;">
          <a href="#" class="btn btn-primary add-btn" data-toggle="modal" data-target="#add_event" style="padding-bottom: 8px;"><i class="bi bi-plus-lg"></i>Add Event/Holiday</a>
        </div>
  
      </div>
    </div>

    <div class="col-lg-12 msg-div">     

        @if($errors->any())
        <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 97.5%;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif 

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible show">
            {{ session('success') }}            
        </div>
        @endif  

        @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible show">
                {{ session('error') }}            
            </div>
        @endif      

  </div>
    
    <!-- End Page Title -->
 
            <div class="row">
              <div class="col-lg-12">
                <div class="card mb-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                      
                        <!-- Calendar -->

                          <div id="calendar"></div>

                        <!-- /Calendar -->
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
  
          <!-- /Page Content -->
        
          <!-- Add Event Modal -->
          <div id="add_event" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add New</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{route('calendar.addUpdateEvent')}}" method="POST">
                  @csrf
                    <div class="form-group">
                      <label>Name/Title <span class="text-danger">*</span></label>
                      <input class="form-control" type="text" name="Event_name" required>
                    </div>
                    <!-- <div class="col-12"> -->
                      <div class="row">                          
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Type <span class="text-danger">*</span></label>
                                <select class="select form-control" name="Event_type" required>
                                  <option>Choose option</option>
                                  <option value="Full Day">Full Day</option>
                                  <option value="Single Day">Single Day</option>
                                  <option value="Custom">Custom</option>
                                  <option value="Holiday">Holiday</option>
                                  <option value="Annual Leave">Annual Leave</option>
                                </select>
                            </div>   
                          </div>
                          @php
                              $departments = departments();
                          @endphp
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Applicable To</label>
                                <select class="select form-control" name="Event_for" required>
                                    <option value="0">All</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>              
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label>Start Time <span class="text-danger">*</span></label>
                              <input class="form-control" type="datetime-local" name="Event_from" required>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label>End Time<span class="text-danger">*</span></label>
                                <input class="form-control" type="datetime-local" name="Event_end" required>
                            </div>
                          </div>

                      </div>
                    <!-- </div> -->
                    
                    <div class="form-group">
                      <label>Details <span class="text-danger">*</span></label>
                      <textarea class="form-control" name="Event_details"></textarea>
                    </div>  
                    
                    <div class="form-group">
                      <label class="control-label">Background colour</label>
                     <!-- <select class="select form-control" name="bg_colour"> 
                         <option value="prim-bk" class="fw-bold prim-bk">[ #0D6EFD ]</option>                       
                        <option value="cful-bk" class="fw-bold cful-bk">[ #55CE63 ]</option>
                        <option value="impo-bk" class="fw-bold impo-bk">[ #FF3A6E ]</option>                        
                        <option value="info-bk" class="fw-bold info-bk">[ #3EC9D6 ]</option>
                        <option value="gen-bk" class="fw-bold gen-bk">[ #A9AAAA ]</option>
                        <option>Danger</option>
                        <option>Success</option>
                        <option>Purple</option>
                        <option>Primary</option>
                        <option>Pink</option>
                        <option>Info</option>
                        <option>Inverse</option>
                        <option>Orange</option>
                        <option>Brown</option>
                        <option>Teal</option>
                        <option>Warning</option> 
                      </select>-->
                      <input type="color" class=" 
                        form-control form-control-color" 
                        id="bg_colour" 
                        name="bg_colour" 
                        value="#006600"
                        style="width:32%;"> 
                    </div>
                    <div class="submit-section">
                      <button class="btn btn-primary submit-btn">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- /Add Event Modal -->
          
          <!-- Event Modal -->
          <div class="modal custom-modal fade" id="event-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Event</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer text-center">
                  <button type="button" class="btn btn-success submit-btn save-event">Create event</button>
                  <button type='submit' class='btn btn-info btn-md' id="updateEventButton">Update</button>
                  <button type="button" class="btn btn-danger submit-btn delete-event" data-dismiss="modal">Delete</button>
                </div>
              </div>
            </div>
          </div>
          <!-- /Event Modal -->
          
          <!-- Add Category Modal-->
          <div class="modal custom-modal fade" id="add-category">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Add a category</h4>
                </div>
                <div class="modal-body p-20">
                  <form>
                    <div class="row">
                      <div class="col-md-6">
                        <label class="col-form-label">Category Name</label>
                        <input class="form-control" placeholder="Enter name" type="text" name="category-name">
                      </div>
                      <div class="col-md-6">
                        <label class="col-form-label">Choose Category Color</label>
                        <select class="form-control" data-placeholder="Choose a color..." name="category-color">
                          <option value="success">Success</option>
                          <option value="danger">Danger</option>
                          <option value="info">Info</option>
                          <option value="pink">Pink</option>
                          <option value="primary">Primary</option>
                          <option value="warning">Warning</option>
                          <option value="orange">Orange</option>
                          <option value="brown">Brown</option>
                          <option value="teal">Teal</option>
                        </select>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-danger save-category" data-dismiss="modal">Save</button>
                </div>
              </div>
            </div>
          </div>




</main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>



  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
  var modal = $("#event-modal");
 


  $(window).click(function(event) {
    if (event.target === modal[0]) {
      modal.hide();
    }
  });

  </script>
@endsection


