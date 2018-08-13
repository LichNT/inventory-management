@component('components.modal-add', [
   'type' => 'chucvu',
   'title' => __('model.chuc_vu'),
   'width' => '35%',
   'route' => 'danhmuc.chucvu.add',
   ])
    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" name="ma" autofocus tabindex="1" required value="{{old('ma')}}">
            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" tabindex="2" required value="{{old('ten')}}">
            
        </div>
    </div>
@endcomponent