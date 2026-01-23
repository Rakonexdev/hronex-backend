
<div class="acr-container">
    @foreach($menulinks as $sidelinks)
        @if(null == $sidelinks->child)
            <div class="row my-1 py-2 ps-3 bg-light bg-gradient">
                <div class="col-md-1"> 
                    <input type="checkbox" 
                            name="link_id[]" 
                            id="link_id-{{$sidelinks->id}}" 
                            value="{{$sidelinks->id}}"
                            @if(null != $rights && in_array($sidelinks->id, $rights)) checked @endif></div>   
                <div class="col-md-5 fw-bold" style="text-align: left;"> {{$sidelinks->name}}</div>                                                             
                <div class="col-md-6"> &nbsp; </div>  
            </div> 
        @else 
            <div class="row my-1 py-2 ps-3 bg-light bg-gradient">
                <div class="col-md-1"> 
                    <input type="checkbox" 
                            name="link_id[]" 
                            id="link_id-{{$sidelinks->id}}" 
                            value="{{$sidelinks->id}}"
                            @if(null != $rights && in_array($sidelinks->id, $rights)) checked @endif></div>   
                <div class="col-md-5 fw-bold" style="text-align: left;"> {{$sidelinks->name}}</div>                                                             
                <div class="col-md-6"> &nbsp; </div>  
            </div>
            @foreach($sidelinks->child as $innerlinks)
                <div class="row my-1 py-2 ps-3 bg-light bg-gradient">
                    <div class="col-md-1"> </div>
                    <div class="col-md-1"> 
                        <input type="checkbox" 
                                name="link_id[]" 
                                id="link_id-{{$innerlinks->id}}" 
                                value="{{$innerlinks->id}}"
                                @if(null != $rights && in_array($innerlinks->id, $rights)) checked @endif></div>   
                    <div class="col-md-6" style="text-align: left;"> {{$innerlinks->name}}</div>                                                             
                    <div class="col-md-4"> &nbsp; </div>  
                </div>
            @endforeach
        @endif
    @endforeach
</div>