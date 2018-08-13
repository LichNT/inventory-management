@component('components.modal-add', [
   'type' => 'phat',
   'title' => __('Thêm'),
   'width' => '35%',
   'route' => 'luong.phat.add'
   ])
    <div class="row">
        <div class="col-sm-12">
            <input type="hidden" class="form-control" id="ngay" name="id_nhan_su" tabindex="3"  value="{{$id_nhan_su}}" >
            <label for="name" class="control-label">Loại phạt<span style="color:red">*</span></label>
            @component('components.select', [
                          'data' => $loaiphats,
                          'text' => 'ten',
                          'value' => 'id',
                          'id' => 'id_loai_phat',
                          'name' => 'id_loai_phat',
                          'tabindex' => 2
                      ])
            @endcomponent
            <label for="name" class="control-label">Ngày  <span style="color:red">*</span></label>
            <input type="text" class="form-control datemask" id="ngay" name="ngay" tabindex="3" required value="{{old('ngay')}}" >

        </div>
    </div>
@endcomponent