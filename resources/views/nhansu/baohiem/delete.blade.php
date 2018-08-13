@component('components.confirm-delete',
[
    'route' => 'nhansu.update.baohiem.delete',
    'method' => 'delete',
    'data' => $baohiem,
    'type' => 'delete-baohiem',
    'title' => 'Xóa bảo hiểm',
    'width' => '35%'
])

<div class="row">
        <div class="col-md-6">
            <label>Tên bảo hiểm</label>
            <input type="text" class="form-control"  value="{{$baohiem->ten}}"disabled >
        </div>
        <div class="col-md-6">
            <label>Tháng bắt đầu</label>
            <input type="text" class="form-control monthmask" value="{{$baohiem->thang_bat_dau}}" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Tháng chuyển bảo hiểm về CN</label>
            <input type="text" class="form-control monthmask"   value="{{$baohiem->thang_chuyen_bao_hiem_ve_chi_nhanh}}"disabled>
        </div>
        <div class="col-md-6">
            <label>Tháng dừng đóng bảo hiểm</label>
            <input type="text" class="form-control monthmask" value="{{$baohiem->thang_dung_dong_bao_hiem}}" disabled >
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Mức đóng bảo hiểm xã hội</label>
            <input type="text" class="form-control "  value="{{$baohiem->mucDongBaoHiem->ten}}" disabled>
        </div>
        <div class="col-md-6">
            <label>Từ ngày</label>
            <input type="text" class="form-control datemask"  value="{{$baohiem->tu_ngay}}" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Tới ngày</label>
            <input type="text" class="form-control datemask "  value="{{$baohiem->toi_ngay}}" disabled>
        </div>
    </div>
@endcomponent