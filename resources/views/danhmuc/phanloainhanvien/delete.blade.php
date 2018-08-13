@component('components.confirm-delete',
[
    'route' => 'danhmuc.phanloainhanvien.delete',
    'method' => 'delete',
    'data' => $phanloainhanvien,
    'type' => 'delete-phanloainhanvien',
    'title' => __('model.phan_loai_nhan_su'),
    'width' => '35%',
])
    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã</label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$phanloainhanvien->ma}}" disabled >

            <label for="ten" class="control-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$phanloainhanvien->ten}}" disabled >


            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $phanloainhanvien->trang_thai,
                'disabled' => 'disabled'
            ])
            @endcomponent
        </div>
    </div>
@endcomponent