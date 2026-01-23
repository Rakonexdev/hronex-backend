<!-- Multi Columns Form -->

    <form class="row g-3" id="employee_payroll_data" action="{{route('save-employee-payroll-data')}}" method="post">
        @csrf
        <div class="col-md-6">
            <input type="hidden" name="user_id" id="user_id_p" value='@if(NULL!=$data){{$data->user_id}}@else 0 @endif'>
            <label for="basic_salary" class="form-label">Basic Salary *</label>
            <input type="number" name="basic_salary" value="@if(NULL!=$data && !$data->employeePayrollInformation->isEmpty()){{$data->employeePayrollInformation[0]->basic_salary}}@else{{0}}@endif" class="form-control" id="basic_salary" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
            
        </div>
        <div class="col-md-6">
            <label for="accomodation_allowance" class="form-label">Accomodation Allowance *</label>
            <input type="number" name="accomodation_allowance" value="@if(NULL!=$data && !$data->employeePayrollInformation->isEmpty()){{$data->employeePayrollInformation[0]->accomodation_allowance}}@else{{0}}@endif" class="form-control" id="accomodation_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
        </div>
        <div class="col-md-6">
            <label for="transport_allowance" class="form-label">Transport Allowance *</label>
            <input type="number" name="transport_allowance" value="@if(NULL!=$data && !$data->employeePayrollInformation->isEmpty()){{$data->employeePayrollInformation[0]->transport_allowance}}@else{{0}}@endif" class="form-control" id="transport_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
        </div>
        <div class="col-md-6">
            <label for="continuous_allowance" class="form-label">Continuous Allowance</label>
            <input type="number" name="continuous_allowance" value="@if(NULL!=$data && !$data->employeePayrollInformation->isEmpty()){{$data->employeePayrollInformation[0]->continuous_allowance}}@else{{0}}@endif" class="form-control" id="continuous_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
        </div>
        <div class="col-md-6">
            <label for="temp_allowance" class="form-label">Temporary Allowance</label>
            <input type="number" name="temp_allowance" value="@if(NULL!=$data && !$data->employeePayrollInformation->isEmpty()){{$data->employeePayrollInformation[0]->temp_allowance}}@else{{0}}@endif" class="form-control" id="temp_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
        </div>
        <div class="col-md-6">
            <label for="other_allowance" class="form-label">Other Allowance</label>
            <input type="number" name="other_allowance" value="@if(NULL!=$data && !$data->employeePayrollInformation->isEmpty()){{$data->employeePayrollInformation[0]->other_allowance}}@else{{0}}@endif" class="form-control" id="other_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
        </div>
        <div class="col-md-12">
            <label for="gross_total" class="form-label">Gross Total</label>
            <input type="number" name="gross_total" value="@if(NULL!=$data && !$data->employeePayrollInformation->isEmpty()){{$data->employeePayrollInformation[0]->gross_total}}@else{{0}}@endif" class="form-control" id="gross_total" style="color: #8D8D8D;">
        </div>        
        <div class="col-md-6">
            <label for="salary_effective_from" class="form-label">Salary Payment Effective From</label>
            <input type="date" name="salary_effective_from" value="@if(NULL!=$data && !$data->employeePayrollInformation->isEmpty()){{$data->employeePayrollInformation[0]->salary_effective_from}}@endif" class="form-control" id="salary_effective_from" style="color: #8D8D8D;">
        </div>
        
        <div class="col-md-6" style="width: 100%; margin-top: 20px;">            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Save & Continue</button>
        </div>
    </form><!-- End Multi Columns Form -->