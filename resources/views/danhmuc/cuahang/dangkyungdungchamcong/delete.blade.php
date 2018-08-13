@component('components.confirm-delete',
[
    'route' => 'dangkyungdungchamcong.delete',
    'method' => 'delete',
    'data' => $dangkyungdungchamcong,
    'type' => 'delete-dangkyungdungchamcong',
    'title' => __('model.dang_ky_cham_cong_dien_thoai'),
    'width' => '35%',
])
<div class="row">
    <div class="col-md-6">
        <label for="ten" class="control-label">Họ tên</label>
        <input type="text" class="form-control" name="ho_ten" disabled  value="{{$dangkyungdungchamcong->ho_ten}}">
        <label for="ten" class="control-label " >Ngày sinh</label>
        <input type="text" class="form-control datemask" name="ngay_sinh" disabled value="{{$dangkyungdungchamcong->ngay_sinh}}">
        <label for="ten" class="control-label">CMND</label>
        <input type="text" class="form-control" name="cmnd" disabled  value="{{$dangkyungdungchamcong->cmnd}}">        
    </div>
    <div class="col-md-6">       
        <label for="ten" class="control-label">Mã</label>
        <input type="text" class="form-control" name="ma"  disabled value="{{$dangkyungdungchamcong->ma}}">
        <label for="ten" class="control-label">Số điện thoại</label>
        <input type="text" class="form-control" name="so_dien_thoai"  disabled value="{{$dangkyungdungchamcong->so_dien_thoai}}">
        <label for="ten" class="control-label">Email</label>
        <input type="text" class="form-control" name="email" disabled  value="{{$dangkyungdungchamcong->email}}">
    </div>
</div>
@endcomponent