@component('components.modal-update', [ 
    'type' => 'update-phongban',
    'title' => __('model.phong_ban'),
    'width' => '35%',
    'route' => 'danhmuc.phongban.update',
    'data' => $phongban,
    'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" name="ma" value="{{$phongban->ma}}" autofocus tabindex="1" required>
            
            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{$phongban->ten}}" tabindex="2" required>

            <label for="ten" class="control-label">Số điện thoại</label>
            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" value="{{$phongban->so_dien_thoai}}" tabindex="3">

            <label for="ten" class="control-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="{{$phongban->email}}" tabindex="4">

            <label for="ten" class="control-label">Người liên hệ</label>
            <input type="text" class="form-control" id="nguoi_lien_he" name="nguoi_lien_he" value="{{$phongban->nguoi_lien_he}}" tabindex="5">

            <label for="loai" class="control-label">Trực thuộc</label>
            @component('components.select', [
                'data' => $phongban_parents, 
                'text' => 'ten', 
                'value' => 'id', 
                'id' => 'parent_id', 
                'name' => 'parent_id',
                'none_required'=>'true',
                'idSelected'=>$phongban->parent_id
            ])
            @endcomponent
            <label for="loai" class="control-label">Loại </label>

            @component('components.select', [
            'title' => 'Loại',
            'data' => $loai_phong_bans,
            'text' => 'ten',
            'value' => 'id',
            'id' => 'loai',
            'name' => 'loai_phong_ban_id',
            'none_required'=>'true',
            'idSelected'=>$phongban->loai_phong_ban_id
            ])
            @endcomponent
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active2'),
                'title_inactive' => __('system.inactive2'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => $phongban->trang_thai,            
            ])
            @endcomponent 
        </div>        
    </div>     
@endcomponent