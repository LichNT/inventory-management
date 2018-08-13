@extends('layouts.form') 
@section('css')
<link rel="stylesheet" href="{{ asset('css/table-report.css') }}"> 
@endsection

@section('content')
    <h2 class="page-header">
        TÔNG HỢP BẢO HIỂM                                                
    </h2>

    <form>
        <div class="row">
            <div class=" col-md-4 ">
                <label class="control-label">Từ ngày</label>
                <input type="text" class="form-control datemask" id="search_time_start" value="{{empty($search_time_start)?"":date_format(date_create($search_time_start),config('app.format_date'))}}" name="search_time_start" tabindex="5">
            </div>
            <div class="col-md-4">
                <label class="control-label">Đến ngày</label>                             
                <input type="text" id="search_time_end" class="form-control datemask"  value="{{empty($search_time_end)?"":date_format(date_create($search_time_end),config('app.format_date'))}}" name="search_time_end" tabindex="4">
            </div>            
        </div>
        <br/>
        <div class="row">
            <div class="col-md-4">                                            
                <button type="submit" id="submit" class="btn bg-olive btn-flat">
                    <i class="fa fa-refresh">  Xuất dữ liệu</i>
                </button>                
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-sm-12">
            <table id="menus" class="table-report table table-bordered table-striped dataTable table-responsive" role="grid">
                <thead>
                    <tr role="row">
                        <th >{{$ten_hien_thi_chi_nhanh}}</th>
                        <th style=" text-align:center;">Tổng số lao động tham gia bảo hiểm</th>
                        <th style=" text-align:center;">Số lao động chính thức chưa đóng bảo hiểm</th>   
                        <th style=" text-align:center;">Tham gia bảo hiểm tại tỉnh</th>                                         
                        <th  class="text" style=" text-align: center">Số lao động tham gia bảo hiểm</th>
                        <th  class="text" style=" text-align: center">Mức lương trích nộp bảo hiểm</th>  
                        <th style=" text-align:center;">Quỹ lương BH</th>
                        <th style=" text-align:center;">Tổng quỹ lương</th>   
                        <th style=" text-align:center;">Số tiền bảo hiểm phải nộp</th>                                         
                        <th  class="text" style="text-align: center">Số tiền bảo hiểm công ty trích nộp</th>
                        <th  class="text" style=" text-align: center">Ghi chú</th>                                                     
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $ten => $chinhanh) 
                        @foreach($chinhanh as $key1=>$tinh)
                            @if(isset($tinh['tong_so_tham_gia_bao_hiem']))  
                                 
                                @if(count($tinh['muc'])>0)                       
                                    @foreach($tinh['muc'] as $key2=> $muc)
                                    <tr>       
                                        @if($key1=0&&$key2=0)  
                                            <td rowspan="{{$chinhanh['rowspan']}}">{{$chinhanh['ten']}}</td>
                                            <td rowspan="{{$chinhanh['rowspan']}}">{{$chinhanh['tong_so_tham_gia_bao_hiem_chi_nhanh']}}</td>
                                            <td rowspan="{{$chinhanh['rowspan']}}">{{$chinhanh['tong_so_khong_tham_gia_bao_hiem_chi_nhanh']}}</td>
                                        @endif                         
                                        @if($key2==0)   
                                           
                                           
                                            
                                            <td rowspan="{{count($tinh['muc'])}}">{{empty($tinh->ten)?null:$tinh->ten}}</td> 
                                        @endif
                                        
                                        <td>{{$muc['chi_tiet_bao_hiems_count']}}</td>
                                        <td>{{$muc['so_tien']}}</td>
                                        <td>{{$muc['so_tien']*$muc['chi_tiet_bao_hiems_count']}}</td>
                                        @if($key2==0)  
                                        <td rowspan="{{count($tinh['muc'])}}">{{$tinh['tong_quy_luong']}}</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                     @if($key1==0)   
                                        <td rowspan="{{$chinhanh['rowspan']}}">{{$chinhanh['ten']}}</td>
                                        <td rowspan="{{$chinhanh['rowspan']}}">{{$chinhanh['tong_so_tham_gia_bao_hiem_chi_nhanh']}}</td>
                                        <td rowspan="{{$chinhanh['rowspan']}}">{{$chinhanh['tong_so_khong_tham_gia_bao_hiem_chi_nhanh']}}</td>
                                    @endif
                                        <td >{{empty($tinh->ten)?null:$tinh->ten}}</td> 
                                       
                                </tr>
                                @endif
                               
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <a href="{{route('report')}}" id="btnback" class="btn btn-default btn-flat">
                <i class="fa fa-undo"></i> {{__('button.back')}}
            </a>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/downloadexcel.js')}}"></script> 
@endsection


