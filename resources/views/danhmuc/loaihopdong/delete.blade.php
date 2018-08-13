@component('components.confirm-delete',
[
    'route' => 'danhmuc.loaihopdong.delete',
    'method' => 'delete',
    'data' => $loaihopdong,
    'type' => 'delete-loaihopdong',
    'width' => '35%',
    'title' => __('model.loai_hop_dong')
])
    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã</label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$loaihopdong->ma}}" disabled >

            <label for="ten" class="control-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$loaihopdong->ten}}" disabled >


            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $loaihopdong->trang_thai,
                'disabled' => 'disabled'
            ])
            @endcomponent
        </div>
    </div>
@endcomponent