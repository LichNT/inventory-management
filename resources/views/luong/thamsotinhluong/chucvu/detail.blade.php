@component('components.modal-update', [
   'type' => 'update-chucvu',
   'title' => __('model.chuc_vu'),
   'width' => '35%',
   'route' => 'luong.chamcong.updatethamsochucvu',
   'data' => $chucvu,
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Từ ngày <span style="color:red">*</span></label>
            <input type="text" class="form-control datemask"  name="tu_ngay"  tabindex="5"  value="{{$chucvu->tu_ngay}}">
        </div>
    </div>
@endcomponent