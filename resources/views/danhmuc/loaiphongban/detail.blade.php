@component('components.modal-update', [
   'type' => 'update-loaiphongban',
   'title' => __('model.loai_phong_ban'),
   'width' => '35%',
   'route' => 'danhmuc.loaiphongban.update',
   'data' => $loaiphongban,
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$loaiphongban->ma}}" autofocus tabindex="1" required>

            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$loaiphongban->ten}}" tabindex="2" required>

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $loaiphongban->trang_thai,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent