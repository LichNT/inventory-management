@component('components.modal-update', [
   'type' => 'update-chitiet',
   'title' => 'chi tiết chấm công',   
   'width' => '50%',
   'route' => 'dangkyungdungchamcong.chitiet.update',
   'data' => $chitiet,
   'method' => 'POST'])
    <div class="row">
        <div class="col-sm-6">
            <label class="control-label">Ảnh bắt đầu ca</label>
            <img src="{{empty($chitiet->duong_dan_anh_check_in)?'/images/defaults/chamcong.png':$chitiet->duong_dan_anh_check_in}}" alt="Ảnh Check In" style="margin-left: auto; margin-right: auto; width: 100%">
        </div>
        <div class="col-sm-6">
            <label class="control-label">Ảnh kết thúc ca</label>
            <img src="{{empty($chitiet->duong_dan_anh_check_out)? '/images/defaults/chamcong.png': $chitiet->duong_dan_anh_check_out}}" alt="Ảnh Check Out" style="margin-left: auto; margin-right: auto; width: 100%">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="control-label">Vị trí bắt đầu ca (so với cửa hàng)</label>
            <input style="{{($chitiet->khoang_cach_check_in > 100)?"color:red":null}}" type="text" class="form-control" disabled tabindex="3"  value="{{$chitiet->khoang_cach_check_in}}">
        </div>
        <div class="col-sm-6">
            <label class="control-label">Vị trí kết thúc ca (so với cửa hàng)</label>
            <input style="{{($chitiet->khoang_cach_check_out > 100)?"color:red":null}}" type="text" class="form-control" disabled tabindex="4"  value="{{$chitiet->khoang_cach_check_out}}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="control-label">Thời gian bắt đầu</label>
            <input type="text" class="form-control" disabled value="{{$chitiet->thoi_gian_check_in}}">           
        </div>
        <div class="col-sm-6">
            <label class="control-label">Thời gian kết thúc</label>  
            <input type="text" class="form-control" disabled value="{{$chitiet->thoi_gian_check_out}}">              
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="control-label">Số giờ làm việc</label>
            <input type="text" class="form-control" disabled value="{{$chitiet->so_gio_lam}}">           
        </div>
        <div class="col-sm-6">
            @component('components.group-checkbox', [
                    'title' => 'Hợp lệ',
                    'id' => 'active',
                    'name' => 'active',
                    'title_active' => 'Hợp lệ',
                    'title_inactive' => 'Không hợp lệ',
                    'value_active' => 6,
                    'value_inactive' => 0,
                    'value' => $chitiet->hop_le,
                ])
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Ghi chú</label>
            <input type="text" class="form-control" name="ghi_chu" tabindex="5"  value="{{$chitiet->ghi_chu}}">
        </div>        
    </div>
@endcomponent