@component('components.modal-update', [
   'type' => 'update-baohiem',
   'title' => 'Cập nhật bảo hiểm',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'nhansu.update.baohiem.edit',
   'data' => $baohiem,
   'method' => 'PUT'])

    <div class="row">
        <div class="col-md-6">
            <label>Tên bảo hiểm<span style="color:red">*</span></label>
            <input type="text" class="form-control" required name="ten" value="{{$baohiem->ten}}" tabindex="1">
        </div>
        <div class="col-md-6">
            <label  >Tham gia bảo hiểm tại Tỉnh/TP</label>
            @component('components.select2', [ 
                'data' => $tinhthanhs,
                'text' => 'ten', 
                'name' => 'id_tinh_thanh', 
                'value' =>'id',
                'none_required' => true, 
                'tabindex' => 2,
                'idSelected'=> $baohiem->id_tinh_thanh ])
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Tháng bắt đầu</label>
            <input type="text" class="form-control monthmask"  name="thang_bat_dau"  value="{{$baohiem->thang_bat_dau}}" tabindex="3">
        </div>
        <div class="col-md-6">
            <label>Tháng chuyển bảo hiểm về CN</label>
            <input type="text" class="form-control monthmask"  name="thang_chuyen_bao_hiem_ve_chi_nhanh"  value="{{$baohiem->thang_chuyen_bao_hiem_ve_chi_nhanh}}" tabindex="4">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Tháng dừng đóng bảo hiểm</label>
            <input type="text" class="form-control monthmask"  name="thang_dung_dong_bao_hiem"  value="{{$baohiem->thang_dung_dong_bao_hiem}}" tabindex="5">
        </div>
        <div class="col-md-6">
            <label  >Mức đóng bảo hiểm<span style="color:red">*</span></label>
            @component('components.select', ['data' => $mucdongbaohiems,
                'text' => 'ten', 
                'name' => 'muc_dong_bao_hiem_id', 
                'value' => 'id',
                'tabindex'=> 6,
                'idSelected'=>$baohiem->muc_dong_bao_hiem_id
                ])
            @endcomponent
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Từ ngày</label>
            <input type="text" class="form-control datemask"  name="tu_ngay"  value="{{$baohiem->tu_ngay}}" tabindex="7">
        </div>
        <div class="col-md-6">
            <label>Tới ngày</label>
            <input type="text" class="form-control datemask "  name="toi_ngay"  value="{{$baohiem->toi_ngay}}" tabindex="8">
        </div>
    </div>

@endcomponent