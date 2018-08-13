@component('components.confirm-delete',
[
    'route' => 'luong.phat.delete',
    'method' => 'delete',
    'data' => $item,
    'type' => 'delete-phat',
    'title' => 'Xóa',
    'width' => '35%',
])
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
                          'disabled'=>'disabled',
                          'idSelected'=>$item->id_loai_phat
                      ])
            @endcomponent
            <label for="name" class="control-label">Ngày</label>
            <input type="text" disabled class="form-control datemask" id="ngay" name="ngay" tabindex="3" required value="{{$item->ngay}}" >
        </div>
    </div>@endcomponent