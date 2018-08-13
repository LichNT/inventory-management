@component('components.confirm-delete',
[
    'route' => 'danhmuc.loaitochuc.delete',
    'method' => 'delete',
    'data' => $loaitochuc,
    'width' => '35%',
    'type' => 'delete-loaitochuc',
    'title' => __('model.loai_to_chuc')
])
    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã</label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$loaitochuc->ma}}" disabled >

            <label for="ten" class="control-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$loaitochuc->ten}}" disabled >

            <label for="ten" class="control-label">Mô tả</label>
            <input type="text" class="form-control"  value="{{$loaitochuc->mo_ta}}" disabled >


            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'inactive',
                'name' => 'inactive',
                'title_active' => __('system.active'),
                'title_inactive' => 'Ngừng sử dụng',
                'value_active' => 0,
                'value_inactive' => 1,
                'value' => $loaitochuc->trang_thai,
                'disabled' => 'disabled'
            ])
            @endcomponent
        </div>
    </div>
@endcomponent