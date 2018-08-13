@component('components.modal-add', [ 
    'type' => 'lookup', 
    'title' => __('model.lookup'),
    'width' => '25%',
    'route' => 'lookup.add',    
    ])
    <div class="row">
        <div class="col-sm-12">
            <label for="ma" class="control-label">Mã<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ma" name="ma" autofocus tabindex="1" required value="{{old('ma')}}">
            
            <label for="ten" class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" tabindex="2" required value="{{old('ten')}}">

            <label for="loai" class="control-label">Loại<span style="color:red">*</span></label>
            @component('components.select', [
                'data' => $loaiLookups, 
                'text' => 'ten', 
                'value' => 'ma', 
                'id' => 'loai', 
                'name' => 'loai',
                'idSelected' => old('loai')
            ])
            @endcomponent

            @component('components.group-checkbox', [
                'title' => 'Trạng thái',
                'id' => 'active',
                'name' => 'active',
                'title_active' => 'Còn sử dụng',
                'title_inactive' => 'Ngừng sử dụng',
                'value_active' => 1,
                'value_inactive' => 0,
                'value' => 1,            
            ])
            @endcomponent 
        </div>        
    </div>     
@endcomponent
