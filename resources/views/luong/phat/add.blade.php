@component('components.modal-add', [
   'type' => 'phat',
   'title' => __('model.phat'),
   'width' => '35%',
   'route' => 'luong.phat.add' 
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
        <div class="col-md-12">
            <label for="name" class="control-label">Mã nhân viên<span style="color:red">*</span></label>
            @component('components.select2', [
                          'data' => $nhansus,
                          'text' => 'ma_ten',
                          'value' => 'id',
                          'id' => 'nhan_su',
                          'name' => 'id_nhan_su',
                          'tabindex' => 1
                      ])
            @endcomponent
            <label for="name" class="control-label">Loại phạt<span style="color:red">*</span></label>
            @component('components.select', [
                          'data' => $loaiphats,
                          'text' => 'ten',
                          'value' => 'id',
                          'id' => 'id_loai_phat',
                          'name' => 'id_loai_phat',
                          'tabindex' => 2
                      ])
            @endcomponent
            <label for="name" class="control-label">Ngày  <span style="color:red">*</span></label>
            <input type="text" class="form-control datemask" id="ngay" name="ngay" tabindex="3" required value="{{old('ngay')}}" >

        </div>
    </div>
@endcomponent