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
              @component('components.perpage',['options' => [10, 20, 50, 100], 'default'=> 10, 'data' => $data, 'routerName' => 'detail', 'id' => $file_import->id])
              @endComponent
            </div>
            <div class="col-md-6">
              @include('import.box-search')
            </div>            
          </div>
          <br/>
          <div class="row">
            <div class="col-sm-12">
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tbody class="nhansu-list-tbody">
                    <tr>
                      <th class="text">Họ và Tên</th>
                      <th class="text" >CMND</th>
                      <th class="text">Mã số thuế</th>
                      <th class="text">Tài khoản ngân hàng</th>
                      <th class="text">Ngày học việc</th>
                      <th class="text">Ngày thử việc</th>
                      <th class="text">Ngày chính thức</th>
                      <th class="text">Ngày nghỉ việc</th>
                      <th class="text">Ngày nghỉ thai sản</th>
                      <th class="text">Ngày đi làm sau thai sản</th>
                      <th class="text">Ngày sinh</th>
                      <th class="text">Ngày cấp CMND</th>
                      <th class="text">Tháng đóng BHXH</th>
                      <th class="text">Tháng chuyển BH về CN</th>
                      <th class="text">Tháng dừng đóng BH</th>
                      <th class="boolen" style="width:10%;">Kết quả import</th>
                      <th class="text" style="width:10%;">Mô tả lỗi</th>
                      <th class="text" style="width:5%;" colspan="3"></th>
                    </tr>
                    @foreach ($data as $nhansu)
                    <tr role="row">                  
                      <td class="text"><a href="#" data-toggle="modal" data-target="{{ '#modal-update-import-nhansu-' . $nhansu->id }}">{{$nhansu->ho_ten}}<a/></td>
                      <td class="text">{{$nhansu->cmnd}}</td>
                      <td class="text">{{$nhansu->ma_so_thue}}</td>
                      <td class="text">{{$nhansu->tai_khoan_ngan_hang}}</td>
                      <td class="text">{{$nhansu->ngay_hoc_viec}}</td>
                      <td class="text">{{$nhansu->ngay_thu_viec}}</td>
                      <td class="text">{{$nhansu->ngay_chinh_thuc}}</td>
                      <td class="text">{{$nhansu->ngay_nghi_viec}}</td>
                      <td class="text">{{$nhansu->nghi_thai_san}}</td>
                      <td class="text">{{$nhansu->di_lam_sau_thai_san}}</td>
                      <td class="text">{{$nhansu->ngay_sinh}}</td>
                      <td class="text">{{$nhansu->ngay_cap}}</td>
                      <td class="text">{{$nhansu->thang_dong_bh}}</td>
                      <td class="text">{{$nhansu->thang_chuyen_bh_ve_cn}}</td>
                      <td class="text">{{$nhansu->thang_dung_dong_bao_hiem}}</td>
                      <td class="boolen">
                          @if($nhansu->active)
                            <span class="label bg-olive block flat">Đã import</span>
                          @else
                            <span class="label bg-maroon block flat">Chưa import</span>
                          @endif
                      </td>
                      <td>
                        @component('components.label',['data'=> $nhansu->mo_ta]) 
                        @endcomponent
                      </td>
                      <td align="center">
                        <a href="#" data-toggle="modal" data-target="{{ '#modal-update-import-nhansu-' . $nhansu->id }}">
                          <i class="fa fa-edit"></i>
                        </a>  
                        @include('import.edit',[ 'importnhansu' => $nhansu])                                      
                      </td>
                      <td align="center">
                        <a href="#" data-toggle="modal" data-target="{{ '#modal-detete-import-nhansu-' . $nhansu->id }}">
                          <i class="fa fa-trash-o"></i>
                        </a>                    
                        @include('import.deletedetail',['importnhansu' => $nhansu])                                                            
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
          <a href="{{route('import')}}" id="btnback" class="btn btn-default btn-flat">
            <i class="fa fa-undo"></i> {{__('button.back')}}
          </a>
      </div>
    </div>
@endsection

@section('script')

@endsection
