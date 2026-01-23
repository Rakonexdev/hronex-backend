<h1>{{trans('messages.user_create')}}</h1>   


{{trans('messages.onboard_email_body')}}:
<a href="{{ route('reset.password.get', $token) }}">{{trans('messages.lbl_verify_lnk').' & '.trans('messages.lbl_rest_password')}}</a>