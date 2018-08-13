@extends('nhansu.edit-layout')

@section('title_detail')
  Chi tiết giảm trừ gia cảnh
@endsection

@section('content_detail')
  <div class="box-header">
    <div class="row">     
      <div class="col-xs-12 pull-right">
        <a href="#" data-toggle="modal" data-target="#modal-add-giamtrugiacanh" class="btn btn-flat bg-olive">
          <i class="fa fa-plus"> Thêm mới</i>
        </a>   
        @include('nhansu.giamtrugiacanh.create')  
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-6">
            @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu.update.giamtrugiacanh','id'=>$nhansu->id])
            @endComponent
        </div>
        <div class="col-sm-6">
          <div id="search" class="dataTables_filter">
            @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'nhansu.update.giamtrugiacanh','id'=> $nhansu->id, 'search' => (empty($search)?null:$search)])
            @endComponent
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <table class="table">
            <thead>
              <tr role="row">
                <th tabindex="0" rowspan="1" colspan="1" style="width: 20%;">Họ tên người phụ thuộc</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Ngày sinh</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Giới tính</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">CMTND</th> 
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Mã số thuế</th> 
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Quan hệ gia đình</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Thời điểm giảm trừ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Thời điểm kết thúc giảm</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;text-align: center">Chỉnh sửa</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 5%;text-align: center">Xóa</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $giamtrugiacanh)
              <tr role="row" class="odd">
                <td>{{$giamtrugiacanh->ho_ten}}</td>
                <td>{{$giamtrugiacanh->ngay_sinh}}</td>
                <td>{{($giamtrugiacanh->gioi_tinh==1)?'Nam':'Nữ'}}</td>
                <td>{{$giamtrugiacanh->cmnd}}</td>
                <td>{{$giamtrugiacanh->ma_so_thue}}</td>
                <td>{{$giamtrugiacanh->quan_he}}</td>
                <td>{{$giamtrugiacanh->thoi_diem_bat_dau}}</td>
                <td>{{$giamtrugiacanh->thoi_diem_ket_thuc}}</td>
                <td align="center">
                  <a href="#" data-toggle="modal" data-target="{{ '#modal-update-giamtrugiacanh-' . $giamtrugiacanh->id }}">
                    <i class="fa fa-edit" ></i>
                  </a>
                  @include('nhansu.giamtrugiacanh.edit')
                </td>
                <td align="center">
                  <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-giamtrugiacanh-' . $giamtrugiacanh->id }}">
                    <i class="fa fa-trash-o"></i>
                  </a>
                @include('nhansu.giamtrugiacanh.delete')
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              @if (count($data) > 10)
              <tr>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 20%;">Họ tên người phụ thuộc</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Ngày sinh</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Giới tính</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">CMTND</th> 
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Mã số thuế</th> 
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Quan hệ gia đình</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Thời điểm giảm trừ</th>
                <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Thời điểm kết thúc giảm</th>
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
@endsection