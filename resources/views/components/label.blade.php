@if(empty($data))
    {{(empty($text_null) ?  '---' : '---')}}    
@elseif(strlen($data) > 50)
    <span>        
        {{mb_substr($data,0, 45 ,"utf-8") . '...'}}
    </span>
@elseif($data=="Nam")
    <span class="label label-success ">
        {{$data}}
    </span>
@elseif($data=="Nữ")
    <span class="label label-warning ">
        {{$data}}
    </span>
@else
    <span >
        {{$data}}
    </span>
@endif