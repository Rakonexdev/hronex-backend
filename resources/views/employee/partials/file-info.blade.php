<form class="row g-3" id="employee_file_data" action="{{route('save-employee-file-data')}}"
    method="post" data-csrf-token="{{ csrf_token() }}" enctype="multipart/form-data">
    @csrf

    @php
    $uploaded = ["degree[]"];
        if(NULL!=$data && null!=$data->employeeFiles){
            foreach($data->employeeFiles as $upfile){
                $uploaded[] = $upfile->file_type;
            }            
        }
    @endphp

    @if(NULL!=$data && null!=$data->employeeFiles)
        <div class="col-md-12 text-end" style="margin-top: 20px;">
            <button type="button" id='uploadedBtn' class="btn btn-success" onclick="cust.showFiles(@if(NULL!=$data){{$data->user_id}}@else 0 @endif);" style="width: 20%;">Uploaded Files</button>
        </div>
    @endif

    @foreach($employee_file_order as $eachfile)
        @php
        if(NULL!=$uploaded && in_array($eachfile[1], $uploaded) ) $eachfile[3] = '';             
        @endphp       
        <div class="col-6">
            <label for="{{$eachfile[1]}}" class="form-label">{{$eachfile[0].' '.$eachfile[3]}} @if('M'==$eachfile[2]) [Multiple] @endif  </label>
            <input type="file" name="{{$eachfile[1]}}" value="{{old($eachfile[1])}}"
                class="form-control" id="{{$eachfile[1]}}" @if('M'==$eachfile[2]) multiple @endif @if('*'==$eachfile[3]) required @endif>
        </div>
    @endforeach      
    
    <div class="col-md-12" style="margin-top: 20px;">
        <input type="hidden" name="user_id" id="user_id_f" value="@if(NULL!=$data){{$data->user_id}}@else 0 @endif">
        <button type="submit" id='fileUploadButton' class="btn btn-primary" style="width: 100%;">Save</button>
    </div>    


</form>