@component('components.confirm-delete',
[
    'route' => 'luong.phat.delete',
    'method' => 'delete',
    'data' => $phat,
    'type' => 'delete-phat',
    'title' => __('model.phat'),
    'width' => '35%',
])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Mã nhân viên</label>
            @component('components.select2', [
                          'data' => $nhansus,
                          'text' => 'ma_ten',
                          'value' => 'id',
                          'id' => 'id_nhan_su',
                          'name' => 'id_nhan_su',
                          'tabindex' => 1,
                          'idSelected' => $phat->id_nhan_su,
                          'disabled'=>true
                      ])
            @endcomponent
            <label for="name" class="control-label">Loại phạt</label>
            @component('components.select', [
                          'data' => $loaiphats,
                          'text' => 'ten',
                          'value' => 'id',
                          'id' => 'id_loai_phat',
                          'name' => 'id_loai_phat',
                          'none_required'=>'true',
                          'idSelected'=>$phat->id_loai_phat,
                          'disabled'=>true
                      ])
            @endcomponent
            <label for="name" class="control-label">Ngày</label>
            <input type="text" class="form-control datemask" disabled id="ngay" name="ngay" tabindex="1" required value="{{$phat->ngay}}" >

        </div>
    </div>
@endcomponent