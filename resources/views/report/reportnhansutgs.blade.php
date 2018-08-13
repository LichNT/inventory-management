@extends('layouts.form')

@section('content')
    <h2 class="page-header">
        BẢNG TỔNG HỢP NHÂN SỰ THẾ GIỚI SỮA
    </h2>

    <form>
        <div class="row">
            <div class=" col-md-2">
                <label class="control-label">Từ ngày</label>
                <input type="text" class="form-control datemask" id="search_time_start" value="{{empty($search_time_start)?"":date_format(date_create($search_time_start),config('app.format_date'))}}" name="search_time_start" tabindex="5">
            </div>
            <div class="col-md-2">
                <label class="control-label">Đến ngày</label>
                <input type="text" id="search_time_end" class="form-control datemask"  value="{{empty($search_time_end)?"":date_format(date_create($search_time_end),config('app.format_date'))}}" name="search_time_end" tabindex="4">
            </div>

            <div class="col-md-2">
                <label  class="control-label">{{$ten_hien_thi_mien}}</label>
                @component('components.select2', ['data' => $miens,'value'=>'id' ,
                'text' => 'ten', 'name' => 'search_mien',
                'none_required' => true,
                'id'=>'mien_moi',
                'idSelected'=>$search_mien,
                 ])
                @endcomponent
            </div>
            <div class="col-md-2">
                <label  class="control-label">{{$ten_hien_thi_chi_nhanh}}</label>
                @component('components.select2', ['data' => $chinhanhs,'value'=>'id' ,'text' => 'ten',
                'name' => 'search_chi_nhanh',
                'none_required' => true,
                'id'=>'chi_nhanh_moi',
                'idSelected'=>$search_chi_nhanh
                ])
                @endcomponent
            </div>
            <div class="col-md-2">
                <label  class="control-label">{{$ten_hien_thi_tinh}}</label>
                @component('components.select2', [
                'data' => $tinhs,
                'value'=>'id' ,'text' => 'ten',
                'name' => 'search_tinh',
                'none_required' => true,
                'id'=>'tinh_moi',
                'idSelected'=>$search_tinh
                ])
                @endcomponent
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-1">
                <button type="submit" class="btn btn-flat bg-olive pull-left">
                    <i class="fa fa-refresh"> {{__('button.xuat_bao_cao')}}</i>
                </button>
            </div>
            <div class="col-md-1" style="margin-left: 30px">
                <button type="button" class="btn bg-olive btn-flat" id="btnXuatExcel" onclick="download()">
                    <i class="fa fa-file-excel-o"> Xuất excel</i>
                </button>
            </div>
        </div>
    </form>

    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-md-6">
                    @component('components.perpage',['options' => [10, 20, 50, 100], 'default'=> 10,'perPage' => $perPage, 'data' => $data, 'routerName' => 'report.nhansuTGS'])
                    @endComponent
                </div>
                <div class="col-sm-6">
                    <div id="search" class="dataTables_filter">
                        @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'report.nhansuTGS', 'search' => (empty($search) ? null : $search)])
                        @endComponent
                    </div>

                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th class="text">Tỉnh</th>
                                <th class="text">Mã</th>
                                <th class="text">Họ tên</th>
                                <th class="text">Chức vụ</th>
                                <th class="text">Bộ phận</th>
                                <th class="text">Cửa hàng</th>
                                <th class="text">Tình trạng</th>
                                <th class="text">Ngày học việc</th>
                                <th class="text">Ngày thử việc</th>
                                <th class="text">Ngày chính thức</th>
                                <th class="text">Ngày nghỉ việc</th>
                                <th class="text">Lương CB</th>
                                <th class="text">Trách nhiệm</th>
                                <th class="text">PC ăn ca</th>
                                <th class="text">PC khác</th>
                                <th class="text">Số TK</th>
                                <th class="text">Chi nhánh ngân hàng</th>
                                <th class="text">Ngày sinh</th>
                                <th class="text">CMND</th>
                                <th class="text">Ngày cấp</th>
                                <th class="text">Nơi cấp</th>
                                <th class="text">Hộ khẩu</th>
                                <th class="text">Địa chỉ</th>
                                <th class="text">Số sổ BHXH</th>
                                <th class="text">Tháng bắt đầu đóng BH</th>
                                <th class="text">Tháng chuyển BH về CN</th>
                                <th class="text">Tháng dừng đóng BH</th>
                                <th class="text">Mã số thuế</th>
                                <th class="text">Số NPT</th>
                                <th class="text">Số ĐT</th>
                                <th class="text">Email</th>
                                <th class="text">Trình độ</th>
                                <th class="text">Chuyên ngành</th>
                            </tr>
                            @foreach ($data as $nhansu)
                                <tr role="row">
                                    <td align="center">
                                        {{isset($nhansu->tinh->ten) ? $nhansu->tinh->ten : '--'}}
                                    </td>
                                    <td class="text">{{$nhansu->ma}}</td>
                                    <td class="text">{{$nhansu->ho_ten}}</td>
                                    <td align="center">
                                        {{isset($nhansu->chucVu) ? $nhansu->chucVu->ten : '--'}}
                                    </td>
                                    <td align="center">
                                        {{isset($nhansu->boPhan) ? $nhansu->boPhan->ten : '--'}}
                                    </td>
                                    <td align="center">
                                        {{isset($nhansu->cuaHang) ? $nhansu->cuaHang->ten : '--'}}
                                    </td>
                                    <td align="center">
                                        {{isset($nhansu->loaiHopDong) ? $nhansu->loaiHopDong->ten : '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->ngay_hoc_viec) ? $nhansu->ngay_hoc_viec: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->ngay_thu_viec) ? $nhansu->ngay_thu_viec: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->ngay_chinh_thuc) ? $nhansu->ngay_chinh_thuc: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->ngay_nghi_viec) ? $nhansu->ngay_nghi_viec: '--'}}
                                    </td>
                                    <td class="text">
                                        --
                                    </td>
                                    <td class="text">
                                        --
                                    </td>
                                    <td class="text">
                                        --
                                    </td>
                                    <td class="text">
                                        --
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->tai_khoan_ngan_hang) ? $nhansu->tai_khoan_ngan_hang: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->chi_nhanh_ngan_hang) ? $nhansu->chi_nhanh_ngan_hang: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->ngay_sinh) ? $nhansu->ngay_sinh: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->cmnd) ? $nhansu->cmnd: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->ngay_cap) ? $nhansu->ngay_cap: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->noi_cap) ? $nhansu->noi_cap: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->ho_khau_thuong_tru) ? $nhansu->ho_khau_thuong_tru: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->cho_o_hien_tai) ? $nhansu->cho_o_hien_tai: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->so_so_bao_hiem) ? $nhansu->so_so_bao_hiem: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->chiTietBaoHiemHienTai->thang_bat_dau) ? $nhansu->chiTietBaoHiemHienTai->thang_bat_dau: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->chiTietBaoHiemHienTai->thang_chuyen_bao_hiem_ve_chi_nhanh) ? $nhansu->chiTietBaoHiemHienTai->thang_chuyen_bao_hiem_ve_chi_nhanh: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->chiTietBaoHiemHienTai->thang_dung_dong_bao_hiem) ? $nhansu->chiTietBaoHiemHienTai->thang_dung_dong_bao_hiem: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->ma_so_thue) ? $nhansu->ma_so_thue: '--'}}
                                    </td>
                                    <td class="text">
                                        {{App\ChiTietGiamTruGiaCanh::query()->where('id_nhan_su',$nhansu->id)->where(function ($query){$query->orWhere('thoi_diem_ket_thuc','>=', Carbon\Carbon::now());
                        $query->orWhere('thoi_diem_ket_thuc',null);})->count()}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->so_dien_thoai) ? $nhansu->so_dien_thoai: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->email) ? $nhansu->email: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->trinhDoVanHoa->ten) ? $nhansu->trinhDoVanHoa->ten: '--'}}
                                    </td>
                                    <td class="text">
                                        {{isset($nhansu->trinhDoChuyenMon->ten) ? $nhansu->trinhDoChuyenMon->ten: '--'}}
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
        <div class="box-footer">
            <a href="{{route('report')}}" id="btnback" class="btn btn-default btn-flat">
                <i class="fa fa-undo"></i> {{__('button.back')}}
            </a>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/report/exportnhansuTGS.js')}}"></script>
    <script src="{{ asset('js/nhansu/changeMien.js') }}"></script>
@endsection

