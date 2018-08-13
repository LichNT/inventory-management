@component('components.modal-add', [
    'type' => 'giamtrugiacanh',
    'title' => 'Thêm mới giảm trừ gia cảnh',
    'width' => '35%',
    'route' => 'nhansu.update.giamtrugiacanh.create',
    'id' => $nhansu->id,
    ])
    <div class="row">
        <div class="col-md-6">
            <label for="ho_ten_nguoi_phu_thuoc" class="control-label">Họ tên người phụ thuộc<span style="color:red">*</span></label>
            <input type="text" class="form-control"  required name="ho_ten" tabindex="1">
        </div>
        <div class="col-md-6">
            <label for="ngay_sinh" class="control-label datemask">Ngày sinh</label>
            <input type="text" class="form-control datemask"   name="ngay_sinh" tabindex="2">
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
                'value' => 1,
            ])
            @endcomponent
        </div>
        <div class="col-sm-6">
            <label for="cmtnd" class="control-label">CMTND</label>
            <input type="text" class="form-control  cmnnmask"   name="cmnd" tabindex="3">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  class="control-label">Mã số thuế</label>
            <input type="text" class="form-control"  name="ma_so_thue"  tabindex="4">
        </div>
        <div class="col-md-6">
            <label for="quan_he_gia_dinh" class="control-label">Quan hệ gia đình</label>
            <input type="text" class="form-control"  name="quan_he"  tabindex="5">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label for="thoi_diem_giam_tru" class="control-label ">Thời điểm giảm trừ</label>
            <input type="text" class="form-control datemask"   name="thoi_diem_bat_dau" tabindex="6">
        </div>
        <div class="col-md-6">
            <label for="thoi_diem_ket_thuc_giam" class="control-label">Thời điểm kết thúc giảm</label>
            <input type="text" class="form-control datemask"   name="thoi_diem_ket_thuc" tabindex="7">
        </div>
    </div>
    
    
@endcomponent