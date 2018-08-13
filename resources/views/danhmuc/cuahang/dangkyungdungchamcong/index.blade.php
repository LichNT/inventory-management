@extends('layouts.app')

@section('title')
<h1 class="title_master_form">{{__('model.dang_ky_cham_cong_dien_thoai')}}</h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">           
            <div class="row">
                <div class="col-xs-12 pull-right">
                    <a href="#" data-toggle="modal" data-target="{{'#modal-add-dangkyungdungchamcong'}}" class="btn btn-flat bg-olive">
                        <i class="fa fa-plus"> Thêm mới</i>
                    </a>
                    @include('danhmuc.cuahang.dangkyungdungchamcong.add')
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6">
                        @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(), 'perPage' => $perPage, 'data' => $data, 'routerName' => 'dangkyungdungchamcong',])
                        @endComponent
                    </div>
                    <div class="col-sm-6">
                        @include('danhmuc.cuahang.dangkyungdungchamcong.box-search')
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped dataTable responsive-table">
                            <thead>
                            <tr>
                                <th >Họ tên</th>
                                <th>Ngày sinh</th>
                                <th>CMND</th>
                                <th>Mã</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>{{$ten_hien_thi_mien}}</th>
                                <th>{{$ten_hien_thi_chi_nhanh}}</th>
                                <th>{{$ten_hien_thi_tinh}}</th>
                                <th>Cửa hàng</th>
                                <th  style=" text-align: center" >Mã thẻ chấm công </th>
                                <th  style="width: 5%; text-align: center">Cấp mã thẻ</th>
                                <th  style="width: 5%; text-align: center">Chi tiết</th>
                                <th  style="width: 5%; text-align: center">Chỉnh sửa</th>
                                <th  style="width: 5%; text-align: center;">Xóa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $dangkyungdungchamcong)
                                <tr>
                                    <td >{{$dangkyungdungchamcong->ho_ten}}</td>
                                    <td>{{$dangkyungdungchamcong->ngay_sinh}}</td>
                                    <td>{{$dangkyungdungchamcong->cmnd}}</td>
                                    <td>{{$dangkyungdungchamcong->ma}}</td>
                                    <td>{{$dangkyungdungchamcong->so_dien_thoai}}</td>
                                    <td>{{$dangkyungdungchamcong->email}}</td>
                                    <td>{{$dangkyungdungchamcong->mien->ten}}</td>
                                    <td>{{$dangkyungdungchamcong->chinhanh->ten}}</td>
                                    <td>{{$dangkyungdungchamcong->tinh->ten}}</td>
                                    <td>{{$dangkyungdungchamcong->cuaHang->ten}}</td>
                                    <td style=" text-align: center">{{$dangkyungdungchamcong->ma_the_cham_cong}}</td>
                                    @if(!empty($dangkyungdungchamcong->ma_the_cham_cong))
                                        <td align="center">
                                            <a href="#" class="btn bg-olive btn-block flat btn-xs">
                                                <i class="fa fa-check-circle"> Đã cấp mã thẻ</i>
                                            </a>
                                        </td>
                                    @else
                                        <td align="center">
                                            <a href="#" class="btn bg-maroon btn-block flat btn-xs" >
                                                <i class="fa fa-exclamation"> Cấp thẻ chấm công </i>
                                            </a>
                                        </td>
                                    @endif
                                    @if(!empty($dangkyungdungchamcong->ma_the_cham_cong))
                                        <td align="center">
                                            <a href="{{route('dangkyungdungchamcong.chitiet', $dangkyungdungchamcong->ma_the_cham_cong)}}" >
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                        </td>
                                    @else
                                        <td align="center">
                                            <a href=# >
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                        </td>
                                    @endif
                                    <td align="center">
                                        <a href="#" data-toggle="modal" onclick="{{'showForm('.$dangkyungdungchamcong->id.')'}}" data-target="{{ '#modal-update-doanhso-' . $dangkyungdungchamcong->id }}">
                                            <i class="fa fa-edit"></i>
                                        </a>    
                                        @include('danhmuc.cuahang.dangkyungdungchamcong.detail')  
                                    </td>
                                
                                    <td align="center">
                                        <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-dangkyungdungchamcong-' . $dangkyungdungchamcong->id }}">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        @include('danhmuc.cuahang.dangkyungdungchamcong.delete') 
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                </div>
                <input type="hidden" id="chi_nhanh_hidden" data="{{$chinhanhs}}">
                <input type="hidden" id="tinh_hidden" data="{{$tinhs}}">
                <input type="hidden" id="cua_hang_hidden" data="{{$cuahangs}}">
                @component('components.pagination', ['pageShow' => 3, 'data' => $data])
                @endComponent
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/dkChamCong.js') }}"></script>
    <script src="{{ asset('js/confirmDangKyChamCong.js') }}"></script>
@endsection