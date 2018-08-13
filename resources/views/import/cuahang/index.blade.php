@extends('layouts.app') 

@section('css')

@endsection 

@section('title')
  <h1>IMPORT THÔNG TIN CỬA HÀNG</h1>
@endsection

@section('content')
<div class="box">
  <div class="box-header">     
    <div class="row">
      <div class="col-xs-12 pull-right">
        <form action="{{ route('upload.cuahang') }}" id="form_import" method="POST"  enctype="multipart/form-data" onsubmit="document.getElementById('submit').disabled=true">
          {{ csrf_field() }}
            <button type="button" id="btnXuatExcel" class="btn bg-default btn-flat margin" onclick="download('{{route('download.template.cuahang')}}',null,null)">
              <i class="fa fa-file-excel-o"> File excel mẫu</i>
            </button>
            <div class="btn bg-olive btn-file btn-flat margin">
              <i class="fa fa-paperclip"></i> Chọn file excel
              <input type="file"  name="import_excel" onchange="form.submit()" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
            </div>            
        </form>
      </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-md-6">
          @component('components.perpage',['options' => [10, 20, 50, 100], 'default'=> 10,'perPage' => $perPage, 'data' => $data, 'routerName' => 'import.cuahang'])
          @endComponent
        </div>
        <div class="col-sm-6">
          <div id="search" class="dataTables_filter">
            @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'import.cuahang', 'search' => (empty($search) ? null : $search)])
            @endComponent
          </div>
        </div>
      </div>
      <br/>
      <div class="row">
        <div class="col-sm-12">
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tbody class="nhansu-list-tbody">
                <tr>
                  <th class="text" style="width:20%;" >Tên file</th>
                  <th class="text" style="width:10%;text-align:center" >Số dòng</th>
                  <th class="text" style="width:10%;text-align:center" >Đã tạo hồ sơ</th>
                  <th class="text" style="width:10%;text-align:center" >Chưa tạo hồ sơ</th>
                  <th class="text" style="width:10%;">Ngày tạo</th>
                  <th class="text" style="width:10%;">Người tạo</th>
                  <th class="text" style="width:10%;text-align:center">Tải file </th>
                  <th style="width:10%;text-align:center">Trạng thái tạo hồ sơ</th>
                  <th style="width:10%;text-align:center">Xóa</th>
                </tr>
                @foreach ($data as $file)
                <tr role="row">
                  <td><a href="{{route('detail.cuahang',$file->id)}}">{{$file->name}}</a></td>
                  <td style="text-align:center"><a href="{{route('detail.cuahang',$file->id)}}">{{$file->detailCuaHangs->count()}}</a></td>
                  <td style="text-align:center"><a href="{{route('detail.cuahang',$file->id) . '?search=&active=1'}}">{{$file->detailCuaHangs->where('active', true)->count()}}</a></td>
                  <td style="text-align:center"><a href="{{route('detail.cuahang',$file->id) . '?search=&active=0'}}">{{$file->detailCuaHangs->where('active', false)->count()}}</a></td>
                  <td>{{$file->updated_at->format('d/m/Y h:m:s')}}</td>
                  <td>{{empty($file->user)?null:$file->user->name}}</td>
                  <td align="center"> <a href="{{url('download/import/'. $file->file_id)}}" >
                      <i class="fa fa-download"></i>
                    </a></td>
                  <td align="center">
                    @if($file->active)
                      <span class="label bg-navy block flat">Đã tạo</span> 
                    @else                    
                      <a href="{{route('import.cuahang.add', $file->id)}}" >
                        <span class="label bg-olive block flat">Tạo dữ liệu</span>
                      </a>
                    @endif
                  </td>
                  <td align="center">
                      <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-import-' . $file->id }}">
                        <span class="label bg-navy block flat"><i class="fa fa-trash-o"></i> Xóa</span>   
                      </a>
                      @include('import.cuahang.delete')
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
  <!-- /.box-body -->
</div>
@endsection 

@section('script') 
@endsection
