@extends('layouts.app') 

@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">  
@endsection

@section('title')
<h1 class="title_master_form">{{__('model.nguoi_dung_he_thong')}}</h1>
@endsection 

@section('content')
<div class="box">
  <div class="box-header">       
    <div class="row">     
      <div class="col-xs-12 pull-right">
        <a href="#" data-toggle="modal" data-target="#modal-add-user" class="btn btn-flat bg-olive">
          <i class="fa fa-plus"> Thêm mới</i>
        </a>                   
        @include('system.user.add', ['roles' => $roles])       
      </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-md-6">
          @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'data' => $data, 'routerName' => 'users'])
          @endComponent
        </div>
          <div class="col-md-6">
              @include('system.user.box-search')
          </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <table class="table table-bordered table-striped dataTable" role="grid">
            @if(Auth::user()->role->code=="sysadmin")
              <thead>
                <tr role="row">
                  <th style="width: 15%;">Tên</th>
                  <th style="width: 15%;">Tài khoản</th>
                  <th style="width: 15%;">Email</th>
                  <th style="width: 15%;">Quyền</th>                  
                  <th style="width: 20%;">Công ty</th>                  
                  <th style="width: 10%;text-align:center;">Trạng thái</th>
                  <th style="width: 5%;text-align:center;">Chỉnh sửa</th>
                  <th style="width: 5%;text-align:center">Xóa</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $user)
                  <tr role="row" class="odd">
                    <td>{{$user->name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role->name}}</td>                   
                    <td>{{empty($user->company)?null:$user->company->name}}</td>                    
                    <td style="text-align:center;">
                      @if ($user->active)
                        <small class="label bg-olive flat">{{__('system.active2')}}</small>
                      @else
                        <small class="label bg-navy flat">{{__('system.inactive2')}}</small>
                      @endif
                    </td>
                    <td align="center">
                      <a href="#" data-toggle="modal" data-target="{{ '#modal-update-user-' . $user->id }}">
                        <i class="fa fa-edit"></i>
                      </a>  
                      @include('system.user.detail',[ 'user' => $user, 'roles' => $roles])                                      
                    </td>                  
                    <td align="center">
                      <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-user-' . $user->id }}">
                        <i class="fa fa-trash-o"></i>
                      </a>                    
                      @include('system.user.delete',['user' => $user])                                                            
                    </td>                  
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                @if (count($data) > 10)
                  <tr>
                    <th style="width: 15%;">Tên</th>
                    <th style="width: 15%;">Tài khoản</th>
                    <th style="width: 15%;">Email</th>
                    <th style="width: 15%;">Quyền</th>                  
                    <th style="width: 20%;">Công ty</th>                  
                    <th style="width: 10%;text-align:center;">Trạng thái</th>
                    <th style="width: 5%;text-align:center;">Chỉnh sửa</th>
                    <th style="width: 5%;text-align:center">Xóa</th>
                  </tr>
                @endif
              </tfoot>
            @else
              <thead>
                <tr role="row">
                  <th style="width: 20%;">Tên</th>
                  <th style="width: 20%;">Tài khoản</th>
                  <th style="width: 20%;">Email</th>
                  <th style="width: 20%;">Quyền</th>                                         
                  <th style="width: 10%;text-align:center;">Trạng thái</th>
                  <th style="width: 5%;text-align:center;">Chỉnh sửa</th>
                  <th style="width: 5%;text-align:center">Xóa</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $user)
                  <tr role="row" class="odd">
                    <td>{{$user->name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->role->name}}</td>                                                    
                    <td style="text-align:center;">
                      @if ($user->active)
                        <small class="label bg-olive flat">Đang hoạt động</small>
                      @else
                        <small class="label bg-navy flat">Ngừng hoạt động</small>
                      @endif
                    </td>
                    <td align="center">
                      <a href="#" data-toggle="modal" data-target="{{ '#modal-update-user-' . $user->id }}">
                        <i class="fa fa-edit"></i>
                      </a>  
                      @include('system.user.detail',[ 'user' => $user, 'roles' => $roles])                                      
                    </td>                  
                    <td align="center">
                      <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-user-' . $user->id }}">
                        <i class="fa fa-trash-o"></i>
                      </a>                    
                      @include('system.user.delete',['user' => $user])                                                            
                    </td>                  
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
                @if (count($data) > 10)
                  <tr>
                    <th style="width: 20%;">Tên</th>
                    <th style="width: 20%;">Tài khoản</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 20%;">Quyền</th>                                         
                    <th style="width: 10%;text-align:center;">Trạng thái</th>
                    <th style="width: 5%;text-align:center;">Chỉnh sửa</th>
                    <th style="width: 5%;text-align:center">Xóa</th>
                  </tr>
                @endif
              </tfoot>
            @endif            
          </table>
        </div>
      </div>
      @component('components.pagination', ['pageShow' => 3, 'data' => $data])
      @endComponent
    </div>
  </div>
  <!-- /.box-body -->
</div>
<input type="hidden" id="chinhanh_hidden" data="{{$chinhanhs}}">

@endsection



@section('script')
    <script src="{{ asset('js/changeUser.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection @section('script')