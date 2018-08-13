@component('components.confirm-delete',
[
    'route' => 'luong.chamcong.deletethamsophucap',
    'method' => 'delete',
    'data' => $phucap,
    'type' => 'delete-phucap',
    'title' => 'Xóa',
    'width' => '35%',
])
    <div class="row">
        <div class="col-sm-12">
            
            <label for="name" class="control-label">Số tiền(vnđ)</label>
            <input type="text" disabled class="form-control maskmoney" id="so_tien" name="so_tien" tabindex="1" required value="{{$phucap->so_tien}}" >
            <label class="control-label">Từ ngày</label>
            <input type="text" class="form-control datemask"disabled value="{{$phucap->tu_ngay}}">
        </div>
    </div>
@endcomponent