@component('components.confirm-delete',
[
    'route' => 'nhansu.update.hosonhansu.delete',
    'method' => 'delete',
    'data' => $hosonhansu,
    'type' => 'delete-hosonhansu',
    'title' => 'Xóa file ',
    'width' => '35%'
])

<div class="row">
    <div class="col-md-6">
        <label>Tên file</label>
        <input type="text" class="form-control"  value="{{$hosonhansu->file_name}}"disabled >
    </div>
    <div class="col-md-6">
        <label>Loại file</label>
        <input type="text" class="form-control " value="{{empty($hosonhansu->loaiHoSo)?'---':$hosonhansu->loaiHoSo->ten}}" disabled>
    </div>
</div>
    
@endcomponent