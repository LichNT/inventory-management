@extends('layouts.form') 
@section('content')
<h2 class="page-header">
        TÔNG HỢP NHÂN SỰ                                             
    </h2>
    <div class="row">
        <div class="col-md-12">
            <!-- Donut chart -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <i class="fa ion-pie-graph"></i>
                    <h3 class="box-title">Bảng đối chiếu phục vụ quyết toán thuế TNCN</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                       <form >    
                        <div class="row">
                            <div class=" col-md-2 ">
                                <label  class="control-label">Năm</label>
                                <input type="number" id="year" class="form-control " value="{{empty($search_time_start)?"":date_format(date_create($search_time_start),'Y')}}"  min="1900" max="2200">
                            </div>
                            <div class="col-md-2 ">
                                <label  class=" control-label"> </label>
                                <select class="form-control" id="loai" >
                                    <option >Chọn</option>
                                    <option value=1>Cả năm</option>
                                    <option value=2>6 tháng đầu năm</option>
                                    <option value=3>6 tháng cuối năm</option>
                                </select>
                            </div>
                            <div class="col-md-2 ">
                                <label  class=" control-label">Từ </label>
                                <input type="text" id="search_time_start" class="form-control monthmask"  value="{{empty($search_time_start)?"":date_format(date_create($search_time_start),'m/Y')}}" name="search_time_start" readonly >
                            </div>
                            <div class="col-md-2 ">
                                <label  class="col-sm-3 control-label">Đến</label>
                                <input type="text" id="search_time_end" class="form-control monthmask "  value="{{empty($search_time_end)?"":date_format(date_create($search_time_end),'m/Y')}}" name="search_time_end" readonly >
                            </div>
                            <div class="col-md-4 ">
                                <br/>
                                <button type="submit" id="submit" class="btn bg-olive btn-flat margin">
                                    <i class="fa ">  Xuất dữ liệu</i>
                                </button>
                                <button type="button" class="btn bg-olive btn-flat" id="btnXuatExcel" onclick="download('/nhansu/thuethunhapcanhan','btnXuatExcel',[])">
                                    <i class="fa fa-file-excel-o">  Xuất excel</i>
                                </button>
                            </div>
                        </div>
                        </form>
                         <br/>
                         <div class="row">
                            <div class="col-sm-6">
                                @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu.hopdonghethan'])
                                @endComponent
                            </div>
                            <div class="col-sm-6">
                                @include('report.box-search-thue')
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <div class="row">
                        
                            <div class="col-sm-12">
                                <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                                    <thead>
                                    <tr role="row">
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">MST</th>
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Họ tên</th>
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Thời hạn HĐLĐ</th>
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Số tháng làm việc</th>
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Giảm trừ bản thân 9tr/1th</th>
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Số người phụ thuộc</th>
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;">Tên người phụ thuộc</th>
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;"> Mã số thuế người phụ thuộc</th>
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;"> Năm sinh</th>
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;"> Quan hệ</th>
                                        <th tabindex="0" rowspan="1" colspan="1" style="width: 10%;"> Thời điểm đăng ký</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                  
                                        @foreach($data as $key => $nhansu) 
                                                                           
                                        @if(count($nhansu->chiTietGiamTruGiaCanhs)!=0)
                                        
                                        @foreach( $nhansu->chiTietGiamTruGiaCanhs as $key=> $giamtrugiacanh)
                                        <tr >
                                            @if($key==0)          
                                            <td rowspan="{{count($nhansu->chiTietGiamTruGiaCanhs)}}">{{$nhansu->ma_so_thue}}</td>
                                            <td rowspan="{{count($nhansu->chiTietGiamTruGiaCanhs)}}">{{$nhansu->ho_ten}}</td>
                                            <td rowspan="{{count($nhansu->chiTietGiamTruGiaCanhs)}}">{{$nhansu->loai_hop_dong}}</td>
                                            <td rowspan="{{count($nhansu->chiTietGiamTruGiaCanhs)}}">{{$nhansu['so_thang_lam_viec']}}</td>
                                            <td rowspan="{{count($nhansu->chiTietGiamTruGiaCanhs)}}">{{($nhansu['so_thang_lam_viec']==0)?'0':'9'}}</td>
                                            <td rowspan="{{count($nhansu->chiTietGiamTruGiaCanhs)}}">{{count($nhansu->chiTietGiamTruGiaCanhs)}}</td>
                                            @endif                                        
                                            <td>{{$giamtrugiacanh->ho_ten}}</td>
                                            <td>{{$giamtrugiacanh->ma_so_thue}}</td>
                                            <td>@component('components.format',['date'=>$giamtrugiacanh->ngay_sinh]) @endcomponent</td>
                                            <td>{{$giamtrugiacanh->quan_he}}</td>
                                            <td>@component('components.format',['date'=>$giamtrugiacanh->thoi_diem_bat_dau]) @endcomponent</td>
                                        </tr>   
                                        @endforeach
                                        @else
                                        <tr >
                                           
                                            <td >{{$nhansu->ma_so_thue}}</td>
                                            <td >{{$nhansu->ho_ten}}</td>
                                            <td >{{$nhansu->loai_hop_dong}}</td>
                                            <td>{{$nhansu['so_thang_lam_viec']}}</td>
                                            <td>{{($nhansu['so_thang_lam_viec']!=0)?$giam_tru_ban_than:'0'}}</td>
                                            <td>0</td>
                                            <td>---</td>
                                            <td>---</td>
                                            <td>---</td>
                                            <td>---</td>
                                            <td>---</td> 
                                        </tr> 
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                    </div>
                </div>
                @component('components.pagination', ['pageShow' => 3, 'data' => $data])
                @endComponent
                <!-- /.box-body-->
                <div class="box-footer">
                    <a href="{{route('report')}}" id="btnback" class="btn btn-default btn-flat">
                        <i class="fa fa-undo"></i> {{__('button.back')}}
                    </a>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <input type="hidden" id="chi_nhanh_hidden" data="{{$chinhanhs}}">
    <input type="hidden" id="tinh_hidden" data="{{$tinhs}}">
    <input type="hidden" id="cua_hang_hidden" data="[]">
    <input type="hidden" id="nhan_su" data="[]">
@endsection

@section('script')
    <script src="{{asset('js/downloadexcel.js')}}"></script>
    <script src="{{ asset('js/dkChamCong.js') }}"></script>
    <script src="{{asset('js/nhansu/thueTNCN.js')}}"></script>
@endsection


