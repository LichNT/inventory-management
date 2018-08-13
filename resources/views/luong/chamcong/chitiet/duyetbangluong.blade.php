@component('components.modal-update', [
   'type' => 'update-duyetbangluong',
   'title' => 'Duyệt bảng lương ',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'luong.chamcong.duyetbangluong',
   'data' => $chamcong,
   'method' => 'PUT'])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Ngày</label>
            <input type="text" class="form-control datemask"  name="ngay_thang" tabindex="3" required value="{{date('d/m/Y')}}" >
        </div>
    </div>
@endcomponent