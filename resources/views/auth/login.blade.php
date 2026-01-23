@extends('auth.layout')
  
@section('content')

    <div class="card mb-3">

        <div class="card-body">

            <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">{{trans('messages.lbl_login_title')}}</h5>
                <p class="text-center small">{{trans('messages.lbl_login_cap')}}</p>
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success al-sign">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger al-sign">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" id="login-form" class="row g-3 needs-validation" novalidate>
            @csrf
                <div class="col-12">
                  <label for="email" class="form-label">{{trans('messages.lbl_email')}}</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="email" name="email" class="form-control" id="email" required>
                    <div class="invalid-feedback">{{trans('messages.lbl_notif_email')}}</div>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                  </div>
                </div>

                <div class="col-12">
                  <label for="password" class="form-label">{{trans('messages.lbl_password')}}</label>
                  <!-- <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                    <input type="password" name="password" class="form-control" id="password" required>
                    <div class="invalid-feedback">{{trans('messages.lbl_notif_password')}}</div>
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                  <!-- </div> -->
                </div>

                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">{{trans('messages.lbl_remember')}}</label>
                  </div>
                </div>
                <div class="col-12">
                    <input type="hidden" name="device_token" id="device_token" value="abc" class="form-control">
                    <input type="hidden" name="device_type" id="device_type" value="Web" class="form-control">
                    <button class="btn btn-primary w-100" id="login-btn" type="submit">{{trans('messages.btn_signin')}}</button>
                </div>
                <div class="col-12">
                  <p class="small mb-0"><!-- Don't have account? --> <a href="{{ route('forgotpassword') }}">{{trans('messages.lbl_forg_password')}} ?<!-- Create an account --></a></p>
                </div>
            </form>

        </div>
    </div>

@endsection

<!-- Firebase related JS -->
<!-- <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
<script src="{{ asset('js/firebase-msgs.js') }}"></script> -->

<script>

    /*window.addEventListener('load', function(){ 
        document.querySelector('#login-btn').addEventListener('click', function (event) {
          event.preventDefault();
          initFirebaseMessagingRegistration();                      
        });
    });*/

</script>