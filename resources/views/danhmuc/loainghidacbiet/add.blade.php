@component('components.modal-add', [
   'type' => 'loainghidacbiet',
   'title' => __('model.loai_nghi_dac_biet'),
   'width' => '35%',
   'route' => 'danhmuc.loainghidacbiet.add',
   ])
    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã</label>
            <input type="text" class="form-control" id="ma" name="ma" autofocus tabindex="1" required value="{{old('ma')}}">
            <label for="ten" class="control-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" tabindex="2" required value="{{old('ten')}}">
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => 1,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent