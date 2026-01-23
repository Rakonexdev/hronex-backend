@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Payroll Information</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('employees')}}">Employee Onboarding</a></li>
                <li class="breadcrumb-item active">Payroll Information</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Payroll Information</h5>
                        @if ($errors->any())
                        <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 97.5%;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <!-- Multi Columns Form -->
                        <form class="row g-3" action="{{route('payroll_information.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label for="basic_salary" class="form-label">Basic Salary *</label>
                                <input type="number" name="basic_salary" value="{{old('basic_salary')}}" class="form-control" id="basic_salary" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
                                <input type="hidden" name="user_id" value="{{isset($user_id) ? $user_id : null}}">
                            </div>
                            <div class="col-md-6">
                                <label for="accomodation_allowance" class="form-label">Accomodation Allowance *</label>
                                <input type="number" name="accomodation_allowance" value="{{old('accomodation_allowance')}}" class="form-control" id="accomodation_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
                            </div>
                            <div class="col-md-6">
                                <label for="transport_allowance" class="form-label">Transport Allowance *</label>
                                <input type="number" name="transport_allowance" value="{{old('transport_allowance')}}" class="form-control" id="transport_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
                            </div>
                            <div class="col-md-6">
                                <label for="other_allowance" class="form-label">Other Allowance</label>
                                <input type="number" name="other_allowance" value="{{old('other_allowance')}}" class="form-control" id="other_allowance" style="color: #8D8D8D;" onkeyup="cust.calculateGrossTotal();">
                            </div>
                            <div class="col-md-12">
                                <label for="gross_total" class="form-label">Gross Total</label>
                                <input type="number" name="gross_total" value="{{old('gross_total')}}" class="form-control" id="gross_total" style="color: #8D8D8D;">
                            </div>
                            @can('profile-update')
                            <div class="col-md-12">
                                <label for="bank_name" class="form-label">Bank Name</label>
                                <input type="text" name="bank_name" value="{{old('bank_name')}}" class="form-control" id="bank_name"
                                    placeholder="Enter Your Bank Name" style="color: #8D8D8D;">
                            </div>
                            <div class="col-md-6">
                                <label for="account_no" class="form-label">Account No:</label>
                                <input type="number" name="account_no" value="{{old('account_no')}}" class="form-control" id="account_no"
                                    placeholder="Enter Your Account No:" style="color: #8D8D8D;">
                            </div>
                            <div class="col-md-6">
                                <label for="iban_no" class="form-label">IBAN No:</label>
                                <input type="text" name="iban_no" value="{{old('iban_no')}}" class="form-control" id="iban_no"
                                    placeholder="Enter Your IBAN No:" style="color: #8D8D8D;">
                            </div>
                            @endcan
                            <div class="col-md-6">
                                <label for="salary_effective_from" class="form-label">Salary Payment Effective From</label>
                                <input type="date" name="salary_effective_from" value="{{old('salary_effective_from')}}" class="form-control" id="salary_effective_from" style="color: #8D8D8D;">
                            </div>
                            @can('profile-update') 
                            <div class="col-md-6">
                                <label for="bank_docs" class="form-label">Attach Supporting Bank Documents</label>
                                <input type="file" name="bank_docs" class="form-control" id="bank_docs" style="color: #8D8D8D;">
                            </div>
                            @endcan
                            <div class="col-md-6" style="width: 100%; margin-top: 100px;">
                                <a type="button" class="btn btn-secondary" style="width: 49%;"
                                    href="{{url('employees-information')}}">Back</a>
                                <button type="submit" class="btn btn-primary" style="width: 50%;">Save & Continue</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

            </div>
        </div>

    </section>

</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            placement: 'right',
            trigger: 'hover'
        });
    });
</script>

<script>
    document.querySelector('#fileUploadButton').addEventListener('click', function (e) {
        e.preventDefault();
        // Get the file input elements
        var degree_attaches = document.querySelector('#employee_data input[name="degree_attaches"]');
        var disclaimer_ltr_moe_atch = document.querySelector('#employee_data input[name="disclaimer_ltr_moe_atch"]');
        var declaration_ltr_moe_atch = document.querySelector('#employee_data input[name="declaration_ltr_moe_atch"]');
        var avatar = document.querySelector('#employee_data input[name="avatar"]');
        var csrfToken = document.querySelector('#employee_data').getAttribute('data-csrf-token');

        // Check if all files were selected
        if (degree_attaches.files.length === 0 || disclaimer_ltr_moe_atch.files.length === 0 || declaration_ltr_moe_atch.files.length === 0) {
            alert('Please select all files to upload.');
            return;
        }

        var formData = new FormData();

        // Append the files and additional fields to the FormData object
        formData.append('degree_attaches', degree_attaches.files[0]);
        formData.append('disclaimer_ltr_moe_atch', disclaimer_ltr_moe_atch.files[0]);
        formData.append('declaration_ltr_moe_atch', declaration_ltr_moe_atch.files[0]);
        formData.append('avatar', avatar.files[0]);

        formData.append('_token', csrfToken);

        document.querySelector('#loadingIcon').style.display = 'block';

        // Send the FormData object to the server using XHR
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/fileUpload');
        xhr.onload = function () {
            document.querySelector('#loadingIcon').style.display = 'none';
            if (xhr.status === 200) {
                alert('Files uploaded successfully.');
            } else {
                alert('Files upload failed.');
            }
        };
        xhr.send(formData);
    });
</script>
@endsection