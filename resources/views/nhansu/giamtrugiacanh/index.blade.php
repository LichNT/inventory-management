
<div class="row">     
  <div class="col-xs-12 pull-right">   
    @include('nhansu.thue.add')
  </div>
</div>

  <!--qua trinh cong tac-->
<div class="row">
  <div class="col-sm-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Chi tiết giảm trừ gia cảnh</h3>
      </div>
      <!-- /.box-header -->      
      <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
          <div class="row">
            <div class="col-sm-12">
              <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                <thead>
                  <tr role="row">
                    <th tabindex="0" rowspan="1" colspan="1" style="width: 20%;">Họ tên người phụ thuộc</th>
                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Ngày sinh</th>
                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">CMTND</th>
                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Thời điểm giảm trừ</th>
                    <th tabindex="0" rowspan="1" colspan="1" style="width: 15%;">Thời điểm kết thúc giảm</th>
                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Quan hệ gia đình</th>
                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Mã số thuế</th>
                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Thời điểm đăng ký</th>
                    <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Đính kèm tài liệu</th>
                    <th tabindex="0" rowspan="1" colspan="1" style="width: 8%;text-align: center">Xóa</th>                  
                  </tr>
                </thead>
                <tbody id="giam_tru_gia_canh">
                <!--foreach-->
                </tbody>
                <tfoot>
                
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 