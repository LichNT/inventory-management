@extends('nhansu.edit-layout')

@section('title_detail')
  Quá trình công tác
@endsection

@section('content_detail')
  <form action="{{route('nhansu.updatenhansu', $nhansu->id)}}" method="POST" onsubmit="document.getElementById('submit').disabled=true">
    {{ csrf_field() }}   
    {{method_field('put')}}
    <div class="row">
        <div class="col-md-3">
            <label >Ngày học việc</label>
            <input type="text" class="form-control datemask input-sm" id="ngay_hoc_viec"  name="ngay_hoc_viec"
                  tabindex="1" value="{{$nhansu->ngay_hoc_viec}}" autofocus>
            <label >Ngày thử việc</label>
            <input type="text" class="form-control datemask input-sm" id="ngay_thu_viec"  name="ngay_thu_viec"
                    tabindex="2" value="{{$nhansu->ngay_thu_viec}}">          
        </div>
        <div class="col-md-3">
            <label >Ngày chính thức</label>
            <input type="text" class="form-control datemask input-sm" id="ngay_chinh_thuc"  name="ngay_chinh_thuc"
                    tabindex="3" value="{{$nhansu->ngay_chinh_thuc}}">
            <label >Ngày nghỉ viêc</label>
            <input type="text" class="form-control datemask input-sm" id="ngay_nghi_viec"  name="ngay_nghi_viec" tabindex="4" value="{{$nhansu->ngay_nghi_viec}}">
        </div>
        <div class="col-md-3">
            @component('components.checkbox', [
                'title' => 'Nghỉ việc',
                'id' => 'da_nghi_viec',
                'name' => 'da_nghi_viec',                                 
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->da_nghi_viec, 
                'tabindex' => 5,      
            ])
            @endcomponent

            @component('components.checkbox', [
                'title' => 'Thử việc',
                'id' => 'thu_viec',
                'name' => 'thu_viec',                                 
                'value_checked' => 1,                  
                'value_unchecked' => 0,                  
                'value' => $nhansu->thu_viec, 
                'tabindex' => 6,      
            ])
            @endcomponent              
        </div>             
    </div>
    <div class="row">
      <div class="col-md-12">
          <button type="submit" id="submit" class="btn btn-flat bg-olive pull-right btn-sm">
              <i class="fa fa-check"></i> {{__('button.edit')}}
          </button>
      </div>                            
    </div>
  </form>      
  <hr>      
  <div class="row">     
    <div class="col-xs-12 pull-right">            
      <a href="#" data-toggle="modal" data-target="#modal-add-change" class="btn btn-flat bg-olive btn-sm">
        <i class="fa fa-plus"> Thêm mới quá trình công tác</i>
      </a>
      @include('nhansu.phongban.change')
    </div>
    <div class="col-md-12">
      <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
          <div class="row">
            <div class="col-sm-6">
                @component('components.perpage',['options' => [10,20,50,100], 'default'=> $data->perPage(),'perPage' => $perPage, 'data' => $data, 'routerName' => 'nhansu.update.phongban','id'=>$nhansu->id])
                @endComponent
            </div>
            <div class="col-sm-6">
              <div id="search" class="dataTables_filter">
                @component('components.search',['title' => 'Tìm kiếm', 'routerName' => 'nhansu.update.phongban','id'=> $nhansu->id, 'search' => (empty($search)?null:$search)])
                @endComponent
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <table id="menus" class="table table-bordered table-striped dataTable" role="grid">
                <thead>
                  <tr role="row">
                  <th  style="width: 10%;">Nhân viên</th>                  
                    <th  style="width: 10%;">{{$ten_hien_thi_mien}}</th>
                    <th  style="width: 10%;">{{$ten_hien_thi_chi_nhanh}}</th>
                    <th  style="width: 10%;">{{$ten_hien_thi_tinh}}</th>
                    <th  style="width: 10%;">Cửa hàng</th>                  
                    <th  style="width: 10%;">Phòng ban</th>
                    <th  style="width: 10%;">Bộ phận</th>
                    <th  style="width: 10%;">Chức vụ</th>
                    <th  style="width: 10%;">Ngày hiệu lực</th>
                    <th  style="width: 5%;">Ngày hết hiệu lực</th>
                    <th  style="width: 5%;">Ngày quyết định</th>
                    <th  style="width: 5%;">Số quyết định</th>
                    <th  style="width: 5%;">Trạng thái</th>
                    <th  style="width: 5%;">Xóa</th>
                </thead>
                <tbody>
                  @foreach ($data as $phongban)
                  <tr role="row" class="odd">
                    <td>{{empty($phongban->nhan_su->ho_ten)? ' ':$phongban->nhan_su->ho_ten}}</td>
                    <td>{{$phongban->mien_moi->ten}}</td>
                    <td>{{$phongban->chi_nhanh_moi->ten}}</td>
                    <td>{{$phongban->tinh_moi->ten}}</td>
                    <td>{{$phongban->cua_hang_moi->ten}}</td>
                    <td>{{$phongban->phong_ban_moi->ten}}</td>
                    <td>{{$phongban->bo_phan_moi->ten}}</td>
                    <td>{{empty($phongban->chuc_vu_moi->ten)? ' ':$phongban->chuc_vu_moi->ten}}</td>
                    <td>{{$phongban->ngay_hieu_luc}}</td>
                    <td>{{$phongban->ngay_het_hieu_luc}}</td>
                    <td>{{$phongban->ngay_quyet_dinh}}</td>
                    <td>{{$phongban->so_quyet_dinh}}</td>
                    <td>
                      @if ($phongban->active)
                        <small class="label bg-olive flat block">{{__('system.active')}}</small>
                      @else
                        <small class="label bg-navy flat block">{{__('system.inactive')}}</small>
                      @endif
                    </td>
                    <td align="center">
                          <a href="#" data-toggle="modal" data-target="{{ '#modal-delete-phongban-' . $phongban->id }}">
                            <i class="fa fa-trash-o"></i>
                          </a>
                          @include('nhansu.phongban.delete')
                        </td>
                  </tr>
                  @endforeach
                </tbody>                
              </table>
            </div>
          </div>
          @component('components.pagination', ['pageShow' => 3, 'data' => $data])
          @endComponent
        </div>
      </div>
      <div class="box-footer">
        <a class="btn btn-default btn-flat" href="{{route('nhansu')}}"><i class="fa fa-undo"></i> {{__('button.back')}}</a>    
      </div>
    </div>
  </div>       
@endsection