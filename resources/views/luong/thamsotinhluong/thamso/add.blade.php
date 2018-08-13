@component('components.modal-add', [
   'type' => 'tham_so_thuong',
   'width' => '35%',
   'route' => 'thamsotinhluongthuong.add',
   ])
    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Giá trị</label>
            <input type="number" class="form-control" placeholder="" name="gia_tri" tabindex="3"  value="{{old('gia_tri')}}">
            <label class="control-label">Từ ngày</label>
            <input type="text" class="form-control datemask"  name="tu_ngay"  tabindex="5"  value="{{old('tu_ngay')}}">
            <label>Tham số</label>
            @component('components.select2', [
                'data' => $thamsos,
                'text' => 'ten',
                'name' => 'ma',
                'value' =>'ma',
                'none_required' => true,
                'tabindex' => 5,
                'idSelected'=> old('ma') ])
            @endcomponent
        </div>

    </div>
@endcomponent