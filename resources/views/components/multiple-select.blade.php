<label>{{$label}}</label>
<select id="{{empty($id)? null:$id}}" class="form-control select2 flat" multiple="multiple"  data-placeholder="{{isset($placeholder)? $placeholder : 'Chọn'}}"
style="width: 100%;" name="{{$name . '[]'}}" {{(isset($required) && $required == true) ? 'required' : null}}>
    @if(isset($selected))
        @foreach($data as $item)
            @if(empty($value))
                @if (isset($item->id))
                    @if(in_array($item->id, $selected))
                        <option value={{$item->id}} selected>{{$item->$text}} </option>
                    @else
                        <option value={{$item->id}}>{{$item->$text}} </option>
                    @endif          
                @endif
            @else
                 @if (isset($item->$value))
                    @if(in_array($item->$value, $selected))
                        <option value={{$item->$value}} selected>{{$item->$text}} </option>
                    @else
                        <option value={{$item->$value}}>{{$item->$text}} </option>
                    @endif          
                @endif
            @endif
           
        @endforeach     
    @else        
        @foreach($data as $item)
            <option value={{empty($value) ? $item->id : $item->$value}}>{{$item->$text}} </option>    
        @endforeach
    @endif    
</select>