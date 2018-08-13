@extends('nhansu.edit-layout')

@section('title_detail')
  Gia cảnh
@endsection

@section('content_detail')
  <div>
    <div class="box">
      <div class="box-header">
        <div class="row">     
          <div class="col-xs-12 pull-right">
            <a href="#" data-toggle="modal" data-target="#modal-add-giacanh" class="btn btn-flat bg-olive">
              <i class="fa fa-plus"> Thêm mới</i>
            </a>   
            @include('nhansu.giacanh.create')  
          </div>
        </div>
      </div>             
      <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
          <div class="row">
            <div class="col-sm-6">
                @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu.update.giacanh','id'=>$nhansu->id])
                @endComponent
            </div>
            <div class="col-sm-6">
              <div id="search" class="dataTables_filter">
                @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'nhansu.update.giacanh','id'=> $nhansu->id, 'search' => (empty($search)?null:$search)])
                @endComponent
              </div>
            </div>
          </div>
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
                  <th style="width: 10%;">Trạng thái</th>
                  <th style="width: 10%;">Chỉnh sửa</th>
                  <th style="width: 8%;text-align: center">Xóa</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $giacanh)
                    <tr role="row" class="odd">
                      <td>{{$giacanh->ho_ten}}</td>
                      <td>{{$giacanh->nam_sinh}}</td>
                      <td>{{($giacanh->gioi_tinh==1)?'Nam':'Nữ'}}</td>
                      <td>{{$giacanh->quan_he}}</td>
                      <td>{{$giacanh->nghe_nghiep}}</td>
                      <td>{{($giacanh->da_chet==1)?'Đã chết':'Chưa chết'}}</td>
                      <td align="center">
                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-giacanh-' . $giacanh->id }}">
                          <i class="fa fa-edit" ></i>
                        </a>
                        @include('nhansu.giacanh.edit')
                      </td>
                      <td align="center">
                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-giacanh-' . $giacanh->id }}">
                          <i class="fa fa-trash-o"></i>
                        </a>
                        @include('nhansu.giacanh.delete')
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  @if (count($data) >= 10)
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
                  @endif
                </tfoot>
              </table>
            </div>
          </div>
          @component('components.pagination', ['pageShow' => 3, 'data' => $data])
          @endComponent
        </div>
      </div>
      <div class="box-footer">
            <a class="btn btn-default btn-flat" href="{{route('nhansu')}}"><i class="fa fa-undo"></i> {{__('button.back')}}</a>    
      </div>
    </div>    
  </div>
@endsection