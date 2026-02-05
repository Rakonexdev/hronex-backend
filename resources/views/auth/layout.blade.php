<!DOCTYPE html>
<html>
<head>
    <title>HRMS</title> 

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('/img/favicon.png')}}" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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

</head>
<body class="landing-pg">

<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="{{ url('/') }}" class="logos d-flex align-items-center w-auto">
                              <img src="{{ asset('img/FAS Logo.png') }}" height="72" alt="FAS" />
                            </a>
                        </div><!-- End Logo -->    

                       <!--  @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                            </li>
                        @endguest -->
                    
          
                        @yield('content')


                        <div class="credits">
                            <!-- All the links in the footer should remain intact. -->
                            <!-- You can delete the links only if you purchased the pro version. -->
                            <!-- Licensing information: https://bootstrapmade.com/license/ -->
                            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/ -->
                            Designed by <a href="#">Rakonex</a>
                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->

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

    <script>
            var APP_URL = {!! json_encode(url('/')) !!}

            window.addEventListener('load', function(){
                if(document.querySelector(".alert")){
                    setTimeout(function() {
                       document.querySelector(".alert").remove();
                     }, 6000);
                }
                if(document.querySelector(".text-danger")){
                    setTimeout(function() {
                       document.querySelector(".text-danger").remove();
                     }, 6000);
                }
            });             
    </script>
     
</body>
</html>