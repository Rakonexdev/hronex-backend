<select name="steps[]" class="form-control mb-2">
    @foreach($roles as $key => $role)
        <option value="{{ $key }}">
            @if($key=='Vp')
                Executive Manager
            @elseif($key=='Principal')
                Manager
            @else
                {{ $role }}
            @endif
            </option>
    @endforeach
</select>
