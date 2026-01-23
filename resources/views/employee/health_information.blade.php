@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Health Information</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('employees')}}">Employee Onboarding</a></li>
                <li class="breadcrumb-item active">Health Information</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Health Information</h5>
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
                        <form class="row g-3" action="{{route('health_information.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label for="inputName5" class="form-label">HMC Card No:</label>
                                <input type="text" name="hmc_card_no" value="{{old('hmc_card_no')}}" class="form-control" id="inputName5" style="color: #8D8D8D;">
                                <input type="hidden" name="user_id" value="{{isset($user_id) ? $user_id : 0}}">
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail5" class="form-label">Health Insurance Status</label>
                                <select id="inputEmail5" name="health_insurance_status" class="form-select" style="color: #8D8D8D;">
                                    <option {{old('health_insurance_status') ? '' : 'selected' }}>Choose Insurance Status...</option>
                                    <option value="1" {{old('health_insurance_status')=='1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{old('health_insurance_status')=='0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="inputName5" class="form-label">Mention the name of your health insurance (if
                                    any)</label>
                                <input type="text" name="health_insurance_name" value="{{old('health_insurance_name')}}" class="form-control" id="inputName5"
                                    placeholder="Name of Health Insurance" style="color: #8D8D8D;">
                            </div>
                            <div class="col-md-12">
                                <label for="inputEmail5" class="form-label">Does the employee suffer from any medical
                                    conditions</label>
                                <select id="inputEmail4" name="medical_ailment_physical" class="form-select" style="color: #8D8D8D;">
                                    <option {{old('medical_ailment_physical') ? '' : 'selected' }}>Choose...</option>
                                    <option value="1" {{old('medical_ailment_physical')=='1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{old('medical_ailment_physical')=='0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="inputName5" class="form-label">Mention Details (if any)</label>
                                <div class="col-md-12"
                                    style="width: 100%; display: flex; flex-direction: row; padding: 0px;">
                                    <input type="text" name="physical_details[]"  class="form-control" id="inp"
                                        style="color: #8D8D8D; margin-right: 10px;">
                                    <button type="button" name="add" id="physical_details" class="btn btn-gamma"><i class="bi bi-plus-lg"></i></button>
                                </div>
                            </div>
                            <div class="col-md-12" id="physical_details_container"></div>
                            <div class="col-md-12">
                                <label for="inputEmail5" class="form-label">Does the employee suffer from any mental
                                    health</label>
                                <select id="inputEmail4" name="medical_ailment_mental" class="form-select" style="color: #8D8D8D;">
                                    <option {{old('medical_ailment_mental') ? '' : 'selected' }}>Choose...</option>
                                    <option value="1" {{old('medical_ailment_mental')=='1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{old('medical_ailment_mental')=='0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="inputName5" class="form-label">Mention Details (if any)</label>
                                <div class="col-md-12"
                                    style="width: 100%; display: flex; flex-direction: row; padding: 0px;">
                                    <input type="text" name="mental_details[]" class="form-control" id="inputName5"
                                        style="color: #8D8D8D; margin-right: 10px;">
                                    <button type="button" class="btn btn-gamma" id="mental_details"><i class="bi bi-plus-lg"></i></button>
                                </div>
                            </div>
                            <div class="col-md-12" id="mental_details_container"></div>
                            <div class="col-md-12">
                                <label for="inputName5" class="form-label">Mention the name of medication taken (if
                                    any)</label>
                                <input type="text" name="medication_details" value="{{old('medication_details')}}" class="form-control" id="inputName5"
                                    placeholder="Name of Medication Taken" style="color: #8D8D8D;">
                            </div>
                            <div class="col-md-6" style="width: 100%; margin-top: 100px;">
                                <a type="button" class="btn btn-secondary" style="width: 49%;"
                                    href="{{route('payroll_information.show', isset($user_id) ? $user_id : null)}}">Back</a>
                                <button type="submit" class="btn btn-primary" style="width: 50%;"
                                    >Save & Continue</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var counter = 1;
        $("#physical_details").click(function() {
            var newInput = $("<input>").attr({
            type: "text",
            name: "physical_details[]",
            class: "form-control",
            style: "color: #8D8D8D; margin-right: 10px;",
            });

            var deleteBtn = $("<button><i class='bi bi-dash-lg'></i>").attr({
            type: "button",
            class: "btn btn-gamma",
            style: "margin-right: 0px;"
            });

            deleteBtn.click(function() {
            $(this).parent().remove();
            counter--;
            });

            var newDiv = $("<div class='col-md-12 mb-2'>").attr("style", "width: 100%; display: flex; flex-direction: row; padding: 0px;").append(newInput, deleteBtn);

            $("#physical_details_container").append(newDiv);

            counter++;
        });
    });
</script>
<script>
    $(document).ready(function() {
        var counter = 1;
        $("#mental_details").click(function() {
            var newInput = $("<input>").attr({
            type: "text",
            name: "mental_details[]",
            class: "form-control",
            style: "color: #8D8D8D; margin-right: 10px;",
            });

            var deleteBtn = $("<button><i class='bi bi-dash-lg'></i>").attr({
            type: "button",
            class: "btn btn-gamma",
            style: "margin-right: 0px;"
            });

            deleteBtn.click(function() {
            $(this).parent().remove();
            counter--;
            });

            var newDiv = $("<div class='col-md-12 mb-2'>").attr("style", "width: 100%; display: flex; flex-direction: row; padding: 0px;").append(newInput, deleteBtn);

            $("#mental_details_container").append(newDiv);

            counter++;
        });
    });
</script>
@endsection