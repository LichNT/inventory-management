@component('components.modal-add', [
   'type' => 'chitietbaolanh',
   'title' => __('model.chitietbaolanh'),
   'width' => '35%',
   'route' => 'chitietbaolanh.add',
   'id'=>$nhansu->id
   ])

    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Số tiền</label>
            <input type="text" class="form-control maskmoney"  name="so_tien" tabindex="1"  value="{{old('so_tien')}}">
            <label for="ma" class="control-label">Ngày tháng</label>
            <input type="text" min=1 class="form-control datemask" name="ngay_thang"  tabindex="2"  value="{{old('ngay_thang')}}">
            @component('components.group-checkbox', [
                'title' => 'Loại',
                'id' => 'loai',
                'name' => 'loai',
                'title_active' => __('Nộp tiền bảo lãnh'),
                'title_inactive' => __('Hoàn trả tiền bảo lãnh'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' =>1,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent