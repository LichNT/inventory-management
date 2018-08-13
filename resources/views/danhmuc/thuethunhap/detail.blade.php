@component('components.modal-update', [
   'type' => 'update-thuethunhap',
   'title' => __('model.thue_thu_nhap'),
   'width' => '35%',
   'route' => 'danhmuc.thuethunhap.update',
   'data' => $thuethunhap,
   'method' => 'POST'])

    <div class="row">
        <div class="col-sm-12">
            <label  class="control-label">Tên<span style="color:red">*</span></label>
            <input type="text" class="form-control" id="ten" name="ten" tabindex="1" required value="{{$thuethunhap->ten}}">
            <label  class="control-label">Cận trên</label>
            <input type="text" class="maskmoney form-control" name="can_tren" tabindex="2"  value="{{number_format($thuethunhap->can_tren)}}">
            <label  class="control-label">Hệ số (%)<span style="color:red">*</span></label>
            <input type="number" required class="form-control" step="0.01" min=0 max=100 name="thue_suat" tabindex="3" value="{{$thuethunhap->thue_suat}}">
        </div>
    </div>
@endcomponent