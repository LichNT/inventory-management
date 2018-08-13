@component('components.confirm-delete',
[
    'route' => 'danhmuc.hopdongchucvu.delete',
    'method' => 'delete',
    'data' => $hopdongchucvu,
    'type' => 'delete-hopdongchucvu',
    'width' => '35%',
    'title' => __('model.hop_dong_chuc_vu')
])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Loại hợp đồng</label>
            <input type="text" class="form-control" id="ma_nhan_su" disabled name="ma_nhan_su" tabindex="1" required value="{{$hopdongchucvu->id_loai_hop_dong}}" >

            <label for="name" class="control-label">Loại chức vụ</label>
            <input type="text" class="form-control" id="ma_nhan_su" disabled name="ma_nhan_su" tabindex="1" required value="{{$hopdongchucvu->id_chuc_vu}}" >

        </div>
    </div>
@endcomponent