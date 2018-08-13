<?php

namespace App\Http\Controllers;

use App\ChiTietBaoHiem;
use App\ChiTietGiamTruGiaCanh;
use App\ChiTietPhat;
use App\ChiTietLuong;
use App\Company;
use App\CuaHang;
use App\LichSuThamSoTinhLuong;
use App\LoaiHopDong;
use App\LoaiPhat;
use App\NhanSu;
use App\PhongBan;
use App\Bac;
use App\PhuCapBacLuong;
use App\TheoDoiHopDong;
use App\ToChuc;
use App\ChucVu;
use App\LoaiChamCong;
use App\ThamSoTinhLuongTheoChucVu;
use App\ThamSoTinhLuongTheoBacLuong;
use App\ThamSoTinhLuongTheoPhuCap;
use App\ThueThuNhap;
use App\LoaiPhuCap;
use App\ChamCongCuaHang;
use App\ChiTietCongTac;
use App\CongNo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Menu;
use App\ChamCong;
use App\ThamSoHeThong;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\ConfigToChuc;
use App\Traits\GetDataCache;

class ChamCongNhanSuController extends Controller
{
    use GetDataCache;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request) {
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_thang = $request->get('search_thang');
        $search_nam = $request->get('search_nam');
        $search_khoa_so = $request->get('search_khoa_so');

        $query = ChamCong::query()->with(['nguoiTao','nguoiSua']);

        if(isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ten', 'ilike', "%$search%");
            });
        }

        if(isset($search_thang)){
            $query->where('thang',$search_thang);
        }

        if(isset($search_nam)){
                $query->where('nam',$search_nam);
        }

        if(isset($search_khoa_so)){
            $query->whereIn('khoa_so',$search_khoa_so);
        }

        $query->orderBy('nam')->orderBy('id','desc');
        $data = $query->paginate($perPage, ['*'], 'page', $page);
        return view('luong.chamcong.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,            
            'search'=> $search,
            'perPage' => $perPage,
            'page' => $page,
            'search_thang' => $search_thang,
            'search_nam' => $search_nam,
            'dots' => collect([(object)['id'=>1,'ten'=>'Lần 1'],(object)['id'=>2,'ten'=>'Lần 2']]),
            'search_khoa_so' => $search_khoa_so
        ]);
    }

    public function add(Request $request) {
        $info = $request->all();
        $user= Auth::user();
        $company = Company::find($user->company_id);
        $validator = Validator::make($info, [
            'ten' => 'required',
            'nam' => 'required',
            'thang' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ten_bang']= 'cham_cong_nhan_su_'.mb_strtolower($company->code).'_'.$info['thang'].'_'.$info['nam'];
        $info['nguoi_tao_id']= $user->id;
        $info['nguoi_sua_id']= $user->id;
        $info['company_id']= $user->company_id;
        $info['ngay_bat_dau']=Carbon::createFromFormat(config('app.format_month'),$info['thang'].'/'.$info['nam'])->startOfMonth();
        $info['ngay_ket_thuc']=Carbon::createFromFormat(config('app.format_month'),$info['thang'].'/'.$info['nam'])->endOfMonth();
        $check_cham_cong= ChamCong::where('ten_bang',$info['ten_bang'])->first();
        if(isset($check_cham_cong)){
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', 'Đã tồn tại bảng lương tháng '.$info['thang'].' năm '.$info['nam']);
        }
        DB::beginTransaction();
        try {
            ChamCong::create($info);
            Schema::create('cham_cong_nhan_su_'.mb_strtolower($company->code).'_'.$info['thang'].'_'.$info['nam'], function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('nhan_su_id');
                $table->foreign('nhan_su_id')->references('id')->on('nhan_sus');
                $table->string('ma', 10);
                $table->string('ho_ten', 30);
                $table->string('ma_the_cham_cong', 50)->nullable();
                $table->unsignedInteger('id_chi_nhanh')->nullable();
                $table->foreign('id_chi_nhanh')->references('id')->on('to_chucs');
                $table->unsignedInteger('id_tinh')->nullable();
                $table->foreign('id_tinh')->references('id')->on('to_chucs');
                $table->unsignedInteger('phong_ban_id')->nullable();
                $table->foreign('phong_ban_id')->references('id')->on('phong_bans');
                $table->unsignedInteger('bo_phan_id')->nullable();
                $table->foreign('bo_phan_id')->references('id')->on('phong_bans');
                $table->unsignedInteger('id_cua_hang')->nullable();
                $table->foreign('id_cua_hang')->references('id')->on('cua_hangs');
                $table->unsignedInteger('id_chuc_vu')->nullable();
                $table->foreign('id_chuc_vu')->references('id')->on('chuc_vus');
                $table->float('he_so_phu_cap_chuc_vu')->nullable();
                $table->float('he_so_phu_cap_doc_hai')->nullable();
                $table->float('he_so_diem_phuc_tap')->nullable();
                $table->float('he_so_phu_cap_tham_nien')->nullable();
                $table->float('so_nguoi_phu_thuoc')->nullable();
                $table->float('he_so_hoan_thanh_cong_viec')->nullable();
                $table->float('he_so_luong_san_pham')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_01')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_02')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_03')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_04')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_05')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_06')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_07')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_08')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_09')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_10')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_11')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_12')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_13')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_14')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_15')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_16')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_17')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_18')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_19')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_20')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_21')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_22')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_23')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_24')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_25')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_26')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_27')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_28')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_29')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_30')->nullable();
                $table->unsignedInteger('gio_lam_them_ngay_cong_so_31')->nullable();

                $table->unsignedInteger('ngay_cong_so_01')->nullable();
                $table->foreign('ngay_cong_so_01')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_02')->nullable();
                $table->foreign('ngay_cong_so_02')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_03')->nullable();
                $table->foreign('ngay_cong_so_03')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_04')->nullable();
                $table->foreign('ngay_cong_so_04')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_05')->nullable();
                $table->foreign('ngay_cong_so_05')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_06')->nullable();
                $table->foreign('ngay_cong_so_06')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_07')->nullable();
                $table->foreign('ngay_cong_so_07')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_08')->nullable();
                $table->foreign('ngay_cong_so_08')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_09')->nullable();
                $table->foreign('ngay_cong_so_09')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_10')->nullable();
                $table->foreign('ngay_cong_so_10')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_11')->nullable();
                $table->foreign('ngay_cong_so_11')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_12')->nullable();
                $table->foreign('ngay_cong_so_12')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_13')->nullable();
                $table->foreign('ngay_cong_so_13')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_14')->nullable();
                $table->foreign('ngay_cong_so_14')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_15')->nullable();
                $table->foreign('ngay_cong_so_15')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_16')->nullable();
                $table->foreign('ngay_cong_so_16')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_17')->nullable();
                $table->foreign('ngay_cong_so_17')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_18')->nullable();
                $table->foreign('ngay_cong_so_18')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_19')->nullable();
                $table->foreign('ngay_cong_so_19')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_20')->nullable();
                $table->foreign('ngay_cong_so_20')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_21')->nullable();
                $table->foreign('ngay_cong_so_21')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_22')->nullable();
                $table->foreign('ngay_cong_so_22')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_23')->nullable();
                $table->foreign('ngay_cong_so_23')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_24')->nullable();
                $table->foreign('ngay_cong_so_24')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_25')->nullable();
                $table->foreign('ngay_cong_so_25')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_26')->nullable();
                $table->foreign('ngay_cong_so_26')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_27')->nullable();
                $table->foreign('ngay_cong_so_27')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_28')->nullable();
                $table->foreign('ngay_cong_so_28')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_29')->nullable();
                $table->foreign('ngay_cong_so_29')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_30')->nullable();
                $table->foreign('ngay_cong_so_30')->references('id')->on('loai_cham_congs');

                $table->unsignedInteger('ngay_cong_so_31')->nullable();
                $table->foreign('ngay_cong_so_31')->references('id')->on('loai_cham_congs');

                foreach (LoaiChamCong::query()->pluck('ma') as $ma){
                    $table->integer($ma)->nullable();
                }

                $table->integer('tong_cong_huong_luong')->nullable();
                $table->integer('tong_lam_them_gio')->nullable();
                $table->integer('so_gio_quy_dinh')->nullable();
                $table->integer('so_ngay_nghi_trong_thang')->nullable();

                $table->decimal('muc_dong_bhxh',15,0)->nullable();
                $table->decimal('khau_tru_bao_hiem',15,0)->nullable();
                $table->decimal('khau_tru_thue_thu_nhap',15,0)->nullable();
                $table->decimal('khau_tru_tien_bao_lanh',15,0)->nullable();
                $table->decimal('tru_khac',15,2)->nullable();

                $table->decimal('luong_thuc_te',15,2)->nullable();
                $table->decimal('tra_luong_lan_1',15,2)->nullable();
                $table->decimal('tra_luong_lan_2',15,2)->nullable();
                $table->decimal('tong_phu_cap',15,2)->nullable();
                $table->decimal('luong_thoi_gian',15,2)->nullable();
                $table->decimal('luong_thoi_gian_chuan',15,2)->nullable();
                $table->decimal('luong_lfr',15,2)->nullable();

                $table->decimal('phu_cap',15,2)->nullable();
                $table->decimal('luong_che_do',15,2)->nullable();
                $table->decimal('luong_che_do_chuan',15,2)->nullable();
                $table->decimal('luong_san_pham',15,2)->nullable();

                $table->decimal('tong_luong',15,2)->nullable();
                $table->decimal('thuc_linh',15,2)->nullable();

                $table->decimal('giam_tru_gia_canh')->nullable();

                $table->decimal('thu_nhap_chiu_thue',15,2)->nullable();
                $table->decimal('thu_thu_nhap',15,2)->nullable();

                $table->decimal('con_lai',15,2)->nullable();
                $table->boolean('ktcn_duyet')->default(false);
                $table->datetime('ngay_ktcn_duyet')->nullable();
                $table->boolean('kttcn_duyet')->default(false);
                $table->datetime('ngay_kttcn_duyet')->nullable();
                $table->boolean('gdcn_duyet')->default(false);
                $table->datetime('ngay_gdcn_duyet')->nullable();

                $table->boolean('ktcy_duyet')->default(false);
                $table->datetime('ngay_ktcy_duyet')->nullable();

                $table->integer('company_id')->nullable();
                $table->timestamps();
            });


            DB::commit();
            return back()
                ->with('ten_bang','cham_cong_nhan_su_'.mb_strtolower($company->code).'_'.$info['thang'].'_'.$info['nam'])
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));
            }catch (\Exception $e){
                DB::rollback();
               
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.validator'));
            }
    }

    public function update(Request $request,$id){

        $chamcong=ChamCong::findOrFail($id);
        $chamcong->ten = $request->get('ten');
        $chamcong->save();
        return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function delete($id){
        $user = Auth::user();
        $company = Company::find($user->company_id);
        $chamcong=ChamCong::findOrFail($id);
        DB::beginTransaction();
        try{
            $month_year = explode('_',substr($chamcong->ten_bang, 22));
            
            $chamcong->delete();
            
            Schema::dropIfExists($chamcong->ten_bang);
            Schema::dropIfExists('phu_cap_'.mb_strtolower($company->code).'_'.$month_year[0].'_'.$month_year[1]);
            Schema::dropIfExists('tham_so_tinh_luong_'.mb_strtolower($company->code).'_'.$month_year[0].'_'.$month_year[1]);
            Schema::dropIfExists('bac_luong_'.mb_strtolower($company->code).'_'.$month_year[0].'_'.$month_year[1]);
            Schema::dropIfExists('chuc_vu_'.mb_strtolower($company->code).'_'.$month_year[0].'_'.$month_year[1]);
            DB::commit();
            return redirect()
                ->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.delete_success'));
        }catch (\Exception $exception){
            DB::rollback();
        }

    }

    function tinhLuong($tenbang,$id){
     
        $user = Auth::user();
       
        $company = Company::find($user->company_id);
        $month_year = explode('_',($tenbang));
        $year=$month_year[count($month_year)-1];
        $month=$month_year[count($month_year)-2];
        $day=Carbon::createFromFormat(config('app.format_month'),$month.'/'.$year); 

        $chamcongnhansu = DB::table($tenbang)->where('id',$id)->first();
        $nhansu=NhanSu::query()->where('ma',$chamcongnhansu->ma)->first();
        $luong_hoc_viec=0;
        $luong_thu_viec=0;
        $luong_thuc_te=0;
        $luong_tang_ca=0;
        $sogio2 =array();

        $thamsotinhluong = LichSuThamSoTinhLuong::query()->get();
        $thamsohethong=ThamSoHeThong::query()->firstOrFail();
   
        for($i=1;$i<=$day->daysInMonth;$i++){
            if($i<10){
                $i='0'.$i;
            }
            $ngay_cong='ngay_cong_so_'.$i;
            $gio_lam_them_ngay_cong='gio_lam_them_ngay_cong_so_'.$i;
            
            if(!empty($chamcongnhansu->$ngay_cong)){
                $ngay=Carbon::createFromFormat(config('app.format_date'),$i.'/'.$month.'/'.$year);
                $chitietluong=ChiTietLuong::where('nhan_su_id',$nhansu->id)->where('ngay_huong_luong','<=',$ngay)->orderBy('ngay_huong_luong','desc')->first();
                if(!empty($chitietluong)){                 
                    $danhmuc_bac_luong=Bac::findOrFail($chitietluong->bac_id);
                    $danhmuc_chucvu=ChucVu::findOrFail($danhmuc_bac_luong->id_chuc_vu);
                    $chucvu=ThamSoTinhLuongTheoChucVu::query()->where('ma',$danhmuc_chucvu->ma)->where('tu_ngay','<=',$ngay)->orderBy('tu_ngay','desc')->first();
                    if(!empty( $chucvu)){
                        $loaingay = LoaiChamCong::find($chamcongnhansu->$ngay_cong);
                        $thamsotinhluong =0;
                        if($loaingay->ma =='L') {
                            $thamsotinhluong = LichSuThamSoTinhLuong::query()->where('ma','pham_tram_lam_them_ngay_le')->where('tu_ngay', '<=', $ngay)->orderBy('tu_ngay', 'desc')->first();
                        }
                        elseif($loaingay->ma =='CN') {
                            $thamsotinhluong = LichSuThamSoTinhLuong::query()->where('ma','pham_tram_lam_them_ngay_nghi')->where('tu_ngay', '<=', $ngay)->orderBy('tu_ngay', 'desc')->first();
                        }else{
                            $thamsotinhluong = LichSuThamSoTinhLuong::query()->where('ma','pham_tram_lam_them_ngay_thuong')->where('tu_ngay', '<=', $ngay)->orderBy('tu_ngay', 'desc')->first();
                        }
                        $bac=ThamSoTinhLuongTheoBacLuong::query()->where('he_so_luong',$danhmuc_bac_luong->he_so_luong)->where('id_chuc_vu',$chucvu->id)->where('tu_ngay','<=',$ngay)->orderBy('tu_ngay','desc')->first();
                       
                        $phucap=ThamSoTinhLuongTheoPhuCap::query()->where('bac_id',$bac->id)->where('tu_ngay','<=',$ngay)->get()->groupBy('id_loai_phu_cap');;
                        
                        $luong_hoc_viec=$chucvu->so_tien_hoc_viec_theo_ngay;
                        $so_ngay_lam=empty($chucvu->so_ngay_nghi_trong_thang)?$chamcongnhansu->tong_ngay_lam_viec:$day->daysInMonth-$chucvu->so_ngay_nghi_trong_thang ;
                        $so_gio_qui_dinh=empty($chucvu->so_gio_quy_dinh)?0:$chucvu->so_gio_quy_dinh;
                        $phamtram=empty($thamsotinhluong->gia_tri)?0:$thamsotinhluong->gia_tri;
                        $sogio =empty($chamcongnhansu->$gio_lam_them_ngay_cong)?0:$chamcongnhansu->$gio_lam_them_ngay_cong;
                        $luong_co_ban_theo_ngay=$bac->muc_luong_co_ban;
                        $tong_phu_cap_theo_ngay=0;
                        
                        if(!empty($phucap)){
                            foreach($phucap as $loaiphucap){
                                foreach($loaiphucap as $loaipc){
                                    
                                    $loaipc['ngay']=strtotime(Carbon::createFromFormat(config('app.format_date'),$loaipc['tu_ngay']));
                                }
                                $max = $loaiphucap->where('ngay', $loaiphucap->max('ngay'))->first();
                                $tong_phu_cap_theo_ngay+=$max->so_tien;
                            }
                        }
                        
                        $hopdong=TheoDoiHopDong::where('id_nhan_su',$nhansu->id)->where('ngay_hieu_luc','<=',$ngay)->orderBy('ngay_hieu_luc')->first();
                        if(!empty($hopdong)){
                            if($hopdong->loai_hop_dong=='ĐTN'){
                                $luong_thuc_te+=$loaingay->ty_le_huong_luong*$luong_hoc_viec;
                            }
                            elseif($hopdong->loai_hop_dong=='TV'){
                                $hesothuviec = LichSuThamSoTinhLuong::query()->where('ma','he_so_luong_thu_viec')->where('tu_ngay','<=',$day)->orderBy('tu_ngay','desc')->first();
                                if(!empty($hesothuviec)){
                                    $luong_thuc_te+=$loaingay->ty_le_huong_luong*($hesothuviec*($luong_co_ban_theo_ngay+$tong_phu_cap_theo_ngay))/$so_ngay_lam;
                                    $luong_tang_ca+=($hesothuviec*$luong_co_ban_theo_ngay*1*($sogio)*$phamtram/100)/($so_ngay_lam*$so_gio_qui_dinh);
                                }     
                            }
                            else{
                                $luong_tang_ca+=($luong_co_ban_theo_ngay*1*$sogio*$phamtram/100)/($so_ngay_lam*$so_gio_qui_dinh);
                                if($luong_tang_ca>0){
                                     $sogio2[]=$luong_tang_ca;
                                }
                                $luong_thuc_te+=$loaingay->ty_le_huong_luong*($luong_co_ban_theo_ngay+$tong_phu_cap_theo_ngay)/$so_ngay_lam;
                            }    
                        }
                    }
                }
            }
        }

        $khau_tru_bao_hiem=($thamsohethong->BHXH_NLD/100)*$chamcongnhansu->muc_dong_bhxh;
        $khau_tru_thue_thu_nhap=0;
        $thu_nhap_tinh_thue=$luong_thuc_te-$thamsohethong->giam_tru_ban_than-($thamsohethong->giam_tru_phu_thuoc*$thamsohethong->so_nguoi_phu_thuoc);
        if($thu_nhap_tinh_thue>0){
            $can_tren=ThueThuNhap::where('can_tren','>',$thu_nhap_tinh_thue)->orderBy('can_tren')->first();
            if(empty($can_tren)){
                $mucdongthue=ThueThuNhap::where('can_tren','<>',null)->orderBy('can_tren')->get()->toArray();
                $muccuoi = ThueThuNhap::where('can_tren',null)->orderBy('can_tren')->first();
                $tong_tien_muc_dong_thue = $mucdongthue[0]['can_tren']*$mucdongthue[0]['thue_suat']/100;
                for ($i=1;$i< count($mucdongthue); $i++){
                    $tong_tien_muc_dong_thue += ($mucdongthue[$i]['can_tren']-$mucdongthue[$i-1]['can_tren'])*$mucdongthue[$i]['thue_suat']/100;
                }
                $khau_tru_thue_thu_nhap = $tong_tien_muc_dong_thue + ($thu_nhap_tinh_thue-$mucdongthue[$i-1]['can_tren'])*$muccuoi->thue_suat/100;
            }
            else{
                $mucdongthue=ThueThuNhap::where('can_tren','<=',$thu_nhap_tinh_thue)->orderBy('can_tren')->get()->toArray();
                if(empty($mucdongthue)){
                    $muc1 = ThueThuNhap::query()->orderBy('can_tren')->first();
                    $khau_tru_thue_thu_nhap = $thu_nhap_tinh_thue*$muc1->thue_suat/100;
                }
                else{                
                    $tong_tien_muc_dong_thue = $mucdongthue[0]['can_tren']*$mucdongthue[0]['thue_suat']/100;
                    if(count($mucdongthue)>1){
                        for ($i=1;$i< count($mucdongthue); $i++){
                            $tong_tien_muc_dong_thue += ($mucdongthue[$i]['can_tren']-$mucdongthue[$i-1]['can_tren'])*$mucdongthue[$i]['thue_suat']/100;
                        }
                        $khau_tru_thue_thu_nhap = $tong_tien_muc_dong_thue + ($thu_nhap_tinh_thue-$mucdongthue[$i-1]['can_tren'])*$can_tren->thue_suat/100;
                    }
                    else{
                        $khau_tru_thue_thu_nhap = $tong_tien_muc_dong_thue + ($thu_nhap_tinh_thue-$mucdongthue[0]['can_tren'])*$can_tren->thue_suat/100;
                    }
                }
            }                
        }
        
        $khau_tru_tien_bao_lanh=0;
        if(!empty( $chucvu)){
        if($chucvu->so_tien_bao_lanh>($nhansu->tong_so_tien_bao_lanh_da_nop-$nhansu->tong_so_tien_bao_lanh_da_tra)){
            $chucvu=ThamSoTinhLuongTheoChucVu::query()->where('ma',$nhansu->chucVu->ma)->orderBy('tu_ngay','desc')->first();
            $chitietcongtac=ChiTietCongTac::query()->where('id_nhan_su', $nhansu->id)->where('active',true)->first();
            if(empty($chitietcongtac->ngay_nhan_shop)){
                $hopdong=TheoDoiHopDong::query()->where('id_nhan_su', $nhansu->id)->where('trang_thai',true)->first();
               
                if(!empty($hopdong)&&$hopdong->loaiHopDong->ma=="CT"&&!empty($chitietcongtac->ngay_hieu_luc)){
                    $ngay_hieu_luc=Carbon::createFromFormat(config('app.format_date'),$chitietcongtac->ngay_hieu_luc)->startOfMonth();
                    $diff_in_months = $ngay_hieu_luc->diffInMonths($day);
                    if($diff_in_months+1<$chucvu->so_thang){         
                        $khau_tru_tien_bao_lanh=($chucvu->so_tien_bao_lanh*$chucvu->so_thang-($nhansu->tong_so_tien_bao_lanh_da_nop-$nhansu->tong_so_tien_bao_lanh_da_tra))/$chucvu->so_thang;
                    }
                   
                }
            }
            else{
                 $ngay_hieu_luc=Carbon::createFromFormat(config('app.format_date'),$chitietcongtac->ngay_nhan_shop)->startOfMonth();
                 $diff_in_months = $ngay_hieu_luc->diffInMonths($day);
                    if($diff_in_months+1<=$chucvu->so_thang){         
                        $khau_tru_tien_bao_lanh=($chucvu->so_tien_bao_lanh*$chucvu->so_thang-($nhansu->tong_so_tien_bao_lanh_da_nop-$nhansu->tong_so_tien_bao_lanh_da_tra))/$chucvu->so_thang;
                    }
            }
            
        }
    }
        $tru_khac=0;
        $congno=CongNo::query()->where('id_nhan_su',$chamcongnhansu->nhan_su_id)
        ->where('inactive',false)->where('thang_nam','<=',$day->startOfMonth())
        ->first();
        if(!empty($congno)){
            $tru_khac=$congno->so_tien;
        }
        DB::table($tenbang)->where('id',$id)->update([
            'luong_thuc_te'=>$luong_thuc_te,
            'luong_thoi_gian'=>$luong_tang_ca,
            'khau_tru_bao_hiem'=>$khau_tru_bao_hiem,
            'khau_tru_thue_thu_nhap'=>$khau_tru_thue_thu_nhap,
            'khau_tru_tien_bao_lanh'=>$khau_tru_tien_bao_lanh,
            'thuc_linh'=>$luong_thuc_te+$luong_tang_ca-$khau_tru_bao_hiem-$khau_tru_thue_thu_nhap-$khau_tru_tien_bao_lanh,
            'tru_khac'=>$tru_khac,
        ]);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }
 
    function resetChamCong($tenbang,$id){
        $user = Auth::user();
        $chamcongnhansu = DB::table($tenbang)->where('id',$id)->first();
        
        $info=[];
        foreach (LoaiChamCong::query()->pluck('ma') as $ma){
            $info[$ma]=null;
        }
        DB::table($tenbang)->where('id',$id)->update($info);
       
        DB::table($tenbang)->where('id',$id)->update([
           'gio_lam_them_ngay_cong_so_01'=>null,
           'gio_lam_them_ngay_cong_so_02'=>null,
           'gio_lam_them_ngay_cong_so_03'=>null,
           'gio_lam_them_ngay_cong_so_04'=>null,
           'gio_lam_them_ngay_cong_so_05'=>null,
           'gio_lam_them_ngay_cong_so_06'=>null,
           'gio_lam_them_ngay_cong_so_07'=>null,
           'gio_lam_them_ngay_cong_so_08'=>null,
           'gio_lam_them_ngay_cong_so_09'=>null,
           'gio_lam_them_ngay_cong_so_10'=>null,
           'gio_lam_them_ngay_cong_so_11'=>null,
           'gio_lam_them_ngay_cong_so_12'=>null,
           'gio_lam_them_ngay_cong_so_13'=>null,
           'gio_lam_them_ngay_cong_so_14'=>null,
           'gio_lam_them_ngay_cong_so_15'=>null,
           'gio_lam_them_ngay_cong_so_16'=>null,
           'gio_lam_them_ngay_cong_so_17'=>null,
           'gio_lam_them_ngay_cong_so_18'=>null,
           'gio_lam_them_ngay_cong_so_19'=>null,
           'gio_lam_them_ngay_cong_so_20'=>null,
           'gio_lam_them_ngay_cong_so_21'=>null,
           'gio_lam_them_ngay_cong_so_22'=>null,
           'gio_lam_them_ngay_cong_so_23'=>null,
           'gio_lam_them_ngay_cong_so_24'=>null,
           'gio_lam_them_ngay_cong_so_25'=>null,
           'gio_lam_them_ngay_cong_so_26'=>null,
           'gio_lam_them_ngay_cong_so_27'=>null,
           'gio_lam_them_ngay_cong_so_28'=>null,
           'gio_lam_them_ngay_cong_so_29'=>null,
           'gio_lam_them_ngay_cong_so_30'=>null,
           'gio_lam_them_ngay_cong_so_31'=>null,
           'ngay_cong_so_01'=>null,
           'ngay_cong_so_02'=>null,
           'ngay_cong_so_03'=>null,
           'ngay_cong_so_04'=>null,
           'ngay_cong_so_05'=>null,
           'ngay_cong_so_06'=>null,
           'ngay_cong_so_07'=>null,
           'ngay_cong_so_08'=>null,
           'ngay_cong_so_09'=>null,
           'ngay_cong_so_10'=>null,
           'ngay_cong_so_11'=>null,
           'ngay_cong_so_12'=>null,
           'ngay_cong_so_13'=>null,
           'ngay_cong_so_14'=>null,
           'ngay_cong_so_15'=>null,
           'ngay_cong_so_16'=>null,
           'ngay_cong_so_17'=>null,
           'ngay_cong_so_18'=>null,
           'ngay_cong_so_19'=>null,
           'ngay_cong_so_20'=>null,
           'ngay_cong_so_21'=>null,
           'ngay_cong_so_22'=>null,
           'ngay_cong_so_23'=>null,
           'ngay_cong_so_24'=>null,
           'ngay_cong_so_25'=>null,
           'ngay_cong_so_26'=>null,
           'ngay_cong_so_27'=>null,
           'ngay_cong_so_28'=>null,
           'ngay_cong_so_29'=>null,
           'ngay_cong_so_30'=>null,
           'ngay_cong_so_31'=>null,
           
            'luong_thuc_te'=>null,
            'khau_tru_thue_thu_nhap'=>null,
            'luong_thoi_gian'=>null,
            'tong_cong_huong_luong'=>null,
            'tong_lam_them_gio'=>null
        ]);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function updateNhanSu($tenbang){
        $user = Auth::user();
        $nhansus= NhanSu::query()->where('da_nghi_viec',false)->with('chiTietLuongs')->get();
        if(!empty($user->id_chi_nhanh)){
            $nhansus->where('id_chi_nhanh',$user->id_chi_nhanh);
        }
        $chamcongs = DB::table($tenbang)->pluck('nhan_su_id')->toArray();
        $month_year = explode('_',substr($tenbang, 22));
        $month=$month_year[0];
        $year=$month_year[1];
        $first_sunday=Carbon::parse("first sunday of 1-".$month.'-'.$year)->day;
        $last_sunday=Carbon::parse("last sunday of 1-".$month.'-'.$year)->day;
        $days=Carbon::createFromDate($year,$month)->daysInMonth-(($last_sunday-$first_sunday)/7+1);
        $day_first=Carbon::createFromDate($year,$month)->startOfMonth();
        $ngay_nghi_les=ThamSoHeThong::query()->first()->ngay_nghi_le;
        $ngay_nghi_les=explode(",",$ngay_nghi_les);

        foreach($ngay_nghi_les as $ngay){
            $ngay=explode("/",$ngay);
            if($ngay[1]==$month){
                $days=$days-1;
            }
        }
        $baohiems = ChiTietBaoHiem::query()->with('mucDongBaoHiem')->get();
        DB::beginTransaction();
        try{
            $data_update = array();
            $data_insert = array();
            $chitietgiamtrus=ChiTietGiamTruGiaCanh::query()->get();
        foreach ($nhansus as $nhansu){
                $baohiem = $baohiems->where('id_nhan_su',$nhansu->id)->where('thang_bat_dau','<=',$day_first)->sortByDesc('thang_bat_dau')->first();
                $nhansuchamcong['muc_dong_bhxh'] = isset($baohiem->mucDongBaoHiem)?$baohiem->mucDongBaoHiem->so_tien:0;
                $nhansuchamcong['nhan_su_id'] = $nhansu['id'];
                $nhansuchamcong['ma'] = $nhansu['ma'];
                $nhansuchamcong['ho_ten'] = $nhansu['ho_ten'];
                $nhansuchamcong['id_chi_nhanh'] = $nhansu['id_chi_nhanh'];
                $nhansuchamcong['id_tinh'] = $nhansu['id_tinh'];
                $nhansuchamcong['id_chuc_vu'] = $nhansu['id_chuc_vu'];
                $nhansuchamcong['phong_ban_id'] = $nhansu['phong_ban_id'];
                $nhansuchamcong['bo_phan_id'] = $nhansu['bo_phan_id'];
                $nhansuchamcong['id_cua_hang'] = $nhansu['id_cua_hang'];
                $nhansuchamcong['ma_the_cham_cong'] = $nhansu['ma_the_cham_cong'];
                $nhansuchamcong['company_id'] = $nhansu['company_id'];
                $chi_tiet_luong=$nhansu->chiTietLuongs->where('inactive',false)->first();
                

                $nhansuchamcong['so_nguoi_phu_thuoc'] = $chitietgiamtrus->where('id_nhan_su',$nhansu->id)
                ->filter(function ($giamtru) use ($chitietgiamtrus) {
                    return
                        (
                            (empty($giamtru->thoi_diem_ket_thuc) )
                            ||
                            (Carbon::createFromFormat(config('app.format_date'),$giamtru->thoi_diem_ket_thuc) >= Carbon::now())
                        );
                })->count();
            if(!in_array($nhansu->id,$chamcongs)){
                $data_insert [] = $nhansuchamcong;
            }else{
                DB::table($tenbang)->where('nhan_su_id',$nhansu->id)->update($nhansuchamcong);
            }

        }
        if(!empty($data_insert)){
            DB::table($tenbang)->insert($data_insert);
        }

            DB::commit();
            return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_error'));
        }
        
       
    }

    function chamCongNgayLe($tenbang){
        $user = Auth::user();       
        $month_year = explode('_',substr($tenbang, 22));
        $month=$month_year[0];
        $year=$month_year[1];
        $first_sunday=Carbon::parse("first sunday of 1-".$month.'-'.$year)->day;
        $last_sunday=Carbon::parse("last sunday of 1-".$month.'-'.$year)->day;
        $ngay_nghi_les=ThamSoHeThong::query()->first()->ngay_nghi_le;
        $ngay_nghi_les=explode(",",$ngay_nghi_les);
        $sunday=$first_sunday;
        $nghichunhat=LoaiChamCong::query()->where('ma','CN')->firstOrFail();
        $nghiletet=LoaiChamCong::query()->where('ma','L')->firstOrFail();
        $number_sun=0;
        do{
            if($sunday<10){
                $sunday='0'.$sunday;
            }
            $nhansuchamcong['ngay_cong_so_'.$sunday]=$nghichunhat->id;
            $sunday+=7;
            $number_sun=$number_sun+1;

        }
        while($sunday<=$last_sunday);
        $number_sun_trung = 0;
        $number_nghi_le = 0;
        foreach($ngay_nghi_les as $ngay){
            $ngay=explode("/",$ngay);

        if($ngay[1]==$month){
            $number_nghi_le = $number_nghi_le +1;
            if((int)$ngay[0]<10){
                $ngay[0]='0'.$ngay[0];
            }
            if(Carbon::createFromFormat(config('app.format_date'),$ngay[0].'/'.$month.'/'.$year)->isSunDay()||
                Carbon::createFromFormat(config('app.format_date'),$ngay[0].'/'.$month.'/'.$year)->isSaturDay())
                {
                    $number_sun_trung =$number_sun_trung+1;
                    $nhansuchamcong['ngay_cong_so_'.$ngay[0]]=$nghiletet->id;
                }
            else{
                $nhansuchamcong['ngay_cong_so_'.$ngay[0]]=$nghiletet->id;
                }
            }
        }
        $nhansuchamcong['CN'] = $number_sun-$number_sun_trung;
        $nhansuchamcong['L'] = $number_nghi_le;
        if(!empty($user->id_chi_nhanh)){
            DB::table($tenbang)->where('id_chi_nhanh',$user->id_chi_nhanh)->update($nhansuchamcong);
        }
        else{
            DB::table($tenbang)->update($nhansuchamcong);
        }
        

        return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));

    }

    function chamCongCuaHang($tenbang){
        $month_year = explode('_',substr($tenbang, 22));
        $month=$month_year[0];
        $year=$month_year[1];
        $start_month=Carbon::createFromFormat(config('app.format_month'),$month.'/'.$year)->startOfMonth();
        $end_month=Carbon::createFromFormat(config('app.format_month'),$month.'/'.$year)->endOfMonth(); 
        $chamcongcuahangs=ChamCongCuaHang::query()->where('thoi_gian_check_in','>=',$start_month)
        ->where('thoi_gian_check_out','>=',$start_month) ->where('thoi_gian_check_in','<=',$end_month) 
        ->where('thoi_gian_check_out','<=',$end_month)->where('thang',$month)->where('nam',$year)
        ->where('hop_le',true)->get()->groupBy('ma_the_cham_cong');
        
        $chamcong=[];
        foreach($chamcongcuahangs as $ma_the_cham_cong=> $chamcongcuahang){
            $nhansu=NhanSu::query()->where('ma_the_cham_cong',$ma_the_cham_cong)->firstOrFail();
           
            for($i=1;$i<=$start_month->daysInMonth;$i++){           
                $day=Carbon::createFromFormat(config('app.format_date'),$i.'/'.$month.'/'.$year); 
                $tong_so_gio_trong_ngay=0;
                foreach($chamcongcuahang as $chamcongch){
                    if( Carbon::createFromFormat(config('app.format_datetime'),$chamcongch->thoi_gian_check_in)->day==$i){
                        $tong_so_gio_trong_ngay+=$chamcongch->so_gio_lam;
                    } 
                
                }
                
            if($tong_so_gio_trong_ngay>0){
               $chucvu=ChucVu::query()->findOrFail($nhansu->id_chuc_vu);
               $thamsochucvu=ThamSoTinhLuongTheoChucVu::query()->where('ma',$chucvu->ma)
               ->where('tu_ngay','<=',$day)->orderBy('tu_ngay','desc')->first();
               
               if(!empty($thamsochucvu)){
                if($thamsochucvu->so_gio_quy_dinh<=$tong_so_gio_trong_ngay){
                    $loaichamcong=LoaiChamCong::query()->where('ma','X')->firstOrFail();
                    if($i<10){
                        $i='0'.$i;                   
                    }
                    $ngaycong['ma_the_cham_cong']=$ma_the_cham_cong;
                    $ngaycong['ngay_cong_so_'.$i]= $loaichamcong->id;
                    if($tong_so_gio_trong_ngay-$thamsochucvu->so_gio_quy_dinh>0)
                    {
                        $ngaycong['gio_lam_them_ngay_cong_so_'.$i]= $tong_so_gio_trong_ngay-$thamsochucvu->so_gio_quy_dinh;
                    }
                    $chamcong[]= $ngaycong;
                }
               }
               
            }
          
          }      
        }
       
        foreach($chamcong as $chamcong){
            DB::table($tenbang)->update($chamcong);
        }
       
        return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));

    }

    function showFormChiTiet(Request $request, $tenbang){
        $user = Auth::user();

        $company = Company::find($user->company_id);
        $search = $request->get('search');
        $search_tinh= $request->get('search_tinh');
        $search_chi_nhanh = $request->get('search_chi_nhanh');
        $search_bo_phan = $request->get('search_bo_phan');
        $search_phong_ban = $request->get('search_phong_ban');
        $search_chuc_vu = $request->get('search_chuc_vu');
        
        $perPage = $request->get('perpage', 50);
        $page = $request->get('page', 1);
        $chamcong = ChamCong::query()->where('ten_bang',$tenbang)->first();
        $tochucCollects = ToChuc::query()->get();
        $phongbanCollects = PhongBan::query()->get();
        $chucvuCollects = ChucVu::query()->get();
        $cuahangCollects = CuaHang::query()->get();
   
        if(empty($chamcong)){
            return redirect()
                    ->back()
                    ->withInput()
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', 'Chưa có bảng chấm công tháng '.$request->get('thang').' năm '.$request->get('nam'));
        }else if(!Schema::hasTable($tenbang)){
            return redirect('chamcong')
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', 'Bảng chấm công tháng '.$chamcong->thang.' năm '.$chamcong->nam.' không tồn tại hoặc đã bị xoá.');
        }
        if(empty($user->id_chi_nhanh)){
            $query=DB::table($tenbang);
        }
      else{
        $query=DB::table($tenbang)->where('id_chi_nhanh',$user->id_chi_nhanh);
      }
       
        $disabled=false;
        $nhansu=$query->first();
        if(!empty($nhansu)){

            if(!empty($user->id_chi_nhanh))
                if($user->role->code=="ketoanchinhanh"&&$nhansu->ktcn_duyet){
                    $disabled=true;
                }
                if($user->role->code=="ketoantruongchinhanh"&&$nhansu->kttcn_duyet){
                    $disabled=true;
                }
                if($user->role->code=="giamdocchinhanh"&&$nhansu->gdcn_duyet){
                    $disabled=true;
                }
            else{

            }
        }
       
        $query->where('company_id',$user->company_id);
        if(isset($search_phong_ban)){
            $query->where('phong_ban_id',$search_phong_ban);
        }

        if(isset($search_bo_phan)){
            $query->where('bo_phan_id',$search_bo_phan);
        }

        if(isset($search_chuc_vu)){
            $query->whereIn('id_chuc_vu',$search_chuc_vu);
        }

        if(isset($search_tinh)){
            $query->where('id_tinh',$search_tinh);
        }
        if(isset($search_chi_nhanh)){
            $query->where('id_chi_nhanh',$search_chi_nhanh);
        }

        if(isset($search)){
            $query->where(function($query)use($search){
                $query->orWhere('ho_ten',$search);
                $query->orWhere('ma',$search);
            });
        }
       
        $chitiets =$query->paginate($perPage, ['*'], 'page', $page);

        $tochus = $this->getDataByName('ToChuc');
        $loaiToChucs = $this->getDataByName('LoaiToChuc');
        $loaiMien = $loaiToChucs->where('ma', 'MIEN')->first();
        $loaiChiNhanh = $loaiToChucs->where('ma', 'CN')->first();
        $loaiTinh = $loaiToChucs->where('ma', 'TINH')->first();
        $miens = collect([]);
        $chinhanhs = collect([]);
        $tinhs = collect([]);
        if(!empty($loaiMien)) {
            $miens = $tochus->where('loai_to_chuc_id', $loaiMien->id);
        }
        if(!empty($loaiChiNhanh)) {
            $chinhanhs = $tochus->where('loai_to_chuc_id', $loaiChiNhanh->id);
        }
        if(!empty($loaiTinh)) {
            $tinhs = $tochus->where('loai_to_chuc_id', $loaiTinh->id);
        }

        $configToChucs = $this->getDataByName('ConfigToChuc');
        $ten_hien_thi_mien = $configToChucs->where('id_loai_to_chuc', $loaiMien->id)->first();
        $ten_hien_thi_chi_nhanh = $configToChucs->where('id_loai_to_chuc', $loaiChiNhanh->id)->first();
        $ten_hien_thi_tinh = $configToChucs->where('id_loai_to_chuc', $loaiTinh->id)->first();

        $loaiPhongBans = $this->getDataByName('LoaiPhongBan');
        $phongBans = $this->getDataByName('PhongBan');
        $loaiPhong = $loaiPhongBans->where('ma', 'P')->first();
        $loaiBoPhan = $loaiPhongBans->where('ma', 'BP')->first();
        $phongbans = collect([]);
        $bophans = collect([]);
        if(!empty($loaiPhong)) {
            $phongbans = $phongBans->where('loai_phong_ban_id', $loaiPhong->id);
        }
        if(!empty($loaiBoPhan)) {
            $bophans = $phongBans->where('loai_phong_ban_id', $loaiBoPhan->id);
        }

        foreach ($chitiets as $chitiet){
            if(isset($chitiet->id_cua_hang)){
            $cuahang = $cuahangCollects->where('id',$chitiet->id_cua_hang)->first();
            $chitiet->cua_hang= $cuahang['ten'];
            }else{
                $chitiet->cua_hang= null;
            }

            if(isset($chitiet->bo_phan_id)){
            $bo_phan = $phongbanCollects->where('id',$chitiet->bo_phan_id)->first();
            $chitiet->bo_phan= $bo_phan['ten'];
            }else{
                $chitiet->bo_phan= null;
            }

            if(isset($chitiet->phong_ban_id)){
            $phongban =  $phongbanCollects->where('id',$chitiet->phong_ban_id)->first();
            $chitiet->phong_ban= $phongban['ten'];
            }else{
                $chitiet->phong_ban= null;
            }

            if(isset($chitiet->id_chi_nhanh)){
            $tochuc = $tochucCollects->where('id',$chitiet->id_chi_nhanh)->first();
            $chitiet->chi_nhanh= $tochuc['ten'];
            }else{
                $chitiet->chi_nhanh= null;
            }
            
            if(isset($chitiet->id_tinh)){
                $tochuc = $tochucCollects->where('id',$chitiet->id_tinh)->first();
                $chitiet->tinh= $tochuc['ten'];
                }else{
                    $chitiet->tinh= null;
                }

            if(isset($chitiet->id_chuc_vu)){
                $tochuc = $chucvuCollects->where('id',$chitiet->id_chuc_vu)->first();
                $chitiet->chuc_vu= $tochuc['ten'];
                }else{
                    $chitiet->chuc_vu= null;
                }
        }
        
        return view('luong.chamcong.chitiet.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $chitiets,
            'code_company' => mb_strtolower($company->code),
            'search'=> $search,
            'perPage' => $perPage,
            'chamcong' => $chamcong,
            'search_phong_ban'=> $search_phong_ban,
            'search_chuc_vu'=> $search_chuc_vu,
            'search_tinh'=>$search_tinh,
            'search_chi_nhanh'=>$search_chi_nhanh,
            'search_bo_phan'=>$search_bo_phan,
            'tinhs'=>$tinhs,
            'chi_nhanhs'=>$chinhanhs,
            'phongbans'=>$phongbans,
            'bophans' => $bophans,
            'chucvus'=>$this->getDataByName('ChucVu'),
            'page' => $page,
            'ten_bang'=>$tenbang,
            'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
            'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
            'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            'disabled'=>$disabled,
        ]);
    }

    function showFormChiTietThamSoChucVu(Request $request){
        $user = Auth::user();

        $search = $request->get('search');
        $search_chuc_vu= $request->get('search_chuc_vu');
        $search_time_start = $request->get('search_time_start');
        $search_time_end = $request->get('search_time_end');
    
        $query=ThamSoTinhLuongTheoChucVu::orderBy('ten');
        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ten', 'ilike', "%{$search}%");
            });
        }
        if (isset($search_chuc_vu)) {
            $query->whereIn('ma',$search_chuc_vu);
            
        }
       
        if(isset($search_time_start)&&isset($search_time_end)){
            $search_time_start = Carbon::createFromFormat(config('app.format_date'), $search_time_start)->startOfDay();
            $search_time_end = Carbon::createFromFormat(config('app.format_date'), $search_time_end)->endOfDay();
            $query->where(function ($query) use ($search_time_start, $search_time_end) {
                $query->whereBetween('tu_ngay', [$search_time_start, $search_time_end]);
                $query->orWhere('tu_ngay', null);
            });
        }
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);

        $query=$query->orderBy('ten');
        $chucvus = $this->getDataByName('ChucVu');
        $data =$query->paginate($perPage, ['*'], 'page', $page);
       
        return view('luong.thamsotinhluong.chucvu.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'chucvus'=>$chucvus,
            'perPage'=>$perPage,
            'search_chuc_vu'=>$search_chuc_vu,
            'search_time_start'=>$search_time_start,
            'search_time_end '=>$search_time_end,
        ]);
    }

    public function updateThamSoChucVu(Request $request,$id){
       
        $info=$request->all();
        $validator = Validator::make($info, [
            'tu_ngay'=>'required'
           
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        DB::beginTransaction();
        try{
                
        $thamsochucvu=ThamSoTinhLuongTheoChucVu::query()->findOrFail($id);
        $thamsochucvu->update($info);
        $chuc_vu_moi_nhat=ThamSoTinhLuongTheoChucVu::query()->where('ma',$thamsochucvu->ma)->orderBy('tu_ngay','desc')->firstOrFail();

     
        ChucVu::query()->where('ma',$chuc_vu_moi_nhat->ma)->update([
            "so_ngay_nghi_trong_thang" => $chuc_vu_moi_nhat->so_ngay_nghi_trong_thang,
            "so_tien_hoc_viec_theo_ngay" =>  $chuc_vu_moi_nhat->so_tien_hoc_viec_theo_ngay,
            "so_gio_quy_dinh" => $chuc_vu_moi_nhat->so_gio_quy_dinh
        ]);
        
        DB::commit();
            return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.update_error'));
        }
        
    }

    public function addThamSoChucVu(Request $request){

        $info=$request->all();
        $user = Auth::user();
        $validator = Validator::make($info, [
            'ma' => 'required|max:255',
            'tu_ngay'=>'required'
           
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        DB::beginTransaction();
        try{
                 
        $chuc_vu=ChucVu::where('ma',$info['ma'])->firstOrFail();
        $info['ten']=$chuc_vu->ten;
        $bacluongs=Bac::query()->where('id_chuc_vu',$chuc_vu->id)->where('muc_luong_co_ban','<>',null)->get();

        $chucvu_add=ThamSoTinhLuongTheoChucVu::create($info);
        $chuc_vu_moi_nhat=ThamSoTinhLuongTheoChucVu::query()->where('ma',$info['ma'])->orderBy('tu_ngay','desc')->first();

        if(empty($chuc_vu_moi_nhat)){
            ChucVu::query()->where('ma',$chuc_vu->ma)->update([
                "so_ngay_nghi_trong_thang" => null,
                "so_tien_hoc_viec_theo_ngay" => null,
                "so_gio_quy_dinh" => null
            ]);
        }
        else{
            ChucVu::query()->where('ma',$chuc_vu_moi_nhat->ma)->update([
                "so_ngay_nghi_trong_thang" => $chuc_vu_moi_nhat->so_ngay_nghi_trong_thang,
                "so_tien_hoc_viec_theo_ngay" =>  $chuc_vu_moi_nhat->so_tien_hoc_viec_theo_ngay,
                "so_gio_quy_dinh" => $chuc_vu_moi_nhat->so_gio_quy_dinh
            ]);
        }
       
        
        foreach($bacluongs as $bac){
            $phucaps=PhuCapBacLuong::query()->where('bac_id',$bac->id)->where('so_tien','<>',null)->get();
            $bac['id_chuc_vu']= $chucvu_add->id;
            $bac['tu_ngay']=$info['tu_ngay'];
            $bacluong=ThamSoTinhLuongTheoBacLuong::create($bac->toArray());
            
            foreach($phucaps as $phucap){
                $phucap['bac_id']=$bacluong->id;       
                $phucap['tu_ngay']=$info['tu_ngay']; 
                  
                ThamSoTinhLuongTheoPhuCap::create($phucap->toArray());
            }
           
        }
        DB::commit();
            return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            Log::error($exception);  
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.update_error'));
        }
    }

    public function deleteThamSoChucVu($id){
        $user = Auth::user();
      
        DB::beginTransaction();
        try{
            $chucvu=ThamSoTinhLuongTheoChucVu::query()->findOrFail($id);
           
            $bacluongs=ThamSoTinhLuongTheoBacLuong::query()->where('id_chuc_vu',$chucvu->id)->get();
            foreach($bacluongs as $bacluong){
                $this->deleteThamSoBacLuong($bacluong->id);
            }
           
            ThamSoTinhLuongTheoChucVu::query()->where('id',$id)->delete();

            $chuc_vu_moi_nhat=ThamSoTinhLuongTheoChucVu::query()->where('ma',$chucvu->ma)->orderBy('tu_ngay','desc')->first();
            if(empty($chuc_vu_moi_nhat)){
                ChucVu::query()->where('ma',$chucvu->ma)->update([
                    "so_ngay_nghi_trong_thang" => null,
                    "so_tien_hoc_viec_theo_ngay" =>  null,
                    "so_gio_quy_dinh" =>null
                ]);
            }
            else{
                ChucVu::query()->where('ma',$chuc_vu_moi_nhat->ma)->update([
                    "so_ngay_nghi_trong_thang" => $chuc_vu_moi_nhat->so_ngay_nghi_trong_thang,
                    "so_tien_hoc_viec_theo_ngay" =>  $chuc_vu_moi_nhat->so_tien_hoc_viec_theo_ngay,
                    "so_gio_quy_dinh" => $chuc_vu_moi_nhat->so_gio_quy_dinh
                ]);
            }
            
            DB::commit();
            return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
        }
        catch(Exception $exception) {
            dd($exception);
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.delete_error'));
        }
    }

    function showFormChiTietThamSoBacLuong(Request $request,$id){
        $user = Auth::user();
        $search = $request->get('search');
        $perPage = $request->get('perpage', 50);
        $page = $request->get('page', 1);

        $chucvu=ThamSoTinhLuongTheoChucVu::query()->findOrFail($id);
        $chucvu=ChucVu::query()->where('ma',$chucvu->ma)->firstOrFail();
        $query=ThamSoTinhLuongTheoBacLuong::query()->where('id_chuc_vu',$id)->orderBy('ten');
        
        if(isset($search)) {
            $query->where(function($query) use($search){
                $query->orWhere('ten', 'ilike', "%{$search}%");
                $query->orWhere('muc_luong_co_ban', floatval($search));
            });
        }
        $bacluongs = Bac::query()->where('id_chuc_vu',$chucvu->id)->get();
        $data =$query->paginate($perPage, ['*'], 'page', $page);
        return view('luong.thamsotinhluong.chucvu.bacluong.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'bacluongs'=>$bacluongs,
            'perPage'=>$perPage,
            'id_chuc_vu'=>$id,
            'ten_chuc_vu'=>$chucvu->ten
           
        ]);
    }

    public function updateThamSoBacLuong(Request $request,$id){
    
        $info=$request->all();
        $validator = Validator::make($info, [
            'tu_ngay' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
       
        $thamsobacluong=ThamSoTinhLuongTheoBacLuong::query()->findOrFail($id);
        $thamsobacluong->update($info);
        $chucvu=ThamSoTinhLuongTheoChucVu::query()->findOrFail($thamsobacluong->id_chuc_vu);
        $thamsobacluong_moi_nhat=ThamSoTinhLuongTheoBacLuong::query()
        ->whereHas('thamSoChucVu',function($query)use($chucvu){
            $query->where('ma', $chucvu->ma);
        })->where('he_so_luong',$thamsobacluong->he_so_luong)->orderBy('tu_ngay','desc')->first();
        if(!empty($thamsobacluong_moi_nhat)){
            Bac::query()->where('he_so_luong',$thamsobacluong_moi_nhat->he_so_luong)
            ->whereHas('chucVu',function($query)use($chucvu){
                $query->where('ma', $chucvu->ma);
            })->update([
                "muc_luong_co_ban" => $thamsobacluong_moi_nhat->muc_luong_co_ban,
            ]);
        }
            return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
        
    }

    public function addThamSoBacLuong(Request $request,$id){

        $info=$request->all();
        $user = Auth::user();
      
        $validator = Validator::make($info, [
            'id' => 'required',
            'muc_luong_co_ban' => 'required',
            'tu_ngay' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        DB::beginTransaction();
        try{
        
        $chucvu=ThamSoTinhLuongTheoChucVu::query()->findOrFail($id);
        $bacluong=Bac::query()->findOrFail($info['id']);
        $phucaps=PhuCapBacLuong::query()->where('bac_id',$bacluong->id)->where('so_tien','<>',null)->get();

        $bacluong['tu_ngay']=$info['tu_ngay'];
        $bacluong['muc_luong_co_ban']=$info['muc_luong_co_ban'];
        $bacluong['id_chuc_vu']=$id;

        $thamsobacluong=ThamSoTinhLuongTheoBacLuong::query()->create($bacluong->toArray());

        $thamsobacluong_moi_nhat=ThamSoTinhLuongTheoBacLuong::query()
        ->whereHas('thamSoChucVu',function($query)use($chucvu){
            $query->where('ma', $chucvu->ma);
        })->where('he_so_luong',$thamsobacluong->he_so_luong)->orderBy('tu_ngay','desc')->first();
        if(!empty($thamsobacluong_moi_nhat)){
            Bac::query()->where('he_so_luong',$thamsobacluong_moi_nhat->he_so_luong)
            ->whereHas('chucVu',function($query)use($chucvu){
                $query->where('ma', $chucvu->ma);
            })->update([
                "muc_luong_co_ban" => $thamsobacluong_moi_nhat->muc_luong_co_ban,
            ]);
        }

    foreach($phucaps as $phucap){
        $phucap['bac_id']=$thamsobacluong->id;
        $phucap['tu_ngay']=$info['tu_ngay'];
        ThamSoTinhLuongTheoPhuCap::query()->create($phucap->toArray());
    }
 
        DB::commit();
            return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_error'));
        }
    }

    public function deleteThamSoBacLuong($id){
        $user = Auth::user();

        DB::beginTransaction();
        try{
            
            $thamsobacluong=ThamSoTinhLuongTheoBacLuong::findOrFail($id);  
            $chucvu=ThamSoTinhLuongTheoChucVu::query()->findOrFail($thamsobacluong->id_chuc_vu);
            
            $thamsophucap=ThamSoTinhLuongTheoPhuCap::where('bac_id',$id)->get();  
            foreach($thamsophucap as $thamsophucap){
                $this->deleteThamSoPhuCap($thamsophucap->id);
            }   
            $thamsobacluong->delete();   
            
            $thamsobacluong_moi_nhat=ThamSoTinhLuongTheoBacLuong::query()
        ->whereHas('thamSoChucVu',function($query)use($chucvu){
            $query->where('ma', $chucvu->ma);
        })->where('he_so_luong',$thamsobacluong->he_so_luong)->orderBy('tu_ngay','desc')->first();
        if(!empty($thamsobacluong_moi_nhat)){
            Bac::query()->where('he_so_luong',$thamsobacluong_moi_nhat->he_so_luong)
            ->whereHas('chucVu',function($query)use($chucvu){
                $query->where('ma', $chucvu->ma);
            })->update([
                "muc_luong_co_ban" => $thamsobacluong_moi_nhat->muc_luong_co_ban,
            ]);
        }
        else{
            Bac::query()->where('he_so_luong',$thamsobacluong->he_so_luong)
            ->whereHas('chucVu',function($query)use($chucvu){
                $query->where('ma', $chucvu->ma);
            })->update([
                "muc_luong_co_ban" =>null,
            ]);
        }
       
        DB::commit();
            return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.delete_error'));
        }
        
    }

    function showFormChiTietThamSoPhuCap(Request $request,$id){
        
        $user = Auth::user();
        $perPage = $request->get('perpage', 50);
        $page = $request->get('page', 1);
        $search=$request->get('search');
        $bac=ThamSoTinhLuongTheoBacLuong::query()->findOrfail($id);
        $chucvu=ThamSoTinhLuongTheoChucVu::query()->findOrfail($bac->id_chuc_vu);
        $chuc_vu_danh_muc=ChucVu::query()->where('ma',$chucvu->ma)->firstOrFail();
        $bac_danh_muc=Bac::query()->where('id_chuc_vu',$chuc_vu_danh_muc->id)->where('he_so_luong',$bac->he_so_luong)->firstOrFail();
        $phucaps = ThamSoTinhLuongTheoPhuCap::query()->where('bac_id',$id)->get();
        $loaiphucap = LoaiPhuCap::query()->whereHas('phuCapBacLuong',function($query) use($bac_danh_muc){
            $query->where('bac_id',$bac_danh_muc->id);
        })->get();
       
        foreach($phucaps as $phucap){
            if(!empty($phucap->id_loai_phu_cap)&&!empty($loaiphucap->where('id',$phucap->id_loai_phu_cap)->first())){
                $phucap->ten=$loaiphucap->where('id',$phucap->id_loai_phu_cap)->first()->ten;
            }
            else{
                $phucap->ten=null;
            }
        }
        $perPage = $request->get('perpage', 50);
        $page = $request->get('page', 1);

        $query=ThamSoTinhLuongTheoPhuCap::query()->where('bac_id',$id)->orderBy('bac_id');
      
        if(isset($search)) {                                
            $query->whereHas('loaiPhuCap', function ($query) use($search) {
              
                $query->where('ten','ilike',"%{$search}%");
            });          
        }
        $data =$query->paginate($perPage, ['*'], 'page', $page);
        return view('luong.thamsotinhluong.chucvu.bacluong.phucap.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'phucaps'=>$loaiphucap,
            'perPage'=>$perPage,      
            'bac_id'=>$id,
            'id_chuc_vu'=>$bac->id_chuc_vu,
            'ten_bac'=>$bac->ten
        ]);
    }

    public function updateThamSoPhuCap(Request $request,$id){
       
        $info=$request->all();
        $validator = Validator::make($info, [
            'tu_ngay' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        DB::beginTransaction();
        try{
      
        $thamsophucap=ThamSoTinhLuongTheoPhuCap::query()->findOrfail($id);
        $bac=ThamSoTinhLuongTheoBacLuong::findOrFail($thamsophucap->bac_id);
        $chucvu=ThamSoTinhLuongTheoChucVu::findOrFail($bac->id_chuc_vu);
        $thamsophucap->update($info);
        $thamsophucap_moi_nhat=ThamSoTinhLuongTheoPhuCap::where('id_loai_phu_cap',$thamsophucap->id_loai_phu_cap)
        ->whereHas('thamSoBac',function($query)use($bac,$chucvu){
            $query->where('he_so_luong',$bac->he_so_luong);
            $query->whereHas('thamsoChucVu',function($query)use($chucvu){
                $query->where('ma',$chucvu->ma);
            });
        })->orderBy('tu_ngay','desc')->first();
        if(!empty($thamsophucap_moi_nhat)){
            PhuCapBacLuong::query()->where('id_loai_phu_cap',$thamsophucap->id_loai_phu_cap)
            ->whereHas('bac',function($query)use($bac,$chucvu){
                $query->where('he_so_luong',$bac->he_so_luong);
                $query->whereHas('chucVu',function($query)use($chucvu){
                    $query->where('ma',$chucvu->ma);
                });
            })->update([
                "so_tien" => $thamsophucap_moi_nhat->so_tien,
            ]);
        }
        DB::commit();
            return redirect()            
            ->back()                               
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));                                                
        }
        catch(Exception $exception) { 
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.update_error'));
        }
    }

    public function addThamSoPhuCap(Request $request,$id){
    
        $info=$request->all();
        $validator = Validator::make($info, [
            'so_tien' => 'required',
            'tu_ngay' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        DB::beginTransaction();
        try{
      
       $info['bac_id']=$id;

       $thamsophucap=ThamSoTinhLuongTheoPhuCap::query()->create($info);

        $bac=ThamSoTinhLuongTheoBacLuong::findOrFail($thamsophucap->bac_id);
        $chucvu=ThamSoTinhLuongTheoChucVu::findOrFail($bac->id_chuc_vu);
        $thamsophucap->update($info);
        $thamsophucap_moi_nhat=ThamSoTinhLuongTheoPhuCap::where('id_loai_phu_cap',$thamsophucap->id_loai_phu_cap)
        ->whereHas('thamSoBac',function($query)use($bac,$chucvu){
            $query->where('he_so_luong',$bac->he_so_luong);
            $query->whereHas('thamsoChucVu',function($query)use($chucvu){
                $query->where('ma',$chucvu->ma);
            });
        })->orderBy('tu_ngay','desc')->first();
        if(!empty($thamsophucap_moi_nhat)){
            PhuCapBacLuong::query()->where('id_loai_phu_cap',$thamsophucap->id_loai_phu_cap)
            ->whereHas('bac',function($query)use($bac,$chucvu){
                $query->where('he_so_luong',$bac->he_so_luong);
                $query->whereHas('chucVu',function($query)use($chucvu){
                    $query->where('ma',$chucvu->ma);
                });
            })->update([
                "so_tien" => $thamsophucap_moi_nhat->so_tien,
            ]);
        }

        DB::commit();
            return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            return redirect()            
                ->back()     
                ->withInput()      
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_error'));
        }  
    }

    public function deleteThamSoPhuCap($id){

    DB::beginTransaction();
        try{
        $thamsophucap=ThamSoTinhLuongTheoPhuCap::query()->findOrFail($id);

        $bac=ThamSoTinhLuongTheoBacLuong::findOrFail($thamsophucap->bac_id);
        $chucvu=ThamSoTinhLuongTheoChucVu::findOrFail($bac->id_chuc_vu);
        $thamsophucap->delete();
        $thamsophucap_moi_nhat=ThamSoTinhLuongTheoPhuCap::where('id_loai_phu_cap',$thamsophucap->id_loai_phu_cap)
        ->whereHas('thamSoBac',function($query)use($bac,$chucvu){
            $query->where('he_so_luong',$bac->he_so_luong);
            $query->whereHas('thamsoChucVu',function($query)use($chucvu){
                $query->where('ma',$chucvu->ma);
            });
        })->orderBy('tu_ngay','desc')->first();
        if(!empty($thamsophucap_moi_nhat)){
            PhuCapBacLuong::query()->where('id_loai_phu_cap',$thamsophucap->id_loai_phu_cap)
            ->whereHas('bac',function($query)use($bac,$chucvu){
                $query->where('he_so_luong',$bac->he_so_luong);
                $query->whereHas('chucVu',function($query)use($chucvu){
                    $query->where('ma',$chucvu->ma);
                });
            })->update([
                "so_tien" => $thamsophucap_moi_nhat->so_tien,
            ]);
        }
        else{
            PhuCapBacLuong::query()->where('id_loai_phu_cap',$thamsophucap->id_loai_phu_cap)
            ->whereHas('bac',function($query)use($bac,$chucvu){
                $query->where('he_so_luong',$bac->he_so_luong);
                $query->whereHas('chucVu',function($query)use($chucvu){
                    $query->where('ma',$chucvu->ma);
                });
            })->update([
                "so_tien" => null,
            ]);
        }
        
        DB::commit();
            return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            return redirect()            
                ->back()     
                ->withInput()      
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_error'));
        } 
    }

    public function syncByExcel(Request $request,$ten_bang) {
        Auth::user();
        $file = $request->file('import_excel'); 
        if(empty($file)) {
            return redirect()            
                ->back()     
                ->withInput()      
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.file_not_found')); 
        }
        
        try{
            $file_id = time();
            $fileName = $file_id. '-' . $file->getClientOriginalName();        
            $path = $file->storeAs('public/imports/', $fileName);
            
            \Excel::filter('chunk')->selectSheetsByIndex(0)->load(storage_path('app/public/imports/'.$fileName))->chunk(250, function ($reader) use($ten_bang) {
                 
                $heading = $reader->getHeading();
               
                if(in_array('ma', $heading)) {
                    $reader->each(function ($row) use($ten_bang){                                      
                        $info = $row->all();    
                                              
                        try{  
                            if(isset($info['ma'])) {
                                for($i=1;$i<=31;$i++){
                                    if($i<10){
                                        $i='0'.$i;
                                    }
                                    $loaichamcong=LoaiChamCong::where('name',$info['ngay_cong_so_'.$i])->first();
                                    if(!empty($loaichamcong)){
                                        $info['ngay_cong_so_'.$i]=$loaichamcong->id;
                                    }
                                
                                }   
            
                                $nhansu =DB::table($ten_bang)->where('ma',$info['ma'])->first();

                                if(isset($nhansu)) {
                                    DB::table($ten_bang)->where('ma',$info['ma'])->update([
                                        'ngay_cong_so_01'=>$info['ngay_cong_so_01'],
                                        'ngay_cong_so_02'=>$info['ngay_cong_so_02'],
                                        'ngay_cong_so_03'=>$info['ngay_cong_so_03'],
                                        'ngay_cong_so_04'=>$info['ngay_cong_so_04'],
                                        'ngay_cong_so_05'=>$info['ngay_cong_so_05'],
                                        'ngay_cong_so_06'=>$info['ngay_cong_so_06'],
                                        'ngay_cong_so_07'=>$info['ngay_cong_so_07'],
                                        'ngay_cong_so_08'=>$info['ngay_cong_so_08'],
                                        'ngay_cong_so_09'=>$info['ngay_cong_so_09'],
                                        'ngay_cong_so_10'=>$info['ngay_cong_so_10'],
                                        'ngay_cong_so_11'=>$info['ngay_cong_so_11'],
                                        'ngay_cong_so_12'=>$info['ngay_cong_so_12'],
                                        'ngay_cong_so_13'=>$info['ngay_cong_so_13'],
                                        'ngay_cong_so_14'=>$info['ngay_cong_so_14'],
                                        'ngay_cong_so_15'=>$info['ngay_cong_so_15'],
                                        'ngay_cong_so_16'=>$info['ngay_cong_so_16'],
                                        'ngay_cong_so_17'=>$info['ngay_cong_so_17'],
                                        'ngay_cong_so_18'=>$info['ngay_cong_so_18'],
                                        'ngay_cong_so_19'=>$info['ngay_cong_so_19'],
                                        'ngay_cong_so_20'=>$info['ngay_cong_so_20'],
                                        'ngay_cong_so_21'=>$info['ngay_cong_so_21'],
                                        'ngay_cong_so_22'=>$info['ngay_cong_so_22'],
                                        'ngay_cong_so_23'=>$info['ngay_cong_so_23'],
                                        'ngay_cong_so_24'=>$info['ngay_cong_so_24'],
                                        'ngay_cong_so_25'=>$info['ngay_cong_so_25'],
                                        'ngay_cong_so_26'=>$info['ngay_cong_so_26'],
                                        'ngay_cong_so_27'=>$info['ngay_cong_so_27'],
                                        'ngay_cong_so_28'=>$info['ngay_cong_so_28'],
                                        'ngay_cong_so_29'=>$info['ngay_cong_so_29'],
                                        'ngay_cong_so_30'=>$info['ngay_cong_so_30'],
                                        'ngay_cong_so_31'=>$info['ngay_cong_so_31'],

                                    ]);
                                }                                                                
                            }  
                            DB::commit();                           
                        }
                        catch(Exception $exception) {
                            Log::error($exception);  
                        }                                                
                    });                                                                           
                }                
            });
            
            return redirect()            
                ->back()                               
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));                                                
        }
        catch(Exception $exception) {                               
            return redirect()            
                ->back()     
                ->withInput()      
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.update_error')); 
        }  
    }

    public function showFormNgayCong($tenbang,$id)
    {
        $user = Auth::user();
        $data =[];
        $chamcongnhansu = DB::table($tenbang)->where('id',$id)->first();
        $nhansu= NhanSu::find($chamcongnhansu->nhan_su_id);
        $chamcong = ChamCong::where('ten_bang',$tenbang)->first();
        $date= Carbon::createFromFormat(config('app.format_month'),$chamcong->thang.'/'.$chamcong->nam)->startOfMonth();
        $loaichamcongs = $this->getDataByName('LoaiChamCong');
        for($i=1; $i<=$date->daysInMonth; $i++){
            if($i<10){
                $i= '0'.$i;
            }
            $ngay='ngay_cong_so_'.$i;
            $loaichamcong=$loaichamcongs->where('id',$chamcongnhansu->$ngay)->first();
            if(isset($loaichamcong))
                $data[] = [ 'id_loai_cham_cong'=>$loaichamcong->id,
                    'ngay'=>$i.'-'.$chamcong->thang.'-'.$chamcong->nam,
                    'ngay_so'=>'ngay_cong_so_'.$i,
                    'loai_cong'=>$loaichamcong->name];
            else
                $data[] = [
                    'id_loai_cham_cong'=>'',
                    'ngay'=>$i.'-'.$chamcong->thang.'-'.$chamcong->nam,
                    'ngay_so'=>'ngay_cong_so_'.$i,
                    'loai_cong'=>''
                ];
        }
        return view('luong.chamcong.chitiet.edit', [
            'menus' => $this->getMenusForUser($user),
            'loaichamcongs' => $loaichamcongs,
            'data'=>$data,
            'activeMenu' => 'ngaycong',
            'tenbang'=>$tenbang,
            'id'=>$id,
            'thang'=>$chamcong->thang,
            'nam'=>$chamcong->nam,
            'ten_nhan_su'=>$nhansu->ho_ten,
            'id_nhan_su'=>$chamcongnhansu->nhan_su_id
        ]);
    }

    public function showFormLamThemGio($tenbang,$id)
    {
        $user = Auth::user();
        $data =[];
        $chamcongnhansu = DB::table($tenbang)->where('id',$id)->first();
        $nhansu= NhanSu::find($chamcongnhansu->nhan_su_id);
        $chamcong = ChamCong::where('ten_bang',$tenbang)->first();
        $date= Carbon::createFromFormat(config('app.format_month'),$chamcong->thang.'/'.$chamcong->nam)->startOfMonth();
        $loaichamcongs = $this->getDataByName('LoaiChamCong');
        for($i=1; $i<=$date->daysInMonth; $i++){
            if($i<10){
                $i= '0'.$i;
            }
            $ngay='gio_lam_them_ngay_cong_so_'.$i;
            $data[] = [ 'so_gio'=>$chamcongnhansu->$ngay,
                        'ngay'=>$i.'-'.$chamcong->thang.'-'.$chamcong->nam,
                        'gio_lam_them'=>'gio_lam_them_ngay_cong_so_'.$i,
                        ];

        }
        return view('luong.chamcong.chitiet.lamthemgio.index', [
            'menus' => $this->getMenusForUser($user),
            'data'=>$data,
            'activeMenu' => 'lamthemgio',
            'tenbang'=>$tenbang,
            'id'=>$id,
            'thang'=>$chamcong->thang,
            'nam'=>$chamcong->nam,
            'ten_nhan_su'=>$nhansu->ho_ten,
            'id_nhan_su'=>$chamcongnhansu->nhan_su_id

        ]);
    }

    function updateNgayCong(Request $request,$tenbang){
       $info=$request->all();
       $id_nhan_su=$info['id_nhan_su'];
       $ngay_so=$info['ngay_so'];
       $value=$info['value'];
        DB::beginTransaction();
        try{
        DB::table($tenbang)->where('nhan_su_id',$id_nhan_su)->update([
            $ngay_so=>$value,
        ]);
        $chamcongnhansu= DB::table($tenbang)->where('nhan_su_id',$id_nhan_su)->first();
        if(!empty($chamcongnhansu)){
            $loaichamcongs=LoaiChamCong::query()->get();
            $tong_so_cong=0;
            for($i=1; $i<=31; $i++){
                if($i<10){
                    $i= '0'.$i;
                }
                $ngay='ngay_cong_so_'.$i;
                $loaichamcong=$loaichamcongs->where('id',$chamcongnhansu->$ngay)->first();
                if(isset($loaichamcong)&&$loaichamcong->huong_luong_co_ban)
                {
                    $tong_so_cong++;
                }
        
            }
        }
        DB::table($tenbang)->where('nhan_su_id',$id_nhan_su)->update([
            'tong_cong_huong_luong'=>$tong_so_cong,
        ]);
        $data= ['tong_cong_huong_luong'=>$tong_so_cong];
        DB::commit();
           return response()->json([
                'code'=>200,
                'message' => 'success',
                'result' => $data
            ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_error'));
        }
    }

    function updateTangCa(Request $request,$tenbang){
        $info=$request->all();
        $id_nhan_su=$info['id_nhan_su'];
        $ngay_so=$info['ngay_so'];
        $value=$info['value'];
        DB::beginTransaction();
        try{
            DB::table($tenbang)->where('nhan_su_id',$id_nhan_su)->update([
                $ngay_so=>$value,
            ]);
            $chamcongnhansu= DB::table($tenbang)->where('nhan_su_id',$id_nhan_su)->first();
            if(!empty($chamcongnhansu)){
                $tong_lam_them_gio=0;
                for($i=1; $i<=31; $i++){
                    if($i<10){
                        $i= '0'.$i;
                    }
                    $ngay='gio_lam_them_ngay_cong_so_'.$i;                 
                    $tong_lam_them_gio+=$chamcongnhansu->$ngay;
            
                }
            }
            DB::table($tenbang)->where('nhan_su_id',$id_nhan_su)->update([
                'tong_lam_them_gio'=>$tong_lam_them_gio,
            ]);
            $data= ['tong_lam_them_gio'=>$tong_lam_them_gio];
            DB::commit();
               return response()->json([
                    'code'=>200,
                    'message' => 'success',
                    'result' => $data
                ]);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_error'));
        }
    }

    public function showFormChiTietChamCong($tenbang,$id)
    {
        $user = Auth::user();
        $data_chamcong=[];
        $chamcongnhansu = DB::table($tenbang)->where('id',$id)->first();
        $data_tangca = isset($chamcongnhansu->tong_so_gio_tang_ca)?$chamcongnhansu->tong_so_gio_tang_ca:0;
        $nhansu=NhanSu::query()->where('id',$chamcongnhansu->nhan_su_id)->with('heSoLuong')->firstOrFail();
        $chamcong = ChamCong::where('ten_bang',$tenbang)->first();
        $start_month = Carbon::createFromFormat(config('app.format_month'),$chamcong->thang.'/'.$chamcong->nam)->startOfMonth();
        $end_month = Carbon::createFromFormat(config('app.format_month'),$chamcong->thang.'/'.$chamcong->nam)->endOfMonth();

        $loaichamcongs = $this->getDataByName('LoaiChamCong');
        $data_cong =array();
        foreach ($loaichamcongs as $loaichamcong){
            $ma = $loaichamcong->ma;
            $data_cong[] =['ten'=>$loaichamcong->ten,
                    'so_ngay_cong'=>isset($chamcongnhansu->$ma)?$chamcongnhansu->$ma:0
                ];
        }
        $count_tong_ngay_cong=0;
        $tong_phu_cap=0;
        foreach($data_cong as $cong){
            $count_tong_ngay_cong+=$cong['so_ngay_cong'];
        }
        foreach($nhansu->heSoLuong->phuCaps as $item){
            $tong_phu_cap+=$item['so_tien'];
        }
        for($i=1; $i<=$start_month->daysInMonth; $i++){
            if($i<10){
                $i= '0'.$i;
            }
            $ngay='ngay_cong_so_'.$i;
            $loaichamcong=$loaichamcongs->where('id',$chamcongnhansu->$ngay)->first();
            if(isset($loaichamcong))
            $data_chamcong[] = [ 'id_loai_cham_cong'=>$loaichamcong->id,
                        'ngay'=>$i.'-'.$chamcong->thang.'-'.$chamcong->nam,
                        'ngay_so'=>'ngay_cong_so_'.$i,
                        'loai_cong'=>$loaichamcong->name];
            else
                $data_chamcong[] = [
                    'id_loai_cham_cong'=>'',
                    'ngay'=>$i.'-'.$chamcong->thang.'-'.$chamcong->nam,
                    'ngay_so'=>'ngay_cong_so_'.$i,
                    'loai_cong'=>''
                ];
        }
        $data_lamthemgio=[];
        for($i=1; $i<=$start_month->daysInMonth; $i++){
            if($i<10){
                $i= '0'.$i;
            }
            $ngay='gio_lam_them_ngay_cong_so_'.$i;
            $data_lamthemgio[] = [ 'so_gio'=>$chamcongnhansu->$ngay,
                        'ngay'=>$i.'-'.$chamcong->thang.'-'.$chamcong->nam,
                        'gio_lam_them'=>'gio_lam_them_ngay_cong_so_'.$i,
                        ];

        }

        $data_phat=ChiTietPhat::query()->where('id_nhan_su',$chamcongnhansu->nhan_su_id)
        ->where('ngay','>=',$start_month)
        ->where('ngay','<=',$end_month)
        ->with('loaiPhat')->get();
        $tong_phat=0;
        foreach($data_phat as $item){
            $tong_phat+=$item->so_tien;
        }
        $disabled=false;
        if(!empty($chamcongnhansu)){

            if(!empty($user->id_chi_nhanh))
                if($user->role->code=="ketoanchinhanh"&&$chamcongnhansu->ktcn_duyet){
                    $disabled=true;
                }
                if($user->role->code=="ketoantruongchinhanh"&&$chamcongnhansu->kttcn_duyet){
                    $disabled=true;
                }
                if($user->role->code=="giamdocchinhanh"&&$chamcongnhansu->gdcn_duyet){
                    $disabled=true;
                }
            else{

            }
        }
       
        return view('luong.chamcong.chitiet.detail', [
            'menus' => $this->getMenusForUser($user),
            'nhansu'=>$nhansu,
            'activeMenu' => 'phucap',
            'tenbang'=>$tenbang,
            'id'=>$id,
            'thang'=>$chamcong->thang,
            'nam'=>$chamcong->nam,
            'chamcong'=>$chamcong,
            'ten_nhan_su'=>$nhansu->ho_ten,
            'data_cong'=>$data_cong,
            'data_tangca'=>$data_tangca,
            'id_nhan_su'=>$chamcongnhansu->nhan_su_id,
            'chamcongnhansu'=>$chamcongnhansu,
            'data_chamcong'=>$data_chamcong,
            'loaichamcongs' => $loaichamcongs,
            'data_lamthemgio'=>$data_lamthemgio,
            'loaiphats'=>$this->getDataByName('LoaiPhat'),
            'data_phat'=>$data_phat,
            'count_tong_ngay_cong'=>$count_tong_ngay_cong,
            'tong_phu_cap'=>$tong_phu_cap,
            'tong_phat'=>$tong_phat,
            'disabled'=>$disabled

        ]);
    }


    function indexThamSoTinhLuongThuong(Request $request){
        $user = Auth::user();
        $menus = Menu::query()
            ->ofRole($user->role_id)
            ->with(['children' => function($query) use($user) {
                $query->ofRole($user->role_id)
                    ->orderBy('order');
            }, 'roles'])
            ->firstLevel()
            ->orderBy('order')
            ->get();

        $perPage = $request->get('perpage', 50);
        $page = $request->get('page', 1);
        $query=LichSuThamSoTinhLuong::query();
        $data =$query->paginate($perPage, ['*'], 'page', $page);
        $thamsos =$query->where('inactive',false)->get();

        return view('luong.thamsotinhluong.thamso.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'thamsos' => $thamsos,
            'perPage'=>$perPage

        ]);
    }

    public function addThamSoTinhLuongThuong(Request $request){
        $info=$request->all();
        $user =  Auth::user();
        DB::beginTransaction();
        try{
            if(empty(!$info['tu_ngay'])){
                $info['tu_ngay']=Carbon::createFromFormat(config('app.format_date'),$info['tu_ngay']);
            }
            $info['inactive'] = true;
            $info = array_except($info, ['_token','_method','id']);
            $info['company_id']=$user->company_id;
            $thamso = LichSuThamSoTinhLuong::query()->where('ma',$info['ma'])->first();
            $info['ten'] = isset($thamso)?$thamso->ten:'';
            LichSuThamSoTinhLuong::create($info);
            DB::commit();
            return redirect()
                ->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));
        }
        catch(Exception $exception) {
            DB::rollback();
           
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.update_error'));
        }
    }



    public function updateThamSoTinhLuongThuong(Request $request,$id){

        $info=$request->all();
        DB::beginTransaction();
        try{
            $info['tu_ngay']=Carbon::createFromFormat(config('app.format_date'),$info['tu_ngay']);
            $info = array_except($info, ['_token','_method']);

            LichSuThamSoTinhLuong::query()->where('id',$id)->update($info);
            DB::commit();
            return redirect()
                ->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.update_error'));
        }
    }

    public function deleteThamSoTinhLuongThuong($id){


        DB::beginTransaction();
        try{
            if(!empty( LichSuThamSoTinhLuong::find($id))){
                $thamso= LichSuThamSoTinhLuong::find();
                if($thamso->inactive==false){
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('alert-type', 'alert-warning')
                        ->with('alert-content', __('system.delete_error'));
                }
                LichSuThamSoTinhLuong::query()->where('id',$id)->delete();
            }
            DB::commit();
            return redirect()
                ->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.delete_success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.delete_error'));
        }
    }
    
    public function print($tenbang,$id){
      
        $chamcongnhansu = DB::table($tenbang)->where('id',$id)->first();
        $chamcong = ChamCong::where('ten_bang',$tenbang)->first();
        return view('luong.chamcong.chitiet.print', [
            'chamcongnhansu' => $chamcongnhansu,
            'thang'=>$chamcong->thang,
            'nam'=>$chamcong->nam,
            'nhansu'=>NhanSu::query()->findOrFail($chamcongnhansu->nhan_su_id),
            ]);
    }

    public function khoaSo(Request $request,$id){
        $info=$request->all();
        $validator = Validator::make($info, [            
            'ngay_khoa_so' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $chamcongnhansu = ChamCong::query()->findOrFail($id);
        if($chamcongnhansu->duyet_bang_luong){
            $chamcongnhansu->ngay_khoa_so= $info['ngay_khoa_so'];
            $chamcongnhansu->khoa_so = true; 
            $chamcongnhansu->save();
            return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
        }
        else{
            return back()->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('Chưa duyệt bảng lương'));
        }
       
        
    }

    public function moSo(Request $request,$id){
        $info=$request->all();
       
        $chamcongnhansu = ChamCong::query()->findOrFail($id); 
        $chamcongnhansu->khoa_so = false; 
        $chamcongnhansu->ngay_khoa_so= null;
        $chamcongnhansu->save();
        return redirect()
        ->back()
        ->with('alert-type', 'alert-success')
        ->with('alert-content', __('system.update_success'));
        
    }

    public function duyetBangLuong(Request $request,$id){
        $user =  Auth::user();
        $info=$request->all();
        $chamcongnhansu=ChamCong::findOrFail($id);
        $tenbang=$chamcongnhansu->ten_bang;
        $validator = Validator::make($info, [            
            'ngay_thang' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        if(!empty($user->id_chi_nhanh)){
           
            if($user->role->code=="ketoanchinhanh"){
                DB::table($tenbang)->where('id_chi_nhanh',$user->id_chi_nhanh)->update([
                    'ktcn_duyet'=>true,
                    'ngay_ktcn_duyet'=>Carbon::createFromFormat(config('app.format_date'),$info['ngay_thang']),
                ]);
                return redirect()
                ->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
            }
            else if($user->role->code=="ketoantruongchinhanh")
            {
               
                DB::table($tenbang)->where('id_chi_nhanh',$user->id_chi_nhanh)->where('ktcn_duyet',true)->update([
                    'kttcn_duyet'=>true,
                    'ngay_kttcn_duyet'=>Carbon::createFromFormat(config('app.format_date'),$info['ngay_thang']),
                ]);
                return redirect()
                ->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
               
            }
            else if($user->role->code=="giamdocchinhanh"){
                DB::table($tenbang)->where('id_chi_nhanh',$user->id_chi_nhanh)->where('kttcn_duyet',true)->update([
                    'gdcn_duyet'=>true,
                    'ngay_gdcn_duyet'=>Carbon::createFromFormat(config('app.format_date'),$info['ngay_thang']),
                ]);
                return redirect()
                ->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
            }
        }
        else{  
           $nhansu= DB::table($tenbang)->where('gdcn_duyet',false)->first();
            if(!empty($nhansu)){
                $chi_nhanh=ToChuc::query()->findOrFail($nhansu->id_chi_nhanh);
                return back()->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('Giám đốc '.$chi_nhanh->ten .' chưa duyệt'));
            }
            $chamcongnhansu->duyet_bang_luong = true; 
            $chamcongnhansu->ngay_duyet= Carbon::createFromFormat(config('app.format_date'),$info['ngay_thang']);
            $chamcongnhansu->save();
            return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
        }
        
    }

    public function duyetLaiBangLuong(Request $request,$id){
        $user =  Auth::user();
        $info=$request->all();
        $tenbang=ChamCong::findOrFail($id)->ten_bang;
        $validator = Validator::make($info, [            
            'id_chi_nhanh' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
      
        DB::table($tenbang)->where('id_chi_nhanh',$info['id_chi_nhanh'])->update([
            'ktcn_duyet'=>false,
            'ngay_ktcn_duyet'=>null,
            'kttcn_duyet'=>false,
            'ngay_kttcn_duyet'=>null,
            'gdcn_duyet'=>false,
            'ngay_gdcn_duyet'=>null,
        ]);
        return redirect()
        ->back()
        ->with('alert-type', 'alert-success')
        ->with('alert-content', __('system.update_success'));
        
        
    }

    public function boDuyet(Request $request,$id){
        $info=$request->all();
       
        $chamcongnhansu = ChamCong::query()->findOrFail($id); 
        $chamcongnhansu->duyet_bang_luong = false; 
        $chamcongnhansu->ngay_duyet= null;
        $chamcongnhansu->save();
        return redirect()
        ->back()
        ->with('alert-type', 'alert-success')
        ->with('alert-content', __('system.update_success'));
        
    }
}
