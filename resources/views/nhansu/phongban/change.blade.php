@component('components.modal-add', [
    'type' => 'change',
    'title' => 'Thêm mới quá trình công tác',
    'width' => '35%',
    'route' => 'nhansu.update.phongban.create',
    'id' => $nhansu->id,
    ])
    <div class="row">
        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_mien}}</label>
            @component('components.select2', ['data' => $miens,'value'=>'id' ,'text' => 'ten', 'name' => 'id_mien_moi', 'none_required' => true, 'id'=>'mien_moi', 'tabindex' => 1])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_chi_nhanh}}</label>
            @component('components.select2', ['data' => $chinhanhs,'value'=>'id' ,'text' => 'ten', 'name' => 'id_chi_nhanh_moi', 'none_required' => true,'id'=>'chi_nhanh_moi', 'tabindex' => 1])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_tinh}}</label>
            @component('components.select2', ['data' => $tinhs,'value'=>'id' ,'text' => 'ten', 'name' => 'id_tinh_moi', 'none_required' => true, 'id'=>'tinh_moi','tabindex' => 1])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên cửa hàng</label>
            @component('components.select2', ['data' => $cuahangs,'value'=>'id' ,'text' => 'ma_ten', 'name' => 'id_cua_hang_moi', 'none_required' => true,'id'=>'cua_hang_moi', 'tabindex' => 2])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên phòng ban</label>
            @component('components.select2', ['data' => $phongbans,'value'=>'id' ,'text' => 'ten', 'name' => 'id_phong_ban_moi', 'none_required' => true,'id'=>'phong_ban_moi' ,'tabindex' => 1])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên bộ phận</label>
            @component('components.select2', ['data' => $bophans,'value'=>'id' ,'text' => 'ten', 'name' => 'id_bo_phan_moi', 'none_required' => true,'id'=>'bo_phan_moi', 'tabindex' => 1])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên chức vụ</label>
            @component('components.select2', ['data' => $chucvus,'value'=>'id' ,'text' => 'ten', 'name' => 'id_chuc_vu_moi', 'none_required' => true, 'tabindex' => 3])
            @endcomponent
        </div>
        
        
        <div class="col-md-6">
            <label for="ngay_hieu_luc" class="control-label ">Ngày hiệu lực</label>
            <input type="text" class="form-control datemask" id="ngay_hieu_luc" name="ngay_hieu_luc" tabindex="4">
        </div>
        <div class="col-sm-6">
            <label for="ngay_het_hieu_luc" class="control-label">Ngày hết hiệu lực</label>
            <input type="text" class="form-control datemask" id="ngay_het_hieu_luc" name="ngay_het_hieu_luc" tabindex="5">
        </div>
        <div class="col-md-6">
            <label for="ngay_quyet_dinh" class="control-label ">Ngày quyết định</label>
            <input type="text" class="form-control datemask" id="ngay_quyet_dinh" name="ngay_quyet_dinh" tabindex="6">
        </div>
        <div class="col-md-6">
            <label for="so_quyet_dinh" class="control-label">Số quyết định</label>
            <input type="text" class="form-control" id="so_quyet_dinh" name="so_quyet_dinh" tabindex="7">
        </div>
        <div class="col-md-6">
            <label for="so_quyet_dinh" class="control-label">Ngày nhận shop</label>
            <input type="text" class="form-control datemask"  name="ngay_nhan_shop" tabindex="8">
        </div>
    </div>

    <script src="{{ asset('js/changePhongBan.js') }}"></script>
@endcomponent