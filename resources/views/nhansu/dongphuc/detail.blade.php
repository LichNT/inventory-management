@extends('nhansu.edit-layout')

@section('title_detail')
  Lịch sử thay đổi đồng phục
@endsection

@section('content_detail')
<div class="box-header">
  {{ csrf_field() }}   
  {{method_field('put')}}
  <div class="row">
      <div class="col-md-3">
          <label >Size đồng phục</label>
          <input type="text" class="form-control " value="{{$nhansu->size->ten}}"  readonly >     
      </div>
      <div class="col-md-3">
          <label >Số lượng đồng phục</label>
          <input type="text" class="form-control " value="{{$nhansu->dong_phuc_so_luong}}"  readonly >                           
      </div>        
  </div>
<hr>      
<div class="row">     
<div class="col-xs-12 pull-right">            
  <a href="#" data-toggle="modal" data-target="#modal-add-change" class="btn btn-flat bg-olive btn-sm">
    <i class="fa fa-plus"> Thêm mới thay đổi đồng phục</i>
  </a>
  @include('nhansu.dongphuc.change')
</div>
</div>
</div>             
<div class="box-body">
<div class="dataTables_wrapper form-inline dt-bootstrap">
<div class="row">
  <div class="col-sm-6">
      @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu.update.dongphuc','id'=>$nhansu->id])
      @endComponent
  </div>
  <div class="col-sm-6">
    <div id="search" class="dataTables_filter">
      @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'nhansu.update.dongphuc','id'=> $nhansu->id, 'search' => (empty($search)?null:$search)])
      @endComponent
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <table class="table table-bordered table-striped dataTable table-responsive">
      <thead>
        <tr>
          <th >Nhân viên</th>                                    
          <th style="text-align:center;">Size</th>
          <th style="text-align:center;">Số lượng</th>
          <th style="text-align:center;">Trạng thái</th>
          <th style="text-align:center;">Ngày cập nhật</th>
          <th style="text-align:center;width:5%">Xóa</th>
      </thead>
      <tbody>
        @foreach ($data as $key=>$dongphuc)
        <tr>
          <td >{{empty($dongphuc->nhanSu->ho_ten)? ' ':$dongphuc->nhanSu->ho_ten}}</td>
          <td style="text-align:center;">{{$dongphuc->size->ten}}</td>
          <td style="text-align:center;">{{$dongphuc->so_luong}}</td>
          <td style="text-align:center;">{{$dongphuc->trangThaiDongPhuc->ten}}</td>
          <td style="text-align:center;">{{$dongphuc->ngay_cap_nhat}}</td>
          <td align="center">
            @if($key==0)
            <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-dongphuc-' . $dongphuc->id }}">
              <i class="fa fa-trash-o" ></i>
            </a>
            @include('nhansu.dongphuc.delete')
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        @if (count($data) > 10)
        <tr>
          <th >Nhân viên</th>                                    
          <th style="text-align:center;">Size</th>
          <th style="text-align:center;">Số lượng</th>
          <th style="text-align:center;">Trạng thái</th>
          <th style="text-align:center;">Ngày cập nhật</th>
          <th style="text-align:center;width:5%">Xóa</th>
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