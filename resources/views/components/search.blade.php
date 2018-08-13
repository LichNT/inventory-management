<form id="search-form" action={{ empty($id) ? route($routerName) : route($routerName, $id)}} method="GET">
    {{ csrf_field() }}
    <label>{{$title}}:
        <input type="search" class="form-control input-sm" value="{{$search}}" name="search" id="search">
    </label>  
</form>
    
    