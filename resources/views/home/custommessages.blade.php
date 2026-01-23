@extends('home.partial.layout')
   
@section('content')


<main id="main" class="main">

    <div class="pagetitle">
      <h1>Custom Notifications</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Custom Notifications</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    
    <section class="section dashboard">
      <div class="row">



                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- <center>
                            <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
                        </center> -->
                        <div class="card">
                            <div class="card-header">{{ __('Custom Notifications') }}</div>
              
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
              
                                <form action="{{ route('send.notification') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                    <div class="form-group">
                                        <label>Message</label>
                                        <textarea class="form-control" name="body"></textarea>
                                      </div>
                                    <button type="submit" class="btn btn-primary">Send Notification</button>
                                </form>
              
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>


</main>


<script type="module">
    /*import { initializeApp } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-app.js";
    import { getMessaging } from "https://www.gstatic.com/firebasejs/9.0.2/firebase-messaging.js";

    // Firebase configuration object
    const firebaseConfig = {
        apiKey: "AIzaSyDmcQjXQbO41MdaD5pR501eT2Q_Jdjl3BE",
        authDomain: "hr-connect-pro.firebaseapp.com",
        projectId: "hr-connect-pro",
        storageBucket: "hr-connect-pro.appspot.com",
        messagingSenderId: "594201777602",
        appId: "1:594201777602:web:4e08559fb9599ad111b25b",
        measurementId: "G-YXTSS3TKXT"
      };

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);*/
</script>

<!-- Firebase related JS -->
<!-- <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
<script src="{{ asset('js/firebase-msgs.js') }}"></script> --> 




@endsection