@component('components.modal-add', [
   'type' => 'chamcong',
   'title' => __('model.bang_cham_cong'),
   'width' => '35%',
   'route' => 'luong.chamcong.add'
   ])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Tên <span style="color:red">*</span></label>
            <input type="text" class="form-control" name="ten" tabindex="1" required value="{{old('ten')}}" autofocus placeholder="Dài không quá 500 ký tự">

            <label class="control-label">Năm <span style="color:red">*</span></label>
            <input type="number" class="form-control" name="nam" tabindex="2" required value="{{old('nam', date('Y'))}}">
            
            <label class="control-label">Tháng<span style="color:red">*</span></label>
            @component('components.select-month', [                          
                          'idSelected' => old('thang', date('m')),
                          'value' => 'id',                          
                          'name' => 'thang',
                      ])
            @endcomponent
        </div>
    </div>
@endcomponent