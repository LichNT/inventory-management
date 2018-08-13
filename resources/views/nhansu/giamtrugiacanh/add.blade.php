<!--alert content-->
<div class="row" id="alert_giam_tru_gia_canh">
</div>
<!--end alert content-->
<div class="row">
    <div class="col col-md-2">
        <label for="ho_ten_nguoi_phu_thuoc" class="control-label">Họ tên người phụ thuộc</label>
        <input type="text" class="form-control " id="ho_ten_nguoi_phu_thuoc">
    </div>
    <div class="col col-md-2">
        <label for="ngay_sinh_thue" class="control-label">Ngày sinh</label>
        <input type="text" class="form-control datemask" id="ngay_sinh_thue">
    </div>
    <div class="col col-md-2">
        <label for="cmtnd" class="control-label">CMTND</label>
        <input type="text" class="form-control " id="cmtnd">
    </div>
    <div class="col col-md-2">
        <label for="thoi_diem_giam_tru" class="control-label">Thời điểm giảm trừ</label>
        <input type="text" class="form-control datemask" id="thoi_diem_giam_tru">
    </div>
    <div class="col col-md-2">
        <label for="thoi_diem_ket_thuc_giam" class="control-label">Thời điểm kết thúc giảm</label>
        <input type="text" class="form-control datemask"  id="thoi_diem_ket_thuc_giam">
    </div>
    <div class="col col-md-2">
        <label for="quan_he_gia_dinh" class="control-label">Quan hệ gia đình</label>
        <input type="text" class="form-control" id="quan_he_gia_dinh">
    </div>
    <div class="col col-md-2">
        <label for="quan_he_gia_dinh" class="control-label">Mã số thuế</label>
        <input type="text" class="form-control" id="ma_so_thue_nguoi_phu_thuoc">
    </div>
    <div class="col col-md-2">
        <label for="quan_he_gia_dinh" class="control-label">Thời điểm đăng ký</label>
        <input type="text" class="form-control monthmask" value="{{date('m/Y')}}" id="thoi_diem_dang_ky">
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <div class="btn btn-default btn-file">
            <i class="fa fa-paperclip"></i> Đính kèm tài liệu
            <input type="file" name="attachment" id="thue_attachment" onchange="attachfiles(event, 'thue_attachment_files', 'thue_files')">
        </div>
        <p class="help-block">Tối đa. 32MB</p>
    </div>    
    <div class="col-md-12">
        <ul class="mailbox-attachments clearfix" id="thue_attachment_files">
            <!--content file-->                       
        </ul>
        <div id="thue_files" class="files">
            <!--input hide file-->                       
        </div>
    </div>    
</div>
<hr>
<div class="row">
    <div class="col col-md-6 pull-right col-sm-12">
        <a class="btn pull-right bg-olive btn-flat" onclick="themGiamTruGiaCanh()">
            <i class="fa fa-plus"></i> Thêm chi tiết giảm trừ gia cảnh</a>
    </div>
</div>
<br>
<input type="hidden" value="[]"  id="hiddenGiamTruGiaCanh" >
<!--javascrip js-->
<script src="{{asset('js/nhansu/addthue.js')}}"></script>