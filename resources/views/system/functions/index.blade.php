@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('title')
<h1 class="title_master_form">{{__('model.function')}}</h1>
@endsection

@section('content')
<div class="box">
  <div class="box-header">       
    <div class="row">     
      <div class="col-xs-12 pull-right">
        <a href="#" data-toggle="modal" data-target="#modal-add-function" class="btn btn-flat bg-olive">
          <i class="fa fa-plus"> Thêm mới</i>
        </a>                   
        @include('system.functions.add')    
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-6">
          @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'system.functions'])
          @endComponent
        </div>
        <div class="col-sm-6">
          @include('system.functions.box-search')
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
              <tr role="row">
                <th style="width: 40%;">Tên Chức Năng</th>
                <th style="width: 45%;">Tên Danh Mục</th>
                <th style="width: 10%;text-align:center">Trang chủ</th>
                <th style="width: 5%;text-align:center">Xóa</th>
              </tr>
            </thead>
            <tbody>             
              @foreach ($data as $rolemenu)                
                <tr role="row">
                  <td>{{$rolemenu->role->name}}</td>
                  <td>{{$rolemenu->menu->name}}</td>               
                  <td style="text-align:center;">
                    @if ($rolemenu->home_router)
                      <small class="label bg-maroon block flat">Trang chủ</small>
                    @else
                      <small class="label bg-olive block flat">Trang thường</small>
                    @endif
                  </td>               
                  <td align="center">
                    <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-rolemenu-' . $rolemenu->id }}">
                      <i class="fa fa-trash-o"></i>
                    </a>                   
                    @include('system.functions.delete',['rolemenu' => $rolemenu])            
                  </td>                   
                </tr>
              @endforeach              
            </tbody>
            <tfoot>
              @if (count($data) > 10)
                <tr>
                  <th style="width: 30%;">Tên Chức Năng</th>
                  <th style="width: 30%;">Tên Danh Mục</th>
                  <th style="width: 30%;text-align:center">Trang chủ</th>
                  <th style="width: 10%;text-align:center">Xóa</th>
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
  </div>
@endsection

@section('script')   
  <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>      
@endsection
      