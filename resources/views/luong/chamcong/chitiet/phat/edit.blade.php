@component('components.modal-update', [
   'type' => 'update-phat',
   'title' => 'Cập nhật',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'luong.phat.update',
   'data' => $item,
   'method' => 'POST'])
    <div class="row">
        <div class="col-sm-12">
            <input type="hidden" class="form-control" id="ngay" name="id_nhan_su" tabindex="3"  value="{{$item->nhanSu->id}}" >
            <label for="name" class="control-label">Loại phạt</label>
            @component('components.select', [
                          'data' => $loaiphats,
                          'text' => 'ten',
                          'value' => 'id',
                          'id' => 'id_loai_phat',
                          'name' => 'id_loai_phat',
                          'tabindex' => 2,
                          'idSelected'=>$item->id_loai_phat
                      ])
            @endcomponent
            <label for="name" class="control-label">Ngày</label>
            <input type="text" class="form-control datemask" id="ngay" name="ngay" tabindex="3" required value="{{$item->ngay}}" >
        </div>
    </div>
@endcomponent