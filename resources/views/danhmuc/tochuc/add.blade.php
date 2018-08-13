
@component('components.modal-add', [ 
    'type' => 'tochuc', 
    'title' => __('model.to_chuc'),
    'width' => '35%',
    'route' => 'danhmuc.tochuc.add',    
    ])
    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" name="ma" autofocus tabindex="1" required>
            
            <label class="control-label">Tên <span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" tabindex="2" required>

            <label class="control-label">Số điện thoại</label>
            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" tabindex="3" >

            <label class="control-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" tabindex="4" >

            <label class="control-label">Người liên hệ</label>
            <input type="text" class="form-control" id="nguoi_lien_he" name="nguoi_lien_he" tabindex="5" >

            <label  class="control-label">Trực thuộc</label>
            @component('components.select', [
                'data' => $all_to_chuc, 
                'text' => 'ten', 
                'value' => 'id', 
                'id' => 'parent_id', 
                'name' => 'parent_id',
                'none_required'=>'true'
            ])
            @endcomponent
            <label class="control-label">Loại <span style="color:red">*</span></label>
            @component('components.select', [
                'title' => 'Loại',
                'data' => $loai_to_chucs,
                'text' => 'ten_hien_thi',
                'value' => 'id',
                'id' => 'loai_to_chuc_id',
                'name' => 'loai_to_chuc_id',                
            ])
            @endcomponent
                       
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'inactive',
                'name' => 'inactive',
                'title_active' => __('system.inactive2'),
                'title_inactive' => __('system.active2'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => 0,            
            ])
            @endcomponent
        </div>
    </div>     
@endcomponent
