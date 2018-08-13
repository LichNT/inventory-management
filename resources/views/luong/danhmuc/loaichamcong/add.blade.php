@component('components.modal-add', [
   'type' => 'loaichamcong',
   'title' => __('model.loai_cham_cong'),
   'width' => '35%',
   'route' => 'luong.danhmuc.loaichamcong.add',
   ])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Mã <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ma" tabindex="1" required value="{{old('ma')}}"  autofocus >
            <label class="control-label">Tên <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ten" tabindex="1" required value="{{old('ten')}}"  >
            <label class="control-label">Tỉ lệ hưởng lương <span style="color:red">*</span> </label>
            <input type="number" min=0  step="any" class="form-control" name="ty_le_huong_luong" required tabindex="2"  value="{{old('ti_le_huong_luong')}}">
            @component('components.checkbox', [
            'title' => 'Hưởng lương cơ bản',                              
            'value_checked' => 1,                  
            'value_unchecked' => 0,                  
            'value' => 1, 
            'name'=>'huong_luong_co_ban' 
            ])
            @endcomponent   
            <br/>     
            <label class="control-label">Mô tả</label>
            <textarea class="form-control" name="mo_ta" tabindex="4">{{old('mo_ta')}}</textarea>
        </div>
    </div>
@endcomponent