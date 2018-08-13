@component('components.modal-update', [
   'type' => 'update-loainghidacbiet',
   'title' => __('model.loai_nghi_dac_biet'),
   'width' => '35%',
   'route' => 'danhmuc.loainghidacbiet.update',
   'data' => $loainghidacbiet,
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã</label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$loainghidacbiet->ma}}" autofocus tabindex="1" required>

            <label for="ten" class="control-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$loainghidacbiet->ten}}" tabindex="2" required>

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $loainghidacbiet->trang_thai,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent