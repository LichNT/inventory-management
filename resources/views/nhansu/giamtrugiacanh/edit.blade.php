@component('components.modal-update', [
   'type' => 'update-giamtrugiacanh',
   'title' => 'Cập nhật giảm trừ gia cảnh',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'nhansu.update.giamtrugiacanh.edit',
   'data' => $giamtrugiacanh,
   'method' => 'PUT'])

     <div class="row">
        <div class="col-md-6">
            <label for="ho_ten_nguoi_phu_thuoc" class="control-label">Họ tên người phụ thuộc<span style="color:red">*</span></label>
            <input type="text" class="form-control"  required name="ho_ten" value="{{$giamtrugiacanh->ho_ten}}" tabindex="1">
        </div>
        <div class="col-md-6">
            <label for="ngay_sinh" class="control-label datemask">Ngày sinh</label>
            <input type="text" class="form-control datemask"   name="ngay_sinh" value="{{$giamtrugiacanh->ngay_sinh}}" tabindex="2">
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
            ])
            @endcomponent
        </div>
        <div class="col-sm-6">
            <label for="cmtnd" class="control-label">CMTND</label>
            <input type="text" class="form-control  cmnnmask" value="{{$giamtrugiacanh->cmnd}}"  name="cmnd" tabindex="3">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  class="control-label">Mã số thuế</label>
            <input type="text" class="form-control"  name="ma_so_thue" value="{{$giamtrugiacanh->ma_so_thue}}" tabindex="4">
        </div>
        <div class="col-md-6">
            <label for="quan_he_gia_dinh" class="control-label">Quan hệ gia đình</label>
            <input type="text" class="form-control"  name="quan_he" value="{{$giamtrugiacanh->quan_he}}" tabindex="6">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="thoi_diem_giam_tru" class="control-label ">Thời điểm giảm trừ</label>
            <input type="text" class="form-control datemask" value="{{$giamtrugiacanh->thoi_diem_bat_dau}}"  name="thoi_diem_bat_dau" tabindex="4">
        </div>
        <div class="col-md-6">
            <label for="thoi_diem_ket_thuc_giam" class="control-label">Thời điểm kết thúc giảm</label>
            <input type="text" class="form-control datemask"  value="{{$giamtrugiacanh->thoi_diem_ket_thuc}}" name="thoi_diem_ket_thuc" tabindex="5">
        </div>
    </div>
    
@endcomponent