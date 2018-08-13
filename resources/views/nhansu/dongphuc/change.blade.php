@component('components.modal-add', [
    'type' => 'change',
    'title' => 'Thêm mới thay đổi đồng phục',
    'width' => '35%',
    'route' => 'nhansu.update.dongphuc.create',
    'id' => $nhansu->id,
    ])
    <div class="row">
        <div class="col-md-6">
            <label  class="control-label">Size<span style="color:red">*</span></label>
            @component('components.select', ['data' => $sizes,
            'value'=>'id' ,
            'text' => 'ten',
            'name' => 'id_size'])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Số lượng<span style="color:red">*</span></label>
            <input type="number" min="0" class="form-control " required name="so_luong" tabindex="4">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  class="control-label">Trạng thái<span style="color:red">*</span></label>
            @component('components.select', ['data' => $trangthaidongphucs,
            'value'=>'id' ,
            'text' => 'ten',
            'name' => 'trang_thai'])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label ">Ngày</label>
            <input type="text" class="form-control datemask"  name="ngay" tabindex="4">
        </div>
    </div>
    
@endcomponent