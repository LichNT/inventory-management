@component('components.modal-add', [
   'type' => 'bacluong',
   'title' => __('model.bac_luong'),
   'width' => '35%',
   'route' => 'chucvu.bacluong.add',
   'id' => $id_chuc_vu,

   ])
    <div class="row">
        <div class="col-sm-12">
            <label for="name" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" tabindex="1" required value="{{old('ten')}}" required autofocus>
            <label for="name" class="control-label">Hệ số lương cơ bản<span style="color:red">*</span></label>
            <input type="number" step="any" class="form-control" id="he_so_luong" name="he_so_luong" tabindex="1" required value="{{old('he_so_luong')}}" required>
            <label for="ma" class="control-label">Mô tả</label>
            <textarea class="form-control" id="mo_ta" name="mo_ta" tabindex="2">{{old('mo_ta')}}</textarea>

        </div>
    </div>
@endcomponent