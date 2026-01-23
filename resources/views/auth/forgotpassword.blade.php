@extends('auth.layout')
  
@section('content')

    <div class="card mb-3">

        <div class="card-body">

            <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">{{trans('messages.lbl_forg_password')}} ? </h5>
                <p class="text-center small">{{trans('messages.lbl_forg_pass_cap')}}</p>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success al-sign">
                    {{ session('message') }}
                </div>
            @endif

            <form action="{{ route('forgotpassword.post') }}" method="POST" class="row g-3 needs-validation">
            @csrf
                <div class="col-12">
                  <label for="email" class="form-label">{{trans('messages.lbl_email_adr')}}</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="email" name="email" class="form-control" id="email" required>
                    <div class="invalid-feedback">{{trans('messages.lbl_notif_email')}}</div>                    
                  </div>
                  @if ($errors->has('email'))
                        <div class="text-danger">{{ $errors->first('email') }}</div>
                    @endif
                </div> 
                
                <div class="col-12">
                  <button class="btn btn-primary w-100" type="submit">{{trans('messages.lbl_rest_password')}}</button>
                </div>
                <div class="col-12">
                  <p class="small mb-0"> {{trans('messages.lbl_remember_pass')}} ? <a href="{{ route('login') }}"> {{trans('messages.btn_login')}} </a></p>
                </div>
            </form>

        </div>
    </div>

@endsection