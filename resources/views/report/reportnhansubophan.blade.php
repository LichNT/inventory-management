@extends('layouts.form') 

@section('content')
    <h2 class="page-header">
        BÁO CÁO NHÂN SỰ THEO BỘ PHẬN
    </h2>
    <form class="form-horizontal" id="search-form" role="form" action={{route('report.nhansubophan')}} method="GET">
        <div class="row">
                <div class=" col-md-2">
                    <label class="control-label">Từ ngày</label>
                    <input type="text" class="form-control datemask" id="search_time_start" value="{{empty($search_time_start)?"":date_format(date_create($search_time_start),'d/m/Y')}}" name="search_time_start" tabindex="5">
                </div>
                <div class="col-md-2">
                    <label class="control-label">Đến ngày</label>                             
                    <input type="text" id="search_time_end" class="form-control datemask"  value="{{empty($search_time_end)?"":date_format(date_create($search_time_end),'d/m/Y')}}" name="search_time_end" tabindex="4">
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
                <button type="button" class="btn bg-olive btn-flat" id="btnXuatExcel" onclick="download('/report/nhansubophan','btnXuatExcel',null)">
                    <i class="fa fa-file-excel-o"> {{__('button.xuat_excel')}}</i>
                </button>
            </div>    
        </div>        
    </form>
    <br/>
    <div class="row">
        <div class="col-sm-12">
            <table class="table">
                <thead>
                    <tr role="row">
                        <th colspan="1" class="text">Bộ phận</th>
                        <th colspan="1" class="text" style="width:15%; text-align: center">Số lượng</th>
                        <th colspan="1" class="text" style="width:15%; text-align: center">Chính thức</th>
                        <th colspan="1" class="text" style="width:15%; text-align: center">Thử việc</th>                            
                        <th colspan="1" class="text" style="width:15%; text-align: center">Học việc</th>
                        <th colspan="1" class="text" style="width:15%; text-align: center">Nghỉ việc</th>                                                                                                                          
                    </tr>
                    
                </thead>
                <tbody>
                @foreach($data as $key => $item)
                    <tr>
                        <td>{{$item->ten}}</td>
                        <td style="width:15%; text-align: center">{{$item->soluong}}</td>
                        <td style="width:15%; text-align: center">{{$item->chinhthuc}}</td>
                        <td style="width:15%; text-align: center">{{$item->thuviec}}</td>
                        <td style="width:15%; text-align: center">{{$item->hocviec}}</td>
                        <td style="width:15%; text-align: center">{{$item->nghiviec}}</td>                        
                    </tr>
                    @endforeach
                <tr>
                    <th style="color:red;">TỔNG CỘNG</th>
                    <th colspan="1" class="text" style="width:15%; text-align: center;">
                        {{$tong['soluong']}}
                    </th>
                    <th colspan="1" class="text" style="width:15%; text-align: center">{{$tong['chinhthuc']}}</th>
                    <th colspan="1" class="text" style="width:15%; text-align: center">{{$tong['thuviec']}}</th>
                    <th colspan="1" class="text" style="width:15%; text-align: center">{{$tong['hocviec']}}</th>
                    <th colspan="1" class="text" style="width:15%; text-align: center">{{$tong['nghiviec']}}</th>                
                </tr>
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
    <script src="{{ asset('js/nhansu/changeMien.js') }}"></script>
@endsection


