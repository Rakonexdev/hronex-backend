@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Employee Information</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('employees')}}">Employee Onboarding</a></li>
                <li class="breadcrumb-item active">Employee Information</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                @if ($errors->any())
                <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 97.5%;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible show">
                        {{ session('error') }}              
                    </div>
                @endif 

                <div class="card">
                    <div class="card-body">

                        <div class="tab-box pb-4">
                            
                            <!-- Tabs -->
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="m-info" data-bs-toggle="pill" data-bs-target="#main-info" type="button" role="tab" aria-controls="main-info" aria-selected="true">Employee Information</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link navl-d" id="o-info" data-bs-toggle="pill" data-bs-target="#oth-info" type="button" role="tab" aria-controls="oth-info" aria-selected="false">Education / Comapany Information</button>
                                </li>
                                @can('view_payroll_basics')
				                <li class="nav-item" role="presentation">
                                    <button class="nav-link navl-d" id="p-info" data-bs-toggle="pill" data-bs-target="#payroll-info" type="button" role="tab" aria-controls="payroll-info" aria-selected="false">Payroll Information</button>
                                </li>
                                @endcan
                                @can('view_attachments')
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link navl-d" id="f-info" data-bs-toggle="pill" data-bs-target="#file-info" type="button" role="tab" aria-controls="file-info" aria-selected="false">Files / Attachments</button>
                                </li>
                                @endcan
				<!-- disabled  aria-disabled="true" -->
                            </ul>
                            
                        </div>

                        <div class="tab-content pt-2" id="myTabContent">

                            <div class="tab-pane fade show active" id="main-info" role="tabpanel" aria-labelledby="main-info-tab">
                                <!-- Add Main Information Modal -->
                                @include("employee.partials.main-info")
                            </div>

                            <div class="tab-pane fade show" id="oth-info" role="tabpanel" aria-labelledby="oth-info-tab">
                                <!-- Add Other Information Modal -->
                                @include("employee.partials.other-info")
                            </div>

			                <div class="tab-pane fade show" id="payroll-info" role="tabpanel" aria-labelledby="payroll-info-tab">
                                <!-- Add Payroll Information Modal -->
                                @include("employee.partials.payroll-info")
                            </div>
                            <div class="tab-pane fade show" id="file-info" role="tabpanel" aria-labelledby="file-info-tab">
                                 <!-- Add File Information Modal -->
                                @include("employee.partials.file-info")
                            </div>

                            <div class="pt-1">&nbsp;</div>

                            <div class="alert-js" id="errorContainer" style="margin-left: 15px; width: 97.5%; text-align: center; color:#FF0000;"></div>
                            <div class="alert-js" id="successMessage" style="margin-left: 15px; width: 97.5%; text-align: center; color:#00CD00;"></div>

                        </div>                        

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

    /*Employee Onboarding form submission*/ 
    document.addEventListener('DOMContentLoaded', function() {
        let formM = document.getElementById('employee_main_data'); 
        let formO = document.getElementById('employee_other_data');          
        let formP = document.getElementById('employee_payroll_data');
        /*let formF = document.getElementById('employee_file_data');*/          

        formM.addEventListener('submit', function(event) {
            event.preventDefault();
            cust.employeeFormSubmit(formM);            
        });
        formO.addEventListener('submit', function(event) {
            event.preventDefault();
            cust.employeeFormSubmit(formO);            
        });
        formP.addEventListener('submit', function(event) {
            event.preventDefault();  
            cust.employeeFormSubmit(formP);                   
        });
        /*formF.addEventListener('submit', function(event) {
            event.preventDefault();                     
        });*/
        
    });

    /*document.querySelector('#fileUploadButton').addEventListener('click', function (e) {

        let csrfToken = document.querySelector('#employee_file_data').getAttribute('data-csrf-token');
        let user_id = document.querySelector('#user_id_f').value;

        let formData = new FormData();        
        formData.append('_token', csrfToken);
        formData.append('user_id', user_id);
        url = APP_URL+'/save-employee-file-data';

        let xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.onload = function () {
            
            if (xhr.status === 200) {                    
                Swal.fire({
                  title: Messages.getText('LABELTEXT.SUCCESS_MSG'),
                  text: data.message,
                  icon: 'success',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed){
                        location.reload();                                                 
                    }
                }) 
            } else {                    
                Swal.fire(
                  Messages.getText('LABELTEXT.ERROR_TITLE'),
                  'error'
                )                    
            }
            
        };
        xhr.send(formData);  

    });*/
    
</script>
@endsection