@component('components.modal-update', [
   'type' => 'update-thamsothuong',
   'title' => 'Cập nhật',
   'width' => '35%',
   'route' => 'thamsotinhluongthuong.update',
   'data' => $thamso,
   'params'=>[$thamso->id],
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label class="control-label">Giá trị</label>
            <input type="number" class="form-control" placeholder="" name="gia_tri" tabindex="3"  value="{{number_format($thamso->gia_tri)}}">
            <label class="control-label">Từ ngày</label>
            <input type="text" class="form-control datemask"  name="tu_ngay"  tabindex="5"  value="{{empty($thamso->tu_ngay)?null:Carbon\Carbon::parse($thamso->tu_ngay)->format('d/m/Y')}}">
            <label>Tham số</label>
            @component('components.select', [
                           'data' => $thamsos,
                           'text' => 'ten',
                           'name' => 'ma',
                           'value' =>'ma',
                           'none_required' => true,
                           'tabindex' => 5,
                           'disabled'=>'disabled',
                           'idSelected'=> $thamso->ma ])
            @endcomponent
        </div>

    </div>

@endcomponent