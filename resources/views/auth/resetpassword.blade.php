@extends('auth.layout')
  
@section('content')

    @php
        $newtoken = explode('_mail_', $token);
    @endphp

    <div class="card mb-3">

        <div class="card-body">

            <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">{{trans('messages.lbl_rest_password')}} </h5>
                <p class="text-center small">{{trans('messages.lbl_rest_pass_cap')}}</p>
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

            <form action="{{ route('reset.password.post') }}" method="POST" class="row g-3 needs-validation">
            @csrf

                <input type="hidden" name="token" value="{{ $newtoken[0] }}">
                <div class="col-12">
                  <label for="email" class="form-label">{{trans('messages.lbl_email_adr')}}</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $newtoken[1] }}" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @endif
                  </div>
                </div> 

                <div class="col-12">
                  <label for="password" class="form-label">{{trans('messages.lbl_password')}}</label>                  
                    <input type="password" name="password" class="form-control" id="password" required>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @endif
                 
                </div>

                <div class="col-12">
                  <label for="cpassword" class="form-label">{{trans('messages.lbl_conf_password')}}</label>                 
                    <input type="password" name="cpassword" class="form-control" id="cpassword" required>
                    @if ($errors->has('cpassword'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @endif                  
                </div>
                
                <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">
                        {{trans('messages.btn_update')}} {{trans('messages.lbl_password')}}
                    </button>
                </div> 
                <div class="col-12">
                  <p class="small mb-0">{{trans('messages.lbl_goto_acc')}} <a href="{{ route('login') }}"> {{trans('messages.btn_login')}}</a></p>
                </div>               
            </form>

        </div>
    </div>

@endsection