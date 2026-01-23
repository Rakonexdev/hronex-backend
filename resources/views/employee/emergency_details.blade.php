@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Emergency Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('employees')}}">Employee Onboarding</a></li>
                <li class="breadcrumb-item active">Emergency Details</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Emergency Details</h5>
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
                        <form class="row g-3" action="{{route('emergency_details.store')}}" method="post">
                            @csrf
                            <div class="col-md-6">
                                <label for="inputEmail5" class="form-label">Primary Emergency Contact Name *</label>
                                <input type="text" name="emergency_primary_name" value="{{old('emergency_primary_name')}}" class="form-control" id="inputEmail5" placeholder="First Name"
                                    style="color: #8D8D8D;">
                                <input type="hidden" name="user_id" value="{{isset($user_id) ? $user_id : null}}">
                            </div>
                            <div class="col-md-6" style="padding-top: 31px;">
                                <input type="text" name="emergency_primary_lname" value="{{old('emergency_primary_lname')}}" class="form-control" id="inputPassword5" placeholder="Last Name"
                                    style="color: #8D8D8D;">
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail5" class="form-label">Relationship</label>
                                <select id="inputEmail5" name="relationship_primary" class="form-select" style="color: #8D8D8D;">
                                    <option {{old('relationship_primary') ? '' : 'selected' }}>Choose Relationship...</option>
                                    @foreach(masterDropdown('relationship') as $relation)
                                    <option value="{{$relation->id}}" {{old('relation')=='1' ? 'selected' : '' }}>
                                        {{$relation->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail5" class="form-label">Primary Emergency Contact No: *</label>
                                <input type="numner" name="emergency_primary_contact" value="{{old('emergency_primary_contact')}}" class="form-control" id="inputEmail5"
                                    placeholder="Enter Contact Number" style="color: #8D8D8D;">
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail5" class="form-label">Secondary Emergency Contact Name *</label>
                                <input type="text" name="emergency_secondary_name" value="{{old('emergency_secondary_name')}}" class="form-control" id="inputEmail5" placeholder="First Name"
                                    style="color: #8D8D8D;">
                            </div>
                            <div class="col-md-6" style="padding-top: 31px;">
                                <input type="text" name="emergency_secondary_lname" value="{{old('emergency_secondary_lname')}}" class="form-control" id="inputPassword5" placeholder="Last Name"
                                    style="color: #8D8D8D;">
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail5" class="form-label">Relationship</label>
                                <select id="inputEmail5" name="relationship_secondary" class="form-select" style="color: #8D8D8D;">
                                    <option {{old('relationship_secondary') ? '' : 'selected' }}>Choose Relationship...</option>
                                    @foreach(masterDropdown('relationship') as $relation)
                                    <option value="{{$relation->id}}" {{old('relation')=='1' ? 'selected' : '' }}>
                                        {{$relation->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail5" class="form-label">Secondary Emergency Contact No: *</label>
                                <input type="numner" name="emergency_secondary_contact" value="{{old('emergency_secondary_contact')}}" class="form-control" id="inputEmail5"
                                    placeholder="Enter Contact Number" style="color: #8D8D8D;">
                            </div>
                            <div class="col-md-12">
                                <label for="inputAddress2" class="form-label">Employee Remarks</label>
                                <div class="col-md-12" style="padding: 0px;">
                                    <textarea class="form-control" id="inputAddress2" name="comment"
                                        style="height: 100px; color: #8D8D8D;">{{old('comment')}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6" style="width: 100%; margin-top: 100px;">
                                <a type="button" class="btn btn-secondary" style="width: 49%;"
                                    href="{{route('health_information.show', $user_id ? $user_id : null)}}">Back</a>
                                <button type="submit" class="btn btn-primary" style="width: 50%;"
                                    >Save</button>
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
    $(document).ready(function () {
        var counter = 1;
        $("#physical_details").click(function () {
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

            deleteBtn.click(function () {
                $(this).parent().remove();
                counter--;
            });

            var newDiv = $("<div class='col-md-12 mb-2'>").attr("style", "width: 100%; display: flex; flex-direction: row; padding: 0px;").append(newInput, deleteBtn);

            $("#physical_details_container").append(newDiv);

            counter++;
        });
    });
</script>
@endsection