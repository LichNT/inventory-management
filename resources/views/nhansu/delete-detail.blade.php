@extends('layouts.app')


@section('content')
    
    <form action="{{ route('nhansu.delete', $nhansu->id) }}" method="POST" >
    {{ csrf_field() }}
<div class="box">
    <div class="box-header">
        <h2 class="page-header">
            Xóa nhân sự
        </h2>
    </div>

    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <th class="text" style="width:20%;">Thông tin chi tiết </th>
                                    <th class="text" style="width:10%;">Số lượng </th>                                  
                                </tr>
                                    @if(count($nhansu->chiTietCongTacs)>0)
                                        <tr role="row">                                        
                                            <td class="text"><a href="{{ route('nhansu.update.phongban', $nhansu->id) }}">Quá trình công tác<a/></td>
                                            <td class="text">{{count($nhansu->chiTietCongTacs)}}</td>
                                        </tr>
                                    @endif
                                    @if(count($nhansu->chiTietBaoHiems)>0)
                                        <tr role="row">                                        
                                            <td class="text"><a href="{{ route('nhansu.update.baohiem', $nhansu->id) }}">Chi tiết bảo hiểm<a/></td>
                                            <td class="text">{{count($nhansu->chiTietBaoHiems)}}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        </br>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn bg-olive btn-flat pull-right" id="submit" tabindex="35"><i class="fa fa-check"></i> {{__('button.delete')}}</button>
                                <a class="btn btn-default btn-flat" href="{{route('nhansu')}}" tabindex="34"><i class="fa fa-undo"></i> {{__('button.back')}}</a>
                            </div>        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--/ box footer-->
    </form>
@endsection
@section('script')

@endsection
