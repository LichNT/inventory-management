@component('components.confirm-delete',
[
    'route' => 'nhansu.update.nghidacbiet.delete',
    'method' => 'delete',
    'data' => $nghidacbiet,
    'type' => 'delete-nghidacbiet',
    'title' => 'Xóa',
    'width' => '35%'
])

    <div class="row">
        <div class="col-md-6">
            <label  >Trường hợp nghỉ đặc biệt</label>
            @component('components.select', [
                'data' => $loainghidacbiets,
                'text' => 'ten',
                'id' => 'id_loai_nghi_dac_biet',
                'value' => 'id',
                'name' => 'id_loai_nghi_dac_biet',
                'none_required'=>'true',
                'idSelected'=>$nghidacbiet->id_loai_nghi_dac_biet,
                'disabled'=>'disabled'
                ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  >Từ ngày</label>
            <input type="text" class="form-control datemask"  name="ngay_bat_dau" tabindex="6" value="{{$nghidacbiet->ngay_bat_dau}}" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  >Đến ngày</label>
            <input type="text" class="form-control datemask"  name="ngay_ket_thuc" tabindex="6" value="{{$nghidacbiet->ngay_ket_thuc}}" disabled>
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
                'disabled'=>'disabled'

            ])
            @endcomponent
        </div>
    </div>
@endcomponent