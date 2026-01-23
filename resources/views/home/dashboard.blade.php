@extends('home.partial.layout')
  
@section('content')


<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

          @if(isset($curacc[$userRole]))

            @if(in_array('AE', $curacc[$userRole]))
              <!-- Active Employees Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Options</h6>
                      </li>

                      <li><a class="dropdown-item" href="{{url('employees')}}">View more</a></li>

                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Active Employees</h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-lines-fill"></i>
                      </div>
                      <div class="ps-3">

                        <h6>{{$active_employees}}</h6>
                        <span class="text-primary small pt-1 fw-bold">Active</span>
                        <span class="text-muted small pt-2">Employees</span>

                      </div>
                    </div>
                  </div>

                </div>
              </div><!-- End Active Employees Card -->
              @endif

              @if(in_array('IE', $curacc[$userRole]))
              <!-- Inactive Employees Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Options</h6>
                      </li>

                      <li><a class="dropdown-item" href="{{url('inactive_employees')}}">View more</a></li>

                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Inactive Employees</h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-lines-fill"></i>
                      </div>
                      <div class="ps-3">

                        <h6>{{$inactive_employees}}</h6>
                        <span class="text-primary small pt-1 fw-bold">Inactive</span>
                        <span class="text-muted small pt-2">Employees</span>

                      </div>
                    </div>
                  </div>

                </div>
              </div><!-- End Inactive Employees Card -->
              @endif

              @if(in_array('LA', $curacc[$userRole]))
              <!-- Leave Approval Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card revenue-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Options</h6>
                      </li>

                      <li><a class="dropdown-item" href="{{ url('leaveapproval') }}">View more</a></li>

                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Leave Approval</h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-clipboard-check"></i>
                      </div>
                      <div class="ps-3">

                        <h6>{{$leave_approval_pending}}</h6>

                        <span class="text-success small pt-1 fw-bold">Pending</span>
                        <span class="text-muted small pt-2">Leaves</span>

                      </div>
                    </div>
                  </div>

                </div>
              </div><!-- End Leave Approval Card -->
              @endif

              @if(in_array('AL', $curacc[$userRole]))
              <!-- Academic Leaves Card -->
              <div class="col-xxl-4 col-xl-12">

                <div class="card info-card customers-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Options</h6>
                      </li>

                      <li><a class="dropdown-item" href="{{ url('calendar') }}">View more</a></li>

                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Events</h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-calendar3"></i>
                      </div>
                      <div class="ps-3">

                        <h6>{{$academic_year_leaves}}</h6>
                        <span class="text-danger small pt-1 fw-bold">Annual Leaves</span>
                        <span class="text-muted small pt-2 ps-1">in 2023</span>

                      </div>
                    </div>

                  </div>
                </div>

              </div><!-- End Academic Leaves Card -->
              @endif

              @if(in_array('QE', $curacc[$userRole]))
              <!-- Qid Expiry Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Options</h6>
                      </li>

                      <li><a class="dropdown-item" href="{{url('employees')}}?type=QE">View more</a></li>

                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">QID Expiry </h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-lines-fill"></i>
                      </div>
                      <div class="ps-3">

                        <h6>{{$qid_exp_count}}</h6>
                        <span class="text-muted small pt-2">Employee(s)</span>

                      </div>
                    </div>
                  </div>

                </div>
              </div><!-- End Qid Expiry Card -->
              @endif

              @if(in_array('PE', $curacc[$userRole]))
              <!-- Passport Expiry Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">

                  <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Options</h6>
                      </li>

                      <li><a class="dropdown-item" href="{{url('employees')}}?type=PE">View more</a></li>

                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Passport Expiry </h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-lines-fill"></i>
                      </div>
                      <div class="ps-3">

                        <h6>{{$pass_exp_count}}</h6>
                        <span class="text-muted small pt-2">Employee(s)</span>

                      </div>
                    </div>
                  </div>

                </div>
              </div><!-- End Passport Expiry Card -->
              @endif
            @endif

            <!-- Reports -->
            <!--<div class="col-12">
              <div class="card">

                <div class="card-body">
                  <h5 class="card-title">Staff Performance</h5>-->

                  <!-- Line Chart -->
                  <!--<div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Sales',
                          data: [31, 40, 28, 51, 42, 82, 56],
                        }, {
                          name: 'Revenue',
                          data: [11, 32, 45, 32, 34, 52, 41]
                        }, {
                          name: 'Customers',
                          data: [15, 11, 32, 18, 9, 24, 11]
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script> -->
                  <!-- End Line Chart -->

                <!--</div>

              </div>
            </div>--> <!-- End Reports -->

            <!-- Recent Sales -->
            <!-- <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Options</h6>
                    </li>

                    <li><a class="dropdown-item" href="{{ url('leaveapproval') }}">View more</a></li>

                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Leave Approval</h5>

                  <table class="table table-striped custom-table datatable dataTable-selector" style="display: inline-table; padding: 5px;">
                    <thead>
                      <tr>
                        <th scope="col">Emp Name</th>
                        <th scope="col">Emp No.</th>
                        <th scope="col">Type of Leave</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <h2 class="table-avatar">
                            <a href="Profile-FAS HRMS.html"><img class="avatar avatar-xs" src="{{asset('img/profile-img.jpg')}}"></a>
                            <a href="Profile-FAS HRMS.html">Mathew Thomas<span>Class Teacher</span></a>
                          </h2>
                        </td>
                        <td class="sorting_1">0001</td>
                        <td>Casual Leave</td>
                        <td><span class="badge bg-success">Approved</span></td>
                      </tr>
                    </tbody>
                  </table>

                </div>

              </div>
            </div> --><!-- End Recent Sales -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Options</h6>
                </li>

                <li><a class="dropdown-item" href="{{ url('dashboard') }}">View more</a></li>

              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Activity Log</h5>

              <div class="activity">

                @if(0 < count($activities))
                  @foreach($activities as $eachactivity)
                    <div class="activity-item d-flex" style="font-size: 0.7rem;">
                      <div class="activite-label">
                        {{$eachactivity->hours}} hrs {{$eachactivity->minutes}} min
                        &nbsp;
                      </div>
                      <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                      <div class="activity-content">
                        <a href="#" class="fw-bold text-dark">{{$eachactivity->module.' '.$eachactivity->event}}:</a> @if(null!=$eachactivity->user){{$eachactivity->user->name}}@endif
                      </div>
                    </div>
                  @endforeach
                @else
                    <div class="activity-item d-flex">
                      <div class="activite-label">  &nbsp; </div>
                      <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                      <div class="activity-content">
                        {{trans('messages.no_data')}}
                      </div>
                    </div>
                @endif

                <!-- <div class="activity-item d-flex">
                  <div class="activite-label">32 min</div>
                  <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                  <div class="activity-content">
                    Activity <a href="#" class="fw-bold text-dark">One</a> here
                  </div>
                </div>

                <div class="activity-item d-flex">
                  <div class="activite-label">56 min</div>
                  <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                  <div class="activity-content">
                    Activity Two
                  </div>
                </div>

                <div class="activity-item d-flex">
                  <div class="activite-label">2 hrs</div>
                  <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                  <div class="activity-content">
                    Activity Three
                  </div>
                </div>

                <div class="activity-item d-flex">
                  <div class="activite-label">1 day</div>
                  <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                  <div class="activity-content">
                    Activity <a href="#" class="fw-bold text-dark">Four</a> here
                  </div>
                </div>

                <div class="activity-item d-flex">
                  <div class="activite-label">2 days</div>
                  <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                  <div class="activity-content">
                    Activity Five
                  </div>
                </div>

                <div class="activity-item d-flex">
                  <div class="activite-label">4 weeks</div>
                  <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                  <div class="activity-content">
                    Activity Six
                  </div>
                </div> -->

              </div>

            </div>
          </div><!-- End Recent Activity -->

          

        </div><!-- End Right side columns -->

      </div>
    </section>

</main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>








<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    You are Logged In
                </div>
            </div>
        </div>
    </div>
</div> -->



@endsection