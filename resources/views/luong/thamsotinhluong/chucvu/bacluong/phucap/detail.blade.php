@component('components.modal-update', [
   'type' => 'update-phucap',
   'title' => 'Cập nhật',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'luong.chamcong.updatethamsophucap',
   'data' => $phucap,
   'method' => 'PUT'])

    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Từ ngày<span style="color:red">*</span></label>
            <input type="text" class="form-control datemask" required name="tu_ngay"  tabindex="3"  value="{{$phucap->tu_ngay}}">
        </div>
    </div>
@endcomponent