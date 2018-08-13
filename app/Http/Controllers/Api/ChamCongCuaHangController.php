<?php

namespace App\Http\Controllers\Api;

use App\Mail\QuenChamCong;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\NhanSu;
use App\DangNhapChamCong;
use App\CuaHang;
use App\ChamCongCuaHang;
use Illuminate\Support\Facades\Hash;
use App\Traits\GetDataCache;
use App\Traits\JwtApi;
use App\Traits\ExecuteCoordinate;
use Exception;

class ChamCongCuaHangController extends Controller
{
    use GetDataCache, JwtApi, ExecuteCoordinate;

    public function login(Request $request) {
        $info = $request->all();
        $validator = Validator::make($info, [            
            'ma_the_cham_cong' => 'required'            
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'code'    => 400,
                'message' => __('shop.invalid'),
                'result'  => $validator->errors()
            ], 400, []);
        }                        
        

        if($this->has('nhansu_chamcongcuahang', $info['ma_the_cham_cong'])) {
            $nhanSu = $this->get('nhansu_chamcongcuahang', $info['ma_the_cham_cong']);
        }
        else{
            $nhanSu = NhanSu::query()->where('ma_the_cham_cong', $info['ma_the_cham_cong'])
            ->with([
                'cuaHang:id,ma,ten,lat,long,ten_dia_diem',
                'mien:id,ma,ten',
                'chiNhanh:id,ma,ten'
            ])
            ->select(['id', 
                'ma', 
                'ho_ten', 
                'cmnd', 
                'ngay_sinh', 
                'so_dien_thoai', 
                'email', 
                'gioi_tinh', 
                'hinh_anh', 
                'id_mien',
                'id_chi_nhanh',
                'id_tinh',
                'id_cua_hang',
                'ma_the_cham_cong',
                'da_nghi_viec',
            ])
            ->first();

            if(empty($nhanSu)) {
                return response()->json([
                    'code'    => 401,
                    'message' => __('shop.nhan_su_not_found'),
                    'result'  => []
                ], 401, []);
            }

            $this->forever('nhansu_chamcongcuahang', $info['ma_the_cham_cong'], $nhanSu);
        }                

        if($nhanSu->da_nghi_viec) {
            return response()->json([
                'code'    => 400,
                'message' => __('shop.inactivity'),
                'result'  => []
            ], 400, []);
        }

        return response()->json([
            'code'    => 200,
            'message' => __('shop.login_success'),
            'result'  => [
                'token' => $this->getToken(["sub" => 'token api cham cong', "ma_the_cham_cong" => $info['ma_the_cham_cong']]),
                'nhan_su' => $nhanSu,
            ]
        ], 200, []);                            
    }  

    public function register(Request $request) {        
        $info = $request->all();
        
        $validator = Validator::make($info, [                              
            'ma' => 'exists:nhan_sus,ma|nullable',                                         
            'id_company' => 'exists:companies,id|nullable',                
            'id_mien' => 'exists:to_chucs,id|nullable',                
            'id_chi_nhanh' => 'exists:to_chucs,id|nullable',                
            'id_tinh' => 'exists:to_chucs,id|nullable',                
            'id_cua_hang' => 'exists:cua_hangs,id|nullable',                
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'code'    => 400,
                'message' => __('shop.invalid'),
                'result'  => $validator->errors()
            ], 400, []);
        } 
        
        DangKyUngDungChamCong::query()->create($info);

        return response()->json([
            'code'    => 200,
            'message' => __('shop.register_success'),
            'result'  => []
        ], 200, []);
    }    

    public function checkin(Request $request) {   
        try{
            $payload = $this->getPayLoad($request);
        }
        catch(ExpiredException $exception) {
            return response()->json([
                'code'    => 401,
                'message' => 'Token expired.',
                'result'  => []
            ], 401, []);
        }
        catch(Exception $e) {
            return response()->json([
                'code'    => 500,
                'message' => 'Error get token.',
                'result'  => []
            ], 500, []);
        }

        $info = $request->all();
        
        $validator = Validator::make($info, [
            'lat' => 'required',
            'long' => 'required',
            'duong_dan_anh' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code'    => 400,
                'message' => __('shop.invalid'),
                'result'  => $validator->errors()
            ], 400, []);
        }

        if(empty($payload['ma_the_cham_cong'])) {
            return response()->json([
                'code'    => 400,
                'message' => __('shop.payload_invalid'),
                'result'  => []
            ], 400, []);
        }        

        if($this->has('nhansu_chamcongcuahang', $payload['ma_the_cham_cong'])) {
            $nhanSu = $this->get('nhansu_chamcongcuahang', $payload['ma_the_cham_cong']);
        }
        else{
            $nhanSu = NhanSu::query()->where('ma_the_cham_cong', $payload['ma_the_cham_cong'])
            ->with([
                'cuaHang:id,ma,ten,lat,long,ten_dia_diem',
                'mien:id,ma,ten',
                'chiNhanh:id,ma,ten'
            ])
            ->select(['id', 
                'ma', 
                'ho_ten', 
                'cmnd', 
                'ngay_sinh', 
                'so_dien_thoai', 
                'email', 
                'gioi_tinh', 
                'hinh_anh', 
                'id_mien',
                'id_chi_nhanh',
                'id_tinh',
                'id_cua_hang',
                'ma_the_cham_cong',
                'da_nghi_viec',
            ])
            ->first();

            if(empty($nhanSu)) {
                return response()->json([
                    'code'    => 401,
                    'message' => __('shop.nhan_su_not_found'),
                    'result'  => []
                ], 401, []);
            }

            $this->forever('nhansu_chamcongcuahang', $payload['ma_the_cham_cong'], $nhanSu);
        }

        if(empty($nhanSu->id_cua_hang)) {
            return response()->json([
                'code'    => 401,
                'message' => __('shop.no_shop_info'),
                'result'  => []
            ], 401, []);
        }
        $now = new Carbon();
        $info['ma'] = time();
        $info['thang'] = $now->month;
        $info['nam'] = $now->year;
        $info['nhan_su_id'] = $nhanSu->id;
        $info['ma_the_cham_cong'] = $nhanSu->ma_the_cham_cong;
        $info['cua_hang_id'] =  $nhanSu->id_cua_hang;
        $info['cmnd'] = $nhanSu->cmnd;
        $info['thoi_gian_check_in'] = new Carbon();
        $info['duong_dan_anh_check_in'] = $info['duong_dan_anh'];
        $info['lat_check_in'] = $info['lat'];
        $info['long_check_in'] = $info['long'];
        $info['het_han_check_out'] = $now->addHours(config('chamcong.check_out_live'));
        $cuaHang = $this->getDataByName('CuaHang')->firstWhere('id', $info['cua_hang_id']);
        if(isset($cuaHang)) {
            $info['cua_hang_lat'] = $cuaHang->lat;
            $info['cua_hang_long'] = $cuaHang->long;
            $info['dia_chi'] = $cuaHang->so_nha . ',' . $cuaHang->phuong_xa;
            $info['huyen'] = $cuaHang->quan_huyen;
            $info['tinh'] = $cuaHang->tinh_thanh;
            $info['khoang_cach_check_in'] = $this->distance($cuaHang->lat, $cuaHang->long, $info['lat_check_in'], $info['long_check_in']);
            if($info['khoang_cach_check_in'] > config('chamcong.distance_max_valid')) {
                $info['hop_le'] = false;
                $info['warning'] = true;
            }
        }
        $chamCongCuaHang = ChamCongCuaHang::query()
            ->create($info);

        return response()->json([
            'code'    => 200,
            'message' => __('shop.checkin_success'),
            'result'  => $chamCongCuaHang
        ], 200, []);
    }

    public function checkout(Request $request) {
        try{
            $payload = $this->getPayLoad($request);
        }
        catch(ExpiredException $exception) {
            return response()->json([
                'code'    => 401,
                'message' => 'Token expired.',
                'result'  => []
            ], 401, []);
        }
        catch(Exception $e) {
            return response()->json([
                'code'    => 500,
                'message' => 'Error get token.',
                'result'  => []
            ], 500, []);
        }
        if(empty($payload['ma_the_cham_cong'])) {
            return response()->json([
                'code'    => 400,
                'message' => __('shop.payload_invalid'),
                'result'  => []
            ], 400, []);
        } 

        $info = $request->only(['lat', 'long', 'duong_dan_anh', 'thoi_gian', 'ma']);
        $validator = Validator::make($info, [                              
            'lat' => 'required',                                         
            'long' => 'required',                                         
            'duong_dan_anh' => 'required',                
            'ma' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code'    => 400,
                'message' => __('shop.invalid'),
                'result'  => $validator->errors()
            ], 400, []);
        }
        $now = new Carbon();
        $info['checked_out'] = true;
        $info['lat_check_out'] = $info['lat'];           
        $info['long_check_out'] = $info['long'];           
        $info['thoi_gian_check_out'] = $now;
        $info['duong_dan_anh_check_out'] = $info['duong_dan_anh'];
        $checkInInfo = ChamCongCuaHang::query()
            ->where('ma', $info['ma'])
            ->first();

        if(empty($checkInInfo)) {
            return response()->json([
                'code'    => 404,
                'message' => __('shop.none_checkin'),
                'result'  => []
            ], 404, []);
        }

        if($checkInInfo->checked_out) {
            return response()->json([
                'code'    => 401,
                'message' => __('shop.checked_out'),
                'result'  => []
            ], 401, []);
        }                  

        if(isset($checkInInfo->thoi_gian_check_in)) {
            $info['so_gio_lam'] = round($info['thoi_gian_check_out']->diffInMinutes(Carbon::createFromFormat(config('app.format_datetime'),$checkInInfo->thoi_gian_check_in))/60, 1);
        }

        $cuaHang = $this->getDataByName('CuaHang')->firstWhere('id', $checkInInfo->cua_hang_id);
        if(isset($cuaHang)) {            
            $info['khoang_cach_check_out'] = $this->distance($cuaHang->lat, $cuaHang->long, $info['lat_check_out'], $info['long_check_out']);
            if($info['khoang_cach_check_out'] > config('chamcong.distance_max_valid')) {
                $info['hop_le'] = false;
                $info['warning'] = true;
            }
        }        
        
        $checkInInfo->update($info);

        return response()->json([
            'code'    => 200,
            'message' => __('shop.checkout_success'),
            'result'  => $checkInInfo
        ], 200, []);
    }

    public function histories(Request $request){
        try{
            $payload = $this->getPayLoad($request);
        }
        catch(ExpiredException $exception) {
            return response()->json([
                'code'    => 401,
                'message' => 'Token expired.',
                'result'  => []
            ], 401, []);
        }
        catch(Exception $e) {
            return response()->json([
                'code'    => 500,
                'message' => 'Error get token.',
                'result'  => []
            ], 500, []);
        }
        if(empty($payload['ma_the_cham_cong'])) {
            return response()->json([
                'code'    => 400,
                'message' => __('shop.payload_invalid'),
                'result'  => []
            ], 400, []);
        }

        $chamcongs = ChamCongCuaHang::query()->where('ma_the_cham_cong',$payload['ma_the_cham_cong'])
            ->orderBy('created_at','desc')
            ->get();

        if(empty($chamcongs)){
            return response()->json([
                'code' => 200,
                'message' => '',
                'result' => []
            ], 200, []);
        }

        if(isset($request->start_time)&&isset($request->end_time)){
            $start_time = Carbon::createFromFormat(config('app.format_date'), $request->start_time)->startOfDay();
            $end_time = Carbon::createFromFormat(config('app.format_date'), $request->end_time)->endOfDay();
            $chamcongs->where('created_at','>=', $start_time)->where('created_at','<=',$end_time);
        }
        $histories = $chamcongs->groupBy(function($chamcongs) {
            return Carbon::parse($chamcongs->created_at)->format('Y-m-d');
        });

        $data = array();

        foreach ($histories as $key=>$history){
            $data [] = [
                'date'=>$key,
                'data'=>$history
                ];
        }
        return response()->json([
            'code' => 200,
            'message' => '',
            'result' => $data
        ], 200, []);
    }

    public function forgetMaChamCong(Request $request){
        $model = QuenChamCong::class;
        $email = $request->get('email');
       $nhansu = NhanSu::query()->where('email',$email)->first();
       if(empty($nhansu)){
           return response()->json([
               'code'    => 401,
               'message' => 'Email không tồn tại trong hệ thống!',
               'result'  => []
           ], 401, []);
       }
       if(isset($nhansu->ma_the_cham_cong)){
               Mail::to($email)->send(new QuenChamCong($model,$nhansu->ma_the_cham_cong));
           return response()->json([
               'code'    => 200,
               'message' => 'Thành công!',
               'result'  => []
           ], 200, []);
       }else{
           return response()->json([
               'code'    => 401,
               'message' => 'Bạn chưa có mã chấm công!',
               'result'  => []
           ], 401, []);
       }

    }
}
