@component('components.modal-add', [
    'type' => 'theodoihopdong',
    'title' => 'Thêm mới hợp đồng',
    'width' => '35%',
    'route' => 'nhansu.update.theodoihopdong.create',
    'id' => $nhansu->id,
    ])

    <div class="row">
        <div class="col-md-6">
            <label  >Loại hợp đồng</label>
            @component('components.select', ['data' => $loaihopdongs,'value'=>'id' ,'text' => 'ten', 'name' => 'loai_hop_dong','none_required'=>true])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  >Số hợp đồng</label>
            <input type="text" class="form-control "  name="so_quyet_dinh" tabindex="1">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  >Ngày quyết định</label>
            <input type="text" class="form-control datemask"  name="ngay_quyet_dinh" tabindex="6">
        </div>
        <div class="col-md-6">
            <label  >Ngày hiệu lực<span style="color:red">*</span></label>
            <input type="text" class="form-control datemask" required name="ngay_hieu_luc" tabindex="7">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label >Ngày hết hiệu lực</label>
            <input type="text" class="form-control datemask"  name="ngay_het_hieu_luc" tabindex="8">
        </div>
        <div class="col-md-6">
        <label >Chọn chức vụ</label>
        
        @component('components.select', [
            'data' => $chitietcongtacs,
            'text' => 'ten',
            'name' => 'id_chuc_vu',
            'value' => 'id',
            'tabindex' => 2,
            'idSelected' => old('id_chuc_vu'),
            'none_required'=>'true'
            ])
        @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  >Trạng thái</label>
            @component('components.group-checkbox', [
              'title' => 'Trạng thái',
              'id' => 'trang_thai',
              'name' => 'trang_thai',
              'title_active' => __('system.active'),
              'title_inactive' => __('system.inactive'),
              'value_active' => 1,
              'value_inactive' => 0,
              'value' => 1,
          ])
            @endcomponent
        </div>
    </div>
@endcomponent