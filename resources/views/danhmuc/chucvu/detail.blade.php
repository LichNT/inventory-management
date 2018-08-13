@component('components.modal-update', [
   'type' => 'update-chucvu',
   'title' => __('model.chuc_vu'),
   'width' => '35%',
   'route' => 'danhmuc.chucvu.update',
   'data' => $chucvu,
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$chucvu->ma}}" autofocus tabindex="1" required>

            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$chucvu->ten}}" tabindex="2" required>

            <label for="ma" class="control-label">Số ngày nghỉ trong tháng</label>
            <input type="number" class="form-control" placeholder="Cửa hàng trưởng nghỉ 2 ngày " name="so_ngay_nghi_trong_thang"  tabindex="3"  value="{{$chucvu->so_ngay_nghi_trong_thang}}">
            <label for="ma" class="control-label">Số tiền học việc theo ngày</label>
            <input type="number" class="form-control" placeholder="" name="so_tien_hoc_viec_theo_ngay" tabindex="3"  value="{{$chucvu->so_tien_hoc_viec_theo_ngay}}">
            <label for="ma" class="control-label">Số giờ quy định</label>
            <input type="number" class="form-control" name="so_gio_quy_dinh"  tabindex="4"  value="{{$chucvu->so_gio_quy_dinh}}">
            <label for="ma" class="control-label">Số tiền bảo lãnh </label>
            <input type="text" class="form-control maskmoney"  name="so_tien_bao_lanh" tabindex="5"  value="{{$chucvu->so_tien_bao_lanh}}">
            <label for="ma" class="control-label">Số tháng phải nộp</label>
            <input type="number" min=1 class="form-control" name="so_thang"  tabindex="6"  value="{{$chucvu->so_thang}}">
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $chucvu->trang_thai,
            ])
            @endcomponent
        </div>
    </div>
@endcomponent