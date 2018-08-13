@component('components.confirm-delete',
[
    'route' => 'nhansu.update.dongphuc.delete',
    'method' => 'delete',
    'data' => $dongphuc,
    'type' => 'delete-dongphuc',
    'title' => 'Xóa đồng phục',
    'width' => '35%'
])


    <div class="row">
        <div class="col-md-6">
            <label>Size</label>
            <input type="text" class="form-control "  value="{{$dongphuc->size->ten}}" disabled>
        </div>
        <div class="col-md-6">
            <label>Số lượng</label>
            <input type="text" class="form-control "  value="{{$dongphuc->so_luong}}" disabled>
        </div>
    </div>
    <div class="row">
    @if($dongphuc->huy_dang_ky)
        <div class="col-md-6">
            <label  class="control-label">Trạng thái</label>
            <input type="text" class="form-control " value="Hủy đăng ký"  disabled>
        </div>
        <div class="col-md-6">
            <label  class="control-label ">Ngày</label>
            <input type="text" class="form-control datemask" value="{{$dongphuc->ngay_bao_huy}}"    disabled>
        </div>
    </div>
    @elseif($dongphuc->da_phat)
    <div class="col-md-6">
            <label  class="control-label">Trạng thái</label>
            <input type="text" class="form-control " value="Đã phát"  disabled>
        </div>
        <div class="col-md-6">
            <label  class="control-label ">Ngày</label>
            <input type="text" class="form-control datemask" value="{{$dongphuc->ngay_phat}}"  disabled>
        </div>
    </div>
    @elseif($dongphuc->hoan_tra)
    <div class="col-md-6">
            <label  class="control-label">Trạng thái</label>
            <input type="text" class="form-control " value="Hoàn trả"  disabled>
        </div>
        <div class="col-md-6">
            <label  class="control-label ">Ngày</label>
            <input type="text" class="form-control datemask" value="{{$dongphuc->ngay_hoan}}"   disabled>
        </div>
    </div>
    @elseif($dongphuc->hong)
    <div class="col-md-6">
            <label  class="control-label">Trạng thái</label>
            <input type="text" class="form-control " value="Hỏng"  disabled>
        </div>
        <div class="col-md-6">
            <label  class="control-label ">Ngày</label>
            <input type="text" class="form-control datemask" value="{{$dongphuc->ngay_bao_hong}}"  disabled>
        </div>
    </div>
    @else
    <div class="col-md-6">
            <label  class="control-label">Trạng thái</label>
            <input type="text" class="form-control " value=""  disabled>
        </div>
        <div class="col-md-6">
            <label  class="control-label ">Ngày</label>
            <input type="text" class="form-control datemask"  disabled  >
        </div>
    </div>
    @endif
@endcomponent