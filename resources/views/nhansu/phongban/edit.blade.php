@component('components.modal-update', [
   'type' => 'update-phong_ban_hien_tai',
   'width' => '35%',
   'route' => 'nhansu.update.phong_ban_hien_tai.edit',
   'data' => $phong_ban_hien_tai,
   'method' => 'PUT'])
    <div class="row">
        <div class="col-md-6">
            <label  class="control-label">Tên phòng ban hiện tại</label>
            @component('components.select', ['data' => $phongbans,
            'idSelected'=>empty($phong_ban_hien_tai->id_phong_ban_moi)? '':$phong_ban_hien_tai->id_phong_ban_moi,
            'value'=>'id' ,
            'text' => 'ten',
            'name' => 'id_phong_ban_moi'])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên phòng ban cũ</label>
            @component('components.select', ['data' => $phongbans,'idSelected'=>empty($phong_ban_hien_tai->id_phong_ban_cu)? '':$phong_ban_hien_tai->id_phong_ban_cu,'value'=>'id','text' => 'ten', 'name' => 'id_phong_ban_cu'])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên cửa hàng hiện tại</label>
            @component('components.select', ['data' => $cuahangs,'value'=>'id' ,'text' => 'ten', 'name' => 'id_cua_hang_moi','idSelected'=>empty($phong_ban_hien_tai->id_cua_hang_moi)? '':$phong_ban_hien_tai->id_cua_hang_moi,])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên cửa hàng cũ</label>
            @component('components.select', ['data' => $cuahangs,'value'=>'id' ,'text' => 'ten', 'name' => 'id_cua_hang_cu','idSelected'=>empty($phong_ban_hien_tai->id_cua_hang_cu)? '':$phong_ban_hien_tai->id_cua_hang_cu,])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên chức vụ hiện tại</label>
            @component('components.select', ['data' => $chucvus,'value'=>'id' ,'text' => 'ten', 'name' => 'id_chuc_vu_moi','idSelected'=>empty($phong_ban_hien_tai->id_chuc_vu_moi)? '':$phong_ban_hien_tai->id_chuc_vu_moi,])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên chức vụ cũ</label>
            @component('components.select', ['data' => $chucvus,'value'=>'id' ,'text' => 'ten', 'name' => 'id_chuc_vu_cu','idSelected'=>empty($phong_ban_hien_tai->id_chuc_vu_cu)? '':$phong_ban_hien_tai->id_chuc_vu_cu,])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label for="ngay_hieu_luc" class="control-label datemask">Ngày hiệu lực</label>
            <input type="text" class="form-control datemask" id="ngay_hieu_luc" value="@component('components.format',['date'=>$phong_ban_hien_tai->ngay_hieu_luc]) @endcomponent" required name="ngay_hieu_luc" tabindex="3">
        </div>
        <div class="col-sm-6">
            <label for="ngay_het_hieu_luc" class="control-label">Ngày hết hiệu lực</label>
            <input type="text" class="form-control  datemask" id="ngay_het_hieu_luc" value="@component('components.format',['date'=>$phong_ban_hien_tai->ngay_het_hieu_luc]) @endcomponent"  name="ngay_het_hieu_luc" tabindex="4">
        </div>
        <div class="col-md-6">
            <label for="ngay_quyet_dinh" class="control-label ">Ngày quyết định</label>
            <input type="text" class="form-control datemask" value="@component('components.format',['date'=>$phong_ban_hien_tai->ngay_quyet_dinh]) @endcomponent" id="ngay_quyet_dinh" required name="ngay_quyet_dinh" tabindex="5">
        </div>
        <div class="col-md-6">
            <label for="so_quyet_dinh" class="control-label">Số quyết định</label>
            <input type="text" class="form-control" id="so_quyet_dinh" value="{{$phong_ban_hien_tai->so_quyet_dinh}}" required name="so_quyet_dinh" tabindex="6">
        </div>
    </div>

@endcomponent