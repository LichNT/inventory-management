@component('components.modal-add', [
   'type' => 'quanhuyen',
   'title' => __('model.quan_huyen'),
   'width' => '35%',
   'route' => 'danhmuc.quanhuyen.add',
   ])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Tỉnh, thành phố<span style="color:red">*</span></label>
            @component('components.select', ['data' => $tinhthanhs,
                'text' => 'ten', 
                'name' => 'tinh_thanh_id', 
                'value' => 'id',
                'id' => 'tinh_thanh_id', 
                'idSelected'=>  old('tinh_thanh_id'),
                'tabindex'=> 1
                ])
            @endcomponent

            <label for="ma" class="control-label">Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" name="ma" autofocus tabindex="1" required value="{{old('ma')}}" tabindex="2">

            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" tabindex="2" required value="{{old('ten')}}" tabindex="3">          
            
            <label class="control-label">Mô tả</label>
            <input type="text" class="form-control" name="mo_ta" tabindex="4" value="{{old('mo_ta')}}" tabindex="4">
            
            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'trang_thai',
                'name' => 'trang_thai',
                'title_active' => __('system.active'),
                'title_inactive' => __('system.inactive'),
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => 1,
                'tabindex'=> 5
            ])
            @endcomponent
        </div>
    </div>
@endcomponent