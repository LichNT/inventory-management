@extends('nhansu.edit-layout')

@section('title_detail')
Theo dõi hợp đồng lao động
@endsection

@section('content_detail')
<div class="box-header">
  <div class="row">     
    <div class="col-xs-12 pull-right">
      <a href="#" data-toggle="modal" data-target="#modal-add-theodoihopdong" class="btn btn-flat bg-olive">
        <i class="fa fa-plus"> Thêm mới</i>
      </a>   
      @include('nhansu.theodoihopdong.create')  
    </div>
  </div>
</div>             
<div class="box-body">
  <div class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="row">
      <div class="col-sm-6">
          @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu.update.theodoihopdong','id'=>$nhansu->id])
          @endComponent
      </div>
      <div class="col-sm-6">
        <div id="search" class="dataTables_filter">
          @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'nhansu.update.theodoihopdong','id'=> $nhansu->id, 'search' => (empty($search)?null:$search)])
          @endComponent
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
          <thead>
            <tr role="row">
              <th>Tên nhân viên</th>
              <th>Loại hợp đồng</th>
              <th>Chức vụ</th>
              <th>Số quyết định</th>
              <th>Ngày ký hợp đồng</th>
              <th>Ngày hiệu lực</th>  
              <th>Ngày hết hiệu lực </th>                  
              <th style="width: 10%;text-align: center">Trạng thái</th>
              <th style="width: 5%;text-align: center"></th>
              <th style="width: 5%;text-align: center">Chỉnh sửa</th>
              <th style="width: 5%;text-align: center">Xóa</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $hopdong)
            <tr role="row" class="odd">
              <td>{{empty($hopdong->nhanSu->ho_ten)?null:$hopdong->nhanSu->ho_ten}}</td>
              <td>{{empty($hopdong->loaiHopDong)?null:$hopdong->loaiHopDong->ten}}</td>
              <td>{{$hopdong->chucVu->ten}}</td>
              <td>{{$hopdong->so_quyet_dinh}}</td>
              <td>{{$hopdong->ngay_quyet_dinh}}</td>
              <td>{{$hopdong->ngay_hieu_luc}}</td>
              <td>{{$hopdong->ngay_het_hieu_luc}}</td>
              <td align="center">
              @if ($hopdong->trang_thai)
                <small class="label bg-olive flat block">{{__('system.active')}}</small>
              @else
                <small class="label bg-navy flat block">{{__('system.inactive')}}</small>
              @endif
            </td>
            <td align="center">
                  <a href="#" data-toggle="modal" data-target="{{ '#modal-enclose-' . $hopdong->id }}">
                      <span class="label bg-maroon flat block">Xem hồ sơ</span>
                  </a>
                  @include('nhansu.theodoihopdong.enclose')
              </td>
              <td align="center">
                <a href="#" data-toggle="modal" data-target="{{ '#modal-update-theodoihopdong-' . $hopdong->id }}">
                  <i class="fa fa-edit" ></i>
                </a>
                @include('nhansu.theodoihopdong.edit')
              </td>
              <td align="center">
                <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-theodoihopdong-' . $hopdong->id }}">
                  <i class="fa fa-trash-o"></i>
                </a>
              @include('nhansu.theodoihopdong.delete')
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            @if (count($data) >= 10)
            <tr>
              <th>Tên nhân viên</th>
              <th>Loại hợp đồng</th>
              <th>Chức vụ</th>
              <th>Số quyết định</th>
              <th>Ngày ký hợp đồng</th>
              <th>Ngày hiệu lực</th>  
              <th>Ngày hết hiệu lực </th>                  
              <th style="width: 10%;">Trạng thái</th>
              <th style="width: 5%;text-align: center"></th>
              <th style="width: 5%;text-align: center">Chỉnh sửa</th>
              <th style="width: 5%;text-align: center">Xóa</th>
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