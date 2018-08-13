@component('components.modal-update', [
   'type' => 'update-khoaso',
   'title' => __('model.bang_cham_cong'),
   'width' => '35%',
   'route' => 'luong.chamcong.khoaso',
   'data' => $item,
   'method' => 'PUT'])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Ngày khóa sổ <span style="color:red">*</span></label>
            <input type="text" class="form-control datemask" name="ngay_khoa_so" tabindex="1" required value="{{date('d/m/Y')}}" autofocus >
        </div>
    </div>
@endcomponent