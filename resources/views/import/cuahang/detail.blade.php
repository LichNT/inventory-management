@extends('layouts.form') 

@section('content')
  <h2 class="page-header">
      CHI TIẾT FILE IMPORT - {{$file_import->name}}   
      <small class="pull-right bg-maroon label flat">{{$file_import->updated_at}}</small>                                                      
  </h2>
  
  <div class="box">
      <!-- /.box-header -->
      <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
          <div class="row">
            <div class="col-md-6">
              @component('components.perpage',['options' => [10, 20, 50, 100], 'default'=> 10, 'data' => $data, 'routerName' => 'detail.cuahang', 'id' => $file_import->id])
              @endComponent
            </div>
            <div class="col-md-6">
              @include('import.cuahang.box-search')
            </div>            
          </div>
          <br/>
          <div class="row">
            <div class="col-sm-12">
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody class="nhansu-list-tbody">
                    <tr>
                      <th class="text" >Mã</th>
                      <th class="text">Tên cửa hàng</th>
                      <th class="text">Tên địa điểm</th>
                      <th class="text">Chi nhánh</th>
                      <th class="text">Tỉnh</th>
                      <th class="text">Địa chỉ</th>
                      <th class="text">Ngày đăng kí KD</th>
                      <th class="text">Ngày khai trương</th>
                      <th class="text">Ngày bán hàng</th>
                      <th class="boolen" style="width:8%;">Kết quả import</th>
                      <th class="text" style="width:7%;">Mô tả lỗi</th>
                      <th class="text" style="width:5%;" colspan="3"></th>
                    </tr>
                    @foreach ($data as $cuahang)
                    <tr role="row">                  
                      <td class="text">{{$cuahang->ma}}<a/></td>
                      <td class="text">{{$cuahang->ten}}</td>
                      <td class="text">{{$cuahang->ten_dia_diem}}</td>
                      <td class="text">{{$cuahang->chiNhanh->ten}}</td>
                      <td class="text">{{$cuahang->tinh->ten}}</td>
                      <td class="text">{{$cuahang->dia_chi}}</td>
                      <td class="text">{{$cuahang->ngay_dang_ki_kinh_doanh}}</td>
                      <td class="text">{{$cuahang->ngay_khai_truong}}</td>
                      <td class="text">{{$cuahang->ngay_ban_hang}}</td>
                      <td class="boolen">
                          @if($cuahang->active)
                            <span class="label bg-olive block flat">Đã import</span>                                 
                          @else
                            <span class="label bg-maroon block flat">Chưa import</span>                  
                          @endif
                      </td>
                      <td>
                        @component('components.label',['data'=> $cuahang->mo_ta])
                        @endcomponent
                      </td>
                      <td align="center">
                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-import-cuahang-' . $cuahang->id }}">
                          <i class="fa fa-edit"></i>
                        </a>
                        @include('import.cuahang.edit',[ 'cuahang' => $cuahang])
                      </td>
                      <td align="center">
                        <a href="#" data-toggle="modal" data-target="{{ '#modal-detete-import-cuahang-' . $cuahang->id }}">
                          <i class="fa fa-trash-o"></i>
                        </a>
                        @include('import.cuahang.deletedetail',['cuahang' => $cuahang])
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <br/> 
          @component('components.pagination', ['pageShow' => 3, 'data' => $data])
          @endComponent
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">          
          <a href="{{route('import.cuahang')}}" id="btnback" class="btn btn-default btn-flat">
            <i class="fa fa-undo"></i> {{__('button.back')}}
          </a>
      </div>
    </div>
@endsection

@section('script')

@endsection
