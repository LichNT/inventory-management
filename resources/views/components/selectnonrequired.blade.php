@if(isset($none_required) && ($none_required))
        <select {{!empty($name) ? 'name=' . $name  : null}} class="form-control" id={{empty($id) ? null : $id}} {{isset($tabindex) ? ('tabindex=' . $tabindex) : null}} {{isset($onchange) ? ('onchange=' . $onchange) : null}}>
                <option value={{null}}>Chọn</option>
                @foreach($data as $item)
                <option value={{empty($value) ? $item->id : $item->$value}} {{(isset($idSelected) && isset($item->$value) && $item->$value == $idSelected) ? 'selected="selected"' : null}}>{{$item->$text}} </option>     
                @endforeach
        </select>
@else
        <select {{!empty($name) ? 'name=' . $name  : null}} class="form-control" id={{empty($id) ? null : $id}} {{isset($tabindex) ? ('tabindex=' . $tabindex) : null}} {{isset($onchange) ? ('onchange=' . $onchange) : null}}>
                <option value={{null}}>Chọn</option>
                @foreach($data as $item)
                <option value={{empty($value) ? $item->id : $item->$value}} {{(isset($idSelected) && isset($item->$value) && $item->$value == $idSelected) ? 'selected="selected"' : null}}>{{$item->$text}} </option>     
                @endforeach
        </select>
@endif
