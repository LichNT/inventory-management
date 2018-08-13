@if(isset($id_inactive)&&isset($id_active))
    <label class="control-label">{{isset($title) ? $title : null}}</label>
    <div  style="margin-top: 5px;" id="test">  
        <input type="radio" id="{{$id_active}}"  value={{$value_active}} name={{$name}}  {{($value == $value_active) ? 'checked' : null}} {{ (isset($disabled) && ($disabled == true)) ? 'disabled' : null }} {{ isset($tabindex) ? 'tabindex='.$tabindex : null }}> {{$title_active}} &nbsp;&nbsp;
        <input type="radio"  id="{{$id_inactive}}"  value={{$value_inactive}} name={{$name}} {{($value == $value_inactive) ? 'checked' : null}} {{(isset($disabled) && ($disabled == true)) ? 'disabled' : null}} {{ isset($tabindex) ? 'tabindex='.($tabindex+1) : null }}> {{$title_inactive}}
    </div>
@else
    <label class="control-label">{{isset($title) ? $title : null}}</label>
    <div style="margin-top: 5px;" id="test">
            <input type="radio"    value={{$value_active}} name={{$name}}  {{($value == $value_active) ? 'checked' : null}} {{ (isset($disabled) && ($disabled == true)) ? 'disabled' : null }} {{ isset($tabindex) ? 'tabindex='.$tabindex : null }}> {{$title_active}} &nbsp;&nbsp;
            <input type="radio"    value={{$value_inactive}} name={{$name}} {{($value == $value_inactive) ? 'checked' : null}} {{(isset($disabled) && ($disabled == true)) ? 'disabled' : null}} {{ isset($tabindex) ? 'tabindex='.($tabindex+1) : null }}> {{$title_inactive}}
       
    </div>
@endif