@component('components.confirm-delete',
[
    'route' => 'luong.chamcong.deletethamsobacluong',
    'method' => 'delete',
    'data' => $bacluong,
    'type' => 'delete-bacluong',
    'title' => 'Xóa',
    'width' => '35%',
  
])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" tabindex="1" required value="{{$bacluong->ten}}" required autofocus disabled>
            <label for="name" class="control-label">Hệ số lương</label>
            <input type="text" class="form-control" id="he_so_luong" name="he_so_luong" tabindex="1" disabled value="{{$bacluong->he_so_luong}}" required autofocus>
        </div>
    </div>
@endcomponent