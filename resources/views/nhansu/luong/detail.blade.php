@extends('nhansu.edit-layout')

@section('title_detail')
  Chi tiết lương
@endsection

@section('content_detail')
<div class="box-header">
  <div class="row">     
    <div class="col-xs-12 pull-right">
      <a href="#" data-toggle="modal" data-target="#modal-add-luong" class="btn btn-flat bg-olive">
        <i class="fa fa-plus"> Thêm mới</i>
      </a>   
      @include('nhansu.luong.create')  
    </div>
  </div>
</div>             
<div class="box-body">
  <div class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="row">
      <div class="col-sm-6">
          @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu.update.luong','id'=>$nhansu->id])
          @endComponent
      </div>
      <div class="col-sm-6">
        <div id="search" class="dataTables_filter">
          @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'nhansu.update.luong','id'=> $nhansu->id, 'search' => (empty($search)?null:$search)])
          @endComponent
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
          <thead>
            <tr role="row">
              <th> Bậc lương</th>
              <th>Ngày hưởng lương</th>
              <th>Số quyết định</th>
              <th>Ngày ký</th>
              <th>Diễn giải</th>
              <th>Hệ số lương</th>
              <th>Lương cơ bản</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;">Trạng thái</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;text-align: center">Chỉnh sửa</th>
              <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;text-align: center">Xóa</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $luong)
            <tr role="row" class="odd">
              <td>{{isset($luong->bacLuong->ten)?$luong->bacLuong->ten:''}}</td>
              <td>{{isset($luong->ngay_huong_luong)?$luong->ngay_huong_luong:''}}</td>
              <td>{{isset($luong->so_quyet_dinh)?$luong->so_quyet_dinh:''}}</td>
              <td>{{isset($luong->ngay_ky)?$luong->ngay_ky:''}}</td>
              <td>{{isset($luong->dien_dai)?$luong->dien_dai:''}}</td>
              <td>{{$luong->bacLuong->he_so_luong}}</td>
              <td>{{$luong->bacLuong->muc_luong_co_ban}}</td>
              <td> @if ($luong->inactive)
                  <small class="label bg-maroon flat block">{{__('system.inactive')}}</small>
                @else
                  <small class="label bg-olive flat block">{{__('system.active')}}</small>
                @endif</td>
              <td align="center">
                <a href="#" data-toggle="modal" data-target="{{ '#modal-update-luong-' . $luong->id }}">
                  <i class="fa fa-edit" ></i>
                </a>
                @include('nhansu.luong.edit')
              </td>
              <td align="center">
                <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-luong-' . $luong->id }}">
                  <i class="fa fa-trash-o"></i>
                </a>
              @include('nhansu.luong.delete')
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            @if (count($data) >= 10)
              <tr role="row">
                <th>Ngạch lương</th>
                <th> Bậc lương</th>
                <th>Ngày hưởng lương</th>
                <th>Số quyết định</th>
                <th>Ngày ký</th>
                <th>Diễn giải</th>
                <th>Hệ số lương</th>
                <th>Lương cơ bản</th>
                <th>Tiền phụ cấp</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;">Trạng thái</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;text-align: center">Chỉnh sửa</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;text-align: center">Xóa</th>
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
<script src="{{ asset('js/nhansu/addChiTietLuong.js') }}"></script>
@endsection