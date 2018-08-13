@component('components.confirm-delete',
[
    'route' => 'danhmuc.thuethunhap.delete',
    'method' => 'delete',
    'data' => $thuethunhap,
    'type' => 'delete-thuethunhap',
   'width' => '35%',
    'title' => __('model.thue_thu_nhap')
])
<div class="row">
        <div class="col-sm-12">
            <label for="ten" class="control-label">Tên</label>
            <input type="text" class="form-control"  value="{{$thuethunhap->ten}}" disabled>
            <label for="ten" class="control-label">Cận trên</label>
            <input type="number" class="form-control"  value="{{$thuethunhap->can_tren}}" disabled>
            <label for="ten" class="control-label">Hệ số (%)</label>
            <input type="number" class="form-control"   value="{{$thuethunhap->thue_suat}}" disabled>
        </div>
    </div>
@endcomponent