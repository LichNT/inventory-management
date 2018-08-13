@extends('layouts.app')

@section('title')
    <h1>DANH SÁCH BẢNG CHẤM CÔNG</h1>
@endsection

@section('content')
    <div>
        <div class="box">
            <div class="box-header">
                <div class="row">
                    @if (\Session::has('ten_bang'))
                    <div style="">
                        <a href="#" id="update-nhansu" data-toggle="modal" data-target="#modal-add-update-nhansu">
                        </a>
                        @include('luong.chamcong.update-nhansu')
                    </div>
                    @endif

                    <div class="col-xs-12 pull-right">
                        <a href="#" data-toggle="modal" data-target="#modal-add-chamcong" class="btn btn-flat bg-olive">
                            <i class="fa fa-plus"> Thêm mới</i>
                        </a> 
                        @include('luong.chamcong.add')                       
                    </div> 
                   
                </div>
            </div>
            <div class="box-body">
                <div class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-4">
                            @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'luong.chamcong'])
                            @endComponent
                        </div>
                        <div class="col-md-8">
                            @include('luong.chamcong.box-search')
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="text-align:center;">Năm</th>
                                    <th style="text-align:center;">Tháng</th>
                                    <th>Tên</th>
                                    <th style="text-align:center;">Ngày tạo</th>
                                    <th style="text-align:center;">Ngày cập nhật</th>
                                    <th style="text-align:center;">Người tạo</th>
                                    <th style="text-align:center;">Người cập nhật</th>
                                    <th style="text-align:center;">Đã khóa sổ</th>
                                    <th style="text-align:center;">Ngày khóa sổ</th>
                                    <th style="text-align:center;">Duyệt bảng lương</th>
                                    <th style="text-align:center;">Ngày duyệt</th>
                                    <th style="text-align:center;">Trả lương lần 1</th>
                                    <th style="text-align:center;">Trả lương lần 2</th>
                                    <th style="width: 5%; text-align: center">Chỉnh sửa</th>
                                    <th style="width: 5%; text-align: center;">Chi tiết chấm công</th>
                                    <th style="width: 5%; text-align: center;">Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td align="center">{{$item->nam}}</td>
                                        <td align="center">{{$item->thang}}</td>
                                        <td><a href="#" data-toggle="modal" data-target="{{ '#modal-update-chamcong-'.$item->id }}">{{$item->ten}}</a></td>
                                        <td align="center">{{$item->created_at}}</td>
                                        <td align="center">{{$item->updated_at}}</td>
                                        <td align="center">{{$item->nguoiTao->name}}</td>
                                        <td align="center">{{$item->nguoiSua->name}}</td>
                                        <td style="text-align:center;">
                                            @if ($item->khoa_so==false)
                                                <a href="#" data-toggle="modal" data-target="{{ '#modal-update-khoaso-'.$item->id }}">
                                                <small class="label bg-olive flat">Mở</small>
                                                </a>
                                                @if(Auth::user()->role->code=="ketoancongty"||Auth::user()->role->name=="admin")            
                                                    @include('luong.chamcong.khoaso')
                                                @endif
                                            @else
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-update-moso-'.$item->id }}">
                                                <small class="label bg-navy flat">Đã khóa</small>
                                                </a>
                                             
                                                @if(Auth::user()->role->code=="ketoancongty"||Auth::user()->role->name=="admin")   
                                                    @include('luong.chamcong.moso')
                                                @endif
                                            @endif
                                        </td>                                                                                                                 
                                        <td align="center">{{$item->ngay_khoa_so}}</td>
                                        <td style="text-align:center;">
                                            @if ($item->duyet_bang_luong)
                                                <a href="#" data-toggle="modal" data-target="{{ '#modal-update-boduyet-'.$item->id }}">
                                                <small class="label bg-navy flat">Đã duyệt</small>
                                                </a>
                                                @if(Auth::user()->role->code=="ketoancongty"||Auth::user()->role->name=="admin")
                                                 @include('luong.chamcong.boduyet')
                                                @endif
                                            @else
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-update-duyetbangluong-'.$item->id }}">
                                                <small class="label bg-olive flat">Chưa duyệt</small>
                                                </a>

                                                @if(Auth::user()->role->code=="ketoancongty"||Auth::user()->role->name=="admin")
                                                    @include('luong.chamcong.chitiet.duyetbangluong',['chamcong'=>$item])
                                                @endif
                                            @endif
                                        </td>
                                        <td align="center">{{$item->ngay_duyet}}</td>
                                        <td align="center">
                                            <a href="{{ URL::route('luong.chamcong.traluonglan1',$item->ten_bang)}}">
                                                <i class="fa fa-align-justify" ></i>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a {{($item->trang_thai_tra_luong_lan_1==1)?'href='.URL::route('luong.chamcong.traluonglan2',$item->ten_bang).'':null}}>
                                                <i class="fa fa-align-justify" ></i>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-update-chamcong-'.$item->id }}">
                                                <i class="fa fa-edit" ></i>
                                            </a>
                                            @include('luong.chamcong.edit')
                                        </td>

                                        <td align="center">
                                            <a href="{{ URL::route('luong.chamcong.chitiet',$item->ten_bang)}}">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </a>
                                        </td>
                                        <td align="center">
                                            <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-chamcong-' . $item->id }}">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            @include('luong.chamcong.delete')
                                        </td>
                                @endforeach

                                </tbody>
                                <tfoot>

                                @if (count($data) > 10)
                                    <tr>
                                        <th style="text-align:center;">Năm</th>
                                        <th style="text-align:center;">Tháng</th>
                                        <th>Tên</th>
                                        <th style="text-align:center;">Ngày tạo</th>
                                        <th style="text-align:center;">Ngày cập nhật</th>
                                        <th style="text-align:center;">Người tạo</th>
                                        <th style="text-align:center;">Người cập nhật</th>
                                        <th style="text-align:center;">Đã khóa sổ</th>
                                        <th style="text-align:center;">Ngày khóa sổ</th>
                                        <th style="text-align:center;">Trả lương</th>
                                        <th style="width: 5%; text-align: center">Chỉnh sửa</th>
                                        <th style="width: 5%; text-align: center;">Chi tiết chấm công</th>
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
        </div>
    </div>
@endsection
@section('script')    
    <script src="{{asset('js/updateChamCong.js')}}"></script>
    <script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
@endsection