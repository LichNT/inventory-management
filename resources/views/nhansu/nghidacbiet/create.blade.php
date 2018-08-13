@component('components.modal-add', [
    'type' => 'nghidacbiet',
    'title' => 'Thêm mới',
    'width' => '35%',
    'route' => 'nhansu.update.nghidacbiet.create',
    'id' => $nhansu->id,
    ])

    <div class="row">
        <div class="col-md-6">
            <label  >Trường hợp nghỉ đặc biệt<span style="color:red">*</span></label>
        @component('components.select', [
            'data' => $loainghidacbiets,
            'text' => 'ten',
            'id' => 'id_loai_nghi_dac_biet',
            'value' => 'id',
            'name' => 'id_loai_nghi_dac_biet',
            'none_required'=>'true'])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  >Từ ngày</label>
            <input type="text" class="form-control datemask"  name="ngay_bat_dau" tabindex="6">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  >Đến ngày</label>
            <input type="text" class="form-control datemask"  name="ngay_ket_thuc" tabindex="6">
        </div>
        <div class="col-md-6">
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => 1,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent