@component('components.confirm-delete', 
[ 
    'route' => 'lookup.delete', 
    'method' => 'delete', 
    'data' => $lookup, 
    'type' => 'delete-lookup',
    'width' => '25%',
    'title' => __('model.lookup')   
]) 
   <div class="row">
        <div class="col-md-12">
            <label for="ma" class="control-label">Mã </label>
            <input type="text" class="form-control" id="ma" value="{{$lookup->ma}}" name="ma" disabled>
            
            <label for="ten" class="control-label">Tên </label>
            <input type="text" class="form-control" id="ten" value="{{$lookup->ten}}" name="ten" disabled>

            <label for="loai" class="control-label">Loại</label>
            @if(isset($lookup->type_lookup))
                <input type="text" class="form-control" id="loai" value="{{$lookup->type_lookup->ten}}" name="loai" disabled>
            @else
                <input type="text" class="form-control" id="loai" value="{{null}}" name="loai" disabled>
            @endif 

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'active',
                'name' => 'active',
                'title_active' => 'Còn sử dụng',
                'title_inactive' => 'Ngừng sử dụng',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $lookup->active,
                'disabled' => 'disabled'            
            ])
            @endcomponent 
        </div> 
    </div>               
@endcomponent