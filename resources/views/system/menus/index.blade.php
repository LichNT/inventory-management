@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection 

@section('title')
<h1 class="title_master_form">{{__('model.menu')}}</h1>
@endsection

@section('content')
<div class="box">
  <div class="box-header">    
    <div class="row">     
      <div class="col-xs-12 pull-right">
        <a href="#" data-toggle="modal" data-target="{{ '#modal-add-menu'}}" class="btn btn-flat bg-olive">
          <i class="fa fa-plus"> Thêm mới</i>
        </a>                   
        @include('system.menus.add') 
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-6">
          @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'system.menus'])
          @endComponent
        </div>
        <div class="col-sm-6">          
          <div id="search" class="dataTables_filter">
            @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'system.menus', 'search' => (empty($search)?null:$search)])
            @endComponent           
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
              <tr role="row">
                <th style="width: 20%;">Thuộc chức năng</th>
                <th style="width: 20%;">Tên</th>
                <th style="width: 20%;">Tên đường dẫn</th>
                <th style="width: 10%;text-align:center;">Biểu tượng</th>                
                <th style="width: 10%;text-align:center;">Thứ tự </th>
                <th style="width: 10%;text-align:center;">Trạng thái </th>
                <th style="width: 5%;text-align:center;">Chỉnh sửa</th>
                <th style="width: 5%;text-align:center;">Xóa</th>
              </tr>
            </thead>
            <tbody>             
              @foreach ($data as $menu)                
                <tr>
                  <td>
                    @if(isset($menu->parent))
                      {{$menu->parent->name}}
                    @else
                      ---
                    @endif                    
                  </td>
                  <td>{{$menu->name}}</td>
                  <td>{{$menu->router_link}}</td>
                  <td align="center">{{$menu->fa_icon}}</td>
                  <td align="center">{{$menu->order}}</td> 
                  <td align="center">
                    @if ($menu->active)
                      <small class="label bg-olive flat">Còn hiệu lực</small>                  
                    @else
                      <small class="label bg-navy flat">Hết hiệu lực</small>
                    @endif                                                 
                  </td>                                   
                  <td align="center">
                    <a href="#" data-toggle="modal" data-target="{{ '#modal-update-menu-' . $menu->id }}">
                      <i class="fa fa-edit"></i>
                    </a>
                    @include('system.menus.detail', ['menu' => $menu, 'menu_parents' => $menu_parents])                                                         
                  </td>
                  <td align="center">
                    <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-menu-' . $menu->id }}">
                      <i class="fa fa-trash-o"></i>
                    </a>                   
                    @include('system.menus.delete', ['menu' => $menu])                   
                  </td>
                </tr>
              @endforeach              
            </tbody>
            <tfoot>
              @if (count($data) > 10)
                <tr>
                  <th style="width: 20%;">Thuộc chức năng</th>
                  <th style="width: 20%;">Tên</th>
                  <th style="width: 10%;">Tên đường dẫn</th>
                  <th style="width: 10%;text-align: center">Biểu tượng</th>
                  <th style="width: 10%;text-align: center">Thứ tự</th>
                  <th style="width: 10%;text-align: center">Trạng thái </th>
                  <th style="width: 10%; text-align: center">Chỉnh sửa</th>
                  <th style="width: 10%; text-align: center;">Xóa</th>
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

      