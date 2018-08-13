@extends('nhansu.edit-layout')

@section('title_detail')
Nghỉ đặc biệt
@endsection

@section('content_detail')
<div class="box-header">
  <div class="row">     
    <div class="col-xs-12 pull-right">
      <a href="#" data-toggle="modal" data-target="#modal-add-nghidacbiet" class="btn btn-flat bg-olive">
        <i class="fa fa-plus"> Thêm mới</i>
      </a>   
      @include('nhansu.nghidacbiet.create')  
    </div>
  </div>
</div>             
<div class="box-body">
  <div class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="row">
      <div class="col-sm-6">
          @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu.update.nghidacbiet','id'=>$nhansu->id])
          @endComponent
      </div>
      <div class="col-sm-6">
        <div id="search" class="dataTables_filter">
          @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'nhansu.update.nghidacbiet','id'=> $nhansu->id, 'search' => (empty($search)?null:$search)])
          @endComponent
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
          <thead>
          <tr role="row">
            <th style="width: 20%;">Tên nhân viên</th>
            <th style="width: 20%;">Trường hợp nghỉ</th>
            <th style="width: 15%;">Từ ngày</th>
            <th style="width: 15%;">Đến ngày</th>
            <th style="width: 15%; text-align: center">Trạng thái</th>
            <th style="width: 8%; text-align: center">Chỉnh sửa</th>
            <th style="width: 7%;text-align: center">Xóa</th>
          </tr>
          </thead>
          <tbody>
            @foreach ($data as $nghidacbiet)
              <tr role="row" class="odd">
                <td>{{empty($nhansu->ho_ten)?null:$nhansu->ho_ten}}</td>
                <td>{{$nghidacbiet->loainghidacbiet->ten}}</td>
                <td>{{$nghidacbiet->ngay_bat_dau}}</td>
                <td>{{$nghidacbiet->ngay_ket_thuc}}</td>
                <td align="center">{{($nghidacbiet->trang_thai)?__('system.active'):__('system.inactive')}}</td>
                <td align="center">
                  <a href="#" data-toggle="modal" data-target="{{ '#modal-update-nghidacbiet-' . $nghidacbiet->id }}">
                    <i class="fa fa-edit" ></i>
                  </a>
                  @include('nhansu.nghidacbiet.edit')
                </td>
                <td align="center">
                  <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-nghidacbiet-' . $nghidacbiet->id }}">
                    <i class="fa fa-trash-o"></i>
                  </a>
                  @include('nhansu.nghidacbiet.delete')
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            @if (count($data) > 10)
              <tr role="row">
                <th style="width: 20%;">Tên nhân viên</th>
                <th style="width: 20%;">Trường hợp nghỉ</th>
                <th style="width: 15%;">Từ ngày</th>
                <th style="width: 15%;">Đến ngày</th>
                <th style="width: 15%; text-align: center">Trạng thái</th>
                <th style="width: 8%; text-align: center">Chỉnh sửa</th>
                <th style="width: 7%;text-align: center">Xóa</th>
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
@endsection