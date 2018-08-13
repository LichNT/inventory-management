@component('components.modal-add', [
   'type' => 'congno',
   'title' => __('model.congno'),
   'width' => '35%',
   'route' => 'luong.congno.add'
   ])
    <div class="row">
        <div class="col-md-6">
            <label>{{$ten_hien_thi_mien}}</label>
            @component('components.select2', [
                    'placeholder' => 'Chọn',
                    'data' => $miens,
                    'text' => 'ten',
                    'id'=>'mien_moi',
                    'none_required'=>true,
                    'value' => 'id',
                    'name' => 'search_mien',
                    'required' => false,
                ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label>{{$ten_hien_thi_chi_nhanh}}</label>
            @component('components.select2', [
                    'placeholder' => 'Chọn',
                    'data' => $chinhanhs,
                    'text' => 'ten',
                    'id'=>'chi_nhanh_moi',
                    'none_required'=>true,
                    'value' => 'id',
                    'name' => 'search_chi_nhanh',
                    'required' => false,
                ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label>{{$ten_hien_thi_tinh}}</label>
            @component('components.select2', [
                'placeholder' => 'Chọn',
                'data' => $tinhs,
                'text' => 'ten',
                'id'=>'tinh_moi',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_tinh',
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label>Cửa hàng</label>
            @component('components.select2', [
                'placeholder' => 'Chọn',
                'data' => $cuahangs,
                'text' => 'ma_ten',
                'id'=>'cua_hang_moi',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_cua_hang',
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-sm-12">
        <label>Chọn nhân sự<span style="color:red">*</span></label>
            @component('components.select2', [
                    'placeholder' => 'Chọn',
                    'data' => $nhansus,
                    'text' => 'ho_ten',
                    'id'=>'nhan_su',
                    'value' => 'id',
                    'name' => 'id_nhan_su',
                    'idSelected' => old('id_nhan_su'),
                ])
            @endcomponent

            <label for="name" class="control-label">Tháng năm<span style="color:red">*</span></label>
            <input type="text" class="form-control monthmask" required name="thang_nam" tabindex="3"  value="{{\Carbon\Carbon::now()->format('m/Y')}}" >

            <label for="name" class="control-label">Số tiền <span style="color:red">*</span></label>
            <input type="number" class="form-control" required name="so_tien" tabindex="3" value="{{number_format(old('so_tien'))}}" >

            <label for="name" class="control-label">Nội dung</label>
            <textarea  class="form-control" name="noi_dung" tabindex="3" >{{old('noi_dung')}}</textarea>

        </div>
    </div>
@endcomponent