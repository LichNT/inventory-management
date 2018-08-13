@extends('layouts.app')

@section('title')
    <h1> Lịch sử thay đổi nhân sự</h1>
@endsection

@section('content')
<div class="box">
    <div class="box-header">
   <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            <b>Mã:{{$nhansu->ma}}</b><br>
            <b>Họ tên:</b>{{$nhansu->ten}}<br>
            <b>Ngày sinh:</b> {{$nhansu->ngay_sinh}}<br>
            <b>cmnd:</b> {{$nhansu->cmnd}}<br>
            <b>Ngày cấp:</b> {{$nhansu->ngay_cap}}<br>
            <b>Nơi cấp:</b> {{$nhansu->noi_cap}}<br>
            <b>Hộ khẩu thường trú:</b> {{$nhansu->ho_khau_thuong_tru}}<br>
            <b>Chỗ ở hiện tại:</b> {{$nhansu->cho_o_hien_tai}}<br>
            <b>Số điện thoại:</b> {{$nhansu->so_dien_thoai}}<br>
            <b>Email:</b> {{$nhansu->email}}<br>
            <b>Giới tính:</b> {{$nhansu->gioi_tinh}}<br>
            <b>Nơi sinh:</b> {{$nhansu->noi_sinh}}<br>
            <b>Quê quán:</b> {{$nhansu->que_quan}}<br>
            <b>Dân tộc:</b> {{$nhansu->dan_toc}}<br>
            <b>Quốc tịch:</b>{{$nhansu->quoc_tich}}<br>
            <b>Tôn giáo:</b> {{$nhansu->ton_giao}}<br>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Mã số thuế:</b>{{$nhansu->ma_so_thue}}<br>
            <b>Mã thẻ chấm công:</b> {{$nhansu->so_the_cham_cong}}<br>
            <b>Gia cảnh:</b> {{$nhansu->gia_canh}}<br>
            <b>Số con:</b> {{$nhansu->so_con}}<br>
            <b>Loại hợp đồng:</b>{{$nhansu->loaiHopDong->ten}}<br>
            <b>Phòng ban:</b> {{$nhansu->phongBan->ten}}<br>
            <b>Tổ chức:</b> {{$nhansu->to_chuc}}<br>
            <b>Cửa hàng:</b> {{$nhansu->cua_hang}}<br>
            <b>Lưu trữ hồ sơ gốc:</b>{{$nhansu->luu_tru_ho_so_goc}}<br>
            <b>Thử việc:</b> {{$nhansu->thu_viec}}<br>
            <b>Nghỉ việc:</b> {{$nhansu->nghi_viec}}<br>
            <b>Ngày chính thức:</b>{{$nhansu->ngay_chinh_thuc}}<br>
            <b>Ngày thử việc:</b>{{$nhansu->ngay_thu_viec}}<br>
            <b>Ngày nghỉ việc:</b>{{$nhansu->ngay_nghi_viec}}<br>
            <b>Trình độ văn hóa:</b> {{$nhansu->trinhDoVanHoa->ten}}<br>
            <b>Chức vụ:</b> {{$nhansu->chucVu->ten}}<br>

        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Số sổ bảo hiểm</b>{{$nhansu->so_so_bao_hiem}}<br>
          <b>Số thẻ bảo hiểm:</b> {{$nhansu->so_the_bao_hiem}}<br>
          <b>Hệ số lương:</b> {{$nhansu->he_so_luong}}<br>
          <b>Lương cơ bản:</b> {{$nhansu->luong_co_ban}}<br>
          <b>Hệ số phụ cấp chức</b>{{$nhansu->he_so_phu_cap_chuc_vu}}<br>
          <b>Hệ số phụ cấp độc hại:</b>{{$nhansu->he_so_phu_cap_doc_hai}}<br>
          <b>Hệ số điểm phức tạp công việc:</b> {{$nhansu->he_so_diem_phuc_tap_cong_viec}}<br>
          <b>Hệ số phụ cấp thâm niên:</b> {{$nhansu->he_so_phu_cap_tham_nien}}<br>
          <b>Số người phụ thuộc</b>{{$nhansu->so_nguoi_phu_thuoc}}<br>
          <b>Số lượng đồng phục:</b> {{$nhansu->dong_phuc_so_luong}}<br>
          <b>Size đồng phục:</b> {{$nhansu->dong_phuc_size}}<br>
        </div>
        <!-- /.col -->
      </div>  
    </div>
</div>             
@endsection

