@component('components.modal-update', [
   'type' => 'update-lamthemgio',
   'title' => __('model.loai_lam_them_gio'),   
   'width' => '35%',
   'route' => 'luong.danhmuc.loailamthemgio.update',
   'data' => $lamthemgio,
   'method' => 'POST'])

    <div class="row">
    <div class="col-sm-12">
            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control"  name="ten" tabindex="2" required value="{{$lamthemgio->ten}}">
            <label for="ten" class="control-label">Hệ số</label>
            <input type="text" class="form-control"  name="he_so" tabindex="3"  value="{{$lamthemgio->he_so}}">
            <label for="ten" class="control-label">Mức lương/ngày</label>
            <input type="text" class="form-control"  name="muc_luong" tabindex="4"  value="{{$lamthemgio->muc_luong}}">
            <label for="ten" class="control-label">Số giờ theo quy định</label>
            <input type="text" class="form-control" name="so_gio_theo_quy_dinh" tabindex="5"  value="{{$lamthemgio->so_gio_theo_quy_dinh}}">
        </div>
    </div>
@endcomponent