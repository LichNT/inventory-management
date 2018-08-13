@component('components.confirm-delete',
[
    'route' => 'nhansu.update.luong.delete',
    'method' => 'delete',
    'data' => $luong,
    'type' => 'delete-luong',
    'width' => '35%',
    'title' => 'Xóa'
])

    <div class="row">
        <div class="col-md-6">
            <label  class="control-label">Ngạch lương</label>
            <input type="text" disabled class="form-control"   name="ngach_luong" tabindex="3" value="{{isset($luong->ngachLuong->name)?$luong->ngachLuong->name:''}}">
        </div>
        <div class="col-md-6">
            <label  class="control-label">Bậc lương</label>
            <input type="text" disabled class="form-control"   name="bac_luong" tabindex="3" value="{{isset($luong->bacLuong->ten)?$luong->bacLuong->ten:''}}">

        </div>

        <div class="col-md-6">
            <label for="ngay_huong_luong" class="control-label datemask">Ngày hưởng lương</label>
            <input type="text" disabled class="form-control datemask"  required name="ngay_huong_luong" tabindex="3" value="{{$luong->ngay_huong_luong}}">
        </div>
        <div class="col-md-6">
            <label for="so_quyet_dinh" class="control-label">Số quyết định</label>
            <input type="text" disabled class="form-control"  name="so_quyet_dinh" tabindex="4" value="{{$luong->so_quyet_dinh}}">
        </div>
        <div class="col-md-6">
            <label for="ngay_ky" class="control-label datemask">Ngày ký</label>
            <input type="text" disabled class="form-control datemask"   name="ngay_ky" tabindex="5" value="{{$luong->ngay_ky}}">
        </div>
        <div class="col-md-6">
            <label for="dien_dai" class="control-label">Diễn giải</label>
            <textarea class="form-control" disabled rows="2" name="dien_dai" tabindex="6">{{$luong->dien_dai}}</textarea>
        </div>
        <div class="col-md-6">
            <label for="he_so_phu_cap_chuc_vu" class="control-label">Hệ số phụ cấp chức vụ</label>
            <input type="text" disabled class="form-control" name="he_so_phu_cap_chuc_vu" tabindex="7" value="{{$luong->he_so_phu_cap_chuc_vu}}">
        </div>
        <div class="col-md-6">
            <label for="he_so_phu_cap_doc_hai" class="control-label">Hệ số phụ cấp độc hại</label>
            <input type="text" disabled class="form-control"  name="he_so_phu_cap_doc_hai" tabindex="8" value="{{$luong->he_so_phu_cap_doc_hai}}">
        </div>
    </div>


@endcomponent