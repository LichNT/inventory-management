@component('components.modal-add', [
   'type' => 'bacluong',
   'title' => __('model.phu_cap'),
   'width' => '35%',
   'route' => 'luong.chamcong.addthamsophucap',
   'id'=>$bac_id,
   ])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Loại phụ cấp<span style="color:red">*</span></label>
            @component('components.select', [
                          'data' => $phucaps,
                          'text' => 'ten',
                          'value' => 'id',
                          'name' => 'id_loai_phu_cap',
                      ])
            @endcomponent
            <label for="name" class="control-label">Số tiền(vnđ)<span style="color:red">*</span></label>
            <input type="text" class="form-control maskmoney" id="so_tien" name="so_tien" tabindex="2" required value="{{number_format(old('so_tien'))}}" >
            <label class="control-label">Từ ngày<span style="color:red">*</span></label>
            <input type="text" class="form-control datemask"  name="tu_ngay"  tabindex="3" required value="{{old('tu_ngay')}}">
        </div>
    </div>
@endcomponent