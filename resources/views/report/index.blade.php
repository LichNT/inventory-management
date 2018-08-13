@extends('layouts.form') @section('content')
<h2 class="page-header">
    HỆ THỐNG BÁO CÁO
</h2>
<table class="table table-hover">
    <tbody>
        <tr>
            <th>Mã</th>
            <th>Tên báo cáo</th>
            <th>Mô tả</th>
        </tr>
        <tr>
            <td>
                <span class="label bg-olive flat">LU001</span>
            </td>
            <td>
                <a href="{{ route('report.nhansubophan')}}">Nhân sự bộ phận</a>
            </td>
            <td>
                <dl>
                    <dd>Báo cáo tổng hợp nhân sự theo từng bộ phận trong một khoảng thời gian.</dd>
                    <dd>Dữ liệu báo cáo theo sơ đồ tổ chức công ty: Miền, Chi nhánh, Tỉnh</dd>
                    <dt>Định dạng</dt>
                    <dd>
                        <i class="fa fa-file-excel-o fa-lg" style="color:green"></i>
                    </dd>
                </dl>
            </td>
        </tr>

        <tr>
            <td>
                <span class="label bg-maroon flat">LU004</span>
            </td>
            <td>
                <a href="{{route('report.nhansuTGS')}}">Nhân sự thế giới sữa</a>
            </td>
            <td>
                <dl>
                    <dd>Báo cáo tổng hợp nhân sự toàn công ty.</dd>
                    <dd>Dữ liệu báo cáo theo sơ đồ tổ chức công ty: Miền, Chi nhánh, Tỉnh</dd>
                    <dt>Định dạng</dt>
                    <dd>
                        <i class="fa fa-file-excel-o fa-lg" style="color:green"></i>
                    </dd>
                </dl>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label bg-olive flat">LU005</span>
            </td>
            <td>
                <a href="{{route('report.tonghopbaohiem')}}">Tổng hợp bảo hiểm</a>
            </td>
            <td>
                <dl>
                    <dd>Báo cáo tổng hợp tham gia bảo hiểm theo sơ đồ tổ chức trong một khoảng thời gian.</dd>
                    <dd>Dữ liệu báo cáo theo sơ đồ tổ chức công ty: Miền, Chi nhánh, Tỉnh</dd>
                    <dt>Định dạng</dt>
                    <dd>
                        <i class="fa fa-file-excel-o fa-lg" style="color:green"></i>
                    </dd>
                </dl>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label bg-maroon flat">LU006</span>
            </td>
            <td>
                <a href="{{route('report.baohiemthegioisuatheonam')}}">Danh sách tham gia bảo hiểm theo năm</a>
            </td>
            <td>
                <dl>
                    <dd>Tổng hợp danh sách tham gia bảo hiểm theo năm</dd>
                    <dd>Dữ liệu báo cáo theo sơ đồ tổ chức công ty: Miền, Chi nhánh, Tỉnh</dd>
                    <dt>Định dạng</dt>
                    <dd>
                        <i class="fa fa-file-excel-o fa-lg" style="color:green"></i>
                    </dd>
                </dl>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label bg-maroon flat">LU008</span>
            </td>
            <td>
                <a href="{{route('nhansu.hopdonghethan')}}">Hợp đồng sắp hết hạn</a>
            </td>
            <td>
                <dl>
                    <dd>Tổng hợp danh sách hợp đồng nhân sự sắp hết hạn trong tháng</dd>
                    <dd>Dữ liệu báo cáo theo sơ đồ tổ chức công ty: Miền, Chi nhánh, Tỉnh</dd>
                    <dt>Định dạng</dt>
                    <dd>
                        <i class="fa fa-file-excel-o fa-lg" style="color:green"></i>
                    </dd>
                </dl>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label bg-maroon flat">LU009</span>
            </td>
            <td>
                <a href="{{route('nhansu.thuethunhapcanhan')}}">Bảng đổi chiếu phục vụ quyết toán thuế TNCN</a>
            </td>
            <td>
                <dl>
                    <dd>Tổng hợp danh sách giảm trừ gia cảnh nhân sự </dd>
                    <dd>Dữ liệu báo cáo theo sơ đồ tổ chức công ty: Miền, Chi nhánh, Tỉnh</dd>
                    <dt>Định dạng</dt>
                    <dd>
                        <i class="fa fa-file-excel-o fa-lg" style="color:green"></i>
                    </dd>
                </dl>
            </td>
        </tr>
    </tbody>
</table>
@endsection @section('script')
<script src="{{asset('js/downloadexcel.js')}}"></script>
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script> @endsection