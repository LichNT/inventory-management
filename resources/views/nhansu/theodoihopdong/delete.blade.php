@component('components.confirm-delete',
[
    'route' => 'nhansu.update.theodoihopdong.delete',
    'method' => 'delete',
    'data' => $hopdong,
    'type' => 'delete-theodoihopdong',
    'title' => 'Xóa hợp đồng',
    'width' => '35%'
])

<div class="row">
        <div class="col-md-6">
            <label  >Loại hợp đồng</label>
            <input type="text" class="form-control " value="{{empty($hopdong->loaiHopDong)?null:$hopdong->loaiHopDong->ten}}" disabled>
        </div>
        <div class="col-md-6">
            <label  >Số quyết định</label>
            <input type="text" class="form-control " value="{{$hopdong->so_quyet_dinh}}" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label  >Ngày quyết định</label>
            <input type="text" class="form-control datemask" value="{{$hopdong->ngay_quyet_dinh}}"disabled >
        </div>
        <div class="col-md-6">
            <label  >Ngày hiệu lực</label>
            <input type="text" class="form-control datemask" value="{{$hopdong->ngay_hieu_luc}}"disabled >
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label >Ngày hết hiệu lực</label>
            <input type="text" class="form-control datemask" value="{{$hopdong->ngay_het_hieu_luc}}" disabled>
        </div>
        <div class="col-md-6">
            @component('components.group-checkbox', [
              'title' => 'Trạng thái',
              'title_active' => __('system.active'),
              'title_inactive' => __('system.inactive'),
              'name'=>'trang_thai',
              'value_active' => 1,
              'value_inactive' => 0,
              'value' => $hopdong->trang_thai,
              'disabled'=>'disabled'
          ])
            @endcomponent
        </div>
    </div>
@endcomponent