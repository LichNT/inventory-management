@component('components.confirm-delete',
[
    'route' => 'danhmuc.trinhdochuyenmon.delete',
    'method' => 'delete',
    'data' => $trinhdochuyenmon,
    'type' => 'delete-trinhdochuyenmon',
    'width' => '35%',
    'title' => __('model.trinh_do_chuyen_mon')
])
    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã</label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$trinhdochuyenmon->ma}}" disabled >

            <label for="ten" class="control-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$trinhdochuyenmon->ten}}" disabled >


            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $trinhdochuyenmon->trang_thai,
                'disabled' => 'disabled'
            ])
            @endcomponent
        </div>
    </div>
@endcomponent