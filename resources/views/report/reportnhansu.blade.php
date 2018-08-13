@extends('layouts.form') 

@section('content')
    <h2 class="page-header">
        BẢNG TỔNG HỢP NHÂN SỰ THẾ GIỚI SỮA                                                
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
            <div class="col-md-4">
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn bg-olive btn-flat" id="btnXuatExcel" onclick="download('/report/nhansu','btnXuatExcel',null)">
                    <i class="fa fa-file-excel-o"> Xuất excel</i>
                </button>
            </div>
        </div>
    </form>

    <div class="row" style="overflow: scroll;">
        <div class="col-sm-12">
            <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                <thead>
                    <tr role="row">
                        <th rowspan="5" style="width: 10%;">Vị trí Công tác</th>
                        @foreach($data[1]['chinhanh'] as $chinhanh )
                       
                                <th colspan="5">{{$chinhanh['ten']}}</th>
                           
                        @endforeach
                        
                    </tr>
                    
                    <tr>
                    @foreach($data[1]['chinhanh'] as $chinhanh )
                        <th class="text" style="width:2%; text-align: center">Chính thức</th>
                        <th class="text" style="width:2%; text-align: center">Thử việc</th>
                        <th class="text" style="width:2%; text-align: center">Học việc</th>
                        <th class="text" style="width:2%; text-align: center">Nghỉ việc</th>
                        <th class="text" style="width:2%; text-align: center">Tổng</th>
                    @endforeach
                    </tr>
                </thead>
                <tbody>
                
                   @foreach($data as $bophan)
                   <tr>
                   <td>{{$bophan['bophan']}}</td>
                   @foreach($bophan['chinhanh'] as $chinhanh)
                        
                        <td>{{$chinhanh['chinh_thuc']}}</td>
                        <td>{{$chinhanh['thu_viec']}}</td>
                        <td>{{$chinhanh['hoc_viec']}}</td>
                        <td>{{$chinhanh['nghi_viec']}}</td>
                       <td>{{$chinhanh['tong']}}</td>
                       
                    @endforeach
                    </tr>
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


