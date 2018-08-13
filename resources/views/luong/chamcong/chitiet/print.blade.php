@extends('layouts.print')

<div class="wrapper">
  <section class="invoice">
    <h1 class="page-header" style="text-align:center">PHIẾU LƯƠNG</h1>
    <p class="lead" style="text-align:center;font-weight:bold;"> {{'Tháng '.$thang.' năm '.$nam}} </p>
    <div class="row invoice-info">
      <div class="col-sm-6 invoice-col">
        <b>Họ tên:</b> {{$nhansu->ho_ten}}
        <br>
        <b>Mã nhân viên:</b> {{$nhansu->ma}}
      </div>
      <div class="col-sm-6 invoice-col">
        <b>Chức vụ:</b> {{$nhansu->chucVu->ten}}
        <br>
        <b>Chi nhánh</b> {{$nhansu->chiNhanh->ten}}
      </div>
    </div>
    <br/>
    <div class="row">
      <div class="col-sm-12">
        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
          <tbody>
            <tr>
              <td>Tổng số công</td>
              <td>{{number_format($chamcongnhansu->tong_cong_huong_luong)}}</td>
            </tr>
            <tr>
              <td>Số giờ làm thêm</td>
              <td>{{number_format($chamcongnhansu->tong_lam_them_gio)}}</td>
            </tr>
            <tr>
              <td>Lương thực tế</td>
              <td>{{number_format($chamcongnhansu->luong_thuc_te)}}</td>
            </tr>
            <tr>
              <td>Lương làm thêm giờ</td>
              <td>{{number_format($chamcongnhansu->luong_thoi_gian)}}</td>
            </tr>
            <tr>
              <td>Khấu trừ thuế</td>
              <td>{{number_format($chamcongnhansu->khau_tru_thue_thu_nhap)}}</td>
            </tr>
            <tr>
              <td>Khấu trừ bảo hiểm</td>
              <td>{{number_format($chamcongnhansu->khau_tru_bao_hiem)}}</td>
            </tr>
            <tr>
              <td>Tiền bảo lãnh</td>
              <td>{{number_format($chamcongnhansu->khau_tru_tien_bao_lanh)}}</td>
            </tr>
            <tr>
              <td>Thực lãnh</td>
              <td>{{number_format($chamcongnhansu->thuc_linh)}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>