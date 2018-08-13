@component('components.modal-update', [
   'type' => 'update-nghidacbiet',
   'title' => 'Cập nhật',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'nhansu.update.nghidacbiet.edit',
   'data' => $nghidacbiet,
   'method' => 'PUT'])

    <div class="row">
        <div class="col-md-6">
            <label  >Trường hợp nghỉ đặc biệt<span style="color:red">*</span></label>
            @component('components.select', [
                'data' => $loainghidacbiets,
                'text' => 'ten',
                'id' => 'id_loai_nghi_dac_biet',
                'value' => 'id',
                'name' => 'id_loai_nghi_dac_biet',
                'none_required'=>'true',
                'idSelected'=>$nghidacbiet->id_loai_nghi_dac_biet
                ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  >Từ ngày</label>
            <input type="text" class="form-control datemask"  name="ngay_bat_dau" tabindex="6" value="{{$nghidacbiet->ngay_bat_dau}}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  >Đến ngày</label>
            <input type="text" class="form-control datemask"  name="ngay_ket_thuc" tabindex="6" value="{{$nghidacbiet->ngay_ket_thuc}}">
        </div>
        <div class="col-md-6">
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $nghidacbiet->trang_thai,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent