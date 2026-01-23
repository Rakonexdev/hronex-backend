<form class="row g-3" id="employee_other_data" action="{{route('save-employee-other-data')}}"
    method="post" data-csrf-token="{{ csrf_token() }}">
    @csrf  

    <div class="col-md-6">
        <label for="school_shift" class="form-label">School Shift *</label>
        <select id="school_shift" name="school_shift" class="form-select"
            style="color: #8D8D8D;">
            <!-- <option {{old('school_shift') ? '' : 'selected' }}>Choose School Shift...</option> -->
            @foreach(masterDropdown('school_shift') as $school_shift)
            <option value="{{$school_shift->id}}" @if(NULL!=$data){{$data->school_shift==$school_shift->id ? 'selected' : ''}}@else{{old('school_shift')=='1' ? 'selected' : '' }}@endif>
                {{$school_shift->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label for="joiningdate" class="form-label">Date of Joining (as per offer letter)
            *</label>
        <input type="date" name="joiningdate" value="@if(NULL!=$data){{$data->joiningdate}}@else{{old('joiningdate')}}@endif"
            class="form-control" id="joiningdate" style="color: #8D8D8D;" onchange="cust.calculateServicePeriod();">
    </div>    
    <div class="col-md-6">
        <label for="department" class="form-label">Current Department *</label>
        <select id="department" name="department" class="form-select" style="color: #8D8D8D;">
            <!-- <option {{old('department') ? '' : 'selected' }}>Choose Curent Department...
            </option> -->
            @foreach(masterDropdown('departments') as $department)
            <option value="{{$department->id}}" @if(NULL!=$data){{$data->department==$department->id ? 'selected' : ''}}@else{{old('department')=='1' ? 'selected' : '' }}@endif>
                {{$department->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label for="designation" class="form-label">Current Position *</label>
        <select id="designation" name="designation" class="form-select" style="color: #8D8D8D;">
            <option {{old('designation') ? '' : 'selected' }}>Choose Current Position...
            </option>
            @foreach(masterDropdown('designations', 'status') as $designation)
            <option value="{{$designation->id}}" @if(NULL!=$data){{$data->designation==$designation->id ? 'selected' : ''}}@else{{old('designation')=='1' ? 'selected' : '' }}@endif>
                {{$designation->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label for="end_probation" class="form-label">End of Probation *</label>
        <input type="date" name="end_probation" value="@if(NULL!=$data){{$data->end_probation}}@else{{old('end_probation')}}@endif"
            class="form-control" id="end_probation" style="color: #8D8D8D;">
    </div>
    <div class="col-md-6">
        <label for="contract_type" class="form-label">Contract Type *</label>
        <select id="contract_type" name="contract_type" class="form-select"
            style="color: #8D8D8D;" onchange="contractChange();">
            <!-- <option {{old('contract_type') ? '' : 'selected' }}>Choose Contract Type...</option> -->
            @foreach(masterDropdown('contract_type') as $contract_type)
            <option value="{{$contract_type->id}}" @if(NULL!=$data){{$data->contract_type==$contract_type->id ? 'selected' : ''}}@else{{old('contract_type')==$contract_type->id ? 'selected' : '' }}@endif>
                {{$contract_type->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label for="contract_length" class="form-label">Contract Length *</label>
        <input type="text" name="contract_length" value="@if(NULL!=$data){{$data->contract_length}}@else{{(old('contract_length')) ? old('contract_length') : 0}}@endif"
            class="form-control" id="contract_length" placeholder="In Months"
            style="color: #8D8D8D;">
    </div>
    <div class="col-md-6">
        <label for="end_contract" class="form-label">End of Contract Date</label>
        <input type="date" name="end_contract" value="@if(NULL!=$data){{$data->end_contract}}@else{{old('end_contract')}}@endif"
            class="form-control" id="end_contract" style="color: #8D8D8D;">
    </div>
    <div class="col-md-6">
        <label for="service_years" class="form-label">Service Years *</label>
        <input type="text" name="service_years" value="@if(NULL!=$data){{$data->service_years}}@else{{(old('service_years')) ? old('service_years') : 0}}@endif"
            class="form-control" id="service_years" placeholder="In Years" style="color: #8D8D8D;" readonly>
    </div>
    <div class="col-md-6">
        <label for="sponsorship_status" class="form-label">Sponsorship *</label>
        <select id="sponsorship_status" name="sponsorship_status" class="form-select"
            style="color: #8D8D8D;">
            <option value="0" {{old('sponsorship_status') ? '' : 'selected' }}>Choose Sponsorship
                Status...</option>
            @foreach(masterDropdown('sponsorship_status') as $sponsorship_status)
            <option value="{{$sponsorship_status->id}}" @if(NULL!=$data){{$data->sponsorship_status==$sponsorship_status->id ? 'selected' : ''}}@else{{old('sponsorship_status')=='1' ? 'selected' : '' }}@endif>
                {{$sponsorship_status->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label for="relevant_degree" class="form-label">Relevent Degree *</label>
        <select id="relevant_degree" name="relevant_degree" class="form-select"
            style="color: #8D8D8D;">
            <option {{old('relevant_degree') ? '' : 'selected' }}>Choose Relevent Degree...
            </option>
            @foreach(masterDropdown('relevant_degree') as $relevant_degree)
            <option value="{{$relevant_degree->id}}" @if(NULL!=$data){{$data->relevant_degree==$relevant_degree->id ? 'selected' : ''}}@else{{old('relevant_degree')=='1' ? 'selected' : '' }}@endif>
                {{$relevant_degree->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label for="degree_details" class="form-label">Degree details</label>
        <input type="text" name="degree_details" value="@if(NULL!=$data){{$data->degree_details}}@else{{(old('degree_details')) ? old('degree_details') : ''}}@endif"
            class="form-control" id="degree_details"
            style="color: #8D8D8D;">
    </div>
    
    <div class="col-6">
        <label for="degree_attest_status" class="form-label">Degree Attestation Status *</label>
        <select id="degree_attest_status" name="degree_attest_status" class="form-select"
            style="color: #8D8D8D;">
            <!-- <option {{old('degree_attest_status') ? '' : 'selected' }}>Choose Degree Attestation
                Status...</option> -->
            <option value="1"
                @if(NULL!=$data){{$data->degree_attest_status=='1' ? 'selected' : ''}}@else{{old('degree_attest_status')=='1' ? 'selected' : '' }}@endif>
                Completely Attested</option>
            <option value="2" @if(NULL!=$data){{$data->degree_attest_status=='2' ? 'selected' : ''}}@else{{old('degree_attest_status')=='2'
                ? 'selected' : '' }}@endif>Not Attested</option>
            <option value="3"
                @if(NULL!=$data){{$data->degree_attest_status=='3' ? 'selected' : ''}}@else{{old('degree_attest_status')=='3' ? 'selected' : '' }}@endif>
                Attestation in Progress</option>
        </select>
    </div>
    <!-- <div class="col-12">
        <label for="inputAddress2" class="form-label">Other Qualifications</label>
        <input type="text" name="other_qualifications[]"
            class="form-control" id="inputAddress2" style="color: #8D8D8D;">
    </div>
    <div class="col-12" style="margin-top: 10px;">
        <input type="text" name="other_qualifications[]"class="form-control" id="inputAddress2"
            style="color: #8D8D8D;">
    </div>
    <div class="col-12" style="margin-top: 10px;">
        <input type="text" name="other_qualifications[]" class="form-control" id="inputAddress2"
            style="color: #8D8D8D;">
    </div> -->

    <div class="col-6">
              <label for="other-qualifications" class="form-label">Other Qualifications</label>
              <div class="qualifications-container">
                  <?php
                    $all_qualification = (isset($data) && $data->other_qualifications) ? unserialize($data->other_qualifications) : [""];
                  ?>
                  @foreach($all_qualification as $index => $qualification)
                  <div class="input-group mb-3">
                      <input type="text" name="other_qualifications[]" value="{{$qualification}}" class="form-control"
                          id="other-qualifications-{{ $index }}" aria-describedby="other-qualifications-help" style="color: #8D8D8D;">
                      <button class="btn btn-outline-secondary remove-qualification" type="button">Remove</button>
                  </div>
                  @endforeach
              </div>
              <button class="btn btn-outline-primary add-qualification" type="button">Add More Qualification</button>
            </div>
    
    <div class="col-md-6">
        <label for="disclaimer_ltr_moe" class="form-label">Disclaimer Letter (MOE)</label>
        <select id="disclaimer_ltr_moe" name="disclaimer_ltr_moe" class="form-select"
            style="color: #8D8D8D;">
            <option value="NA" @if(NULL!=$data){{$data->disclaimer_ltr_moe=='NA' ? 'selected' : ''}}@else{{old('disclaimer_ltr_moe')=='NA' ? 'selected' : '' }}@endif>NA
            </option>
            <option value="Yes" @if(NULL!=$data){{$data->disclaimer_ltr_moe=='Yes' ? 'selected' : ''}}@else{{old('disclaimer_ltr_moe')=='Yes' ? 'selected' : '' }}@endif>Yes
            </option>
            <option value="No" @if(NULL!=$data){{$data->disclaimer_ltr_moe=='No' ? 'selected' : ''}}@else{{old('disclaimer_ltr_moe')=='No' ? 'selected' : '' }}@endif>No
            </option>
        </select>
    </div> 
     <div class="col-md-6">
        <label for="declaration_ltr_moe" class="form-label">Declaration Letter (MOE)</label>
        <select id="declaration_ltr_moe" name="declaration_ltr_moe" class="form-select"
            style="color: #8D8D8D;">
            <option value="NA" @if(NULL!=$data){{$data->declaration_ltr_moe=='No' ? 'selected' : ''}}@else{{old('declaration_ltr_moe')=='NA' ? 'selected' : '' }}@endif>NA
            </option>
            <option value="Yes" @if(NULL!=$data){{$data->declaration_ltr_moe=='No' ? 'selected' : ''}}@else{{old('declaration_ltr_moe')=='Yes' ? 'selected' : '' }}@endif>Yes
            </option>
            <option value="No" @if(NULL!=$data){{$data->declaration_ltr_moe=='No' ? 'selected' : ''}}@else{{old('declaration_ltr_moe')=='No' ? 'selected' : '' }}@endif>No
            </option>
        </select>
    </div>     
    
    <div class="col-12">
        <label for="hrcomment" class="form-label">Comments</label>
        <div class="col-12" style="padding: 0px;">
            <textarea class="form-control" name="hrcomment" id="hrcomment"
                style="height: 100px; color: #8D8D8D;">@if(NULL!=$data){{$data->hrcomment}}@else{{old('hrcomment')}}@endif</textarea>
        </div>
    </div>
    
    <div class="col-md-12" style="width: 100%; margin-top: 20px;">
        <input type="hidden" name="user_id" id="user_id_o" value="@if(NULL!=$data){{$data->user_id}}@else 0 @endif">
        <button type="submit" id="employee_other_data_btn" class="btn btn-primary" style="width: 100%;">Save &
            Continue</button>
    </div>
</form>

<script>
function contractChange()
{
    if(2==document.getElementById('contract_type').value){
        document.getElementById('contract_length').value = 0;
        document.getElementById('contract_length').readOnly = true;
    }else{
        document.getElementById('contract_length').readOnly = false;
    }
}
</script>