<?php

namespace App\Http\Controllers;

use App\BangMaNhanSu;
use App\ChiTietBaoHiem;
use App\ChiTietCongTac;
use App\ChiTietGiamTruGiaCanh;
use App\ChiTietNghiDacBiet;
use App\CuaHang;
use App\ImportCuaHang;
use App\LoaiHopDong;
use App\LoaiNghiDacBiet;
use App\TheoDoiHopDong;
use App\ToChuc;
use App\LoaiTarget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Menu;
use App\DanhSachFileImport;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\ImportNhanSu;
use App\QuocTich;
use App\DanToc;
use App\TonGiao;
use App\ConfigToChuc;
use App\NhanSu;
use App\LoaiChamCong;
use App\Attachment;
use App\Target;
use App\Lookup;
use App\Traits\ExecuteExcel;
use App\Traits\ExecuteString;
use App\Traits\GenNo;
use App\Traits\GetDataCache;
use DB;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    use ExecuteExcel, ExecuteString, GetDataCache, GenNo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);        
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = DanhSachFileImport::query()->where('type','nhan_su');
        $query->with('details');
        $query->orderBy('updated_at','desc');
        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('name', 'ilike', "%{$search}%");
            });
        }
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $query->with(['user']);
        $data = $query->paginate($perPage, ['*'], 'page', $page);     
        $user = Auth::user();

        return view('import.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }

    public function upload(Request $request){
        $user = Auth::user();
        $userID = $user->id;
        $file = $request->file('import_excel');
        if(empty($file)) {
            return redirect()            
                    ->back()     
                    ->withInput()      
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.file_not_found')); 
        }
        DB::beginTransaction();
         try{
            $file_id=time();
            $fileName = $file_id.'_'. $file->getClientOriginalName();
            $file->storeAs('public/imports/', $fileName);
            $file = DanhSachFileImport::create([
                'name'=> $file->getClientOriginalName(),
                'link'=> 'app/public/imports/'.$fileName,
                'file_id' =>  $file_id,
                'nguoi_tao' => $userID,
                'active' =>false,
                'company_id' => $user->company_id,
            ]);
              
            if(Storage::exists('public/imports/'.$file->file_id.'_'.$file->name)){
                \Excel::filter('chunk')->selectSheetsByIndex(0)->load(storage_path('app/public/imports/'.$file->file_id.'_'.$file->name))->chunk(250, function ($reader)use($file,$userID,$user) {                                                                                                                                                                               
                    $reader->each(function ($row) use($file,$userID,$user) {                                            
                        $info = $row->all();          

                        if(isset($info['stt'])) {
                            try{
                                $info['file_id'] = $file->id;
                                if(isset($info['ho_ten'])) {
                                    $info['ho_ten'] = $this->cappitalizeEachWord($info['ho_ten']);
                                }
                                if(isset($info['cmnd'])) {
                                    $info['cmnd'] = $this->code($info['cmnd']);
                                }
                                if(isset($info['gioi_tinh'])) {
                                    $info['gioi_tinh'] = $this->cappitalizeEachWord($info['gioi_tinh']);
                                    $info['gioi_tinh'] = $this->gioiTinh($info['gioi_tinh']);
                                }
                                if(isset($info['so_yeu_li_lich'])) {
                                    $info['so_yeu_li_lich'] = $this->cappitalizeEachWord($info['so_yeu_li_lich']);
                                    $info['so_yeu_li_lich'] = $this->boolean($info['so_yeu_li_lich']);
                                }
                                if(isset($info['ban_sao_cmnd'])) {
                                    $info['ban_sao_cmnd'] = $this->cappitalizeEachWord($info['ban_sao_cmnd']);
                                    $info['ban_sao_cmnd'] = $this->boolean($info['ban_sao_cmnd']);
                                }
                                if(isset($info['ban_sao_ho_khau'])) {
                                    $info['ban_sao_ho_khau'] = $this->cappitalizeEachWord($info['ban_sao_ho_khau']);
                                    $info['ban_sao_ho_khau'] = $this->boolean($info['ban_sao_ho_khau']);
                                }
                                if(isset($info['ban_sao_giay_khai_sinh'])) {
                                    $info['ban_sao_giay_khai_sinh'] = $this->cappitalizeEachWord($info['ban_sao_giay_khai_sinh']);
                                    $info['ban_sao_giay_khai_sinh'] = $this->boolean($info['ban_sao_giay_khai_sinh']);
                                }
                                if(isset($info['ban_sao_bang_cap_chung_chi'])) {
                                    $info['ban_sao_bang_cap_chung_chi'] = $this->cappitalizeEachWord($info['ban_sao_bang_cap_chung_chi']);
                                    $info['ban_sao_bang_cap_chung_chi'] = $this->boolean($info['ban_sao_bang_cap_chung_chi']);
                                }
                                if(isset($info['anh'])) {
                                    $info['anh'] = $this->cappitalizeEachWord($info['anh']);
                                    $info['anh'] = $this->boolean($info['anh']);
                                }
                                if(isset($info['so_so_bhxh'])) {
                                    $info['so_so_bhxh'] = $this->cappitalizeEachWord($info['so_so_bhxh']);
                                    $info['so_so_bhxh'] = $this->boolean($info['so_so_bhxh']);
                                }
                                if(isset($info['quyet_dinh_nghi_viec'])) {
                                    $info['quyet_dinh_nghi_viec'] = $this->cappitalizeEachWord($info['quyet_dinh_nghi_viec']);
                                    $info['quyet_dinh_nghi_viec'] = $this->boolean($info['quyet_dinh_nghi_viec']);
                                }
                                if(isset($info['tai_khoan_ca_nhan'])) {
                                    $info['tai_khoan_ca_nhan'] = $this->cappitalizeEachWord($info['tai_khoan_ca_nhan']);
                                    $info['tai_khoan_ca_nhan'] = $this->boolean($info['tai_khoan_ca_nhan']);
                                }
                                if(isset($info['giay_ksk'])) {
                                    $info['so_y_li_lich'] = $this->cappitalizeEachWord($info['giay_ksk']);
                                    $info['giay_ksk'] = $this->boolean($info['giay_ksk']);
                                }
                                if(isset($info['cam_ket_thue'])) {
                                    $info['cam_ket_thue'] = $this->cappitalizeEachWord($info['cam_ket_thue']);
                                    $info['cam_ket_thue'] = $this->boolean($info['cam_ket_thue']);
                                }
                                if(isset($info['ngay_sinh'])) {
                                    $info['ngay_sinh'] = $this->toTimeStamp($info['ngay_sinh']);
                                }
                                if(isset($info['ngay_hoc_viec'])) {
                                    $info['ngay_hoc_viec'] = $this->toTimeStamp($info['ngay_hoc_viec']);
                                }
                                if(isset($info['ngay_thu_viec'])) {
                                    $info['ngay_thu_viec'] = $this->toTimeStamp($info['ngay_thu_viec']);
                                }
                                if(isset($info['ngay_chinh_thuc'])) {
                                    $info['ngay_chinh_thuc'] = $this->toTimeStamp($info['ngay_chinh_thuc']);
                                }
                                if(isset($info['ngay_nghi_viec'])) {
                                    $info['ngay_nghi_viec'] = $this->toTimeStamp($info['ngay_nghi_viec']);
                                }
                                if(isset($info['ngay_cap'])) {
                                    $info['ngay_cap'] = $this->toTimeStamp($info['ngay_cap']);
                                }
                                if(isset($info['nghi_thai_san'])) {
                                    $info['nghi_thai_san'] = $this->toTimeStamp($info['nghi_thai_san']);
                                }
                                if(isset($info['di_lam_sau_thai_san'])) {
                                    $info['di_lam_sau_thai_san'] = $this->toTimeStamp($info['di_lam_sau_thai_san']);
                                }
                                if(isset($info['so_dien_thoai'])) {
                                    $info['so_dien_thoai'] =  $this->trimAll($info['so_dien_thoai']);
                                }
                                if(isset($info['ma_so_thue'])) {
                                    $info['ma_so_thue'] =  $this->trimAll($info['ma_so_thue']);
                                }
                                if(isset($info['tai_khoan_ngan_hang'])) {
                                    $info['tai_khoan_ngan_hang'] =  $this->trimAll($info['tai_khoan_ngan_hang']);
                                }
                                if(isset($info['so_so_bao_hiem'])) {
                                    $info['so_so_bao_hiem'] =  $this->trimAll($info['so_so_bao_hiem']);
                                }
                                if(isset($info['ma_so_thue'])) {
                                    $info['ma_so_thue'] =  $this->trimAll($info['ma_so_thue']);
                                }
                                if(isset($info['so_con'])) {
                                    $info['so_con'] =  $this->trimAll($info['so_con']);
                                }
                                if(isset($info['email'])) {
                                    $info['email'] =  $this->trimAll($info['email']);
                                }

                                if(isset($info['tinh'])) {
                                    $info['tinh'] = $this->cappitalizeEachWord($info['tinh']);
                                    $tinh = ToChuc::query()->whereHas('loaiToChuc',function($query){
                                        $query->where('ma','TINH');
                                    })->where('ten','ilike',"%{$info['tinh']}%")->first();
                                    $info['id_tinh'] = empty($tinh)?null:$tinh->id;
                                }

                                if(isset($info['ma_hd'])) {
                                    $info['ma_hd'] = strtoupper($info['ma_hd']);
                                    switch ($info['ma_hd']){
                                        case 'NV':
                                            $info['da_nghi_viec'] = true;
                                            break;
                                        case 'TV':
                                            $info['thu_viec'] =true;
                                            $hopdong = LoaiHopDong::query()->where('ma','like',$info['ma_hd'])->first();
                                            $info['id_loai_hop_dong'] = empty($hopdong)?null:$hopdong->id;
                                            break;
                                        case 'ĐTN':
                                            $info['hoc_viec'] =true;
                                            $hopdong = LoaiHopDong::query()->where('ma','like',$info['ma_hd'])->first();
                                            $info['id_loai_hop_dong'] = empty($hopdong)?null:$hopdong->id;
                                            break;
                                        case 'CT':
                                            $info['chinh_thuc'] =true;
                                            $hopdong = LoaiHopDong::query()->where('ma','like',$info['ma_hd'])->first();
                                            $info['id_loai_hop_dong'] = empty($hopdong)?null:$hopdong->id;
                                            break;
                                        default:
                                            $hopdong = LoaiHopDong::query()->where('ma','like',$info['ma_hd'])->first();
                                            $info['id_loai_hop_dong'] = empty($hopdong)?null:$hopdong->id;
                                            break;
                                    }
                                }

                                $info['active'] = null;
                                $info['invalid'] = false;

                            }
                            catch(Exception $exception) {
                                $info['invalid'] = true;
                            }
                            $info['nguoi_cap_nhat'] = $userID;
                            $info['nguoi_tao'] = $userID;   
                            $info['company_id'] = $user->company_id;                                           
                            ImportNhanSu::create($info);                                 
                        }                                                                                                      
                    });
                    DB::commit();
                });
                
                return back()                         
                    ->with('alert-type', 'alert-success')
                    ->with('alert-content', __('system.create_success'));
            }
            return back()          
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.file_not_found'));                                    
        }
        catch(Exception $exception) {            
            DB::rollback();
            $fileName = 'public/imports/'.$file->file_id.'_'.$file->name;
            if(Storage::exists($fileName)){
                Storage::delete($fileName);
            }    

            Log::error($exception);

            return redirect()            
                ->back()     
                ->withInput()      
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.upload_error')); 
        }
    }

    public function detail(Request $request,$id)
    {   
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');
        $active = $request->get('active');
        $invalid = $request->get('invalid');
        
        $user = Auth::user();

        $fileImport = DanhSachFileImport::findOrFail($id);
        $query = ImportNhanSu::query()->where('file_id',$id);
            
        if(!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ho_ten', 'ilike', "%{$search}%");
                $query->orWhere('cmnd', 'ilike', "%{$search}%");
            });
        }

        if(isset($search_trang_thai)) {
            $query->whereIn('active', $search_trang_thai);
        }
         
        $query->orderBy('updated_at','desc');        

        $data = $query->paginate($perPage, ['*'], 'page', $page);
        
        return view('import.detail', [
            'menus' => $this->getMenusForUser($user),
            'data'=>$data,
            'id'=>$id,
            'file_import' => $fileImport,
            'search' => $search,
            'search_trang_thai' => $search_trang_thai,
            'active' => $active,
            'invalid' => $invalid,
            'quoc_gias'=>$this->getDataByName('QuocTich'),
            'dan_tocs'=> $this->getDataByName('DanToc'),
            'ton_giaos'=> $this->getDataByName('TonGiao'),
        ]);
    }
    
    public function add($id){     
        $user = Auth::user();
        $userID = $user->id;   
        $dataImportCaNhan = ImportNhanSu::query()->where('file_id', $id)->get();
        $fileImport = DanhSachFileImport::findOrFail($id);
          try{
            foreach($dataImportCaNhan as $canhan) {
                if($canhan->active == false) {
                     try{
                        $nhansu = NhanSu::create([
                            'ma' => $this->genCodeNhanSu(),
                            'ho_ten' => $canhan->ho_ten,
                            'gioi_tinh' => $canhan->gioi_tinh,
                            'ngay_sinh' => $canhan->ngay_sinh,
                            'cmnd' => $canhan->cmnd,
                            'ngay_cap' => $canhan->ngay_cap,
                            'noi_cap' => $canhan->noi_cap,
                            'ho_khau_thuong_tru' => $canhan->ho_khau_thuong_tru,
                            'cho_o_hien_tai' => $canhan->cho_o_hien_tai,
                            'so_dien_thoai' => $canhan->so_dien_thoai,
                            'email' => $canhan->email,
                            'ma_so_thue' => $canhan->ma_so_thue,
                            'tai_khoan_ngan_hang' => $canhan->tai_khoan_ngan_hang,
                            'ngay_hoc_viec' => $canhan->ngay_hoc_viec,
                            'ngay_chinh_thuc' => $canhan->ngay_chinh_thuc,
                            'ngay_thu_viec' => $canhan->ngay_thu_viec,
                            'ngay_nghi_viec' => $canhan->ngay_nghi_viec,
                            'id_tinh' => $canhan->id_tinh,
                            'id_chi_nhanh' => empty($canhan->id_tinh)?null:$canhan->tinh->parent_id,
                            'id_mien' => empty($canhan->id_tinh)?null:$canhan->tinh->parent->parent_id,
                            'id_loai_hop_dong' => $canhan->id_loai_hop_dong,
                            'da_nghi_viec' => $canhan->da_nghi_viec,
                            'thu_viec' => $canhan->thu_viec,
                            'hoc_viec' => $canhan->hoc_viec,
                            'chinh_thuc' => $canhan->chinh_thuc,
                            'trinh_do' => $canhan->trinh_do,
                            'chuyen_nganh' => $canhan->chuyen_nganh,
                            'so_so_bao_hiem' => $canhan->so_so_bao_hiem,
                            'so_yeu_li_lich' => $canhan->so_yeu_li_lich,
                            'ban_sao_cmnd' => $canhan->ban_sao_cmnd,
                            'ban_sao_ho_khau' => $canhan->ban_sao_ho_khau,
                            'ban_sao_giay_khai_sinh' => $canhan->ban_sao_giay_khai_sinh,
                            'ban_sao_bang_cap_chung_chi' => $canhan->ban_sao_bang_cap_chung_chi,
                            'anh' => $canhan->anh,
                            'so_so_bhxh' => $canhan->so_so_bhxh,
                            'quyet_dinh_nghi_viec' => $canhan->quyet_dinh_nghi_viec,
                            'tai_khoan_ca_nhan' => $canhan->tai_khoan_ca_nhan,
                            'co_giay_ksk' => $canhan->giay_ksk,
                            'cam_ket_thue' => $canhan->cam_ket_thue,
                            'nguoi_cap_nhat' => $userID,
                            'nguoi_tao' => $userID,
                            'source_id' => $canhan->file_id,
                            'company_id' => $canhan->company_id,
                        ]);


                         if(isset($canhan->thang_dong_bh)||isset($canhan->thang_chuyen_bh_ve_cn)||isset($canhan->thang_dung_dong_bao_hiem)) {
                             ChiTietBaoHiem::create([
                                 'id_nhan_su' => $nhansu->id,
                                 'ten' => 'Bảo hiểm xã hội',
                                 'thang_bat_dau' => $canhan->thang_dong_bh,
                                 'thang_chuyen_bao_hiem_ve_chi_nhanh' => $canhan->thang_chuyen_bh_ve_cn,
                                 'thang_dung_dong_bao_hiem' => $canhan->thang_dung_dong_bao_hiem,
                             ]);
                         }
                         if(isset($canhan->nghi_thai_san)||isset($canhan->di_lam_sau_thai_san)){
                             ChiTietNghiDacBiet::create([
                                 'id_nhan_su' => $nhansu->id,
                                 'id_loai_nghi_dac_biet' => LoaiNghiDacBiet::where('ten','like','Nghỉ Thai Sản')->first()->id,
                                 'ngay_bat_dau' => $canhan->nghi_thai_san,
                                 'ngay_ket_thuc' => $canhan->di_lam_sau_thai_san,
                                 'trang_thai' => true,
                             ]);
                         }
                         if(isset($canhan->id_loai_hop_dong)){
                             $hopdong = LoaiHopDong::query()->findOrFail($canhan->id_loai_hop_dong);
                             if(isset($hopdong)){
                                 switch ($hopdong->ma){
                                     case 'TV':
                                         $ngayhieuluc = $nhansu->ngay_thu_viec;
                                         break;
                                     case 'ĐTN':
                                         $ngayhieuluc = $nhansu->ngay_hoc_viec;
                                         break;
                                     case 'CT':
                                         if(isset($nhansu->ngay_chinh_thuc)){
                                             $ngay = Carbon::createFromFormat(config('app.format_date'),$nhansu->ngay_chinh_thuc)->day;
                                             $thang = Carbon::createFromFormat(config('app.format_date'),$nhansu->ngay_chinh_thuc)->month;
                                             $nam = Carbon::now()->year;
                                             $ngayhieuluc = Carbon::createFromFormat(config('app.format_date'),$ngay.'/'.$thang.'/'.$nam);
                                             if ($ngayhieuluc>Carbon::now()){
                                                 $ngayhieuluc = $ngayhieuluc->addYear(-1);
                                             }
                                         }
                                         else{
                                             $ngayhieuluc = null;
                                         }
                                         break;
                                     default:
                                         $ngayhieuluc = null;
                                         break;
                                 }
                                 TheoDoiHopDong::create([
                                     'id_nhan_su' => $nhansu->id,
                                     'loai_hop_dong' => $canhan->id_loai_hop_dong,
                                     'ngay_hieu_luc' => $ngayhieuluc,
                                     'trang_thai' => true
                                 ]);
                             }
                         }

                         if(isset($canhan->id_tinh)){
                             ChiTietCongTac::create([
                                 'id_nhan_su' => $nhansu->id,
                                 'id_tinh_moi' => $canhan->id_tinh,
                                 'id_chi_nhanh_moi' => empty($canhan->id_tinh)?null:$canhan->tinh->parent_id,
                                 'id_mien_moi' => empty($canhan->id_tinh)?null:$canhan->tinh->parent->parent_id,
                                 'active' => true
                             ]);
                         }
                        if($canhan->so_con>0){
                            for($i=1;$i<=$canhan->so_con;$i++){
                                ChiTietGiamTruGiaCanh::create([
                                    'id_nhan_su' => $nhansu->id,
                                    'ho_ten' => empty($canhan['ms_npt'.$i])?'Chưa khai':$canhan['ms_npt'.$i],
                                    'gioi_tinh' => true,
                                ]);
                            }
                        }
                        $canhan->active = true;
                    }
                     catch(QueryException $exception) {
                         $canhan->active = false;
                         $motaloi = substr($exception->getMessage(),0,15);
                         switch ($motaloi) {
                             case 'SQLSTATE[23505]':
                                 $canhan->mo_ta  = 'Trùng thông tin';
                                 break;
                             case 'SQLSTATE[23502]':
                                 $canhan->mo_ta  = 'Chưa đầy đủ thông tin';
                                 break;
                             default:
                                 $canhan->mo_ta = 'Lỗi dữ liệu';
                                 break;
                         }
                     }
                     catch(Exception $exception) {
                         $canhan->active = false;
                         $canhan->mo_ta = 'Lỗi dữ liệu';
                         Log::error($exception);
                     }
                }
            }

            DB::beginTransaction();

            try{
                $fileImport->update(['active' => true]);
                foreach($dataImportCaNhan as $canhan) {
                    $canhan->save();
                }
                DB::commit();
                
                return back()
                    ->with('alert-type', 'alert-success')
                    ->with('alert-content', __('system.import_success'));
            }
            catch(QueryException $exception) {
                DB::rollBack();
                Log::error($exception);                                       
                return redirect()            
                    ->back()                           
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.import_error'));
            }              
        }
        catch(Exception $exception) {
            Log::error($exception);
            return redirect()            
                ->back()     
                ->withInput()      
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.import_error'));
        }               
    }

    public function getDownload(Request $request, $id)
    {

        $user = Auth::user();
        $file = DanhSachFileImport::query()
            ->where('file_id', $id)
            ->first();
        if(!empty($file)){
            if(Storage::exists('public/imports/'.$file->file_id.'_'.$file->name))
            {
                return response()->download(storage_path('app/public/imports/'.$file->file_id.'_'.$file->name));
            }
            else{
                return back()
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.file_not_found'));
            }
        }
        else{
            return back()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.file_not_found'));
        }
                 
    }

    public function delete($id){

        Auth::user();
        $file = DanhSachFileImport::findOrFail($id);
        if(!empty($file)){
            DB::beginTransaction();
            try{
                $fileName = 'public/imports/'.$file->file_id.'_'.$file->name;
                if(Storage::exists($fileName)){
                    Storage::delete($fileName);
                }             
                DanhSachFileImport::destroy($id);
                ImportNhanSu::query()->where('file_id', $id)->delete();
                NhanSu::query()->where('source_id', $id)->delete();
                DB::commit();

                return back()->withInput()
                    ->with('alert-type', 'alert-success')
                    ->with('alert-content', __('system.delete_success'));                
            }
            catch(Exception $exception) {
                DB::rollback();                            
                return redirect()            
                    ->back()     
                    ->withInput()      
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.delete_file_error')); 
            }             
        } 
        
        return redirect()            
                ->back()     
                ->withInput()      
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.file_not_found')); 
    }

    /**
     * Update detail file import
     */
    public function update(Request $request, $id) {

        $user = Auth::user();
        $info = $request->all();
        $importDetail = ImportNhanSu::findOrfail($id);
        if($importDetail->active || $importDetail->invalid) {
            return back()->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', 'Dữ liệu đã import hoặc không hợp lệ.');
        }

        DB::beginTransaction();
        try{
            $info['company_id']=$user->company_id;
            $validator = Validator::make($info, [
                'ho_ten' => 'required',
                'cmnd' => 'nullable|unique_with:nhan_sus,company_id',
                'ma' => 'nullable|unique_with:nhan_sus,company_id',
                'ma_so_thue' => 'nullable|unique_with:nhan_sus,company_id',
                'tai_khoan_ngan_hang' => 'nullable|unique_with:nhan_sus,company_id',
            ],
                [
                    'cmnd.unique_with' => 'Trường cmnd đã tồn tại.',
                    'ma.unique_with' => 'Trường mã đã tồn tại.',
                    'ma_so_thue.unique_with' => 'Trường mã số thuế đã tồn tại.',
                    'tai_khoan_ngan_hang.unique_with' => 'Trường tài khoản ngân hàng đã tồn tại.',
                ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator)
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.validator'));
            }

            $info['active'] = true;
            $info['mo_ta'] =null;
            $importDetail->update($info);

            $nhansu = NhanSu::create([
                'ma' => $this->genCodeNhanSu(),
                'ho_ten' => $importDetail->ho_ten,
                'gioi_tinh' => $importDetail->gioi_tinh,
                'ngay_sinh' => $importDetail->ngay_sinh,
                'cmnd' => $importDetail->cmnd,
                'ngay_cap' => $importDetail->ngay_cap,
                'noi_cap' => $importDetail->noi_cap,
                'ho_khau_thuong_tru' => $importDetail->ho_khau_thuong_tru,
                'cho_o_hien_tai' => $importDetail->cho_o_hien_tai,
                'so_dien_thoai' => $importDetail->so_dien_thoai,
                'email' => $importDetail->email,
                'ma_so_thue' => $importDetail->ma_so_thue,
                'tai_khoan_ngan_hang' => $importDetail->tai_khoan_ngan_hang,
                'ngay_hoc_viec' => $importDetail->ngay_hoc_viec,
                'ngay_chinh_thuc' => $importDetail->ngay_chinh_thuc,
                'ngay_thu_viec' => $importDetail->ngay_thu_viec,
                'ngay_nghi_viec' => $importDetail->ngay_nghi_viec,
                'id_tinh' => $importDetail->id_tinh,
                'id_chi_nhanh' => empty($importDetail->id_tinh)?null:$importDetail->tinh->parent_id,
                'id_mien' => empty($importDetail->id_tinh)?null:$importDetail->tinh->parent->parent_id,
                'id_loai_hop_dong' => $importDetail->id_loai_hop_dong,
                'da_nghi_viec' => $importDetail->da_nghi_viec,
                'thu_viec' => $importDetail->thu_viec,
                'hoc_viec' => $importDetail->hoc_viec,
                'chinh_thuc' => $importDetail->chinh_thuc,
                'trinh_do' => $importDetail->trinh_do,
                'chuyen_nganh' => $importDetail->chuyen_nganh,
                'so_so_bao_hiem' => $importDetail->so_so_bao_hiem,
                'so_yeu_li_lich' => $importDetail->so_yeu_li_lich,
                'ban_sao_cmnd' => $importDetail->ban_sao_cmnd,
                'ban_sao_ho_khau' => $importDetail->ban_sao_ho_khau,
                'ban_sao_giay_khai_sinh' => $importDetail->ban_sao_giay_khai_sinh,
                'ban_sao_bang_cap_chung_chi' => $importDetail->ban_sao_bang_cap_chung_chi,
                'anh' => $importDetail->anh,
                'so_so_bhxh' => $importDetail->so_so_bhxh,
                'quyet_dinh_nghi_viec' => $importDetail->quyet_dinh_nghi_viec,
                'tai_khoan_ca_nhan' => $importDetail->tai_khoan_ca_nhan,
                'co_giay_ksk' => $importDetail->giay_ksk,
                'cam_ket_thue' => $importDetail->cam_ket_thue,
                'nguoi_cap_nhat' => $user->id,
                'nguoi_tao' => $user->id,
                'source_id' => $importDetail->file_id,
                'company_id' => $importDetail->company_id,
            ]);


            if(isset($importDetail->thang_dong_bh)||isset($importDetail->thang_chuyen_bh_ve_cn)||isset($importDetail->thang_dung_dong_bao_hiem)) {
                ChiTietBaoHiem::create([
                    'id_nhan_su' => $nhansu->id,
                    'ten' => 'Bảo hiểm xã hội',
                    'thang_bat_dau' => $importDetail->thang_dong_bh,
                    'thang_chuyen_bao_hiem_ve_chi_nhanh' => $importDetail->thang_chuyen_bh_ve_cn,
                    'thang_dung_dong_bao_hiem' => $importDetail->thang_dung_dong_bao_hiem,
                ]);
            }
            if(isset($importDetail->nghi_thai_san)||isset($importDetail->di_lam_sau_thai_san)){
                ChiTietNghiDacBiet::create([
                    'id_nhan_su' => $nhansu->id,
                    'id_loai_nghi_dac_biet' => LoaiNghiDacBiet::where('ten','like','Nghỉ Thai Sản')->first()->id,
                    'ngay_bat_dau' => $importDetail->nghi_thai_san,
                    'ngay_ket_thuc' => $importDetail->di_lam_sau_thai_san,
                    'trang_thai' => true,
                ]);
            }
            if(isset($importDetail->id_loai_hop_dong)){
                $hopdong = LoaiHopDong::query()->findOrFail($importDetail->id_loai_hop_dong);
                if(isset($hopdong)){
                    switch ($hopdong->ma){
                        case 'TV':
                            $ngayhieuluc = $nhansu->ngay_thu_viec;
                            break;
                        case 'ĐTN':
                            $ngayhieuluc = $nhansu->ngay_hoc_viec;
                            break;
                        case 'CT':
                            if(isset($nhansu->ngay_chinh_thuc)){
                                $ngay = Carbon::createFromFormat(config('app.format_date'),$nhansu->ngay_chinh_thuc)->day;
                                $thang = Carbon::createFromFormat(config('app.format_date'),$nhansu->ngay_chinh_thuc)->month;
                                $nam = Carbon::now()->year;
                                $ngayhieuluc = Carbon::createFromFormat(config('app.format_date'),$ngay.'/'.$thang.'/'.$nam);
                                if ($ngayhieuluc>Carbon::now()){
                                    $ngayhieuluc = $ngayhieuluc->addYear(-1);
                                }
                            }
                            else{
                                $ngayhieuluc = null;
                            }
                            break;
                        default:
                            $ngayhieuluc = null;
                            break;
                    }
                    TheoDoiHopDong::create([
                        'id_nhan_su' => $nhansu->id,
                        'loai_hop_dong' => $importDetail->id_loai_hop_dong,
                        'ngay_hieu_luc' => $ngayhieuluc,
                        'trang_thai' => true
                    ]);
                }
            }

            if(isset($importDetail->id_tinh)){
                ChiTietCongTac::create([
                    'id_nhan_su' => $nhansu->id,
                    'id_tinh_moi' => $importDetail->id_tinh,
                    'id_chi_nhanh_moi' => empty($importDetail->id_tinh)?null:$importDetail->tinh->parent_id,
                    'id_mien_moi' => empty($importDetail->id_tinh)?null:$importDetail->tinh->parent->parent_id,
                    'active' => true
                ]);
            }
            if($importDetail->so_con>0){
                for($i=1;$i<=$importDetail->so_con;$i++){
                    ChiTietGiamTruGiaCanh::create([
                        'id_nhan_su' => $nhansu->id,
                        'ho_ten' => empty($importDetail['ms_npt'.$i])?'Chưa khai':$importDetail['ms_npt'.$i],
                        'gioi_tinh' => true,
                    ]);
                }
            }
            DB::commit();
            return redirect()->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.import_success'));
        }
        catch(Exeption $exception){
            $importDetail->active = false;
            $importDetail->save();
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.upload_error'));
        }
    }

    public function deletedetail($id) {

        Auth::user();
        try{
            ImportNhanSu::findOrFail($id)->delete();

            return back()->withInput()
                    ->with('alert-type', 'alert-success')
                    ->with('alert-content', __('system.delete_success')); 
        }
        catch(Exception $exception) {
            return back()->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.delete_error')); 
        } 
    }

    public function getTemplateFile($name) {
        $user = Auth::user();
        $excelFile = '';
        switch ($name) {
            case 'tem_nhan_su_update_sync':
                $excelFile = public_path() . '/report/tem_nhan_su_update_sync.xlsx';
                break;            
            case 'tem_to_chuc_sync':
                $excelFile = public_path() . '/report/tem_to_chuc_sync.xlsx';
                break;
            case 'tem_phat_sync':
                $excelFile = public_path() . '/report/tem_phat_sync.xlsx';
                break;
            default:
                break;
        }        
        $this->load($excelFile, 'sheet1', function ($sheet) use (&$data, &$input) {})->download('xlsx');
    }    

    public function uploadFile(Request $request) { 
        
        $info = $request->all();
        $user = Auth::user();
        
        $validator = Validator::make($info, [            
            'file' => 'required|file|max:32768',      // max 32MB = 32768KB,              
        ]);            

        if ($validator->fails()) {  
            $message = "validation failed";
            $failedRules = $validator->failed();

            if(isset($failedRules['file']['required'])) { 
                $message = 'Tệp không được tìm thấy';
            }
            else if(isset($failedRules['file']['file'])) { 
                $message = 'Không hỗ trợ định dạng tệp';
            }
            else if(isset($failedRules['file']['max'])) { 
                $message = 'Kích thước tệp quá lớn';
            }

            return response()->json([
                'message' => $message,
                'data' => [
                    $validator->errors()->all()
                ]
            ], 400);                                         
        }
      
        $file_id=time();
        $fileUpload = $request->file;
        $fileName = $file_id. '-' . $fileUpload->getClientOriginalName();
        $fileUpload->storeAs('public/files/', $fileName);
        $path = "storage/files/" . $fileName;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data['url']=url($path);
        $data['file_id']= $file_id;
        $data['name']= $fileName;
        $data['type']= $type;
        $attachment=new Attachment();
        $attachment->link=$path;
        $attachment->file_type=$type;
        $attachment->file_icon=$request->file_icon;
        $attachment->file_id=$file_id;
        $attachment->name=$fileName;
        $attachment->file_size=$fileUpload->getClientSize();

        if(!empty($request->reference_type)){
            $attachment->reference_type=$request->reference_type;
        }
        if(!empty($request->reference_id)){
            $attachment->reference_id=$request->reference_id;
        }
        $attachment->save();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }

    public function remove(Request $request) { 
        $info = $request->all();
        $user = Auth::user();
        $validator = Validator::make($info, [            
            'file_id' => 'required',
        ]);

        if ($validator->fails()) {  
            $message = "validation failed";
            $failedRules = $validator->failed();
            if(isset($failedRules['file_id']['required'])) { 
                $message = 'Tệp không được tìm thấy';
            }
            return response()->json([
                'message' => $message,
                'data' => [
                    $validator->errors()->all()
                ]
            ], 400);
        }

        $attachment = Attachment::query()
            ->where('file_id',  $request->file_id)->first();
            
           Storage::delete('public/files/'. $attachment->name);
           $attachment->delete();
        return response()->json([
            'message' =>  'success',
        ], 200);
    }

    public function getDownloadFile(Request $request, $file_id)
    {
        Auth::user();
        $info = $request->all();

        $attachment = Attachment::query()
            ->where('file_id',  $file_id)->first();
            if(Storage::exists('public/files/'. $attachment->name))
            {
                return response()->download(storage_path('app/public/files/'.$attachment->name));
            }             
    }

    public function show(Request $request, $file_id)
    {
        $info = $request->all();
        $user = Auth::user();
        $attachment = Attachment::query()
            ->where('file_id',  $file_id)->first();
            if(Storage::exists('public/files/'. $attachment->name))
            {
                return Response::make(file_get_contents(storage_path('app/public/files/'.$attachment->name)),200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$attachment->name.'"'
                ]);
            }             
    }

    public function indexCuaHang(Request $request)
    {
        $search = $request->get('search');
        $query = DanhSachFileImport::query()->where('type','cua_hang');
        $query->with('detailCuaHangs');
        $query->orderBy('updated_at','desc');
        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('name', 'ilike', "%{$search}%");
            });
        }
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $query->with(['user']);
        $data = $query->paginate($perPage, ['*'], 'page', $page);
        $user = Auth::user();

        return view('import.cuahang.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search' => $search,
            'perPage' => $perPage,
        ]);
    }

    public function uploadCuaHang(Request $request){
        $user = Auth::user();
        $userID = $user->id;
        $file = $request->file('import_excel');
        if(empty($file)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.file_not_found'));
        }
        DB::beginTransaction();
        try{
            $file_id=time();
            $fileName = $file_id.'_'. $file->getClientOriginalName();
            $file->storeAs('public/imports/', $fileName);
            $file = DanhSachFileImport::create([
                'name'=> $file->getClientOriginalName(),
                'link'=> 'app/public/imports/'.$fileName,
                'file_id' =>  $file_id,
                'nguoi_tao' => $userID,
                'active' =>false,
                'company_id' => $user->company_id,
                'type' => 'cua_hang',
            ]);

            if(Storage::exists('public/imports/'.$file->file_id.'_'.$file->name)){
                \Excel::filter('chunk')->selectSheetsByIndex(0)->load(storage_path('app/public/imports/'.$file->file_id.'_'.$file->name))->chunk(250, function ($reader)use($file,$userID,$user) {
                    $reader->each(function ($row) use($file,$userID,$user) {
                        $info = $row->all();

                        if(isset($info['stt'])) {
                            try{
                                $info['file_id'] = $file->id;

                                if(isset($info['ma'])) {
                                    $info['ma'] = $this->code($info['ma']);
                                }
                                if(isset($info['ten'])) {
                                    $info['ten'] = $this->cappitalizeEachWord($info['ten']);
                                }
                                if(isset($info['so_dien_thoai'])) {
                                    $info['so_dien_thoai'] = $this->trimALl($info['so_dien_thoai']);
                                }
                                if(isset($info['ngay_dang_ki_kinh_doanh'])) {
                                    $info['ngay_dang_ki_kinh_doanh'] = $this->toTimeStamp($info['ngay_dang_ki_kinh_doanh']);
                                }
                                if(isset($info['ngay_khai_truong'])) {
                                    $info['ngay_khai_truong'] = $this->toTimeStamp($info['ngay_khai_truong']);
                                }
                                if(isset($info['ngay_ban_hang'])) {
                                    $info['ngay_ban_hang'] = $this->toTimeStamp($info['ngay_ban_hang']);
                                }
                                if(isset($info['fax'])) {
                                    $info['fax'] = $this->trimALl($info['fax']);
                                }
                                if(isset($info['zip_code'])) {
                                    $info['zip_code'] = $this->trimALl($info['zip_code']);
                                }
                                if(isset($info['kinh_do'])) {
                                    $info['kinh_do'] = $this->trimALl($info['kinh_do']);
                                }
                                if(isset($info['vi_do'])) {
                                    $info['vi_do'] = $this->trimALl($info['vi_do']);
                                }
                                if(isset($info['ten_chi_nhanh'])) {
                                    $info['ten_chi_nhanh'] = $this->cappitalizeEachWord($info['ten_chi_nhanh']);
                                    $chinhanh = ToChuc::query()->whereHas('loaiToChuc',function($query){
                                        $query->where('ma','CN');
                                    })->where('ten','ilike',"%{$info['ten_chi_nhanh']}%")->first();
                                    $info['ten_chi_nhanh'] = empty($chinhanh)?null:$chinhanh->id;
                                }
                                else $info['ten_chi_nhanh']=null;
                                if(isset($info['ten_tinh'])) {
                                    $info['ten_tinh'] = $this->cappitalizeEachWord($info['ten_tinh']);
                                    $tinh = ToChuc::query()->whereHas('loaiToChuc',function($query){
                                        $query->where('ma','TINH');
                                    })->where('ten','ilike',"%{$info['ten_tinh']}%")->first();
                                    if(isset($tinh)){
                                        if($tinh->parent_id == $info['ten_chi_nhanh']||$info['ten_chi_nhanh']==null){
                                            $info['id_tinh'] = $tinh->id;
                                            $info['ten_chi_nhanh'] = $tinh->parent_id;
                                        }
                                        else $info['id_tinh'] = null;
                                    }
                                    else $info['id_tinh'] = null;
                                }
                                if(isset($info['quoc_gia'])) {
                                    $quocgia = QuocTich::query()->where('ma','ilike',$info['quoc_gia'])->first();
                                    $info['quoc_gia'] = empty($quocgia)?null:$quocgia->ma;
                                }

                                $info['active'] = null;
                                $info['invalid'] = false;

                            }
                            catch(Exception $exception) {
                                $info['invalid'] = true;
                            }
                            $info['nguoi_cap_nhat'] = $userID;
                            $info['nguoi_tao'] = $userID;
                            $info['company_id'] = $user->company_id;
                            ImportCuaHang::create($info);
                        }
                    });
                    DB::commit();
                });

                return back()
                    ->with('alert-type', 'alert-success')
                    ->with('alert-content', __('system.create_success'));
            }
            return back()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.file_not_found'));
        }
        catch(Exception $exception) {
            DB::rollback();
            $fileName = 'public/imports/'.$file->file_id.'_'.$file->name;
            if(Storage::exists($fileName)){
                Storage::delete($fileName);
            }


            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.upload_error'));
        }

    }

    public function addCuaHang($id){
        $user = Auth::user();
        $userID = $user->id;
        $dataImportCuaHang = ImportCuaHang::query()->where('file_id', $id)->get();
        $fileImport = DanhSachFileImport::findOrFail($id);

        try{
            foreach($dataImportCuaHang as $cuahang) {

                if($cuahang->active == false) {
                    try{
                        if(!empty($cuahang->id_tinh)){
                            $tinh = ToChuc::where('id',$cuahang->id_tinh)->first();
                        }
                        CuaHang::create([
                            'ma' => $cuahang->ma,
                            'ten' => $cuahang->ten,
                            'ten_dia_diem' => $cuahang->ten_dia_diem,
                            'dia_chi' => $cuahang->dia_chi,
                            'quoc_gia' => $cuahang->quoc_gia,
                            'so_dien_thoai' => $cuahang->so_dien_thoai,
                            'fax' => $cuahang->fax,
                            'lat' =>$cuahang->vi_do,
                            'long' =>$cuahang->kinh_do,
                            'zip_code' => $cuahang->zip_code,
                            'id_tinh' => $cuahang->id_tinh,
                            'id_chi_nhanh' => $cuahang->ten_chi_nhanh,
                            'id_mien' => empty($cuahang->ten_chi_nhanh)?null:$cuahang->chiNhanh->parent_id,
                            'ngay_dang_ki_kinh_doanh' => $cuahang->ngay_dang_ki_kinh_doanh,
                            'ngay_khai_truong' => $cuahang->ngay_khai_truong,
                            'ngay_ban_hang' => $cuahang->ngay_ban_hang,
                            'nguoi_dai_dien' => $cuahang->nguoi_dai_dien,
                            'nguoi_lien_he' => $cuahang->nguoi_lien_he,
                            'source_id' => $cuahang->file_id,
                            'company_id' => $cuahang->company_id,
                        ]);
                        $cuahang->active = true;
                    }
                    catch(QueryException $exception) {
                        $cuahang->active = false;
                        $motaloi = substr($exception->getMessage(),0,15);
                        switch ($motaloi) {
                            case 'SQLSTATE[23505]':
                                $cuahang->mo_ta  = 'Trùng thông tin';
                                break;
                            case 'SQLSTATE[23502]':
                                $cuahang->mo_ta  = 'Chưa đầy đủ thông tin';
                                break;
                            default:
                                break;
                        }
                    }catch(Exception $exception) {
                        $cuahang->active = false;
                        $cuahang->mo_ta = 'Lỗi dữ liệu';
                        Log::error($exception);
                    }
                }
            }

            DB::beginTransaction();

            try{
                $fileImport->update(['active' => true]);
                foreach($dataImportCuaHang as $cuahang) {
                    $cuahang->save();
                }
                DB::commit();

                return back()
                    ->with('alert-type', 'alert-success')
                    ->with('alert-content', __('system.import_success'));
            }
            catch(QueryException $exception) {
                DB::rollBack();
                Log::error($exception);
                return redirect()
                    ->back()
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.import_error'));
            }
        }
        catch(Exception $exception) {
            Log::error($exception);
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.import_error'));
        }
    }

    public function detailCuaHang(Request $request,$id)
    {
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');
        $active = $request->get('active');
        $invalid = $request->get('invalid');

        $user = Auth::user();

        $fileImport = DanhSachFileImport::findOrFail($id);
        $query = ImportCuaHang::query()->where('file_id',$id);

        $ten_hien_thi_chi_nhanh = ConfigToChuc::query()->whereHas('loaiToChuc',function($query){
            $query->where('ma','CN');
        })->first();

        if(!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ten', 'ilike', "%{$search}%");
                $query->orWhere('ten_dia_diem', 'ilike', "%{$search}%");
                $query->orWhere('ma', 'ilike', "%{$search}%");
            });
        }

        if(isset($search_trang_thai)) {
            $query->whereIn('active', $search_trang_thai);
        }

        $query->orderBy('ma');

        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('import.cuahang.detail', [
            'menus' => $this->getMenusForUser($user),
            'data'=>$data,
            'id'=>$id,
            'file_import' => $fileImport,
            'search' => $search,
            'search_trang_thai' => $search_trang_thai,
            'active' => $active,
            'invalid' => $invalid,
            'quoc_gias' => $this->getDataByName('QuocTich'),
            'chinhanhs' => ToChuc::query()->whereHas('loaiToChuc',function($query){
                $query->where('ma','CN');
            })->get(),
            'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
            ]);
    }

    public function deleteCuaHang($id){

        $user = Auth::user();
        $file = DanhSachFileImport::findOrFail($id);
        if(!empty($file)){
            DB::beginTransaction();
            try{
                $fileName = 'public/imports/'.$file->file_id.'_'.$file->name;
                if(Storage::exists($fileName)){
                    Storage::delete($fileName);
                }
                DanhSachFileImport::destroy($id);
                ImportCuaHang::query()->where('file_id', $id)->delete();
                CuaHang::query()->where('source_id', $id)->delete();
                DB::commit();

                return back()->withInput()
                    ->with('alert-type', 'alert-success')
                    ->with('alert-content', __('system.delete_success'));
            }
            catch(Exception $exception) {
                DB::rollback();
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.delete_file_error'));
            }
        }
    }

    public function updateCuaHang(Request $request, $id) {

        $user = Auth::user();
        $info = $request->all();

        $importDetail = ImportCuaHang::findOrfail($id);
        if($importDetail->active || $importDetail->invalid) {
            return back()->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', 'Dữ liệu đã import hoặc không hợp lệ.');
        }

        DB::beginTransaction();
        try{
            $info['company_id']=$user->company_id;
            $validator = Validator::make($info, [
                'ten' => 'required|max:255',
                'ten_dia_diem' => 'required|max:255',
                'ma' => 'required|max:255|unique_with:cua_hangs,company_id'
            ],
                [
                    'ma.unique_with' => 'Trường mã đã tồn tại.'
                ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator)
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.validator'));
            }

            $info['source_id'] = $importDetail->file_id;
            CuaHang::create($info);
            $importDetail->active = true;
            $importDetail->mo_ta =null;
            ImportCuaHang::findOrFail($id)->update($info);
            $importDetail->save();
            DB::commit();
            return redirect()->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.import_success'));
        }
        catch(Exeption $exception){
            $importDetail->active = false;
            $importDetail->save();
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
    }

    public function deletedetailCuaHang($id) {

        Auth::user();
        try{
            ImportCuaHang::findOrFail($id)->delete();

            return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.delete_success'));
        }
        catch(Exception $exception) {
            return back()->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.delete_error'));
        }
    }

    public function getTemplateFileCuaHang() {
        Auth::user();
        $chinhanhs = ToChuc::query()->where('inactive',false)->whereHas('loaiToChuc',function($query){
            $query->where('ma','CN');
        })->orderBy('ten')->get();
        $tinhs = ToChuc::query()->where('inactive',false)->whereHas('loaiToChuc',function($query){
            $query->where('ma','TINH');
        })->orderBy('ten')->get();
        $quocgias = $this->getDataByName('QuocTich');
        if(file_exists(public_path() . '/report/tem_cua_hang_tgs.xlsx')){
            $excelFile = public_path() . '/report/tem_cua_hang_tgs.xlsx';
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$chinhanhs, &$quocgias, &$tinhs) {
                foreach($quocgias as $key => $quocgia) {
                    $rowKey = (int)$key+2;
                    $sheet->setCellValue('AA'.$rowKey,$quocgia->ten);
                }
                foreach($tinhs as $key => $tinh) {
                    $rowKey = (int)$key;
                    $sheet->setCellValue('AB'.$rowKey,$tinh->ten);
                }
                foreach($chinhanhs as $key => $chinhanh) {
                    $rowKey = (int)$key;
                    $sheet->setCellValue('AC'.$rowKey,$chinhanh->ten);
                }
            })->download('xlsx');

        }
        else{
            return back()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.file_not_found'));
        }
    }

    public function getTemplateFileChamCong() {
        Auth::user();
        $loaichamcongs = LoaiChamCong::query()->orderBy('ten')->get();
        if(file_exists(public_path() . '/report/tem_cham_cong.xlsx')){
            $excelFile = public_path() . '/report/tem_cham_cong.xlsx';
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$loaichamcongs) {
                foreach($loaichamcongs as $key => $loaichamcong) {
                    $rowKey = (int)$key;
                    $sheet->row($rowKey + 2, [
                        '','','','','','','','','','','','','','','','','','','','',
                        '','','','','','','','','','','','','','','','','','','','',
                        '','','','','','','','','','','','','','','','','','','','',
                        $loaichamcong->ten
                        ]);
                }
            })->download('xlsx');

        }
        else{
            return back()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.file_not_found'));
        }
    }

    public function getTemplateFileTarget() {
        Auth::user();
        $loaitarget = LoaiTarget::query()->orderBy('ma')->get();
        $shops=CuaHang::query()->get();
        if(file_exists(public_path() . '/report/tem_target.xlsx')){
            $excelFile = public_path() . '/report/tem_target.xlsx';           
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$loaitarget,&$shops) {
                $month_year=Carbon::now()->format('m/Y');
                $header=['Tháng','Mã','Shop'];
                
                foreach($loaitarget as  $loaitarget){                                         
                   $header[]=$loaitarget->ten;                   
                };
               
                $sheet->row( 1, $header);
                foreach($shops as $key => $shop) {
                    $rowKey = (int)$key;
                    $sheet->row($rowKey + 2, [
                        $month_year,
                        $shop->ma,
                        $shop->ten
                    ]);
                }
               
            })->download('xlsx');

        }
        else{
            return back()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.file_not_found'));
        }
    }

    public function uploadTarget(Request $request){
        $user = Auth::user();
        $userID = $user->id;
        $file = $request->file('import_excel');
        if(empty($file)) {
            return redirect()            
                    ->back()     
                    ->withInput()      
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.file_not_found')); 
        }
        DB::beginTransaction();
         try{
            $file_id=time();
            $fileName = $file_id.'_'. $file->getClientOriginalName();
            $file->storeAs('public/imports/', $fileName);
            $file = DanhSachFileImport::create([
                'name'=> $file->getClientOriginalName(),
                'link'=> 'app/public/imports/'.$fileName,
                'file_id' =>  $file_id,
                'nguoi_tao' => $userID,
                'active' =>false,
                'company_id' => $user->company_id,
            ]);
              
            if(Storage::exists('public/imports/'.$file->file_id.'_'.$file->name)){
                \Excel::filter('chunk')->selectSheetsByIndex(0)->load(storage_path('app/public/imports/'.$file->file_id.'_'.$file->name))->chunk(250, function ($reader)use($file,$userID,$user) {                                                                                                                                                                               
                    $reader->each(function ($row) use($file,$userID,$user) {                                            
                        $info = $row->all();  
                        if(isset($info['ma'])) {
                            $cuahang = CuaHang::where('ma',$info['ma'])->first();

                            if(isset($info['thang'])){
                                if(is_numeric($info['thang'])) {
                                    $info['thang'] = Carbon::createFromTimestamp(($info['thang'] - 25569) * 86400)->startOfMonth();
                                }
                                else{                    
                                    $info['thang'] = Carbon::createFromFormat(config('app.format_month'),$info['thang'])->startOfMonth();
                                }
                            }
                            
                            $loaitargets = LoaiTarget::query()->orderBy('ma')->get();
                            foreach($loaitargets as  $loaitarget){                                         
                                $ten = $this->vn_to_str(strtolower(str_replace(' ', '_', $loaitarget->ten)));
                                if(isset($info[$ten])){
                                    $target = Target::where('id_cua_hang',empty($cuahang)?null:$cuahang->id)->where('id_loai_target',$loaitarget->id)
                                        ->where('tu_ngay',$info['thang'])->first();
                                    if(!empty($target)){
                                        $target->update([
                                            'so_tien' => $info[$ten],
                                        ]);
                                    }
                                    else{
                                        Target::create([
                                            'id_cua_hang' => empty($cuahang)?null:$cuahang->id,
                                            'id_loai_target' => $loaitarget->id,
                                            'so_tien' => $info[$ten],
                                            'tu_ngay' =>  $info['thang'],
                                            'company_id' => $user->company_id
                                        ]);
                                    }
                                }                
                                    
                            };
                                                         
                        }                                                                                                      
                    });
                    DB::commit();
                });
                      
                return back()                         
                    ->with('alert-type', 'alert-success')
                    ->with('alert-content', __('system.create_success'));
            }
            return back()          
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.file_not_found'));                                    
        }
        catch(Exception $exception) {        
            DB::rollback();
            $fileName = 'public/imports/'.$file->file_id.'_'.$file->name;
            if(Storage::exists($fileName)){
                Storage::delete($fileName);
            }    

            Log::error($exception);

            return redirect()            
                ->back()     
                ->withInput()      
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.upload_error')); 
        }
    }

    public function getTemplateFileNhanSuUpdate() {
        Auth::user();
        $tongiaos = $this->getDataByName('TonGiao');
        $quocgias = $this->getDataByName('QuocTich');
        $dantocs = $this->getDataByName('DanToc');
        if(file_exists(public_path() . '/report/tem_nhan_su_update_sync.xlsx')){
            $excelFile = public_path() . '/report/tem_nhan_su_update_sync.xlsx';
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$tongiaos, &$quocgias, &$dantocs) {
                foreach($tongiaos as $key => $tongiao) {
                    $rowKey = (int)$key;
                    $sheet->row($rowKey + 2, [
                        '','','','','','','','','','','','','','','','','','','','','','','','','','','','',
                        $tongiao->ten
                    ]);
                }
                foreach($dantocs as $key => $dantoc) {
                    $rowKey = (int)$key;
                    $sheet->row($rowKey + 2, [
                        '','','','','','','','','','','','','','','','','','','','','','','','','','','',
                        $dantoc->ten
                    ]);
                }
                foreach($quocgias as $key => $quocgia) {
                    $rowKey = (int)$key;
                    $sheet->row($rowKey + 2, [
                        '','','','','','','','','','','','','','','','','','','','','','','','','','',
                        $quocgia->ten
                    ]);
                }
            })->download('xlsx');

        }
        else{
            return back()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.file_not_found'));
        }
    }

    public function getTemplateFileNhanSu() {
        Auth::user();
        $tinhs = ToChuc::query()->whereHas('loaiToChuc',function($query) {
            $query->where('ma', 'TINH');
        })->get();
        $hopdongs = $this->getDataByName('LoaiHopDong');
        if(file_exists(public_path() . '/report/tem_nhan_su_sync.xlsx')){
            $excelFile = public_path() . '/report/tem_nhan_su_sync.xlsx';
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$tinhs, &$hopdongs) {
                foreach($tinhs as $key => $tinh) {
                    $rowKey = (int)$key+2;
                    $sheet->setCellValue('BA'.$rowKey,$tinh->ten);
                }
                foreach($hopdongs as $key => $hopdong) {
                    $rowKey = (int)$key+2;
                    $sheet->setCellValue('BB'.$rowKey,$hopdong->ma);
                }
            })->download('xlsx');

        }
        else{
            return back()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.file_not_found'));
        }
    }

}
