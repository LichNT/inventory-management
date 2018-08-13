@component('components.modal-update', [
   'type' => 'update-bacluong',
   'title' => 'Cập nhật',
   'buttonName' => 'Cập nhật',
   'width' => '35%',
   'route' => 'chucvu.bacluong.edit',
   'data' => $bacluong,
   'method' => 'PUT'])

        <div class="row">
            <div class="col-sm-12">
                <label for="name" class="control-label">Tên</label>
                <input type="text" class="form-control" id="ten" name="ten" tabindex="1" required value="{{$bacluong->ten}}" required autofocus>
                <label for="name" class="control-label">Hệ số lương cơ bản</label>
                <input type="number" step="any" class="form-control" id="he_so_luong" name="he_so_luong" tabindex="1" required value="{{$bacluong->he_so_luong}}" required autofocus>
                <label for="name" class="control-label">Mức lương cơ bản<span style="color:red">*</span></label>
                <input type="text" class="form-control" id="muc_luong_co_ban" name="muc_luong_co_ban" tabindex="1" required value="{{$bacluong->muc_luong_co_ban}}" required>
                <label for="ma" class="control-label">Mô tả</label>
                <textarea class="form-control" id="mo_ta" name="mo_ta" tabindex="2">{{$bacluong->mo_ta}}</textarea>
            </div>
        </div>
@endcomponent