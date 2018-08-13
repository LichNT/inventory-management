@component('components.modal-add', [
   'type' => 'loailamthemgio',
   'title' => __('model.loai_lam_them_gio'),
   'width' => '35%',
   'route' => 'luong.danhmuc.loailamthemgio.add',
   ])
    <div class="row">
        <div class="col-sm-12">
        
            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control"  name="ten" tabindex="2" required value="{{old('ten')}}">
            <label for="ten" class="control-label">Hệ số</label>
            <input type="text" class="form-control"  name="he_so" tabindex="3"  value="{{old('he_so')}}">
            <label for="ten" class="control-label">Mức lương/ngày</label>
            <input type="text" class="form-control"  name="muc_luong" tabindex="4"  value="{{old('muc_luong')}}">
            <label for="ten" class="control-label">Số giờ theo quy định</label>
            <input type="text" class="form-control" name="so_gio_theo_quy_dinh" tabindex="5"  value="{{old('so_gio_theo_quy_dinh')}}">
        </div>
    </div>
@endcomponent