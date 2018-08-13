@if(isset($none_required) && ($none_required))
        <select {{isset($on_change)?'onchange=getChild("'.$name.'",event,"'.$idChild.'","'.$chil.'","'.$parent_name.'","'.$id_current.'")':null}}
                {{isset($chamcong)?'onchange=chamCong("'.$name.'","'.$id_nhan_su.'","'.$id.'")':null}}
                data="{{$data}}" {{!empty($disabled) ? 'disabled'  : null}}  {{!empty($name) ? 'name=' . $name  : null}} class="form-control" {{empty($id) ? null : 'id='.$id}} {{isset($tabindex) ? ('tabindex=' . $tabindex) : null}} {{isset($onchange) ? ('onchange=' . $onchange) : null}}>
                <option value={{null}}>{{empty($tatca)? 'Chọn': $tatca}}</option>
                @foreach($data as $item)
                <option value={{empty($value) ? $item->id : ($item->$value)}} {{(isset($idSelected) && isset($item->$value) && ($item->$value) == $idSelected) ? 'selected="selected"' : null}}>{{$item->$text}} </option>
                @endforeach
        </select>
@else
        <select {{isset($on_change)?'onchange=getChild("'.$name.'",event,"'.$idChild.'","'.$chil.'","'.$parent_name.'","'.$id_current.'")':null}}
                {{isset($chamcong)?'onchange=chamCong("'.$name.'","'.$id_nhan_su.'","'.$id.'")':null}}
                data="{{$data}}" {{!empty($disabled) ? 'disabled'  : null}} {{empty($tabindex)? '0':'tabindex='.$tabindex}}
                required {{!empty($name) ? 'name=' . $name  : null}} class="form-control" {{empty($id) ? null : 'id='.$id}} {{isset($tabindex) ? ('tabindex=' . $tabindex) : null}}
                {{isset($onchange) ? ('onchange=' . $onchange) : null}}>
                <option value={{null}}>{{empty($tatca)? 'Chọn': $tatca}}</option>
                @foreach($data as $item)
                <option value={{empty($value) ? $item->id : ($item->$value)}} {{(isset($idSelected) && isset($item->$value) && ($item->$value) == $idSelected) ? 'selected="selected"' : null}}>{{$item->$text}} </option>
                @endforeach
        </select>
@endif
