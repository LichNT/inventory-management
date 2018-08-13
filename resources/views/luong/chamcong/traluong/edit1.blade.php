@component('components.modal-update', [
   'type' => 'update-luonglan1',
   'title' => 'Cập nhật',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'luong.chamcong.updateluongnhansulan1',
   'data' => $item,
   'params' => [$ten_bang,$item->id],
   'method' => 'PUT'])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Lương lần 1</label>
            <input type="text" class="form-control maskmoney"  {{($trang_thai_thanh_toan)?'disabled':null}} id="tra_luong_lan_1" name="tra_luong_lan_1" tabindex="3" required value="{{number_format($item->tra_luong_lan_1)}}" >
        </div>
    </div>
@endcomponent