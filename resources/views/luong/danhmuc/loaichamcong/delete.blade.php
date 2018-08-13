@component('components.confirm-delete',
[
    'route' => 'luong.danhmuc.loaichamcong.delete',
    'method' => 'delete',
    'data' => $loaichamcong,
    'type' => 'delete-loaichamcong',
    'title' => __('model.loai_cham_cong'),
    'width' => '35%'
])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Mã <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ma" tabindex="1" disabled value="{{$loaichamcong->ma}}"  autofocus >
            <label class="control-label">Tên <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ten" tabindex="1" required value="{{$loaichamcong->ten}}"  disabled >
            <label class="control-label">Tỉ lệ hưởng lương<span style="color:red">*</span> </label>
            <input type="number" min=0 class="form-control" name="ty_le_huong_luong" required tabindex="2"  value="{{$loaichamcong->ty_le_huong_luong}}" disabled>
            @component('components.checkbox', [
            'title' => 'Hưởng lương cơ bản',                              
            'value_checked' => 1,                  
            'value_unchecked' => 0,                  
            'value' => $loaichamcong->huong_luong_co_ban, 
            'name'=>'huong_luong_co_ban' ,
            'disabled'=>'disabled'
            ])
            @endcomponent   
            <br/>  
            <label class="control-label">Mô tả</label>
            <textarea class="form-control" name="mo_ta" tabindex="4" disabled>{{$loaichamcong->mo_ta}}</textarea>
        </div>
    </div>
@endcomponent