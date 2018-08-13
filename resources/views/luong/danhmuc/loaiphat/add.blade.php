@component('components.modal-add', [
   'type' => 'loaiphat',
   'title' => __('model.loai_phat'),
   'width' => '35%',
   'route' => 'luong.danhmuc.loaiphat.add',
   ])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Tên <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ten" tabindex="1" required value="{{old('ten')}}" required autofocus placeholder="Tối đa 255 kí tự">
            <label for="name" class="control-label ">Số tiền(vnđ)</label>
            <input type="text" class="form-control maskmoney" id="so_tien" name="so_tien" tabindex="2"  value="{{old('so_tien')}}" >
            <label class="control-label">Mô tả</label>
            <textarea class="form-control" name="mo_ta" tabindex="2">{{old('mo_ta')}}</textarea>
            @component('components.group-checkbox', [
               'title' => 'Trạng thái',
               'id' => 'inactive',
               'name' => 'inactive',
               'title_active' => __('system.active'),
               'title_inactive' => __('system.inactive'),
               'value_active' => 0,
               'value_inactive' => 1,
               'value' => 0,
           ])
            @endcomponent
        </div>
    </div>
@endcomponent