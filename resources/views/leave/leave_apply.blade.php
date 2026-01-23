@extends('home.partial.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Leave Application</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Leave Section</li>
                    <li class="breadcrumb-item active">Leave Application</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Leave Application Form</h5>
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
                            <form class="row g-3" action="{{route('leave-apply')}}" method="post">
                                @csrf
                                <div class="col-md-6">
                                    <label for="inputName5" class="form-label">Employee ID</label>
                                    <input type="text" name="employee_id" class="form-control" id="inputEmployeeId" style="color: #8D8D8D;">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputName5" class="form-label">Employee Name</label>
                                    <input type="text" name="employee_name" class="form-control" id="inputEmployeeName" style="color: #8D8D8D;">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputName5" class="form-label">Designation</label>
                                    <input type="text" name="designation" class="form-control" id="designation" style="color: #8D8D8D;">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputName5" class="form-label">Department</label>
                                    <input type="text" class="form-control" id="department" style="color: #8D8D8D;">
                                </div>
                                <div class="col-md-12">
                                    <label for="typeleave" class="form-label">Type Of Leave *</label>
                                    <select id="typeleave" name="leave_type" class="form-select" style="color: #8D8D8D;">
                                        <option {{old('leave_type') ? '' : 'selected' }}>Choose Relationship...</option>
                                        @foreach(masterDropdown('leave_types') as $leave_type)
                                        <option value="{{$leave_type->id}}" {{old('leave_type')=='1' ? 'selected' : '' }}>
                                            {{$leave_type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="otherleavedet" class="form-label">Mention Leave (If Other)</label>
                                    <input type="text" class="form-control" id="inputEmail5"
                                        placeholder="Enter details about leave" style="color: #8D8D8D;">
                                </div>
                                <div class="col-md-12">
                                    <label for="attachcert" class="form-label">Attach supporting documents for your leave
                                        application
                                    </label>
                                    <input type="file" name="attachment" class="form-control" id="attachcert" style="color: #8D8D8D;">
                                </div>
                                <div class="col-md-6">
                                    <label for="startdate" class="form-label">Leave Start Date *</label>
                                    <input type="date" name="date_from" class="form-control" id="startdate" style="color: #8D8D8D;">
                                </div>
                                <div class="col-md-6">
                                    <label for="enddate" class="form-label">Leave End Date *</label>
                                    <input type="date" name="date_to" class="form-control" id="enddate" style="color: #8D8D8D;">
                                </div>
                                <div id="starttime" class="col-md-6">
                                    <label for="starttime" class="form-label">Leave Start time</label>
                                    <input type="time" name="time_from" class="form-control" id="starttime" style="color: #8D8D8D;">
                                </div>
                                <div id="endtime" class="col-md-6">
                                    <label for="starttime" class="form-label">Leave End time</label>
                                    <input type="time" name="time_end" class="form-control" id="endtime" style="color: #8D8D8D;">
                                </div>
                                <div class="col-md-6">
                                    <label for="leavedays" class="form-label">Leave (no. of days or hours) *</label>
                                    <input type="text" name="no_days" class="form-control" id="leavedays" style="color: #8D8D8D;">
                                </div>
                                <div class="col-md-6">
                                    <label for="reason" class="form-label">Reason of leave application *</label>
                                    <input type="text" name="reason" class="form-control" id="reason" style="color: #8D8D8D;">
                                </div>

                                <div class="col-md-6" style="width: 100%; margin-top: 100px;">
                                    <button type="reset" class="btn btn-secondary" style="width: 49%;">Reset</button>
                                    <button type="submit" class="btn btn-primary" style="width: 50%;">Submit</button>
                                </div>
                            </form><!-- End Multi Columns Form -->
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main><!-- End #main -->
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    inputEmployeeId.addEventListener('change', function() {
        var employeeId = inputEmployeeId.value;

        axios.get(APP_URL+'/get_employee_name/' + employeeId)
            .then(function(response) {
                if (Object.keys(response.data).length === 0) {
                    inputEmployeeName.value = "No employee details found";
                    department.value = "No department details found";
                    designation.value = "No designation details found";
                }
                else {
                    inputEmployeeName.value = response.data.name + ' ' + response.data.lname;
                    department.value = response.data.department;
                    designation.value = response.data.designation;
                }
                console.log(response.data);

            })
            .catch(function(error) {
                console.error('Error fetching employee details:', error);
            });
    });
</script>
@endsection
