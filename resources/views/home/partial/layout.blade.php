{{header("cache-Control: no-store, no-cache, must-revalidate")}}
{{header("cache-Control: post-check=0, pre-check=0", false)}}
{{header("Pragma: no-cache")}}
{{header("Expires: Sat, 26 Jul 1997 05:00:00 GMT")}}

@php
    /** @var $view App\Http\ViewModels\ProfileViewModel */

    $get_token = 0;

@endphp

<!DOCTYPE html>
<html>
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>HRMS</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{asset('/img/favicon.png')}}" />

    <!-- Bootstrap CSS -->
  <link href="{{asset('css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Calendar CSS-->
  <link href="{{asset('css/fullcalendar.min.css') }}" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Extra Fonts & Line CSS -->
  <link href="{{asset('css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{asset('css/line-awesome.min.css') }}" rel="stylesheet">
  <link href="{{asset('fonts/fontawesome.css') }}" rel="stylesheet">
  <link href="{{asset('fonts/material.css') }}" rel="stylesheet">
  <link href="{{asset('fonts/feather.css') }}" rel="stylesheet">
  <link href="{{asset('fonts/tabler-icons.min.css') }}" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{asset('vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{asset('css/style.css') }}" rel="stylesheet">

  <!-- Extra CSS File -->
  <link href="{{asset('css/style(2).css') }}" rel="stylesheet">
  <link href="{{asset('css/style(3).css') }}" rel="stylesheet">

  <link href="{{asset('css/custom.css') }}" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.css">
  @yield('page_css')
</head>
<body>

<!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <i class="bi bi-list toggle-sidebar-btn"></i>
      <a href="{{ url('dashboard') }}" class="logo d-flex align-items-center space">
        <img src="{{ asset('img/FAS Logo.png') }}" alt="">
      </a>
    </div><!-- End Logo -->

    <div class="search-bar search-space">
      <form class="search-form d-flex align-items-center" method="POST" action="{{route('get_search')}}">
        @csrf
        <input type="text" name="query" placeholder="Search by Emp Id,Emp first Name or Last Name,Qid " title="Enter search  keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown"> 
          <a class="nav-link nav-icon" href="#" onclick="document.querySelector('#ntf_cnt').style.display='none';" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>    
              <span class="badge bg-primary badge-number badge-round" id="ntf_cnt" style="display:none;" >0</span>    
          </a><!-- End Notification Icon -->
    
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow dropdown-notiftn notifications" id="notif-contents">              
          </ul><!-- End Notification Dropdown Items -->  
        </li>
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ asset('uploads/users/profile/' . Auth::User()->avatar) }}" alt="Profile" 
                 class="rounded-circle"
                 style="width:38px; height:38px;">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::User()->name}}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile dropdown-adjust">
            <li class="dropdown-header">
              <h6>{{Auth::User()->name}}</h6>
              <span></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            @if(!Auth::user()->hasRole(ADMIN_ROLE) && !Auth::user()->hasRole(SUPER_ADMIN_ROLE))
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('employees.show', Auth::User()->id) }}"> 
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            @endif
            
            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> -->

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @php 
    $role_access = Session::get('role_access'); 
  @endphp

  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      @foreach($menulinks as $sidelinks)

        @if( in_array($sidelinks->id, $role_access) )

            @if(null == $sidelinks->child)
                <li class="nav-item">
                  <a class="nav-link @if(Request::segment(1) != $sidelinks->path) collapsed @endif " href="{{ url($sidelinks->path) }}">
                    <i class="bi bi-grid"></i>
                    <span>{{$sidelinks->name}}</span>
                  </a>
                </li> 
            @else
              <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#{{$sidelinks->name}}-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-menu-button-wide"></i><span>{{$sidelinks->name}}</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="{{$sidelinks->name}}-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  @foreach($sidelinks->child as $innerlinks)
                    @if( in_array($innerlinks->id, $role_access) )
                      <li>
                        <a href="{{ url($innerlinks->path) }}">
                          <i class="bi bi-circle"></i><span>{{$innerlinks->name}}</span>
                        </a>
                      </li>
                    @endif
                  @endforeach
                </ul>
              </li>
            @endif
            
        @endif

      @endforeach

    </ul>

  </aside><!-- End Sidebar-->

  

            @yield('content')



   <!-- ======= Footer ======= -->
 <footer id="footer" class="footer">
    @include("home.partial.view-modal")
    <div id="loader" class="lds-dual-ring hidden overlay"></div>

    <div class="copyright">
        &copy; Copyright <strong><span>HRMS</span></strong>. All Rights Reserved |
        Designed by <a href="#">Rakonex</a>
    </div>
</footer>

  <!-- End Footer -->
  <span>
  @php
    $schoolEvent = App\Models\SchoolEvent::get()->toArray();
    $eventData = [];
    foreach($schoolEvent as $val){
        $eventData[] = array(
          'id'=>$val['id'],
          'title' => $val['event_title'],
          'start' => $val['event_from'],
          //'end' => $val['event_to'],
         'end' => date('Y-m-d', strtotime($val['event_to'] . ' +1 day')),        
          'backgroundColor' => $val['bg_color'],
          'event_type'=>$val['event_type'],
          'applicable_to'=>$val['applicable_to'],
          'event_details'=>$val['event_details']
        );        
    }
    $event = json_encode($eventData);

    if(Session::has('success') && session('success')==trans('messages.success_login')){
      $get_token = 1;
    }else{
      $get_token = 0;
    }
    $departments = departments();
  @endphp
 
  <!-- 'className' => $val['bg_color'] -->
  <span>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>  

  <!-- Vendor JS Files -->
  <script src="{{ asset('vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/chart.js/chart.min.js') }}"></script>
  <script src="{{ asset('vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('js/main.js') }}"></script>

  <!-- jQuery -->
  <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>

  <!-- Bootstrap Core JS -->
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>

  <!-- Datetimepicker JS -->
  <script src="{{ asset('js/moment.min.js') }}"></script>

  <!-- Calendar JS-->
  <script src="{{ asset('js/fullcalendar.min.js') }}"></script>
  <!--<script src="{{ asset('js/jquery.fullcalendar.js') }}"></script>-->

  <script src="{{ asset('js/languages/Messages.js') }}"></script> 
  <script src="{{ asset('js/languages/Messages.en_US.js') }}"></script> 

  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.all.min.js"></script> -->
  <script src="{{ asset('js/swal/sweetalert2.js') }}"></script>

  <!-- Custom Function JS File -->
  <script src="{{ asset('js/custom.js') }}"></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.6.1/socket.io.min.js"></script>
  <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.0/echo.min.js"></script> -->
  


  <script>
      var APP_URL = {!! json_encode(url('/')) !!}      

      window.addEventListener('load', function(){
          if(document.querySelector(".alert")){
              setTimeout(function() {
                  document.querySelector(".alert").remove();
                }, 6000);
          }
          /*if(document.querySelector(".text-danger")){
              setTimeout(function() {
                  document.querySelector(".text-danger").remove();
                }, 6000);
          }*/
      });

    !function($) {
      "use strict";

      var CalendarApp = function() {
          this.$body = $("body")
          this.$modal = $('#event-modal'),
          this.$event = ('#external-events div.external-event'),
          this.$calendar = $('#calendar'),
          this.$saveCategoryBtn = $('.save-category'),
          this.$categoryForm = $('#add-category form'),
          this.$extEvents = $('#external-events'),
          this.$calendarObj = null
      };


    /* on drop */
    CalendarApp.prototype.onDrop = function (eventObj, date) {
    var $this = this;
    var originalEventObject = eventObj.data('eventObject');
    var $categoryClass = eventObj.attr('data-class');
    
    var copiedEventObject = $.extend({}, originalEventObject);
    copiedEventObject.start = date;

    if (originalEventObject.end !== null && originalEventObject.end !== undefined) {
        var endDate = new Date(originalEventObject.end);
        endDate.setDate(endDate.getDate() - 1);
        copiedEventObject.end = endDate.toISOString();
    }
    //copiedEventObject.end = originalEventObject.end;
   /* if (originalEventObject.end !== null && originalEventObject.end !== undefined) {
        var endDiff = moment(originalEventObject.end).diff(moment(originalEventObject.start), 'days');
        copiedEventObject.end = moment(date).add(endDiff, 'days').subtract(1, 'days').format();
    }*/
    if ($categoryClass)
        copiedEventObject['className'] = [$categoryClass];

    $this.$calendarObj.fullCalendar('renderEvent', copiedEventObject, true);

    if ($('#drop-remove').is(':checked')) {
        eventObj.remove();
    }
};


    /* on click on event */
    CalendarApp.prototype.onEventClick =  function (calEvent, jsEvent, view) {
        var $this = this;
            var form = $("<form method='POST' class='event-form'></form>");
            form.append("<label class='control-label'>Change event name</label><span class='text-danger'>*</span>");
            form.append("<div class='input-group' style='margin-bottom: 2px;'><input class='form-control' type=text name='event_title' value='" + calEvent.title + "' /></div>");
            // Add Type field
            form.append("<div class='form-group'><label class='control-label' style='margin-top: 2px;'>Type <span class='text-danger'>*</span></label><select class='select form-control' name='Event_type' required>" +
              "<option value='Full Day'" + (calEvent.event_type === 'Full Day' ? " selected" : "") + ">Full Day</option>" +
              "<option value='Single Day'" + (calEvent.event_type === 'Single Day' ? " selected" : "") + ">Single Day</option>" +
              "<option value='Custom'" + (calEvent.event_type === 'Custom' ? " selected" : "") + ">Custom</option>" +
              "<option value='Holiday'" + (calEvent.event_type === 'Holiday' ? " selected" : "") + ">Holiday</option>" +
              "<option value='Annual Leave'" + (calEvent.event_type === 'Annual Leave' ? " selected" : "") + ">Annual Leave</option>" +
              "</select></div>");
            // Add Applicable To field
            var applicableToSelect = "<div class='form-group'><label class='control-label' style='margin-top: 2px;'>Applicable To</label><select class='select form-control' name='Event_for' required><option value='0'" + (calEvent.applicable_to === '0' ? " selected" : "") + ">All</option>";

            @foreach($departments as $department)
                applicableToSelect += "<option value='{{ $department->id }}'" + (calEvent.applicable_to == '{{ $department->id }}' ? " selected" : "") + ">{{ $department->name }}</option>";
            @endforeach

            applicableToSelect += "</select></div>";

            form.append(applicableToSelect);
            // form.append("<div class='input-group'><input class='form-control' type=text name='event_title' value='" + calEvent.title + "' /><span class='input-group-append'><button type='submit' class='btn btn-info btn-md'>Update</button></span></div>");
           //bg colour
           form.append("<div class='form-group'><label class='control-label'>Background colour</label><input type='color' class='form-control form-control-color' id='bg_colour' name='bg_colour' value= '"+calEvent.backgroundColor+"' style='width:32%;'> </div>");
           //details 
           form.append("<div class='form-group'><label>Details <span class='text-danger'>*</span></label><input class='form-control' name='Event_details' value='"+calEvent.event_details+"'></input></div> "); 
          //  form.append("<div class='input-group ' style='align-item:center;'><button type='submit' class='btn btn-info btn-md'>Update</button></div>");
           //update
            var actionUrl = "{{ route('calendar.UpdateEvent') }}";
            form.attr('action', actionUrl);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            form.append("<input type='hidden' name='_token' value='" + csrfToken + "'>");
            form.append("<input type='hidden' name='id' value='" + calEvent.id + "'>");
           
            $this.$modal.modal("show");
            //delete
            $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
                document.querySelector('#loader').classList.remove('hidden');
                $.ajax({
                    url: "{{ route('calendar.DeleteEvent') }}",
                    method: 'POST',
                    data: { id: calEvent.id, _token: csrfToken },
                    success: function (response) {                        
                        $this.$calendarObj.fullCalendar('removeEvents', calEvent.id);
                        document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
                       
                        new Swal(response.message);
                        $this.$modal.modal('hide');
                        
                    },
                    error: function (xhr, status, error) {
                      document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
                        console.error(error);
                    }
                });
            });

         //update
           // $this.$modal.find('form').on('submit', function (event) {
            $('#updateEventButton').click(function(event) {
                event.preventDefault(); 

                document.querySelector('#loader').classList.remove('hidden');
                var formData = $this.$modal.find('form').serialize();

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
                        new Swal(response.message);
                        calEvent.title = form.find("input[type='text']").val();
                        $this.$calendarObj.fullCalendar('updateEvent', calEvent);
                        $this.$modal.modal('hide');
                        window.location.reload();
                    },
                    error: function (xhr, status, error) {
                        document.querySelector('#loader').classList.add('lds-dual-ring', 'overlay', 'hidden');
                        console.error(error);
                    }
                });

                return false;
            });

            $this.$modal.find('.close').click(function() {
        $this.$modal.modal('hide');
    });
    },
    /* on select */
    CalendarApp.prototype.onSelect = function (start, end, allDay) {
      
        var $this = this;
            $this.$modal.modal({
                backdrop: 'static'
            });
            var form = $("<form></form>");
            form.append("<div class='row'></div>");
            form.find(".row")
                .append("<div class='col-md-12'><div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' type='text' name='title'/></div></div>")
                .append("<div class='col-md-12'><div class='form-group'><label class='control-label'>Category</label><select class='select form-control' name='category'></select></div></div>")
                .find("select[name='category']")
                .append("<option value='prim-bk' class='fw-bold prim-bk'>[ #0D6EFD ]</option>")                       
                .append("<option value='cful-bk' class='fw-bold cful-bk'>[ #55CE63 ]</option>")
                .append("<option value='impo-bk' class='fw-bold impo-bk'>[ #FF3A6E ]</option>")                        
                .append("<option value='info-bk' class='fw-bold info-bk'>[ #3EC9D6 ]</option>")
                .append("<option value='gen-bk' class='fw-bold gen-bk'>[ #D4D2D2 ]</option>")
                .append("<option value='bg-warning'>Warning</option></div></div>");
            $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                form.submit();
            });
            $this.$modal.find('form').on('submit', function () {
                var title = form.find("input[name='title']").val();
                var beginning = form.find("input[name='beginning']").val();
                var ending = form.find("input[name='ending']").val();
                var categoryClass = form.find("select[name='category'] option:checked").val();
                if (title !== null && title.length != 0) {
                   
                    $this.$calendarObj.fullCalendar('renderEvent', {
                        title: title,
                        start:start,
                        end: end,
                        allDay: false,
                        className: categoryClass
                    }, true);  
                    $this.$modal.modal('hide');
                }
                else{
                    alert('You have to give a title to your event');
                }
                return false;
                
            });
            $this.$calendarObj.fullCalendar('unselect');
    },
    CalendarApp.prototype.enableDrag = function() {
        //init events
        $(this.$event).each(function () {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
            // make the event draggable using jQuery UI
            
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0, //  original position after the drag
                start: function(event, ui) {
        alert('Drag started!'); // Add the alert here
      },
      
            });
        });
    }
    /* Initializing */
    CalendarApp.prototype.init = function() {
        this.enableDrag();
        /*  Initialize the calendar  */
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var form = '';
        var today = new Date($.now());


        var defaultEvents =  {!! $event !!}; 
        // defaultEvents.forEach(function(event) {
        //     if (event.end !== null && event.end !== undefined) {
        //         var endDate = new Date(event.end);
        //         endDate.setDate(endDate.getDate() + 1);
        //         event.end = endDate.toISOString();
        //     }
        // });
      //console.log(defaultEvents);
        var $this = this;
        $this.$calendarObj = $this.$calendar.fullCalendar({
            slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
            minTime: '00:00:00',
            maxTime: '24:00:00',  
            defaultView: 'month',  
            handleWindowResize: true,   
            height: $(window).height() - 200,   
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: defaultEvents,
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            drop: function(date, jsEvent, ui, resourceId)  {
            $this.onDrop($(this), date); },
            select: function (start, end, allDay) { $this.onSelect(start, end, allDay); },
            eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); },
            //eventColor: '#c501df',
            eventDrop: function(event, delta, revertFunc){ 
                
              var eventData = {
                id: event.id,
                title: event.title,
                start: event.start.format(),
                end: null,
                _token: $('meta[name="csrf-token"]').attr('content') // Get the CSRF token from the meta tag in your HTML
              };
              // if (event.end !== null && event.end !== undefined) {
              //     eventData.end = event.end.format(); // Make sure event.end is not null or undefined
              // }
              if (event.end !== null && event.end !== undefined) {
                  // Subtract 1 day from the end date
                  var endDate = moment(event.end).subtract(1, 'days');
                  eventData.end = endDate.format();
              }
              // alert(eventData.end);
              $.ajax({
                  url: "{{ route('calendar.changeEventDate') }}",
                  method: 'POST',
                  data: eventData,
                  success: function (response) {
                    var copiedEventObject = $.extend({}, event); // Create a copy of the event object
                    copiedEventObject.start = response.start;
                    
                    if (response.end !== null && response.end !== undefined) {
                        copiedEventObject.end = moment(response.end); 
                    } else {
                        copiedEventObject.end = null;
                    }
                    
                    $this.$calendarObj.fullCalendar('updateEvent', copiedEventObject);
                  },
                  error: function (xhr, status, error) {
                      console.error(error);
                  }
              });

            }

        });

        //on new event
        this.$saveCategoryBtn.on('click', function(){
            var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
            var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
            if (categoryName !== null && categoryName.length != 0) {
                $this.$extEvents.append('<div class="external-event bg-' + categoryColor + '" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="mdi mdi-checkbox-blank-circle m-r-10 vertical-middle"></i>' + categoryName + '</div>')
                $this.enableDrag();
            }

        });
    },

   //init CalendarApp
    $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
    
}(window.jQuery),

//initializing CalendarApp
function($) {
    "use strict";
    $.CalendarApp.init()
}(window.jQuery);


  /*Other qualifications multiple add*/
  $(function() {
      const maxQualifications = 6;
      const $qualificationsContainer = $('.qualifications-container');
      const $addButton = $('.add-qualification');

      function updateQualificationButtons() {
          const $qualifications = $qualificationsContainer.find('.input-group');
          $addButton.prop('disabled', $qualifications.length >= maxQualifications);
          $qualifications.find('.remove-qualification').prop('disabled', $qualifications.length <= 1);
      }

      function addQualification() {
          const $lastQualification = $qualificationsContainer.find('.input-group:last-child');
          const $newQualification = $lastQualification.clone();
          $newQualification.find('input').val('');
          $newQualification.insertAfter($lastQualification);
          updateQualificationButtons();
      }

      function removeQualification(event) {
          $(event.currentTarget).closest('.input-group').remove();
          updateQualificationButtons();
      }

      $addButton.on('click', addQualification);
      $qualificationsContainer.on('click', '.remove-qualification', removeQualification);
      updateQualificationButtons();
  });

  /*Real time changes*/
  /*const eventSource = new EventSource(APP_URL+'/sse');
  eventSource.addEventListener('message', function (event) {
      const data = JSON.parse(event.data);
      // Handle the received data
  });
  eventSource.addEventListener('error', function (event) {
      // Handle any errors
  });
  eventSource.addEventListener('close', function (event) {
      // Handle the connection being closed
  });*/


  /*const eventSource = new EventSource(APP_URL+'/broadcasting/events');

  eventSource.addEventListener('HrmUpdates', function (event) {
      const data = JSON.parse(event.data);
      // Handle the received data here
      console.log(data);
  });*/



  </script>

  <!-- <script type="module">

      import Echo from "laravel-echo";

      window.Echo = new Echo({
          broadcaster: 'firebase',
      });
          
      window.Echo.channel('hrm-notifs')
          .listen('HrmUpdates', (event) => {
              console.log(event.data);
      });

  </script> -->

  <!-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('a48f607383811b0a8bbf', {
      cluster: 'mt1'
    });

    var channel = pusher.subscribe('hrm-notifs');
    channel.bind('notification', function(data) {
      alert(JSON.stringify(data));
    });
  </script> -->

  <!-- Firebase Notifications related JS starts : Don't try to change the code position -->

  <!-- <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.7.1/firebase-messaging.js"></script> -->
  
  <script src="https://www.gstatic.com/firebasejs/10.5.2/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/10.5.2/firebase-messaging-compat.js"></script>
 
  <script>
    var get_token = {!! json_encode($get_token) !!} 

    /*if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register(APP_URL+'/firebase-messaging-sw.js')
        .then(function(registration) {
            console.log('Registration successful, scope is:', registration.scope);
        }).catch(function(err) {
            console.log('Service worker registration failed, error:', err);
        });
    }*/
  
    const firebaseConfig = {
        apiKey: "AIzaSyDmcQjXQbO41MdaD5pR501eT2Q_Jdjl3BE", 
        authDomain: "hr-connect-pro.firebaseapp.com",
        databaseURL: "https://hr-connect-pro-default-rtdb.firebaseio.com",
        projectId: "hr-connect-pro",
        storageBucket: "hr-connect-pro.appspot.com",
        messagingSenderId: "594201777602",
        appId: "1:594201777602:web:4e08559fb9599ad111b25b",
        measurementId: "G-YXTSS3TKXT"
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();    

    // Get firebase token on login and save it to db
    window.addEventListener('load', function(){
      if(1 == get_token){
        cust.initFirebaseMessagingRegistration();
        /*cust.addAlertsToNotifications(); */ 
      }       

        /*document.querySelector('#login-btn').addEventListener('click', function (event) {
          event.preventDefault();
            initFirebaseMessagingRegistration();                      
        });*/       
        
    });

    // Listen for web notification (Firebase) messages
    messaging.onMessage((payload) => {
        // Customize the payload data as needed
        const { title, body } = payload.notification;

        // Show notification count
        let ntf_cnt = document.getElementById('ntf_cnt');
        ntf_cnt.style.display = 'block';
        ntf_cnt.textContent = parseInt(ntf_cnt.textContent)+1;

        // Update notification contents with the customized data
        let ntf_cntnts =  document.getElementById('notif-contents');
        let current_cntnts = ntf_cntnts.innerHTML;
        let newContent = current_cntnts + "<li class='notification-item'><i class='bi bi-exclamation-circle text-warning'></i><div><a href='"+payload.data.link+"'><h6>"+title+"</h6><p>"+body+"</p></a></div></li><li><hr class='dropdown-divider'></li>";
        ntf_cntnts.innerHTML = newContent;

        // Perform additional actions with server side based on the payload data [if any]
        // ...

    }, e => {
        console.log(e)
    });
    
  </script>
  <!-- Firebase Notifications related JS ends-->


  @yield('script')

</body>
</html>