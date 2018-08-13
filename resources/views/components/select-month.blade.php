@if(isset($none_required) && ($none_required))
<select {{!empty($name) ? 'name=' . $name  : null}} class="form-control" {{empty($id) ? null :'id='. $id}} {{isset($tabindex) ? ('tabindex=' . $tabindex) : null}}>
    <option value={{null}}>{{empty($tatca)? 'Chọn': $tatca}}</option>
    @for($i=0;$i<12;$i++)
    <option value="{{$i+1}}" {{(isset($idSelected)  && ($i+1) == $idSelected) ? 'selected="selected"' : null}}>Tháng {{$i+1}} </option>
    @endfor
</select>
@else
<select {{!empty($name) ? 'name=' . $name  : null}} class="form-control"  {{empty($id) ? null :'id='. $id}} {{isset($tabindex) ? ('tabindex=' . $tabindex) : null}} required>
    <option value={{null}}>{{empty($tatca)? 'Chọn': $tatca}}</option>
    <@for($i=0;$i<12;$i++)
        <option value="{{$i+1}}" {{(isset($idSelected)  && ($i+1) == $idSelected) ? 'selected="selected"' : null}}>Tháng {{$i+1}} </option>
    @endfor
</select>
@endif