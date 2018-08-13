@component('components.modal-add', [
    'type' => 'baohiem',
    'title' => 'Thêm mới bảo hiểm',
    'width' => '35%',
    'route' => 'nhansu.update.baohiem.create',
    'id' => $nhansu->id,
    ])

    <div class="row">
        <div class="col-md-6">
            <label  >Tên bảo hiểm<span style="color:red">*</span></label>
            <input type="text" class="form-control" required name="ten" tabindex="4">
        </div>
        <div class="col-md-6">
            <label  >Tham gia bảo hiểm tại Tỉnh/TP</label>
            @component('components.select2', [ 
                'data' => $tinhthanhs,
                'text' => 'ten', 
                'name' => 'id_tinh_thanh', 
                'value' =>'id',
                'none_required' => true, 
                'tabindex' => 5,
                'idSelected'=> old('id_tinh_thanh') ])
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  >Tháng bắt đầu</label>
            <input type="text" class="form-control monthmask"  name="thang_bat_dau" tabindex="6">
        </div>
        <div class="col-md-6">
            <label  >Tháng chuyển bảo hiểm về CN</label>
            <input type="text" class="form-control monthmask"  name="thang_chuyen_bao_hiem_ve_chi_nhanh" tabindex="7">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  >Tháng dừng đóng bảo hiểm</label>
            <input type="text" class="form-control monthmask"  name="thang_dung_dong_bao_hiem" tabindex="8">
        </div>
        <div class="col-md-6">
            <label  >Mức đóng bảo hiểm<span style="color:red">*</span></label>
            @component('components.select', ['data' => $mucdongbaohiems,
                'text' => 'ten', 
                'name' => 'muc_dong_bao_hiem_id', 
                'value' => 'id',
                'tabindex'=> 9,
                'idSelected'=>old('muc_dong_bao_hiem_id')
                ])
            @endcomponent
        </div>  
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  >Từ ngày</label>
            <input type="text" class="form-control datemask"  name="tu_ngay" tabindex="10">
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tới ngày</label>
            <input type="text" class="form-control datemask"  name="toi_ngay" tabindex="11">
        </div>
    </div>
@endcomponent