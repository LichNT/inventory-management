@component('components.modal-add', [
   'type' => 'loaiphucap',
   'title' => __('model.loai_phu_cap'),
   'width' => '35%',
   'route' => 'luong.danhmuc.loaiphucap.add',
   ])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Tên <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ten" tabindex="1" required value="{{old('ten')}}" required autofocus placeholder="Tối đa 255 kí tự">
            
            <label class="control-label">Mô tả</label>
            <textarea class="form-control" name="mo_ta" tabindex="2">{{old('mo_ta')}}</textarea>
        </div>
    </div>
@endcomponent