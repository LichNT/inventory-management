@component('components.modal-update', [
   'type' => 'update-theodoihopdong',
   'title' => 'Cập nhật hợp đồng',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'nhansu.update.theodoihopdong.edit',
   'data' => $hopdong,
   'method' => 'PUT'])

    <div class="row">
        <div class="col-md-6">
            <label  >Loại hợp đồng</label>
            @component('components.select', ['data' => $loaihopdongs,'value'=>'id' ,
            'text' => 'ten', 
            'name' => 'loai_hop_dong',
            'idSelected'=>$hopdong->loai_hop_dong,
            'none_required'=>true
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  >Số hợp đồng</label>
            <input type="text" class="form-control " value="{{$hopdong->so_quyet_dinh}}"  name="so_quyet_dinh" tabindex="1">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  >Ngày quyết định</label>
            <input type="text" class="form-control datemask" value="{{$hopdong->ngay_quyet_dinh}}" name="ngay_quyet_dinh" tabindex="6">
        </div>
        <div class="col-md-6">
            <label  >Ngày hiệu lực<span style="color:red">*</span></label>
            <input type="text" class="form-control datemask" value="{{$hopdong->ngay_hieu_luc}}" required name="ngay_hieu_luc" tabindex="7">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label >Ngày hết hiệu lực</label>
            <input type="text" class="form-control datemask" value="{{$hopdong->ngay_het_hieu_luc}}" name="ngay_het_hieu_luc" tabindex="8">
        </div>
        <div class="col-md-6">
        <label >Chọn chức vụ</label>
        
        @component('components.select', [
            'data' => $chitietcongtacs,
            'text' => 'ten',
            'name' => 'id_chuc_vu',
            'value' => 'id',
            'tabindex' => 2,
            'none_required'=>'true',
            'idSelected' => $hopdong->id_chuc_vu
            ])
        @endcomponent
        </div>
        </div>
        <div class="row">
        <div class="col-md-6">
            @component('components.group-checkbox', [
              'title' => 'Trạng thái',
              'id' => 'trang_thai',
              'name' => 'trang_thai',
              'title_active' => __('system.active'),
              'title_inactive' => __('system.inactive'),
              'value_active' => 1,
              'value_inactive' => 0,
              'value' => $hopdong->trang_thai,
          ])
            @endcomponent
        </div>
    </div>
@endcomponent