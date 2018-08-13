@component('components.confirm-delete',
[
    'route' => 'danhmuc.mucdongbaohiem.delete',
    'method' => 'delete',
    'data' => $mucdongbaohiem,
    'width' => '35%',
    'type' => 'delete-mucdongbaohiem',
    'title' => __('model.muc_dong_bao_hiem')
])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ten" tabindex="1" required value="{{$mucdongbaohiem->ten}}" disabled>
            
            <label for="name" class="control-label">Số tiền  <span style="color:red">*</span></label>
            <input type="text" class="form-control " name="so_tien" tabindex="2"  value="{{$mucdongbaohiem->so_tien}}" disabled >

        </div>
    </div>
@endcomponent