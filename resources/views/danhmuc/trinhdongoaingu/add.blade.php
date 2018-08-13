@component('components.modal-add', [
   'type' => 'trinhdongoaingu',
   'title' => __('model.trinh_do_ngoai_ngu'),
   'width' => '35%',
   'route' => 'danhmuc.trinhdongoaingu.add',
   ])
    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã<span style="color:red">*</span></label>
        <input type="text" class="form-control" id="ma" name="ma" autofocus tabindex="1" required value="{{old('ma')}}">
            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" tabindex="2" required value="{{old('ten')}}">
            <label for="ten" class="control-label">Mô tả</label>
            <input type="text" class="form-control" id="mo_ta" name="mo_ta" tabindex="3" value="{{old('mo_ta')}}">
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => old('trang_thai'),
            ])
            @endcomponent
        </div>
    </div>
@endcomponent