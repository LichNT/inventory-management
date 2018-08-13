@extends('layouts.app') 
@section('css')
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection 
@section('title')
<h1 class="title_master_form">{{__('model.company')}}</h1>
@endsection
 @section('content')
<div class="box">
  <div class="box-header">
    <div class="row">
      <div class="col-xs-12 pull-right">
        <a href="#" data-toggle="modal" data-target="#modal-add-company" class="btn btn-flat bg-olive">
          <i class="fa fa-plus"> Thêm mới</i>
        </a>
        @include('system.company.add', [ 'companies' => $companies])
      </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-6">
          @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(), 'perPage' => $perPage, 'data' => $data, 'routerName'
          => 'companies']) @endComponent
        </div>
        <div class="col-sm-6">
          <div id="search" class="dataTables_filter">
            @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'companies', 'search' => (empty($search)?null:$search)])
            @endComponent
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
            <thead>
              <tr role="row">
                <th style="width: 30%;">Trực thuộc</th>
                <th style="width: 20%;">Mã</th>
                <th style="width: 30%;">Tên</th>
                <th style="width: 10%;text-align:center;">Trạng thái</th>
                <th style="width: 5%;text-align:center;">Chỉnh sửa</th>
                <th style="width: 5%;text-align:center">Xóa</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $company)
              <tr role="row" class="odd">
                <td>{{isset($company->parent) ? $company->parent->name : '---'}}</td>
                <td>{{$company->code}}</td>
                <td>{{$company->name}}</td>
                <td style="text-align:center;">
                  @if ($company->active)
                  <small class="label bg-olive flat">{{__('system.active2')}}</small>
                  @else
                  <small class="label bg-navy flat">{{__('system.inactive2')}}</small>
                  @endif
                </td>
                <td align="center">
                  <a href="#" data-toggle="modal" data-target="{{ '#modal-update-company-' . $company->id }}">
                    <i class="fa fa-edit"></i>
                  </a>
                  @include('system.company.detail',[ 'company' => $company, 'companies' => $companies])
                </td>
                <td align="center">
                  <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-company-' . $company->id }}">
                    <i class="fa fa-trash-o"></i>
                  </a>
                  @include('system.company.delete',['company' => $company, 'companies' => $companies])
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
          </table>
        </div>
      </div>
      @component('components.pagination', ['pageShow' => 3, 'data' => $data]) @endComponent
    </div>
  </div>
  <!-- /.box-body -->
</div>



@endsection @section('script')

<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script> @endsection