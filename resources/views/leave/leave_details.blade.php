@extends('home.partial.layout')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Leave Details</h1>
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
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="bg-white">
                                    <table class="table">
                                        <thead></thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row" colspan="2">Employee ID</th>
                                                <td scope="row" colspan="2">
                                                    {{ $leave_applications->employee->employee_no }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" colspan="2">Employee Name</th>
                                                <td scope="row" colspan="2">
                                                    {{ $leave_applications->employee->name }}
                                                    {{ $leave_applications->employee->lname }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" colspan="2">Department</th>
                                                <td scope="row" colspan="2">
                                                    {{ $leave_applications->employee->departments->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" colspan="2">Designation</th>
                                                <td scope="row" colspan="2">
                                                    {{ $leave_applications->employee->designations->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" colspan="2">Type of Leave</th>
                                                <td scope="row" colspan="2">
                                                    {{ $leave_applications->leavetypes->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" colspan="2">Available Leaves</th>
                                                <td scope="row" colspan="2">{{ $available_leaves - $taken_leaves }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" colspan="2">Leaves Taken</th>
                                                <td scope="row" colspan="2">{{ $taken_leaves }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row" colspan="2">Reason for Leave</th>
                                                <td scope="row" colspan="2">
                                                    {{ $leave_applications->reason }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main><!-- End #main -->
@endsection
