<h1>{{trans('messages.lbl_forg_pass_email')}}</h1>
   
{{trans('messages.lbl_forg_pas_eml_cap')}}:
<a href="{{ route('reset.password.get', $token) }}">{{trans('messages.lbl_rest_password')}}</a>