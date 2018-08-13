@component('components.modal-add', [
   'type' => 'target',
   'title' => __('model.target'),
   'width' => '35%',
   'route' => 'luong.target.add'
   ])
    <div class="row">
        <div class="col-sm-12">
        <label>Chọn cửa hàng<span style="color:red">*</span></label>
            @component('components.select2', [
                    'placeholder' => 'Chọn',
                    'data' => $cuahangs,
                    'text' => 'ten',
                    'id'=>'id',
                    'value' => 'id',
                    'name' => 'id_cua_hang',
                    'idSelected' => old('id_cua_hang'),
                ])
            @endcomponent
            <label>Chọn loại target<span style="color:red">*</span></label>
            @component('components.select2', [
                    'placeholder' => 'Chọn',
                    'data' => $loaitargets,
                    'text' => 'ten',
                    'id'=>'loai_target',
                    'value' => 'id',
                    'name' => 'id_loai_target',
                    'idSelected' => old('id_loai_target'),
                    
                ])
            @endcomponent

            <label for="name" class="control-label">Số tiền <span style="color:red">*</span></label>
            <input type="number" class="form-control" required name="so_tien" tabindex="3" value="{{old('so_tien')}}" >

            <label for="name" class="control-label">Tháng<span style="color:red">*</span></label>
            <input type="text" class="form-control monthmask" required name="tu_ngay" tabindex="3"  value="{{\Carbon\Carbon::now()->format('m/Y')}}" >

        </div>
    </div>
@endcomponent