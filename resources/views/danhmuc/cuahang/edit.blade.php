@extends('layouts.form')

@section('css')
    <style>
        #map-canvas{
            width: 100%;
            height: 250px;
            margin-top: 5px
        }
    </style>
@endsection

@section('content')
    <h2 class="page-header">
        CẬP NHẬT THÔNG TIN CỬA HÀNG
    </h2>
    <form id="customer-add-form" method="POST" action="{{ route('cuahang.update', $cuahang->id)}}" >
        {{csrf_field() }}
        {{ method_field('put') }}
        <div class="box-body">
            <div class="row">
                <div class="col col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">{{$ten_hien_thi_mien}}<span style="color:red">*</span></label>
                                @component('components.select', [
                            'data' => $miens,
                            'text' => 'ten',
                            'name' => 'id_mien',
                            'value' => 'id',
                            'id' => 'mien',
                            'tabindex' => 1,
                            'idSelected' => $cuahang->id_mien
                            ])
                                @endcomponent
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">{{$ten_hien_thi_chi_nhanh}}<span style="color:red">*</span></label>
                                @component('components.select', [
                            'data' => $cuahang->chinhanh->parent->childs,
                            'text' => 'ten',
                            'name' => 'id_chi_nhanh',
                            'value' => 'id',
                            'id' => 'chi_nhanh',
                            'tabindex' => 2,
                            'idSelected' =>  $cuahang->id_chi_nhanh
                            ])
                                @endcomponent
                            </div>
                            <input type="hidden" id="chi_nhanh_hidden" data="{{$chi_nhanhs}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">{{$ten_hien_thi_tinh}}</label>
                                @component('components.select', [
                            'data' =>$cuahang->chinhanh->childs,
                            'text' => 'ten',
                            'name' => 'id_tinh',
                            'value' => 'id',
                            'id' => 'tinh',
                            'tabindex' => 3,
                            'none_required'=>true,
                            'idSelected' => $cuahang->id_tinh
                            ])
                                @endcomponent
                                @if ($errors->has('id_tinh'))
                                    <span class="help-block" style="color:red">
                                        <strong>{{ $errors->first('id_tinh') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="hidden" id="tinh_hidden" data="{{$tinhs}}">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">Mã <span style="color:red">*</span></label>
                                <input type="text" class="form-control" required placeholder="Mã" name="ma"
                                    tabindex="4" value="{{$cuahang->ma}}">
                                @if ($errors->has('ma'))
                                    <span class="help-block" style="color:red">
                                        <strong>{{ $errors->first('ma') }}</strong>
                                    </span>
                                @endif
                            </div> 
                        </div> 
                    </div>
                    <div class="form-group">
                        <label >Loại cửa hàng</label>
                        @component('components.select', [
                                'data' => $loai_cua_hangs,
                                    'text' => 'ten',
                                    'name' => 'loai_cua_hang',
                                    'value' => 'ma',
                                    'none_required' => true,
                                    'id' => 'loai_cua_hang',
                                    'tabindex' => 5,
                                    'idSelected' => $cuahang->loai_cua_hang
                                    ])
                        @endcomponent
                    </div>
                    <div class="form-group">
                        <label >Tên cửa hàng<span style="color:red">*</span></label>
                        <input type="text" class="form-control" required placeholder="Tên cửa hàng" name="ten" tabindex="6" value="{{$cuahang->ten}}">
                        @if ($errors->has('ten'))
                            <span class="help-block" style="color:red">
                                <strong>{{ $errors->first('ten') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                                <label for="notes">Ngày đăng ký KD</label>
                                <input type="text" class="form-control datemask" id="ngay_dang_ki_kinh_doanh"  name="ngay_dang_ki_kinh_doanh"
                                    tabindex="7" value="{{$cuahang->ngay_dang_ki_kinh_doanh}}">
                            </div>
                    <div class="form-group">
                        <label >Ngày khai trương</label>
                        <input type="text" class="form-control datemask" id="ngay_khai_truong"  name="ngay_khai_truong"
                                    tabindex="8" value="{{$cuahang->ngay_khai_truong}}">
                            </div>
                    <div class="form-group">
                        <label for="attention">Ngày bán hàng</label><br/>
                        <input type="text" class="form-control datemask" id="ngay_ban_hang"  name="ngay_ban_hang"
                               tabindex="9" value="{{$cuahang->ngay_ban_hang}}">
                        </div>
                    <div class="form-group">
                        <label for="attention">Vĩ độ</label><br/>
                        <input type="text"  class="form-control" readonly name="lat" id="lat" value="{{$cuahang->lat}}">
                    </div>

                    <div class="form-group">
                        <label for="attention">Kinh độ</label><br/>
                        <input type="text" class="form-control" readonly name="long" id="long"  value="{{$cuahang->long}}">
                    </div>
                    </div>
                <div class="col col-md-4">
                    <div class="form-group">
                        <label >Tên địa điểm<span style="color:red">*</span></label>
                        <input type="text" class="form-control" placeholder="Tên địa điểm" name="ten_dia_diem" required tabindex="10" value="{{$cuahang->ten_dia_diem}}">
                        @if ($errors->has('ten_dia_diem'))
                            <span class="help-block" style="color:red">
                                <strong>{{ $errors->first('ten_dia_diem') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label >Số nhà, đường</label>
                        <input type="text" class="form-control" placeholder="Số nhà, đường" name="dia_chi" tabindex="11" value="{{$cuahang->dia_chi}}">
                    </div>
                    <div class="form-group">
                        <label>Phường/xã</label>
                        <input type="text" placeholder="Phường/xã" class="form-control" name="phuong_xa" tabindex="12" value="{{$cuahang->phuong_xa}}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Quốc gia</label>
                                @component('components.select', [
                                'data' => $quoc_gias,
                                'text' => 'ten',
                                'name' => 'quoc_gia',
                                'value' => 'ma',
                                'none_required' => true,
                                'id' => 'quoc_gia',
                                'tabindex' => 13,
                                'idSelected' => $cuahang->quoc_gia
                                ])
                                @endcomponent
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label > Tỉnh thành</label>
                                @component('components.select2',[
                                'data' => $tinh_thanhs,
                                'text' => 'ten',
                                'name' => 'tinh_thanh',
                                'value' => 'id',
                                'none_required' => true,
                                'id' => 'tinh_thanh',
                                'tabindex' => 14,
                                'idSelected' => $cuahang->tinh_thanh
                                ])
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Quận huyện</label>
                                @component('components.select2', [
                                    'data' => $cuahang->tinhThanh->quanHuyens,
                                        'text' => 'ten',
                                        'name' => 'quan_huyen',
                                        'value' => 'id',
                                        'none_required' => true,
                                        'id' => 'quan_huyen',
                                        'tabindex' => 15,
                                        'idSelected' => $cuahang->quan_huyen
                                        ])
                                @endcomponent
                            </div>
                            <input type="hidden" id="quan_huyen_hidden" data="{{$quan_huyens}}">
                        </div>
                        <div class=" col-md-6 form-group">
                            <label >Zip code</label>
                            <input type="text" class="form-control" placeholder="Mã zip" name="zip_code" tabindex="16" value="{{$cuahang->zip_code}}">
                        </div>
                    </div>                 
                </div>
                <div class="col col-md-4">
                    <div class="form-group">
                        <label >Người đại diện</label>
                        <input type="text" class="form-control" placeholder="Người đại diện" name="nguoi_dai_dien" tabindex="17" value="{{$cuahang->nguoi_dai_dien}}">
                    </div>
                    <div class="form-group">
                        <label >Người liên hệ</label>
                        <input type="text" class="form-control" placeholder="Người liên hệ" name="nguoi_lien_he" tabindex="18" value="{{$cuahang->nguoi_lien_he}}">
                    </div>
                    <div class="form-group">
                        <label >Số điện thoại</label>
                        <input type="text" class="form-control" placeholder="Số điện thoại" name="so_dien_thoai" tabindex="19" value="{{$cuahang->so_dien_thoai}}">
                    </div>
                    <div class="form-group">
                        <label >Số fax</label>
                        <input type="text" class="form-control" placeholder="Số fax" name="fax" tabindex="20" value="{{$cuahang->fax}}">
                    </div>
                    <div class="form-group">
                        <label >Email</label>
                        <input type="text" class="form-control"  placeholder="Email" name="email" tabindex="21" value="{{$cuahang->email}}">
                    </div>
                </div>
                <div class="col col-md-8">
                    <div class="form-group">
                        <label>Vị trí của hàng</label>
                        <br>
                        <input type="text" id="searchmap" placeholder="Chọn vị trí..." style="width: 100%;padding: 5px">
                        <br>
                        <div id="map-canvas"></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn bg-olive btn-flat pull-right" tabindex="22">
                <i class="fa fa-check"></i> {{__('button.add')}}
            </button>
            <a href="{{route('cuahang')}}" class="btn btn-default btn-flat">
                <i class="fa fa-undo"></i> {{__('button.back')}}
            </a>
        </div>
    </form>
@endsection



@section('script')
    <script src="{{ asset('js/editCuaHang.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyB6K1CFUQ1RwVJ-nyXxd6W0rfiIBe12Q&libraries=places"
            type="text/javascript"></script>
    <script src="{{ asset('js/map.js') }}">
    </script>
@endsection
