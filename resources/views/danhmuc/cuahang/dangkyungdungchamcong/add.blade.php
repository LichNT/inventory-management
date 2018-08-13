@component('components.modal-add', [
   'type' => 'dangkyungdungchamcong',
   'title' => __('model.dang_ky_cham_cong_dien_thoai'),
   'width' => '30%',
   'route' => 'dangkyungdungchamcong.add',
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
                    'idSelected' => $search_mien,
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
                    'idSelected' => $search_chi_nhanh,
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
                'idSelected' => $search_tinh,
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
                'idSelected' => $search_cua_hang,
                'required' => false,
            ])
            @endcomponent
        </div>
        <div class="col-md-12">
            <label  class="control-label">Tên Nhân sự</label>
            @component('components.select2', ['data' => $nhansus,'value'=>'id' ,
            'text' => 'ma_ten', 'name' => 'id_nhan_su',
              'tabindex' => 1,
            'id'=>'nhan_su'
              ])
            @endcomponent
        </div>        
    </div>
@endcomponent