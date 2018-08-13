@component('components.modal-update', [
   'type' => 'update-dongphuc',
   'width' => '35%',
   'route' => 'nhansu.update.dongphuc.edit',
   'title' => 'Cập nhật trạng thái đồng phục',
   'data' => $dongphuc,
   'method' => 'PUT'])
    <div class="row">
        <div class="col-md-6">
            <label  class="control-label">Trạng thái<span style="color:red">*</span></label>
            @component('components.select', ['data' => $trangthaidongphucs,
            'idSelected'=>$dongphuc->id_trang_thai_dong_phuc,
            'value'=>'id' ,
            'text' => 'ten',
            'name' => 'trang_thai'])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label ">Ngày</label>
            <input type="text" class="form-control datemask" value="{{$dongphuc->ngay_cap_nhat}}"   name="ngay" tabindex="4">
        </div>
    </div>

    
@endcomponent