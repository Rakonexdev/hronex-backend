@php
    if(NULL!= $data){
        $currentEmployeeId = $last_id;
    }else{
        $currentEmployeeId = $last_id+1;        
    }
    $emp_id = employeeIdMaker($currentEmployeeId);
@endphp
<!-- Multi Columns Form -->
<form class="row g-3" id="employee_main_data" action="{{route('save-employee-main-data')}}"
    method="post" data-csrf-token="{{ csrf_token() }}" enctype="multipart/form-data">
    @csrf

    <div class="col-md-12">
        <label for="temp_employee_id" class="form-label">Employee ID/No.</label>
        <input type="text" name="temp_employee_id" value="{{$emp_id}}" class="form-control hidee"
            id="temp_employee_id" readonly style="color: #8D8D8D;">
        <input type="text" name="employee_no" value="@if(NULL!=$data){{$data->employee_no}}@else{{old('employee_no')}}@endif" class="form-control"
            id="employee_no" required>
        <input type="hidden" name="employee_id" value="{{$currentEmployeeId}}" class="form-control"
            id="employee_id">
        <input type="hidden" name="user_id" value='@if(NULL!=$data){{$data->user_id}}@else 0 @endif' class="form-control"
            id="user_id_m">
    </div>    
    <div class="col-md-6">
        <label for="name" class="form-label">Employee Name (as per QID) *</label>
        <input type="text" name="name" value="@if(NULL!=$data){{$data->name}}@else{{old('name')}}@endif" class="form-control"
            id="name" placeholder="First Name" style="color: #8D8D8D;" required>
    </div>
    <div class="col-md-6" style="padding-top: 31px;">
        <input type="text" name="lname" value="@if(NULL!=$data){{$data->lname}}@else{{old('lname')}}@endif" class="form-control"
            id="lname" placeholder="Last Name" style="color: #8D8D8D;">
    </div>
    <div class="col-md-6">
        <label for="dob" class="form-label">DOB *</label>
        <input type="date" name="dob" value="@if(NULL!=$data){{$data->dob}}@else{{old('dob')}}@endif" class="form-control"
            id="dob" style="color: #8D8D8D;" onchange="cust.calculateAge();">
    </div>
    <div class="col-md-6">
        <label for="age" class="form-label">Age</label>
        <input type="number" name="age" value="@if(NULL!=$data){{\Carbon\Carbon::parse($data->dob)->diff(date('Y-m-d'))->format('%y');}}@else{{old('age')}}@endif" class="form-control"
            id="age" style="color: #8D8D8D;">
    </div>
    <div class="col-md-6">
        <label for="gender" class="form-label">Gender *</label>
        <select id="gender" name="gender" class="form-select" style="color: #8D8D8D;">
            <option value=''>Choose Gender...</option>
            <option value="Male" @if(NULL!=$data){{$data->gender=='Male' ? 'selected' : '' }}@else{{old('gender')=='Male' ? 'selected' : '' }}@endif>Male</option>
            <option value="Female" @if(NULL!=$data){{$data->gender=='Female' ? 'selected' : '' }}@else{{old('gender')=='Female' ? 'selected' : '' }}@endif>Female
            </option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="nationality" class="form-label">Nationality *</label>
        <select id="nationality" name="nationality" class="form-select" style="color: #8D8D8D;">
            <option value=''>Choose Nationality...</option>
            @foreach(masterDropdown('countries', 'status') as $country)
            <option value="{{$country->id}}" @if(NULL!=$data){{$data->nationality==$country->id ? 'selected' : '' }}@else{{old('nationality') == $country->id ? 'selected' : '' }}@endif>
            {{$country->country_name}}</option>
            @endforeach

        </select>
    </div>
    <div class="col-6">
        <label for="email" class="form-label">Email Address *</label>
        <input type="email" name="email" value="@if(NULL!=$data){{$data->email}}@else{{old('email')}}@endif" class="form-control"
            id="email" style="color: #8D8D8D; box-shadow: none;">
    </div>
    <div class="col-md-6">
        <label for="marital_status" class="form-label">Marital Satus *</label>
        <select id="marital_status" name="marital_status" class="form-select"
            style="color: #8D8D8D;">
            <option value=''>Choose Marital Status...
            </option>
            <option value="Single" @if(NULL!=$data){{$data->marital_status=='Single' ? 'selected' : '' }}@else{{old('marital_status')=='Single' ? 'selected' : '' }}@endif>Single
            </option>
            <option value="Married" @if(NULL!=$data){{$data->marital_status=='Married' ? 'selected' : '' }}@else{{old('marital_status')=='Married' ? 'selected' : '' }}@endif>
                Married</option>
            <option value="Seperated/Divorced" @if(NULL!=$data){{$data->marital_status=='Seperated/Divorced' ? 'selected' : '' }}@else{{old('marital_status')=='Seperated/Divorced' ? 'selected' : '' }}@endif>
                Seperated/Divorced</option>
            <option value="Widowed" @if(NULL!=$data){{$data->marital_status=='Widowed' ? 'selected' : '' }}@else{{old('marital_status')=='Widowed' ? 'selected' : '' }}@endif>
                Widowed</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="qidno" class="form-label">QID *</label>
        <input type="number" name="qidno" value="@if(NULL!=$data){{$data->qidno}}@else{{old('qidno')}}@endif" class="form-control"
            id="qidno" style="color: #8D8D8D;">
    </div>
    <div class="col-md-6">
        <label for="qidexpiry" class="form-label">QID Expiry *</label>
        <input type="date" name="qidexpiry" value="@if(NULL!=$data){{$data->qidexpiry}}@else{{old('qidexpiry')}}@endif" class="form-control"
            id="qidexpiry" style="color: #8D8D8D;">
    </div>                            
    <div class="col-md-6">
        <label for="passportno" class="form-label">Passport No *</label>
        <input type="text" name="passportno" value="@if(NULL!=$data){{$data->passportno}}@else{{old('passportno')}}@endif"
            class="form-control" id="passportno" style="color: #8D8D8D;">
    </div>
    <div class="col-md-6">
        <label for="passportexpiry" class="form-label">Passport Expiry *</label>
        <input type="date" name="passportexpiry" value="@if(NULL!=$data){{$data->passportexpiry}}@else{{old('passportexpiry')}}@endif"
            class="form-control" id="passportexpiry" style="color: #8D8D8D;">
    </div> 
    <div class="col-md-6">
        <label for="mobile1" class="form-label">Primary Contact No *</label>
        <input type="text" name="mobile1" value="@if(NULL!=$data){{$data->mobile1}}@else{{old('mobile1')}}@endif" class="form-control"
            id="mobile1" style="color: #8D8D8D;">
    </div>
    <div class="col-md-6">
        <label for="mobile2" class="form-label">Secondary Contact No</label>
        <input type="text" name="mobile2" value="@if(NULL!=$data){{$data->mobile2}}@else{{old('mobile2')}}@endif" class="form-control"
            id="mobile2" style="color: #8D8D8D;">
    </div>    
    
    @if(NULL==$data)
    <div class="col-12">
        <label for="avatar" class="form-label">Profile Picture Upload</label>
        <input type="file" name="avatar" value="{{old('avatar')}}" class="form-control"
            id="avatar">
    </div>
    @endif

    <div class="col-md-12" style="width: 100%; margin-top: 20px;">
        <button type="submit" id="employee_main_data_btn" class="btn btn-primary" style="width: 100%;">Save &
            Continue</button>
    </div>
</form><!-- End Multi Columns Form -->