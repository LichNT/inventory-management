@component('components.confirm-delete',
[
    'route' => 'cuahang.delete',
    'method' => 'cuahang',
    'data' => $cuahang,
    'type' => 'delete-cuahang',
    'title' => 'Xóa cửa hàng',
    'width' => '25%',
])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Trực thuộc</label>
            <input type="text" class="form-control" value="{{$cuahang->tinh->ten}}"  disabled>

            <label class="control-label">Tên cửa hàng</label>
            <input type="text" class="form-control"  value="{{$cuahang->ten}}"  disabled>

            <label class="control-label">Địa điểm</label>
            <input type="text" class="form-control" value="{{$cuahang->ten_dia_diem}}"  disabled>

            <label class="control-label">Ngày đăng kí</label>
            <input type="text" class="form-control datemask"  value="{{$cuahang->ngay_dang_ki_kinh_doanh}}"  disabled>
        </div>
    </div>
@endcomponent
