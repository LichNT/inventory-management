@component('components.confirm-delete',
[
    'route' => 'luong.chamcong.deletethamsochucvu',
    'method' => 'delete',
    'data' => $chucvu,
    'type' => 'delete-chucvu',
    'title' => __('model.chuc_vu'),
    'width' => '35%',
])
    <div class="row">
    <div class="col-sm-12">
            <label class="control-label">Số ngày nghỉ trong tháng</label>
            <input type="number" class="form-control" disabled  value="{{$chucvu->so_ngay_nghi_trong_thang}}">
            
            <label class="control-label">Số giờ quy định</label>
            <input type="number" class="form-control" disabled  tabindex="4"  value="{{$chucvu->so_gio_quy_dinh}}">
           
            <label class="control-label">Từ ngày</label>
            <input type="text" class="form-control datemask"  disabled  tabindex="5"  value="{{$chucvu->tu_ngay}}">
            <label class="control-label">Đến ngày</label>
            <input type="text" class="form-control datemask"  disabled  tabindex="6"  value="{{$chucvu->den_ngay}}">
        </div>
    </div>
@endcomponent