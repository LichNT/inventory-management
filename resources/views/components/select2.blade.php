@if(isset($none_required) && ($none_required))
        <select data="{{$data}}" {{!empty($name) ? 'name=' . $name  : null}} class="form-control select2" id={{empty($id) ? null : $id}} {{isset($onchange) ? ('onchange=' . $onchange) : null}} {{!empty($disabled) ? 'disabled'  : null}} {{empty($autofocus) ? null: 'autofocus'}} {{isset($tabindex) ? ('tabindex=' .  $tabindex) : null}}>
                <option value={{''}}>Chọn</option>
                @foreach($data as $item)
                <option id-data="{{$item->id}}" value={{empty($value) ? $item->id : $item->$value}} {{(isset($idSelected) && isset($item->$value) && $item->$value == $idSelected) ? 'selected="selected"' : null}}>{{$item->$text}} </option>
                @endforeach
        </select>
@else
        <select data="{{$data}}" required {{!empty($name) ? 'name=' . $name  : null}} class="form-control select2" id={{empty($id) ? null : $id}} {{isset($onchange) ? ('onchange=' . $onchange) : null}} {{!empty($disabled) ? 'disabled'  : null}} {{empty($autofocus) ? null: 'autofocus'}} {{isset($tabindex) ? ('tabindex=' .  $tabindex) : null}}>
                <option value={{''}}>Chọn</option>
                @foreach($data as $item)
                <option id-data="{{$item->id}}" value={{empty($value) ? $item->id : $item->$value}} {{(isset($idSelected) && isset($item->$value) && $item->$value == $idSelected) ? 'selected="selected"' : null}}>{{$item->$text}} </option>
                @endforeach
        </select>
@endif

