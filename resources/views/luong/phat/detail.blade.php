@component('components.modal-update', [
   'type' => 'update-phat',
   'title' => __('model.phat'),
   'width' => '35%',
   'route' => 'luong.phat.update',
   'data' => $phat,
   'method' => 'POST'])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Nhân viên<span style="color:red">*</span></label>
            <input type="text" class="form-control " readonly required value="{{$phat->nhanSu->ho_ten}}" >
            <label for="name" class="control-label">Loại phạt<span style="color:red">*</span></label>
            @component('components.select', [
                          'data' => $loaiphats,
                          'text' => 'ten',
                          'value' => 'id',
                          'id' => 'id_loai_phat',
                          'name' => 'id_loai_phat',
                          'tabindex' => 2,
                          'idSelected'=>$phat->id_loai_phat
                      ])
            @endcomponent
            <label for="name" class="control-label">Ngày<span style="color:red">*</span></label>
            <input type="text" class="form-control datemask" id="ngay" name="ngay" tabindex="3" required value="{{$phat->ngay}}" >

        </div>
    </div>
@endcomponent