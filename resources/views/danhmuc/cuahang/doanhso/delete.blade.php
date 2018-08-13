@component('components.confirm-delete',
[
    'route' => 'cuahang.doanhso.delete',
    'method' => 'delete',
    'data' => $doanhso,
    'type' => 'delete-doanhso',
    'title' => 'Xóa doanh số'
])
<div class="row">
    <div class="col-sm-12">
        <label class="control-label">Tháng</label>
        <input class="form-control"   value="{{$doanhso->thang}}" disabled>
        <label  class="control-label">Năm</label>
        <input  class="form-control" name="nam" tabindex="2"  value="{{$doanhso->nam}}" disabled>
        <label  class="control-label">Ngày bắt đầu</label>
        <input  class="form-control datemask"  name="ngay_bat_dau"  tabindex="2"  value="{{$doanhso->ngay_bat_dau}}" disabled>
        <label  class="control-label">Ngày kết thúc</label>
        <input  class="form-control datemask"  name="ngay_ket_thuc" tabindex="3"  value="{{$doanhso->ngay_ket_thuc}}" disabled>
        <label  class="control-label">Mục tiêu doanh số</label>
        <input  type="text" class="form-control" name="muc_tieu_doanh_so"  tabindex="4"  value="{{$doanhso->muc_tieu_doanh_so}}" disabled>
        <label  class="control-label">Doanh số thực tế</label>
        <input  type="text" class="form-control" name="doanh_so_thuc_te" tabindex="5"  value="{{$doanhso->doanh_so_thuc_te}}" disabled>
    </div>
</div>
@endcomponent