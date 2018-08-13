@component('components.modal-add', [
   'type' => 'doanhso',
   'title' => __('Doanh số cửa hàng'),
   'width' => '35%',
   'route' => 'cuahang.doanhso.add',
   'id'=>$cuahang->id
   ])
    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Tháng<span style="color:red">*</span></label>
            @component('components.select-month', [   
                'name' => 'thang',
                'value' => 'id',
                'id' => 'thang',
                'tabindex' => 1,
                'idSelected' =>old('thang'),
                ])
            @endcomponent
            <label for="ten" class="control-label">Năm<span style="color:red">*</span></label>
            <input type="number" class="form-control" name="nam" required tabindex="2"  value="{{old('nam')}}">
            <label for="ma" class="control-label">Ngày bắt đầu</label>
            <input type="text" class="form-control datemask"  name="ngay_bat_dau"  tabindex="2"  value="{{old('ngay_bat_dau')}}">
            <label for="ten" class="control-label">Ngày kết thúc</label>
            <input type="text" class="form-control datemask"  name="ngay_ket_thuc" tabindex="3"  value="{{old('ngay_ket_thuc')}}">
            <label for="ma" class="control-label">Mục tiêu doanh số</label>
            <input type="text" class="form-control" name="muc_tieu_doanh_so"  tabindex="4"  value="{{old('muc_tieu_doanh_so')}}">
            <label for="ten" class="control-label">Doanh số thực tế</label>
            <input type="text" class="form-control" name="doanh_so_thuc_te" tabindex="5"  value="{{old('doanh_so_thuc_te')}}">
        </div>
    </div>
@endcomponent