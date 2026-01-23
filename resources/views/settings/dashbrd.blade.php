@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard Card Settings</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard Card Settings</li>
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
                                <th scope="col" class="ps-4 pb-4">Dashboard Cards</th>
                                <th scope="col" class="">
                                <button type="submit" class="btn btn-success">UPDATE</button>
                                </th>
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
                                @foreach($cards as $key => $eachcard) 
                                    @php
                                    if(isset($curacc[$eachrole->id]) && in_array($key, $curacc[$eachrole->id])){ 
                                        $checked = 'checked'; 
                                    }else{
                                        $checked = '';
                                    }

                                    @endphp
                                    <span class="ps-3">
                                        <input type="checkbox" name="card[{{$eachrole->id}}][]" id="card-{{$loop->iteration}}" value="{{$key}}" {{$checked}}> {{$eachcard}}
                                    </span>
                                @endforeach
                                </td>
                                <td></td>
                            </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                    </form>

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

@endsection