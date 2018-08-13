
<div class="row">     
  <div class="col-xs-12 pull-right">   
    @include('nhansu.giacanh.add')
  </div>
</div>

  <!--qua trinh cong tac-->
<div class="row">
  <div class="col-sm-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Gia cảnh</h3>
      </div>
      <!-- /.box-header -->      
      <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
          <div class="row">
            <div class="col-sm-12">
              <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                <thead>
                  <tr role="row">                   
                    <th style="width: 20%;">Họ và tên</th>
                    <th style="width: 10%;">Năm sinh</th>
                    <th style="width: 15%;">Giới tính</th>
                    <th style="width: 15%;">Quan hệ</th>
                    <th style="width: 10%;">Nghề nghiệp</th>
                    <th style="width: 10%;">Đã chết</th>
                    <th style="width: 10%;">Chỉnh sửa</th>
                    <th style="width: 8%;text-align: center">Xóa</th>
                  </tr>
                </thead>
                <tbody id="bao_hiem">                
                </tbody>               
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 