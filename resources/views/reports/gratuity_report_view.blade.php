@extends('home.partial.layout')
@section('content')
<link rel="stylesheet" href="{{asset('css/report.css')}}">
    <main id="main" class="main">
        <div class="pagetitle">
            <div class="row align-items-center">

                <div class="col">
                    <div class="pagetitle">
                        <h1>Gratuity Report</h1>
                        <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Gratuity Report</li>
                        </ol>
                        </nav>
                        
                    </div>
                </div>
            </div>    
        </div>       

        <!-- Search Filter -->        
        <form action="{{route('final-statement')}}" method="post" target="_blank">
        @csrf 
        <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Select Employee </label>
                        <input class="form-control" list="emplist" id="empList" placeholder="Type to search..." oninput='onInput()' autocomplete="off">
                        <input type="hidden" class="form-control" id="employee_id" name="employee_id" value=''>
                        <datalist id="emplist" onclick="" autocomplete="off">
                            @if(0 < count($emp_list))
                                @foreach($emp_list as $eachemps)
                                    <option value="{{$eachemps->employee->name.' '.$eachemps->employee->lname}}" data-id="{{$eachemps->employee->id}}"></option>
                                @endforeach
                            @endif
                        </datalist>
                    </div>
                </div>

                <div class="col-md-2" style="padding-top: 2rem;">                    
                    <button type="submit" class="btn btn-block btn-alpha">Go</button>                    
                </div>

            </div>
        </form>

        <div class="col-lg-12 msg-div">
            @if($errors->any())
                <div class="alert alert-danger al-sign" style="margin-left: 15px; width: 97.5%;">
                    <ul>                        
                        <li>{{trans('messages.lbl_choose').' '.trans('messages.lbl_academic_emp')}}</li>                       
                    </ul>
                </div>
            @endif 
        </div>

        <div class="col-md-12" style="min-height: 100vh;"></div> 

    </main>
@endsection

<script>  

    function onInput() {
        let input = document.getElementById('empList'); 
        let dataList = document.getElementById('emplist'); 
        let hidinput = document.getElementById('employee_id');      
        let selectedOption = input.value;        
        let opts = dataList.childNodes;
        let options = dataList.getElementsByTagName('option');
        let selectedOptionId = '';
        
        for (var i = 0; i < options.length; i++) {
          if (options[i].value === selectedOption) {
            selectedOptionId = options[i].getAttribute('data-id');
            break;
          }
        }  
        hidinput.value = selectedOptionId;    
        
        /*console.log('Selected Value:', selectedOption);
        console.log('Selected ID:', selectedOptionId);*/
    }    
</script>