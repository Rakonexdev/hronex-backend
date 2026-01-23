@php $a=0; @endphp

@if(null!=$data->employeeFiles)
	@foreach($data->employeeFiles as $eachfile)		
		@php
	        $a=1;
	        $atch = $eachfile->file_data;
	    @endphp
		
	        @foreach($atch as $eachfl)

				@php
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

				@if(File::exists(public_path($eachfile->file_path.'/'.$eachfl)))
		          <div class="document {{$bg_style}}" id="div_{{$eachfile->id}}">
		          	<div class="document-header text-right pe-2">
		          		<span id="del-fl" style="color:#FF0000; cursor:pointer;font-weight:bold;" onclick="cust.deleteFile({{$eachfile->id}}, '{{$eachfl}}');">x</span>
		          	</div>
					
		          	<a href="{{asset($eachfile->file_path)}}/{{$eachfl}}" target="__blank">
			            <div class="document-body">
						<iframe src='{{asset($eachfile->file_path)}}/{{$eachfl}}' width='100%' height='100%' frameborder='0'></iframe>
			            </div>
			            <div class="document-footer">
			                <span class="document-name" style="text-align:center;"> 
			                  {{ucfirst($eachfile->file_type)}} File
			                </span>
			                <!-- <span class="document-description"> 1.2 MB </span> -->
			            </div>
			        </a>
		          </div>
				@endif

		    @endforeach

	@endforeach
@endif

@if(0 == $a)
	{{trans('messages.no_data')}}
@endif
