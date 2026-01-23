@if(NULL!=$leave_application && NULL != $leave_application->attachment)   
		
		@php               
	    	$eachfl = $leave_application->attachment;

	        $ext = explode('.', $eachfl);
	        $extCount = count($ext);
	        $lastIndex = $extCount-1;

	        if('xls'== $ext[$lastIndex] || 'xlsx'== $ext[$lastIndex] || 'csv'== $ext[$lastIndex] || 'xls'== $ext[$lastIndex]){
	          $bg_style = 'success';
	          $bg_type = 'excel';
	        }else if('pdf'== $ext[$lastIndex]){
	          $bg_style = 'danger';
	          $bg_type = 'pdf';
	        }else if('doc'== $ext[$lastIndex] || 'docx'== $ext[$lastIndex]){
	          $bg_style = 'info';
	          $bg_type = 'word';
	        }else if('txt'== $ext[$lastIndex]){
	          $bg_style = '';
	          $bg_type = 'text';
	        }else if('png'== $ext[$lastIndex] || 'jpeg'== $ext[$lastIndex] || 'jpg'== $ext[$lastIndex]){
	          $bg_style = '';
	          $bg_type = 'image';
	        }else{
	          $bg_style = '';
	          $bg_type = '';
	        }
	        
	    @endphp
			    
        <div class="document {{$bg_style}}">
	      	<div class="document-header text-right pe-2"></div>
	      	<a href="{{asset('uploads/employees/leave')}}/{{$eachfl}}" target="__blank">
	            <div class="document-body">
	                <i class="fa fa-file-{{$bg_type}}-o text-{{$bg_style}}"></i>
	            </div>
	            <div class="document-footer">
	                <span class="document-name" style="text-align:center;"> 
	                  Leave ttachment
	                </span>
	                <!-- <span class="document-description"> 1.2 MB </span> -->
	            </div>
	        </a>
        </div>  	
@else
	<div class="text-center" style="color:#FF0000;">{{trans('messages.no_data')}}</div>
@endif
