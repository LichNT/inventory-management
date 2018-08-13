@component('components.confirm-delete',
[
    'route' => 'nhansu.update.phongban.delete',
    'method' => 'delete',
    'data' => $phongban,
    'type' => 'delete-phongban',
    'title' => 'Xóa',
    'width' => '35%'
])

     <div class="row">
        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_mien}}</label>
            <input type="text" class="form-control "  value="{{$phongban->mien_moi->ten}}" disabled>
        </div>
        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_chi_nhanh}}</label>
            <input type="text" class="form-control "  value="{{$phongban->chi_nhanh_moi->ten}}" disabled>
        </div>
        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_tinh}}</label>
            <input type="text" class="form-control "  value="{{$phongban->tinh_moi->ten}}" disabled>
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên cửa hàng</label>
            <input type="text" class="form-control "  value="{{$phongban->cua_hang_moi->ten}}" disabled>
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên phòng ban</label>
            <input type="text" class="form-control "  value="{{$phongban->phong_ban_moi->ten}}" disabled>
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên bộ phận</label>
            <input type="text" class="form-control "  value="{{$phongban->bo_phan_moi->ten}}" disabled>
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên chức vụ</label>
            <input type="text" class="form-control "  value="{{$phongban->chuc_vu_moi->ten}}" disabled>
        </div>
        
        <div class="col-md-6">
            <label for="ngay_hieu_luc" class="control-label ">Ngày hiệu lực </label>
            <input type="text" class="form-control datemask"  value="{{$phongban->ngay_hieu_luc}}" disabled>
        </div>
        <div class="col-sm-6">
            <label for="ngay_het_hieu_luc" class="control-label">Ngày hết hiệu lực</label>
            <input type="text" class="form-control datemask" value="{{$phongban->ngay_het_hieu_luc}}" disabled>
        </div>
        <div class="col-md-6">
            <label for="ngay_quyet_dinh" class="control-label ">Ngày quyết định</label>
            <input type="text" class="form-control datemask" value="{{$phongban->ngay_quyet_dinh}}" disabled>
        </div>
        <div class="col-md-6">
            <label for="so_quyet_dinh" class="control-label">Số quyết định</label>
            <input type="text" class="form-control" value="{{$phongban->so_quyet_dinh}}" disabled>
        </div>
    </div>
@endcomponent