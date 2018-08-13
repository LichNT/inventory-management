@extends('layouts.form') 
@section('css')
@endsection

@section('content')
    <h2 class="page-header">
        THỐNG KÊ BẢO HIỂM THEO NĂM                                         
    </h2>

    <form>
        <div class="row">
            <div class=" col-md-3 ">
                <label class="control-label">Từ ngày</label>
                <input type="text" class="form-control datemask" id="search_time_start" value="{{empty($search_time_start)?"":date_format(date_create($search_time_start),config('app.format_date'))}}" name="search_time_start" tabindex="5">
            </div>
            <div class="col-md-3">
                <label class="control-label">Đến ngày</label>                             
                <input type="text" id="search_time_end" class="form-control datemask"  value="{{empty($search_time_end)?"":date_format(date_create($search_time_end),config('app.format_date'))}}" name="search_time_end" tabindex="4">
            </div>  
            <div class="col-md-2">
                <label  class="control-label">{{$ten_hien_thi_mien}}</label>
                @component('components.select2', ['data' => $miens,'value'=>'id' ,
                'text' => 'ten', 'name' => 'search_mien', 
                'none_required' => true, 
                'id'=>'search_mien',
                'idSelected'=>$search_mien,
                    ])
                @endcomponent
            </div>
            <div class="col-md-2">
                <label  class="control-label">{{$ten_hien_thi_chi_nhanh}}</label>
                @component('components.select2', ['data' => $chinhanhs,'value'=>'id' ,'text' => 'ten', 
                'name' => 'search_chi_nhanh', 
                'none_required' => true,
                'id'=>'search_chi_nhanh',
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
                'id'=>'search_tinh',
                'idSelected'=>$search_tinh
                ])
                @endcomponent
            </div>
            <br>          
        </div>
        <br/>
        <div class="row">
            <div class="col-md-4">                                            
                <button type="submit" id="submit" class="btn bg-olive btn-flat">
                    <i class="fa fa-refresh">  Xuất dữ liệu</i>
                </button>
                <button type="button" class="btn bg-olive btn-flat" id="btnXuatExcel" onclick="download('/report/baohiemthegioisuatheonam','btnXuatExcel',null)">
                    <i class="fa fa-file-excel-o">  Xuất excel</i>
                </button> 
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-sm-12">
            <table id="menus" class="table table-responsive">
                <thead>
                    <tr>
                        <th>Họ và tên</th>
                        <th style=" text-align:center;">Mã nhân viên</th>
                        <th style=" text-align:center;">Số sổ bảo hiểm</th>   
                        <th style=" text-align:center;">Chức vụ</th>                                         
                        <th style=" text-align: center">{{$ten_hien_thi_chi_nhanh}}</th>
                        <th style=" text-align: center">Mức đóng 1</th>
                        <th style=" text-align: center">Tháng bắt đầu</th>
                        <th style=" text-align: center">Đến hết tháng</th> 
                        <th style=" text-align: center">Mức đóng 2</th>
                        <th style="text-align: center">Tháng bắt đầu</th>
                        <th style=" text-align: center">Đến hết tháng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $baohiem)
                    <tr>
                        <td>{{$baohiem['ho_ten']}}</td>
                        <td>{{$baohiem['ma']}}</td>
                        <td>{{$baohiem['so_so_bao_hiem']}}</td>
                        <td>{{$baohiem['chuc_vu']}}</td>
                        <td>{{$baohiem['chi_nhanh']}}</td>
                        <td>{{$baohiem['muc_1']}}</td>
                        <td>{{$baohiem['muc_1_tu_thang']}}</td>
                        <td>{{$baohiem['muc_1_den_thang']}}</td>
                        <td>{{$baohiem['muc_2']}}</td>
                        <td>{{$baohiem['muc_2_tu_thang']}}</td>
                        <td>{{$baohiem['muc_2_den_thang']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @component('components.pagination', ['pageShow' => 3, 'data' => $data])
            @endComponent
        </div>
        <div class="box-footer">
            <a href="{{route('report')}}" id="btnback" class="btn btn-default btn-flat">
                <i class="fa fa-undo"></i> {{__('button.back')}}
            </a>
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
@endsection


