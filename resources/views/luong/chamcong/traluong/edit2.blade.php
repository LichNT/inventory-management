@component('components.modal-update', [
   'type' => 'update-luonglan2',
   'title' => 'Cập nhật',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'luong.chamcong.updateluongnhansulan2',
   'data' => $item,
   'params' => [$ten_bang,$item->id],
   'method' => 'PUT'])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Lương lần 2</label>
            <input type="text" class="form-control maskmoney"  {{($trang_thai_thanh_toan)?'disabled':null}} id="tra_luong_lan_2" name="tra_luong_lan_2" tabindex="3" required value="{{number_format($item->tra_luong_lan_2)}}" >
        </div>
    </div>
@endcomponent