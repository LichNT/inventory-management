@component('components.modal-update', [
   'type' => 'update-mucdongbaohiem',
   'title' => __('model.muc_dong_bao_hiem'),
   'width' => '35%',
   'route' => 'danhmuc.mucdongbaohiem.update',
   'data' => $mucdongbaohiem,
   'method' => 'POST'])
   <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ten" tabindex="1" required value="{{$mucdongbaohiem->ten}}" >
            
            <label for="name" class="control-label">Số tiền  <span style="color:red">*</span></label>
            <input type="text" class="form-control " name="so_tien" tabindex="2"  value="{{$mucdongbaohiem->so_tien}}" >

        </div>
    </div>
@endcomponent