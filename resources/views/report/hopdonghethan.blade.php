@extends('layouts.app')

@section('title')
  <h1>DANH SÁCH HỢP ĐỒNG HẾT HẠN TRONG THÁNG</h1>
@endsection

@section('content')
  <div>
    <div class="box">
      <div class="box-header">
        <button type="button" class="btn bg-olive btn-flat margin" id="btnXuatExcel" onclick="download('/nhansu/hopdonghethan/exports/excel','btnXuatExcel',null)">
            <i class="fa fa-file-excel-o"> Xuất excel</i>
        </button>
      </div>             
      <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
          <div class="row">
            <div class="col-sm-6">
                @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu.hopdonghethan'])
                @endComponent
            </div>
            <div class="col-sm-6">
                @include('report.box-search')
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                <thead>
                  <tr role="row">
                    <th style="width: 15%;">Tên nhân viên</th>
                    <th style="width: 15%;">Loại hợp đồng</th>
                    <th style="width: 15%;">Số quyết định</th>
                    <th style="width: 15%;">Ngày ký hợp đồng</th>
                    <th style="width: 15%;">Ngày hiệu lực</th>  
                    <th style="width: 15%;">Ngày hết hiệu lực </th>                  
                    <th style="width: 10%;">Trạng thái</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $hopdong)
                  <tr role="row" class="odd">
                    <td>{{empty($hopdong->nhansu->ho_ten)?null:$hopdong->nhansu->ho_ten}}</td>
                    <td>{{empty($hopdong->loaiHopDong)?null:$hopdong->loaiHopDong->ten}}</td>
                    <td>{{$hopdong->so_quyet_dinh}}</td>
                    <td>{{$hopdong->ngay_quyet_dinh}}</td>
                    <td>{{$hopdong->ngay_hieu_luc}}</td>
                    <td>{{$hopdong->ngay_het_hieu_luc}}</td>
                    <td>
                    @if ($hopdong->trang_thai)
                      <small class="label bg-olive flat block">{{__('system.active')}}</small>
                    @else
                      <small class="label bg-navy flat block">{{__('system.inactive')}}</small>
                    @endif
                  </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  @if (count($data) >= 10)
                  <tr>
                  <th style="width: 15%;">Tên nhân viên</th>
                    <th style="width: 15%;">Loại hợp đồng</th>
                    <th style="width: 10%;">Số hợp đồng</th>
                    <th style="width: 10%;">Ngày ký hợp đồng</th>
                    <th style="width: 10%;">Ngày hiệu lực</th>  
                    <th style="width: 10%;">Ngày hết hiệu lực </th>                  
                    <th style="width: 10%;">Trạng thái</th>
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
            <a class="btn btn-default btn-flat" href="{{route('report')}}"><i class="fa fa-undo"></i> {{__('button.back')}}</a>    
      </div>
    </div>    
  </div>
  
@endsection
@section('script')
    <script src="{{asset('js/downloadexcel.js')}}"></script>
    <script src="{{ asset('js/searchCuaHang.js') }}"></script>

@endsection
