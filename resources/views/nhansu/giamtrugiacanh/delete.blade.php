@component('components.confirm-delete',
[
    'route' => 'nhansu.update.giamtrugiacanh.delete',
    'method' => 'delete',
    'data' => $giamtrugiacanh,
    'type' => 'delete-giamtrugiacanh',
    'width' => '35%',
    'title' => 'Xóa giảm trừ gia cảnh'
])

  <div class="row">
        <div class="col-md-6">
            <label for="ho_ten_nguoi_phu_thuoc" class="control-label">Họ tên người phụ thuộc</label>
            <input type="text" class="form-control" disabled  value="{{$giamtrugiacanh->ho_ten}}" >
        </div>
        <div class="col-md-6">
            <label for="ngay_sinh" class="control-label datemask">Ngày sinh</label>
            <input type="text" class="form-control datemask" disabled   value="{{$giamtrugiacanh->ngay_sinh}}">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @component('components.group-checkbox', [
                'title' => 'Giới tính',
                'name' => 'gioi_tinh',
                'title_active' => 'Nam',
                'title_inactive' => 'Nữ',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' =>$giamtrugiacanh->gioi_tinh,
                'disabled'=>'disabled'
            ])
            @endcomponent
        </div>
        <div class="col-sm-6">
            <label for="cmtnd" class="control-label">CMTND</label>
            <input type="text" class="form-control  cmnnmask" value="{{$giamtrugiacanh->cmnd}}" disabled >
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  class="control-label">Mã số thuế</label>
            <input type="text" class="form-control"   value="{{$giamtrugiacanh->ma_so_thue}}"disabled>
        </div>
        <div class="col-md-6">
            <label for="quan_he_gia_dinh" class="control-label">Quan hệ gia đình</label>
            <input type="text" class="form-control"  value="{{$giamtrugiacanh->quan_he}}" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="thoi_diem_giam_tru" class="control-label ">Thời điểm giảm trừ</label>
            <input type="text" class="form-control datemask" value="{{$giamtrugiacanh->thoi_diem_bat_dau}}"disabled >
        </div>
        <div class="col-md-6">
            <label for="thoi_diem_ket_thuc_giam" class="control-label">Thời điểm kết thúc giảm</label>
            <input type="text" class="form-control datemask"  value="{{$giamtrugiacanh->thoi_diem_ket_thuc}}" disabled>
        </div>
    </div>
    
@endcomponent