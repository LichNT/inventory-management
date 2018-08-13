@component('components.confirm-delete',
[
    'route' => 'chitietbaolanh.delete',
    'method' => 'delete',
    'data' => $item,
    'type' => 'delete-chitietbaolanh',
    'title' => __('model.chitietbaolanh'),
    'width' => '35%',
])
    <div class="row">
        <div class="col-sm-12">
            @if($item->loai)
            <input type="text" class="form-control " disabled  value="Nộp tiền bảo lãnh">
           @else
           <input type="text"  class="form-control " disabled  value="Hoàn trả tiền bảo lãnh">
           @endif
            <label for="ma" class="control-label">Số tiền</label>
            <input type="text" class="form-control maskmoney" disabled  value="{{$item->so_tien}}">
            <label for="ma" class="control-label">Ngày tháng</label>
            <input type="text"  class="form-control datemask" disabled  value="{{$item->ngay_thang}}">
            <label for="ma" class="control-label">Loại</label>
           
        </div>
    </div>
@endcomponent