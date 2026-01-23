@php
  $role = Auth::user();
  $hrRole = Spatie\Permission\Models\Role::where('name', HR_ROLE)->first();  
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="bg-white">
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="5"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th colspan="2">{{$valueId}}</th>
                        @if($role->hasRole(VP_ROLE) || $role->hasRole('Executive-Admin'))
                        <th colspan="2">HOD Rating</th>
                        @endif
                        @if($role->hasRole('Principal'))
                        <th colspan="2">Principal Rating</th>
                        @endif
                    </tr>
                    @foreach(get_appraisal_data($valueName,$dept) as $appraisal_data)
                    <tr>
                        <td scope="row" colspan="2">
                            <span class="text-wrap">{{$appraisal_data->details}}</span>
                        <input type="hidden" name="appraisal_data[]" value="{{$appraisal_data->id}}">

                        </td>
                        @if($role->hasRole(VP_ROLE) || $role->hasRole('Executive-Admin'))
                        <td scope="row" colspan="2">
                        <select id="hod_rating_{{$appraisal_data->id}}" class="form-select" style="color: #8D8D8D;" name="hod_rating[]" value="">
                            <option selected></option>
                            <option>NA</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                        </td>
                        @endif
                        @if($role->hasRole('Principal'))
                        <td scope="row" colspan="2">
                        <select id="principal_rating_{{$appraisal_data->id}}" class="form-select" style="color: #8D8D8D;" name="principal_rating[]" value="">
                            <option selected></option>
                            <option>NA</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                        </td>
                        @endif
                        <td style="display: none;">
                        <input type="hidden" name="type[]" value="COMPETENCIES (Ratings and Weightages entered by Appraiser)">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>            