@extends('nhansu.edit-layout')

@section('title_detail')
    Lịch sử thay đổi nhân sự
@endsection

@section('content_detail')
    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-md-6">
                    @component('components.perpage',['options' => [10, 20, 50, 100], 'default'=> 10,'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu.update.lichsuthaydoi','id'=>$nhansu->id])
                    @endComponent
                </div>
                <div class="col-md-6">
                    <div id="search" class="dataTables_filter">
                        @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'nhansu.update.lichsuthaydoi','id'=>$nhansu->id, 'search' => (empty($search)?null:$search)])
                        @endComponent
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-responsive">
                            <tbody>
                            <tr>
                                <th class="text">Loại</th>                                                                                           
                                <th class="text">Ngày thay đổi</th>
                                <th class="text">Người thay đổi</th>
                                <th style="width:50%;">Nội dung thay đổi</th>
                                <th style="width:10%; text-align: center">Chi tiết</th>
                            </tr>
                            @foreach ($data as $log)
                                <tr role="row">
                                    <td>
                                        @if ($log->change_code == "C")
                                            <small class="label bg-olive flat block">Tạo mới</small>
                                        @elseif($log->change_code == "U")
                                            <small class="label bg-maroon flat block">Cập nhật</small>                                        
                                        @else
                                            <small class="label bg-navy flat block">Xóa</small>
                                        @endif
                                    </td>                                                                                                       
                                    <td>
                                        {{isset($log->updated_at) ? $log->updated_at : '--'}}
                                    </td>  
                                    <td>
                                        {{ $log->nguoiCapNhat->name}}
                                    </td>                                      
                                    <td>
                                        {{ $log->change_content}}
                                    </td>                                      
                                    <td align="center">
                                        <a href="{{route('nhansu.update.lichsuthaydoi.detail', $log->id)}}" >
                                            <i class="fa fa-edit"></i>
                                        </a>
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
@endsection
