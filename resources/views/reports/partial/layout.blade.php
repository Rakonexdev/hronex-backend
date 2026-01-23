{{header("cache-Control: no-store, no-cache, must-revalidate")}}
{{header("cache-Control: post-check=0, pre-check=0", false)}}
{{header("Pragma: no-cache")}}
{{header("Expires: Sat, 26 Jul 1997 05:00:00 GMT")}}

<!DOCTYPE html>
<html>
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>FAS-HRMS</title>

    <!-- Bootstrap CSS -->
  <link href="{{asset('css/bootstrap.min.css') }}" rel="stylesheet"> 

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

  <!-- Main CSS File -->
  <link href="{{asset('css/style.css') }}" rel="stylesheet">

  <!-- Extra CSS File -->
  <link href="{{asset('css/style(2).css') }}" rel="stylesheet">
  <link href="{{asset('css/style(3).css') }}" rel="stylesheet">

  <link href="{{asset('css/custom.css') }}" rel="stylesheet">
  @yield('page_css')
</head>
<body>

  <div class="col-xl-12">
    @yield('content') 
  </div>  
  
  
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>  

  <!-- Vendor JS Files -->  
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>   

  <!-- jQuery -->
  <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>

  <!-- Bootstrap Core JS -->
  <script src="{{ asset('js/bootstrap.min.js') }}"></script>

  <!-- Datetimepicker JS -->
  <script src="{{ asset('js/moment.min.js') }}"></script>  

  <script src="{{ asset('js/languages/Messages.js') }}"></script> 
  <script src="{{ asset('js/languages/Messages.en_US.js') }}"></script>   

  <!-- Custom Function JS File -->
  <script src="{{ asset('js/custom.js') }}"></script> 

  <!-- Report excel -->
  <script src="{{ asset('js/export.js') }}"></script>

</body>
</html>