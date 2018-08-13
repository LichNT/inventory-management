@component('components.modal-update', [
   'type' => 'update-doanhso',
   'title' => __('model.dang_ky_cham_cong_dien_thoai'),
   'width' => '35%',
   'route' => 'dangkyungdungchamcong.update',
   'data' => $dangkyungdungchamcong,
   'method' => 'POST'])

    <div class="row">
        <div class="col-md-6">
            <label for="ten" class="control-label">Họ tên</label>
            <input type="text" class="form-control" name="ho_ten" required tabindex="1"  value="{{$dangkyungdungchamcong->ho_ten}}">
            <label for="ten" class="control-label " >Ngày sinh</label>
            <input type="text" class="form-control datemask" name="ngay_sinh" required tabindex="2"  value="{{$dangkyungdungchamcong->ngay_sinh}}">
            <label for="ten" class="control-label">CMND</label>
            <input type="text" class="form-control" name="cmnd" required tabindex="3"  value="{{$dangkyungdungchamcong->cmnd}}">            
        </div>
        <div class="col-md-6">            
            <label for="ten" class="control-label">Mã</label>
            <input type="text" class="form-control" name="ma" required tabindex="4"  value="{{$dangkyungdungchamcong->ma}}">
            <label for="ten" class="control-label">Số điện thoại</label>
            <input type="text" class="form-control" name="so_dien_thoai" required tabindex="5"  value="{{$dangkyungdungchamcong->so_dien_thoai}}">
            <label for="ten" class="control-label">Email</label>
            <input type="text" class="form-control" name="email" required tabindex="6"  value="{{$dangkyungdungchamcong->email}}">
        </div>

        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_mien}}</label>
            @component('components.select', ['data' => $miens,
            'value'=>'id' ,'text' => 'ten', 
            'name' => 'id_mien', '
            none_required' => true, 
            'id'=>'mien'.$dangkyungdungchamcong->id,
            'parent_name'=>'parent_id',
            'id_current' => $dangkyungdungchamcong->id,
            'chil'=>'chi_nhanh',
            'idChild'=>'chi_nhanh'.$dangkyungdungchamcong->id,
            'on_change'=>true,
            'tabindex' => 7,
            'idSelected'=>$dangkyungdungchamcong->id_mien
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_chi_nhanh}}</label>
            @component('components.select', ['data' => $dangkyungdungchamcong->chinhanh->parent->childs,
            'value'=>'id' ,'text' => 'ten', 
            'name' => 'id_chi_nhanh',
            'none_required' => true,
            'id'=>'chi_nhanh'.$dangkyungdungchamcong->id,
            'parent_name'=>'parent_id',
             'id_current' => $dangkyungdungchamcong->id,
            'chil'=>'tinh',
            'idChild'=>'tinh'.$dangkyungdungchamcong->id,
            'on_change'=>true,
            'tabindex' => 8,
            'idSelected'=>$dangkyungdungchamcong->id_chi_nhanh
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">{{$ten_hien_thi_tinh}}</label>
            @component('components.select', ['data' => $dangkyungdungchamcong->chinhanh->childs,
            'value'=>'id' ,'text' => 'ten',
            'name' => 'id_tinh',
            'parent_name'=>'id_tinh',
            'none_required' => true,
             'parent_name'=>'parent_id',
            'chil'=>'tinh',
            'id_current' => $dangkyungdungchamcong->id,
            'idChild'=>'cua_hang'.$dangkyungdungchamcong->id,
            'on_change'=>true,
             'id'=>'tinh'.$dangkyungdungchamcong->id,
            'tabindex' => 9,
            'idSelected'=>$dangkyungdungchamcong->id_tinh
            ])
            @endcomponent
        </div>
        <div class="col-md-6">
            <label  class="control-label">Tên cửa hàng</label>
            @component('components.select', ['data' => $dangkyungdungchamcong->chinhanh->cuaHangs,
            'value'=>'id' ,'text' => 'ten',
             'name' => 'id_cua_hang',
             'id_current' => $dangkyungdungchamcong->id,
             'none_required' => true,
             'id'=>'cua_hang'.$dangkyungdungchamcong->id,
              'tabindex' => 10,
              'idSelected'=>$dangkyungdungchamcong->cuaHang->id
              ])
            @endcomponent
        </div>
        
    </div>
    <div class="modal-footer">
        <div class="col col-md-3 pull-right col-sm-12">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <button type="button" id="searchnhansu" onclick="{{'confirmDangKyChamCong('.$dangkyungdungchamcong->id.')'}}" class="btn btn-flat bg-olive pull-right">
                <i class="fa fa-search" ></i> Tìm kiếm</button>
        </div>
    </div>
    <div class="overlay" >
        <i class="fa fa-refresh fa-spin" style="font-size:15px; display:none"></i>
    </div>
    <div class="ket_qua_tim_kiem" >
        <div class="row">
            <div class="col-md-6">
                <label for="ten" class="control-label" >Họ tên </label>
                <input type="text" class="form-control" id="{{'ho_ten_'.$dangkyungdungchamcong->id}}" disabled>
                <label for="ma" class="control-label" >Ngày sinh</label>
                <input type="text" class="form-control datemask" id="{{'ngay_sinh_'.$dangkyungdungchamcong->id}}"disabled   >
                <label for="ten" class="control-label"  >CMND</label>
                <input type="text" class="form-control" id="{{'cmnd_'.$dangkyungdungchamcong->id}}" disabled>                    
            </div>
            <div class="col-md-6">                    
                <label for="ma" class="control-label" >Mã</label>
                <input type="text" class="form-control" id="{{'ma_'.$dangkyungdungchamcong->id}}" readonly name="ma_confirm">
                <label for="ten" class="control-label" >Số điện thoại</label>
                <input type="text" class="form-control" id="{{'so_dien_thoai_'.$dangkyungdungchamcong->id}}" disabled>
                <label for="ten" class="control-label" >Email</label>
                <input type="text" class="form-control" id="{{'email_'.$dangkyungdungchamcong->id}}" disabled>
            </div>
        </div>
    </div>
    <div class="khong_tim_thay" style=" display:none">
    </div>
@endcomponent

