<label>{{$label}}</label>
<select {{empty($id)?null:'id='.$id}} class="form-control select2 flat" multiple="multiple"  data-placeholder="{{isset($placeholder)? $placeholder : 'Chọn'}}"
        style="width: 100%;" name="{{$name . '[]'}}" {{(isset($required) && $required == true) ? 'required' : null}}>
    @if(isset($selected))
        @foreach(array(["key"=>0,"value"=>$false_text],["key"=>1,"value"=>$true_text]) as $item)
            @if(in_array($item["key"], $selected))
                <option value={{$item["key"]}} selected>{{$item["value"]}} </option>
            @else
                <option value={{$item["key"]}}>{{$item["value"]}} </option>
            @endif
        @endforeach
    @else
        <option value=0>{{$false_text}} </option>
        <option value=1>{{$true_text}} </option>
    @endif
</select>