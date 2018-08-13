@component('components.modal-add', [
    'type' => 'hosonhansu',
    'title' => 'Thêm mới file nhân sự',
    'width' => '35%',
    'route' => 'nhansu.update.hosonhansu.create',
    'id' => $nhansu->id,
    'enctype'=>'multipart/form-data'
    ])

    <div class="row">
        <div class="col-md-8">
            <label  >Loại hồ sơ<span style="color:red">*</span></label>
            @component('components.select', [
                    'data' => $loaihosonhansus,
                    'text' => 'ten',
                    'name' => 'id_type',
                    'value' => 'id',
                    'tabindex' => 1,
                    'idSelected' => old('id_type')
                    ])
            @endcomponent

        </div>
        <div class="col-md-4">
        <br/>
        <form>
            <div class="btn bg-olive btn-file btn-flat margin">
              <i class="fa fa-paperclip"></i> Chọn file 
              <input type="file"  name="file_ho_so_nhan_su" onchange="form.submit();this.disabled=true">
            </div> 
        </div>
        </form>
    </div>
    
@endcomponent