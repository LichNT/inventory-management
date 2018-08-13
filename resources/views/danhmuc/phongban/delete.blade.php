@component('components.confirm-delete', 
[ 
    'route' => 'danhmuc.phongban.delete', 
    'method' => 'delete', 
    'data' => $phongban, 
    'type' => 'delete-phongban',
    'width' => '35%',
    'title' => __('model.phong_ban')   
]) 
   <div class="row">
   <div class="col-sm-12">
            <label for="ma" class="control-label">Mã</label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$phongban->ma}}" disabled >
            
            <label for="ten" class="control-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$phongban->ten}}" disabled >

            <label for="loai" class="control-label">Trực thuộc</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$phongban->myParent->ten}}" disabled >
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active2'),
                'title_inactive' => __('system.inactive2'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $phongban->trang_thai,  
                'disabled' => 'disabled'           
            ])
            @endcomponent 
        </div> 
    </div>               
@endcomponent