@extends('layouts.app') 
@section('css')
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"> 
@endsection 

@section('title')
<h1 class="title_master_form">{{__('model.lookup')}}</h1>
@endsection 

@section('content')
<div class="box">
  <div class="box-header">
    <div class="row">
      <div class="col-xs-12 pull-right">
        <a href="#" data-toggle="modal" data-target="#modal-add-lookup" class="btn btn-flat bg-olive create">
          <i class="fa fa-plus"> Thêm mới</i>
        </a>
        @include('lookup.shared.add')
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-6">
          @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage'=>$perPage, 'routerName'
          => 'lookup']) @endComponent
        </div>
        <div class="col-sm-6">
          @include('lookup.shared.box-search')
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
              <tr role="row">
                <th style="width: 20%;">Mã</th>
                <th style="width: 30%;">Tên</th>
                <th style="width: 30%;">Loại</th>
                <th style="width: 10%;text-align: center">Trạng thái</th>
                <th style="width: 5%; text-align: center">Chỉnh sửa</th>
                <th style="width: 5%;text-align: center ">Xóa</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $lookup)
              <tr role="row">
                <td>{{$lookup->ma}}</td>
                <td>{{$lookup->ten}}</td>
                <td>{{$lookup->type_lookup->ten}}</td>
                <td style="text-align: center;">
                  @if ($lookup->active)
                  <small class="label bg-olive flat block">Đang sử dụng</small>
                  @else
                  <small class="label bg-navy flat block">Ngừng sử dụng</small>
                  @endif
                </td>
                <td align="center">
                  <a href="#" data-toggle="modal" data-target="{{ '#modal-update-lookup-' . $lookup->id }}">
                    <i class="fa fa-edit"></i>
                  </a>
                  @include('lookup.shared.detail', [ 'lookup' => $lookup])
                </td>
                <td align="center">
                  <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-lookup-' . $lookup->id }}">
                    <i class="fa fa-trash-o"></i>
                  </a>
                  @include('lookup.shared.delete', ['lookup'=> $lookup])
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              @if (count($data) > 10)
              <tr>
                <th style="width: 20%;">Mã</th>
                <th style="width: 20%;">Tên</th>
                <th style="width: 20%;">Loại</th>
                <th style="width: 20%;text-align: center">Trạng thái</th>
                <th style="width: 10%; text-align: center">Chỉnh sửa</th>
                <th style="width: 10%;text-align: center ">Xóa</th>
              </tr>
              @endif
            </tfoot>
          </table>
        </div>
      </div>
      @component('components.pagination', ['pageShow' => 3, 'data' => $data]) @endComponent
    </div>
  </div>
</div>
@endsection