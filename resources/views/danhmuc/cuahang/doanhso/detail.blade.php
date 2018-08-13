@component('components.modal-update', [
   'type' => 'update-doanhso',
   'title' => __('Chỉnh sửa doanh số'),
   'buttonName' => __('button.update_lookup'),
   'width' => '35%',
   'route' => 'cuahang.doanhso.update',
   'data' => $doanhso,
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Tháng<span style="color:red">*</span></label>
            @component('components.select-month', [   
                'name' => 'thang',
                'value' => 'id',
                'id' => 'thang',
                'tabindex' => 1,
                'idSelected' =>$doanhso->thang,
                'none_required'=>true
                ])
            @endcomponent
            <label for="ten" class="control-label">Năm<span style="color:red">*</span></label>
            <input type="number" class="form-control" name="nam" tabindex="2"  value="{{$doanhso->nam}}">
            <label for="ma" class="control-label">Ngày bắt đầu</label>
            <input type="text" class="form-control datemask"  name="ngay_bat_dau"  tabindex="2"  value="{{$doanhso->ngay_bat_dau}}">
            <label for="ten" class="control-label">Ngày kết thúc</label>
            <input type="text" class="form-control datemask"  name="ngay_ket_thuc" tabindex="3"  value="{{$doanhso->ngay_ket_thuc}}">
            <label for="ma" class="control-label">Mục tiêu doanh số</label>
            <input type="text" class="form-control" name="muc_tieu_doanh_so"  tabindex="4"  value="{{$doanhso->muc_tieu_doanh_so}}">
            <label for="ten" class="control-label">Doanh số thực tế</label>
            <input type="text" class="form-control" name="doanh_so_thuc_te" tabindex="5"  value="{{$doanhso->doanh_so_thuc_te}}">
        </div>
    </div>
@endcomponent