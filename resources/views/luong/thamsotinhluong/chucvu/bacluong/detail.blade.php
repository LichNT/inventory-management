@component('components.modal-update', [
   'type' => 'update-bacluong',
   'title' => 'Cập nhật',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'luong.chamcong.updatethamsobacluong',
   'data' => $bacluong,
   'method' => 'PUT'])

        <div class="row">
            <div class="col-sm-12">
                <label class="control-label">Từ ngày<span style="color:red">*</span></label>
                <input type="text" class="form-control datemask"  name="tu_ngay"  tabindex="2" required value="{{$bacluong->tu_ngay}}">
            </div>
        </div>
@endcomponent