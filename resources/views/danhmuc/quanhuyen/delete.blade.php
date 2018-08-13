@component('components.confirm-delete',
[
    'route' => 'danhmuc.quanhuyen.delete',
    'method' => 'delete',
    'data' => $quanhuyen,
    'type' => 'delete-quanhuyen',
    'width' => '35%',
    'title' => __('model.quan_huyen')
])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Tỉnh, thành phố</label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$quanhuyen->tinh_thanh->ten}}" disabled>

            <label for="ma" class="control-label">Mã</label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$quanhuyen->ma}}" disabled >

            <label for="ten" class="control-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$quanhuyen->ten}}" disabled >

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $quanhuyen->trang_thai,
                'disabled' => 'disabled'
            ])
            @endcomponent
        </div>
    </div>
@endcomponent