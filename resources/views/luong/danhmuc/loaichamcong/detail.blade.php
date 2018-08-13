@component('components.modal-update', [
   'type' => 'update-loaichamcong',
   'title' => __('model.loai_cham_cong'),
   'width' => '35%',
   'route' => 'luong.danhmuc.loaichamcong.edit',
   'data' => $loaichamcong,
   'method' => 'PUT'])

    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Mã <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ma" tabindex="1" required value="{{$loaichamcong->ma}}"  autofocus >
            <label class="control-label">Tên <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ten" tabindex="1" required value="{{$loaichamcong->ten}}"  >
            <label class="control-label">Tỉ lệ hưởng lương<span style="color:red">*</span> </label>
            <input type="number" min=0  class="form-control" step="any" name="ty_le_huong_luong" required tabindex="2"  value="{{$loaichamcong->ty_le_huong_luong}}">
            <br/>    
           @component('components.checkbox', [
            'title' => 'Hưởng lương cơ bản',                              
            'value_checked' => 1,                  
            'value_unchecked' => 0,                  
            'value' => $loaichamcong->huong_luong_co_ban, 
            'name'=>'huong_luong_co_ban' 
            ])
            @endcomponent
            <br/>            
            <label class="control-label">Mô tả</label>
            <textarea class="form-control" name="mo_ta" tabindex="4">{{$loaichamcong->mo_ta}}</textarea>
        </div>
    </div>
@endcomponent