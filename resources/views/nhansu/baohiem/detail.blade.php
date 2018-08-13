@extends('nhansu.edit-layout')

@section('title_detail')
Lịch sử tham gia bảo hiểm
@endsection

@section('content_detail')
<div class="box-header">
  <form action="{{route('nhansu.updatenhansu', $nhansu->id)}}" method="POST" onsubmit="document.getElementById('submit').disabled=true">
      {{ csrf_field() }}   
      {{method_field('put')}}
      <div class="row">
          <div class="col-md-4">
              <label >Số sổ bảo hiểm</label>
              <input type="text" class="form-control  input-sm"  name="so_so_bao_hiem"
                     tabindex="1" value="{{$nhansu->so_so_bao_hiem}}" autofocus>          
          </div>
          <div class="col-md-4">
              <label >Số thẻ bảo hiểm</label>
              <input type="text" class="form-control  input-sm"   name="so_the_bao_hiem"
                      tabindex="2" value="{{$nhansu->so_the_bao_hiem}}">
          </div>
          {{-- <div class="col-md-4">
          <br>
              @component('components.checkbox', [
                  'title' => 'Tham gia bảo hiểm',
                  'name' => 'tham_gia_bao_hiem',                                 
                  'value_checked' => 1,                  
                  'value_unchecked' => 0,                  
                  'value' => $nhansu->tham_gia_bao_hiem, 
                  'tabindex' => 3,      
              ])
              @endcomponent          
          </div>      --}}
      </div>
      <div class="row">
        <div class="col-md-12">
            <button type="submit" id="submit" class="btn btn-flat bg-olive pull-right btn-sm">
                <i class="fa fa-check"></i> {{__('button.edit')}}
            </button>
        </div>                            
      </div>
  </form>  
  <hr> 
  <div class="row">     
    <div class="col-xs-12 pull-right">
      <a href="#" data-toggle="modal" data-target="#modal-add-baohiem" class="btn btn-flat bg-olive">
        <i class="fa fa-plus"> Thêm mới</i>
      </a>   
      @include('nhansu.baohiem.create')  
    </div>
  </div>
  </div>             
  <div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-6">
            @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu.update.baohiem','id'=>$nhansu->id])
            @endComponent
        </div>
        <div class="col-sm-6">
          <div id="search" class="dataTables_filter">
            @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'nhansu.update.baohiem','id'=> $nhansu->id, 'search' => (empty($search)?null:$search)])
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
                <th>Tên bảo hiểm</th>
                <th>Tỉnh thành</th>
                <th>Tháng bắt đầu</th>
                <th>Tháng chuyển bảo hiểm về CN</th>
                <th>Tháng dừng đóng BH</th>  
                <th>Mức đóng bảo hiểm xã hội</th>                  
                <th>Từ ngày </th>
                <th>Đến ngày</th>
                <th style="width: 5%;text-align: center">Chỉnh sửa</th>
                <th style="width: 5%;text-align: center">Xóa</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $baohiem)
              <tr role="row" class="odd">
                <td>{{empty($baohiem->nhanSu->ho_ten)?null:$baohiem->nhanSu->ho_ten}}</td>
                <td>{{$baohiem->ten}}</td>
                <td>{{$baohiem->tinhThanh->ten}}</td>
                <td>{{$baohiem->thang_bat_dau}}</td>
                <td>{{$baohiem->thang_chuyen_bao_hiem_ve_chi_nhanh}}</td>
                <td>{{$baohiem->thang_dung_dong_bao_hiem}}</td>
                <td>{{$baohiem->mucDongBaoHiem->ten}}</td>
                <td>{{$baohiem->tu_ngay}}</td>
                <td>{{$baohiem->toi_ngay}}</td>
                <td align="center">
                  <a href="#" data-toggle="modal" data-target="{{ '#modal-update-baohiem-' . $baohiem->id }}">
                    <i class="fa fa-edit" ></i>
                  </a>
                  @include('nhansu.baohiem.edit', ['baohiem' => $baohiem])
                </td>
                <td align="center">
                  <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-baohiem-' . $baohiem->id }}">
                    <i class="fa fa-trash-o"></i>
                  </a>
                @include('nhansu.baohiem.delete')
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              @if (count($data) >= 10)
              <tr>               
                <th>Tên nhân viên</th>
                <th>Tên bảo hiểm</th>
                <th>Tỉnh thành</th>
                <th>Tháng bắt đầu</th>
                <th>Tháng chuyển bảo hiểm về CN</th>
                <th>Tháng dừng đóng BH</th>  
                <th>Mức đóng bảo hiểm xã hội</th>                  
                <th>Từ ngày </th>
                <th>Đến ngày</th>
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