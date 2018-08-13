@component('components.modal-update', [
   'type' => 'update-loaiphucap',
   'title' => __('model.loai_phu_cap'),
   'width' => '35%',
   'route' => 'luong.danhmuc.loaiphucap.edit',
   'data' => $loaiphucap,
   'method' => 'PUT'])

        <div class="row">
            <div class="col-sm-12">
                <label class="control-label">Tên<span style="color:red">*</span></label>
                <input type="text" class="form-control" name="ten" tabindex="1" required value="{{$loaiphucap->ten}}" required autofocus placeholder="Tối đa 255 kí tự">
                
                <label class="control-label">Mô tả</label>
                <textarea class="form-control" name="mo_ta" tabindex="2">{{$loaiphucap->mo_ta}}</textarea>
            </div>
        </div>
@endcomponent