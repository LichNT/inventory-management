@component('components.modal-add', [
   'type' => 'bacluong',
   'title' => __('model.bac_luong'),
   'width' => '35%',
   'route' => 'luong.chamcong.addthamsobacluong',
   'id'=>$id_chuc_vu

   ])
    <div class="row">
        <div class="col-sm-12">
            <label>Bậc lương<span style="color:red">*</span></label>
            @component('components.select2', [
                'data' => $bacluongs,
                'text' => 'ten',
                'name' => 'id',
                'value' =>'id',
                'tabindex' => 1,])
            @endcomponent
            <label for="name" class="control-label">Mức lương cơ bản<span style="color:red">*</span></label>
            <input type="text" class="form-control maskmoney" id="so_tien" name="muc_luong_co_ban" tabindex="2" value="{{old('muc_luong_co_ban')}}" required>
            <label class="control-label">Từ ngày<span style="color:red">*</span></label>
            <input type="text" class="form-control datemask" required name="tu_ngay"  tabindex="3" required value="{{old('tu_ngay')}}">
           
        </div>
    </div>
@endcomponent