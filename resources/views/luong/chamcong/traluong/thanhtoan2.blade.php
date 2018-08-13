@component('components.modal-add', [
   'type' => 'thanhtoan2',
   'title' => 'trả lương',
   'width' => '35%',
   'route' => 'luong.chamcong.thanhtoan2',
   'id'=>$ten_bang,
   'method' => 'POST'])
    <div class="row">
        <div class="col-sm-12">
                <label class="control-label">Ngày trả lương<span style="color:red">*</span></label>
                <input type="text" class="form-control datemask"  name="ngay_giao_dich" tabindex="2" value="{{old('ngay_giao_dich')}}">
                <label class="control-label">Nội dung</label>
            <textarea class="form-control" name="noi_dung" tabindex="2" >{{old('noi_dung')}}</textarea>
        </div>
        </div>
@endcomponent