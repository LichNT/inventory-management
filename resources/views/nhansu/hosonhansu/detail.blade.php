@extends('nhansu.edit-layout') @section('title_detail') Danh sách file đính kèm @endsection @section('content_detail')
<div class="box-header">
  <div class="row">
    <div class="col-xs-12 pull-right">
      <a href="#" data-toggle="modal" data-target="#modal-add-hosonhansu" class="btn btn-flat bg-olive">
        <i class="fa fa-plus"> Thêm mới</i>
      </a>
      @include('nhansu.hosonhansu.create')
    </div>
  </div>
</div>

<div class="box-body">
  <div class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="row">
      <div class="col-sm-6">
        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data'
        => $data, 'routerName' => 'nhansu.update.hosonhansu','id'=>$nhansu->id]) @endComponent
      </div>
      <div class="col-sm-6">
        <div id="search" class="dataTables_filter">
          @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'nhansu.update.hosonhansu','id'=> $nhansu->id, 'search'
          => (empty($search)?null:$search)]) @endComponent
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
          <thead>
            <tr role="row">
              <th style="width: 45%;">Tên file</th>
              <th style="width: 45%;">Loại</th>
              <th style="width: 5%;text-align: center">Dowload</th>
              <th style="width: 5%;text-align: center">Xóa</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $hosonhansu)
            <tr role="row" class="odd">
              <td>{{$hosonhansu->file_name}}</td>
              <td>{{empty($hosonhansu->loaiHoSo)?'---':$hosonhansu->loaiHoSo->ten}}</td>
              <td align="center">
                <a href="{{url('hosonhansu/download/file/'. $hosonhansu->file_id)}}">
                  <i class="fa fa-download"></i>
              </td>
              <td align="center">
                <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-hosonhansu-' . $hosonhansu->id }}">
                  <i class="fa fa-trash-o"></i>
                </a>
                @include('nhansu.hosonhansu.delete')
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            @if (count($data) >= 10)
            <tr>
              <th style="width: 45%;">Tên file</th>
              <th style="width: 45%;">Loại</th>
              <th style="width: 5%;text-align: center">Dowload</th>
              <th style="width: 5%;text-align: center">Xóa</th>
            </tr>
            @endif
          </tfoot>
        </table>
      </div>
    </div>
    @component('components.pagination', ['pageShow' => 3, 'data' => $data]) @endComponent
  </div>
</div>
<div class="box-footer">
  <a class="btn btn-default btn-flat" href="{{route('nhansu')}}">
    <i class="fa fa-undo"></i> {{__('button.back')}}</a>
</div>
@endsection