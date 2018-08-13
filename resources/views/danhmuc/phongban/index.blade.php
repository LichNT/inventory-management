@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.phong_ban')}}</h1>
@endsection

@section('content')
<div class="box">
  <div class="box-header">         
    <div class="row">     
      
      <div class="col-xs-12">
        <a href="#" data-toggle="modal" data-target="{{ '#modal-add-phongban'}}" class="btn btn-flat bg-olive">
          <i class="fa fa-plus"> Thêm mới</i>
        </a> 
        @include('danhmuc.phongban.add')
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-6">
        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'routerName' => 'danhmuc.phongban'])
          @endComponent
        </div>
        <div class="col-sm-6">                      
            @include('danhmuc.phongban.box-search')         
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
              <tr role="row">
                <th tabindex="0" rowspan="1" colspan="1">Trực thuộc</th>
                <th tabindex="0" rowspan="1" colspan="1">Mã</th>
                <th tabindex="0" rowspan="1" colspan="1">Tên</th>
                <th tabindex="0" rowspan="1" colspan="1">Số điện thoại</th>
                <th tabindex="0" rowspan="1" colspan="1">Email</th>
                <th tabindex="0" rowspan="1" colspan="1">Người liên hệ</th>
                <th tabindex="0" rowspan="1" colspan="1">Loại</th>
                <th tabindex="0" rowspan="1" colspan="1" style="text-align: center">Trạng thái </th>
                <th tabindex="0" rowspan="1" colspan="1" style="text-align: center" >Chỉnh sửa</th>
                <th tabindex="0" rowspan="1" colspan="1" style="text-align: center">Xóa</th>
              </tr>
            </thead>
            <tbody>             
              @foreach ($data as $phongban)                
                <tr role="row">
                  <td>{{isset($phongban->myParent) ? $phongban->myParent->ten : '---'}}</td>
                  <td>{{$phongban->ma}}</td>
                  <td>{{$phongban->ten}}</td>
                  <td>{{$phongban->so_dien_thoai}}</td>
                  <td>{{$phongban->email}}</td>
                  <td>{{$phongban->nguoi_lien_he}}</td>
                  <td>{{$phongban->loai_phong_ban['ten']}}</td>
                  <td style="text-align: center;">
                      @if ($phongban->trang_thai)
                          <small  class="label bg-olive flat block">{{__('system.active2')}}</small>
                      @else
                          <small class="label bg-navy flat block">{{__('system.inactive2')}}</small>
                      @endif
                  </td>         
                  <td align="center">
                    <a href="#" data-toggle="modal" data-target="{{ '#modal-update-phongban-' . $phongban->id }}">
                      <i class="fa fa-edit"></i>
                    </a>
                        @include('danhmuc.phongban.detail')                                                 
                  </td>
                  <td align="center">
                    <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-phongban-' . $phongban->id }}">
                      <i class="fa fa-trash-o"></i>
                    </a>                   
                    @include('danhmuc.phongban.delete')          
                  </td>
                </tr>
              @endforeach              
            </tbody>
            <tfoot>
              @if (count($data) > 10)
                <tr>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 20%;">Trực thuộc</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Mã phòng ban</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Tên phòng ban</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Số điện thoại</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Email</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Người liên hệ</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Loại</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;text-align: center">Trạng thái </th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 5%; text-align: center">Chỉnh sửa</th>
                  <th tabindex="0" rowspan="1" colspan="1" style="width: 5%; text-align: center;">Xóa</th>
                </tr>
              @endif              
            </tfoot>
          </table>
        </div>
      </div>
      @include('components.pagination', ['pageShow' => 3,'data' => $data])
    </div>
  </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>      
@endsection
      