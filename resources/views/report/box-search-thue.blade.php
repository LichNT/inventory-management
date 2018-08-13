@component('components.box-search',['routerName' => 'nhansu.thuethunhapcanhan', 'search' => (empty($search)?null:$search)])
    <div class="row">
        <div class="col-md-6">
            <label>{{$ten_hien_thi_mien}}</label>
            @component('components.select2', [
                    'placeholder' => 'Chọn',
                    'data' => $miens,
                    'text' => 'ten',
                    'id'=>'search_mien',
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
                    'id'=>'search_chi_nhanh',
                    'none_required'=>true,
                    'value' => 'id',
                    'name' => 'search_chi_nhanh',
                    'idSelected' => $search_chi_nhanh,
                    'required' => false,
                ])
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label>{{$ten_hien_thi_tinh}}</label>
            @component('components.select2', [
                'placeholder' => 'Chọn',
                'data' => $tinhs,
                'text' => 'ten',
                'id'=>'search_tinh',
                'none_required'=>true,
                'value' => 'id',
                'name' => 'search_tinh',
                'idSelected' => $search_tinh,
                'required' => false,
            ])
            @endcomponent
        </div>
       
    </div>
   
@endComponent