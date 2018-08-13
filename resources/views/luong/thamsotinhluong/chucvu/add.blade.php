@component('components.modal-add', [
   'type' => 'chucvu',
   'title' => __('model.chuc_vu'),
   'width' => '35%',
   'route' => 'luong.chamcong.addthamsochucvu',
   ])
    <div class="row">
        <div class="col-sm-12">
            <label  >Chức vụ</label>
            @component('components.select2', [
                'data' => $chucvus,
                'text' => 'ten',
                'name' => 'ma',
                'value' =>'ma',
                'none_required' => true,
                'tabindex' => 5,
                'idSelected'=> old('ma') ])
            @endcomponent
            <label class="control-label">Số ngày nghỉ trong tháng</label>
            <input type="number" class="form-control" placeholder="Cửa hàng trưởng nghỉ 2 ngày " name="so_ngay_nghi_trong_thang" tabindex="3"  value="{{old('so_ngay_nghi_trong_thang')}}">
            <label for="ma" class="control-label">Số tiền học việc theo ngày</label>
            <input type="text" class="form-control maskmoney" placeholder="" name="so_tien_hoc_viec_theo_ngay" tabindex="3"  value="{{old('﻿so_tien_hoc_viec_theo_ngay')}}">
            <label class="control-label">Số giờ quy định</label>
            <input type="number" class="form-control" name="so_gio_quy_dinh"  tabindex="4"  value="{{old('so_gio_quy_dinh')}}">
            <label for="ma" class="control-label">Số tiền bảo lãnh phải nộp/tháng </label>
            <input type="text" class="form-control maskmoney"  name="so_tien_bao_lanh" tabindex="5"  value="{{old('so_tien_bao_lanh')}}">
            <label for="ma" class="control-label">Số tháng phải nộp tiền bảo lãnh</label>
            <input type="number" min=1 class="form-control" name="so_thang"  tabindex="6"  value="{{old('so_thang')}}">
            <label class="control-label">Từ ngày <span style="color:red">*</span></label>
            <input type="text" class="form-control datemask" required name="tu_ngay"  tabindex="5"  value="{{old('tu_ngay')}}">           
        </div>

    </div>
@endcomponent