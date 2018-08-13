@component('components.confirm-delete',
[
    'route' => 'luong.congno.delete',
    'method' => 'delete',
    'data' => $congno,
    'type' => 'delete-congno',
    'title' => __('model.congno'),
    'width' => '35%',
])
    <div class="row">

        <div class="col-sm-12">
            <label for="name" class="control-label">Nhân viên<span style="color:red">*</span></label>
            <input type="text" class="form-control" disabled readonly required value="{{$congno->nhanSu->ho_ten}}" >

            <label for="name" class="control-label">Tháng năm<span style="color:red">*</span></label>
            <input type="text" class="form-control monthmask" disabled required name="thang_nam" tabindex="3"  value="{{$congno->thang_nam}}" >

            <label for="name" class="control-label">Số tiền <span style="color:red">*</span></label>
            <input type="number" class="form-control" required name="so_tien" disabled tabindex="3" value="{{$congno->so_tien}}" >

            <label for="name" class="control-label">Nội dung</label>
            <textarea  class="form-control" name="noi_dung" tabindex="3" disabled >{{$congno->noi_dung}}</textarea>

        </div>
    </div>
@endcomponent