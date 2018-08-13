@component('components.confirm-delete',
[
    'route' => 'luong.danhmuc.loaiphucap.delete',
    'method' => 'delete',
    'data' => $loaiphucap,
    'type' => 'delete-loaiphucap',
    'title' => __('model.loai_phu_cap'),
    'width' => '35%'
])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Tên</label>
            <input type="text" class="form-control" name="ten" tabindex="1" required value="{{$loaiphucap->ten}}" required autofocus disabled>
            
            <label class="control-label">Mô tả</label>
            <textarea class="form-control" name="mo_ta" disabled tabindex="2">{{$loaiphucap->mo_ta}}</textarea>
        </div>
    </div>
@endcomponent