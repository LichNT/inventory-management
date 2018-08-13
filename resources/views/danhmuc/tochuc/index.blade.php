@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.to_chuc')}}</h1>
@endsection

@section('content')
<div class="box">
  <div class="box-header">         
    <div class="row">     
      
      <div class="col-xs-12">
        <a href="#" data-toggle="modal" data-target="{{ '#modal-add-tochuc'}}" class="btn btn-flat bg-olive">
          <i class="fa fa-plus"> Thêm mới</i>
        </a> 
        @include('danhmuc.tochuc.add')
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-6">
        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(), 'routerName' => 'danhmuc.tochuc'])
          @endComponent
        </div>
        <div class="col-sm-6">           
            @include('danhmuc.tochuc.box-search')         
        </div>
      </div>
    </div>
      <div class="row">
        <div class="col-sm-12">
          <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
              <tr role="row">
                <th>Trực thuộc</th>
                <th>Mã</th>
                <th>Tên</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Người liên hệ</th>
                <th>Loại</th>
                <th style="text-align:center">Trạng thái </th>
                <th style="text-align:center">Chỉnh sửa</th>
                <th style="text-align:center">Xóa</th>
              </tr>
            </thead>
            <tbody>             
              @foreach ($data as $tochuc)                
                <tr role="row">
                  <td>{{isset($tochuc->parent) ? $tochuc->parent->ten : '---'}}</td>
                  <td>{{$tochuc->ma}}</td>
                  <td>{{$tochuc->ten}}</td>
                  <td>{{$tochuc->so_dien_thoai}}</td>
                  <td>{{$tochuc->email}}</td>
                  <td>{{$tochuc->nguoi_lien_he}}</td>
                  <td>{{$tochuc->loaiToChuc['ten']}}</td>
                  <td style="text-align: center;">
                      @if ($tochuc->inactive)
                        <small class="label bg-navy flat block">{{__('system.inactive2')}}</small>
                          
                      @else
                        <small  class="label bg-olive flat block">{{__('system.active2')}}</small>
                      @endif
                  </td>      
                  <td align="center">
                    <a href="#" data-toggle="modal" data-target="{{ '#modal-update-tochuc-' . $tochuc->id }}">
                      <i class="fa fa-edit"></i>
                    </a>
                        @include('danhmuc.tochuc.detail')                                                 
                  </td>
                  <td align="center">
                    <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-tochuc-' . $tochuc->id }}" onclick="{{'deleteToChuc('.$tochuc->id.')'}}">
                      <i class="fa fa-trash-o"></i>
                    </a>                   
                    @include('danhmuc.tochuc.delete')          
                  </td>
                </tr>
              @endforeach              
            </tbody>
            <tfoot>
              @if (count($data) > 10)
                <tr>
                  <th>Trực thuộc</th>
                  <th>Mã</th>
                  <th>Tên</th>
                  <th>Số điện thoại</th>
                  <th>Email</th>
                  <th>Người liên hệ</th>
                  <th>Loại</th>
                  <th style="text-align:center">Trạng thái </th>
                  <th style="text-align:center">Chỉnh sửa</th>
                  <th style="text-align:center">Xóa</th>
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
  <script src="{{ asset('js/deleteToChuc.js') }}"></script>
  <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>      
@endsection
      