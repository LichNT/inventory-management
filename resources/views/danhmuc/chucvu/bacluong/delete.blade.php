@component('components.confirm-delete',
[
    'route' => 'chucvu.bacluong.delete',
    'method' => 'delete',
    'data' => $bacluong,
    'type' => 'delete-bacluong',
    'title' => 'Xóa',
    'width' => '35%'
])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" tabindex="1" required value="{{$bacluong->ten}}" required autofocus disabled>
            <label for="name" class="control-label">Hệ số lương</label>
            <input type="text" class="form-control" id="he_so_luong" name="he_so_luong" tabindex="1" disabled value="{{$bacluong->he_so_luong}}" required autofocus>
            <label for="ma" class="control-label">Mô tả</label>
            <textarea class="form-control" id="mo_ta" name="mo_ta" disabled tabindex="2">{{$bacluong->mo_ta}}</textarea>
        </div>
    </div>
@endcomponent