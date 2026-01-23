@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Role Access Settings</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Role Access Settings</li>
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

                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible show">
                        {{ session('success') }}              
                    </div>
                @endif 

                @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible show">
                        {{ session('error') }}              
                    </div>
                @endif 

                <div class="card">
                    <div class="card-body">

                    <form action="{{route('updatedashcard')}}" method="post" id="dashcard-form" name="dashcard-form">
                    @csrf
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col" class="pb-4">Roles</th>
                                <th scope="col" class="ps-4 pb-4">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $eachrole)
                            <tr>                            
                                <td class="fw-bold">
                                    {{strtoupper($eachrole->name)}}
                                    <input type="hidden" name="role[]" id="role-{{$loop->iteration}}" value="{{$eachrole->id}}" >
                                </td>
                                <td>
                                    <span class="btn btn-info" 
                                        data-toggle="modal" 
                                        data-target="#role_access_modal"
                                        onclick="getLinksAndAccess({{$eachrole->id}}, '{{strtoupper($eachrole->name)}}');">
                                        Link Access
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                    </form>

                    </div>
                </div>

            </div>
        </div>

        <form action="{{route('updateroleaccess')}}" name="role_access_form" id="role_access_form" method="post">
        @csrf
            <div class="modal fade show" id="role_access_modal" tabindex="-1" style="display: none;" aria-hidden="true" >
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Role Link Access</h5>                    
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div style="padding:1rem 2rem; background-color:#ddf0f9;">
                        <h5>Role: <span id="role_name_sp"></span> </h5>
                        <input type="hidden" name="role_id" id="role_id" value="0">
                    </div>
                    <div style="padding-left:2rem; margin-top:1rem;">
                        <h5>Menu Links</h5>
                    </div>
                    <div class="modal-body" id="linkaccess_div">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>
        </from>

    </section>

</main><!-- End #main -->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function () {

        getLinksAndAccess = function(roleid, rolename)
        {
            if(0 >= roleid)
                return false;

            url = APP_URL+'/getLinksAndAccess/'+roleid;

            fetch(url)
            .then(response => response.text())
            .then(data => {
                // Set the content of the modal               
                document.getElementById('linkaccess_div').innerHTML = data;
                document.getElementById('role_name_sp').textContent = rolename;
                document.getElementById('role_id').value = roleid;
                
            })
            .catch(error => {
                // Handle any errors that occur during the request
                console.error('Error:', error);
            });	    
        };
        
    });
</script>

@endsection