<?php

namespace App\Http\Controllers;
use App\ChamCong;
use App\CuaHang;
use App\Lookup;
use App\PhongBan;
use App\QuanHuyen;
use App\QuocTich;
use App\TinhThanh;
use App\ToChuc;
use App\DoanhSoCuaHang;
use App\DangKyUngDungChamCong;
use App\NhanSu;
use App\BangMaChamCong;
use App\ConfigToChuc;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Menu;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\DangNhapChamCong;
use App\ChamCongCuaHang;
use App\Traits\ExecuteExcel;
use App\Traits\ExecuteString;
use App\Traits\GetDataCache;

class KhoController extends Controller
{
    use GetDataCache, ExecuteExcel, ExecuteString;   

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['dangNhapChamCong', 'dangKyChamCong', 'index', 'checkin', 'checkout']]);
    }

    public function index(Request $request)
    {
        $search_time_start = $request->get('search_time_start');
        $search_time_end = $request->get('search_time_end');
        $search_tinh_thanh = $request->get('search_tinh_thanh');
        $search_loai_cua_hang = $request->get('search_loai_cua_hang');
        $search_chi_nhanh = $request->get('search_chi_nhanh');
        $search_company = $request->get('search_company');
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');        

        if($request->headers->get('accept') =='application/json') {
            $query = CuaHang::query()->with(['tinh','quanHuyen','loaiCuaHang','tinhThanh','quocGia','chinhanh']);
            $query->withoutGlobalScope('company');            
            $query->orderBy('ten');                        

            if (isset($search_chi_nhanh)) {
                $query->where('id_chi_nhanh', $search_chi_nhanh);
            }

            if (isset($search_company)) {
                $query->where('company_id', $search_company);
            }            

            return response()->json([
                'code'    => 200,
                'message' => 'Success',
                'result'  => $query->get()
            ], 200, []);
        }
        else{
            $query = CuaHang::query()->with(['tinh','quanHuyen','loaiCuaHang','tinhThanh','quocGia','chinhanh']);

            if (isset($search_tinh_thanh)) {
                $query->where('id_tinh', $search_tinh_thanh);
            }

            if (isset($search_chi_nhanh)) {
                $query->where('id_chi_nhanh', $search_chi_nhanh);
            }

            if (isset($search_loai_cua_hang)) {
                $query->whereIn('loai_cua_hang', $search_loai_cua_hang);
            }

            if (isset($search_time_start) && isset($search_time_end)) {
                $search_time_start = Carbon::createFromFormat(config('app.format_date'), $search_time_start)->startOfDay();
                $search_time_end = Carbon::createFromFormat(config('app.format_date'), $search_time_end)->endOfDay();
                $query->where(function ($query) use ($search_time_start, $search_time_end) {
                    $query->whereBetween('ngay_dang_ki_kinh_doanh', [$search_time_start, $search_time_end]);
                    $query->orWhere('ngay_dang_ki_kinh_doanh', null);

                });
            }
            if (isset($search)) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('ten', 'ilike', "%{$search}%");
                    $query->orWhere('ten_dia_diem', 'ilike', "%{$search}%");
                    $query->orWhere('ma', 'ilike', "%{$search}%");
                });
            }

            $query->orderBy('ma');

            $user = Auth::user();
            
            $lookups = $this->getDataByName('Lookup')
                ->where('active', true);

            $tochus = $this->getDataByName('ToChuc');
            $loaiToChucs = $this->getDataByName('LoaiToChuc');
            $loaiMien = $loaiToChucs->where('ma', 'MIEN')->first();
            $loaiChiNhanh = $loaiToChucs->where('ma', 'CN')->first();
            $loaiTinh = $loaiToChucs->where('ma', 'TINH')->first();
            $chinhanhs = collect([]);
            $tinhs = collect([]);
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

            if($request->headers->get('accept')=='xlsx'){
                $data = $query->get();
                if(isset($search_chi_nhanh)){
                    $chi_nhanh = ToChuc::query()->where('id',$search_chi_nhanh)->first();
                }
                if(isset($search_tinh_thanh)){
                    $tinh = ToChuc::query()->where('id',$search_tinh_thanh)->first();
                }
                $excelFile = public_path() . '/report/tem_cua_hang.xlsx';
                $this->load($excelFile, 'Sheet1', function ($sheet) use (&$data,&$search_time_start,&$search_time_end,&$chi_nhanh,&$tinh,&$ten_hien_thi_chi_nhanh,&$ten_hien_thi_tinh) {

                    $sheet->setCellValue('D2',empty($search_time_start)?null:Carbon::parse($search_time_start)->format(config('app.format_date')));
                    $sheet->setCellValue('E2',empty($search_time_end)?null:Carbon::parse($search_time_end)->format(config('app.format_date')));
                    $sheet->setCellValue('C3',empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi);
                    $sheet->setCellValue('D3',empty($chi_nhanh)?null:$chi_nhanh->ten);
                    $sheet->setCellValue('C4',empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi);
                    $sheet->setCellValue('D4',empty($tinh)?null:$tinh->ten);
                    foreach($data as $key => $cuahang) {
                        $rowKey = (int)$key;
                        $sheet->row($rowKey + 8, [
                            $rowKey + 1,
                            $cuahang->ma,
                            $cuahang->ten,
                            $cuahang->ten_dia_diem,
                            $cuahang->dia_chi,
                            isset($cuahang->quocGia->ten)?$cuahang->quocGia->ten:'',
                            $cuahang->fax,
                            isset($cuahang->chinhanh->ten)?$cuahang->chinhanh->ten:'',
                            isset($cuahang->tinh->ten)?$cuahang->tinh->ten:'',
                            $cuahang->ngay_dang_ki_kinh_doanh,
                            $cuahang->ngay_khai_truong,
                            $cuahang->ngay_ban_hang,
                            $cuahang->so_dien_thoai,
                            $cuahang->zip_code,
                            $cuahang->nguoi_dai_dien,
                            $cuahang->nguoi_lien_he,
                        ]);
                    }
                })->download('xlsx');
            }
            else {
                $data = $query->paginate($perPage, ['*'], 'page', $page);

                return view('kho.index', [
                    'menus' => $this->getMenusForUser($user),
                    'data' => $data,
                    'search' => $search,
                    'perPage' => $perPage,
                    'tinh_thanhs' => $this->getDataByName('TinhThanh'),
                    'tinhs' => $tinhs,
                    'quan_huyens' => $this->getDataByName('QuanHuyen'),
                    'chi_nhanhs' => $chinhanhs,
                    'loai_cua_hangs' => $lookups->where('loai', 'loai_cua_hang'),
                    'search_time_start' => empty($search_time_start)?null:Carbon::parse($search_time_start)->format(config('app.format_date')),
                    'search_time_end' => empty($search_time_end)?null:Carbon::parse($search_time_end)->format(config('app.format_date')),
                    'search_tinh_thanh' => $search_tinh_thanh,
                    'search_chi_nhanh' => $search_chi_nhanh,
                    'search_loai_cua_hang' => $search_loai_cua_hang,
                    'ten_hien_thi_mien' => empty($ten_hien_thi_mien) ? 'Miền' : $ten_hien_thi_mien->ten_hien_thi,
                    'ten_hien_thi_chi_nhanh' => empty($ten_hien_thi_chi_nhanh) ? 'Chi nhánh' : $ten_hien_thi_chi_nhanh->ten_hien_thi,
                    'ten_hien_thi_tinh' => empty($ten_hien_thi_tinh) ? 'Tỉnh' : $ten_hien_thi_tinh->ten_hien_thi,
                ]);
            }
        }                    
    }

    public function showFormAdd()
    {
        $user = Auth::user();

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

        $lookups = $this->getDataByName('Lookup')
            ->where('active', true);
        return view('danhmuc.cuahang.add', [
            'menus' => $this->getMenusForUser($user),
            'miens'=>$miens,
            'chi_nhanhs'=>$chinhanhs,
            'tinhs'=>$tinhs,
            'quoc_gias'=>$this->getDataByName('QuocTich'),
            'loai_cua_hangs'=>$lookups->where('loai','loai_cua_hang'),
            'tinh_thanhs'=>$this->getDataByName('TinhThanh'),
            'quan_huyens'=>$this->getDataByName('QuanHuyen'),
            'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
            'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
            'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
        ]);
    }

    public function add(Request $request)
    {
        $info = $request->all();
        $user = Auth::user();
        $info['company_id']=$user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ten_dia_diem' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:cua_hangs,company_id'

        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);
        $info['ma_chi_nhanh']="kxd";
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        DB::beginTransaction();
        try {
            CuaHang::query()->create($info);
            DB::commit();

            return redirect()
                ->route('cuahang')
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));
        }
        catch(Exeption $exception){
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_error'));
        }
    }

    public function showFormUpdate($id)
    {
        $user = Auth::user();
        $cuahang = CuaHang::query()->where('id',$id)->with(['tinh','quanHuyen','loaiCuaHang','tinhThanh','quocGia','chinhanh'])->first();

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

        $lookups = $this->getDataByName('Lookup')
            ->where('active', true);
        return view('danhmuc.cuahang.edit', [
            'menus' => $this->getMenusForUser($user),
            'cuahang'=>$cuahang,
            'miens'=>$miens,
            'chi_nhanhs'=>$chinhanhs,
            'tinhs'=>$tinhs,
            'quoc_gias'=>$this->getDataByName('QuocTich'),
            'loai_cua_hangs'=>$lookups->where('loai','loai_cua_hang'),
            'tinh_thanhs'=>$this->getDataByName('TinhThanh'),
            'quan_huyens'=>$this->getDataByName('QuanHuyen'),
            'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
            'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
            'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
        ]);
    }

    public function update(Request $request, $id)
    {
        $info = $request->all();
        $user = Auth::user();
        if(!empty($user->company_id)){
            $info['company_id']=$user->company_id;
        }
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ten_dia_diem' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:cua_hangs,company_id,'.$id,
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
        $cuahang = CuaHang::query()->findOrFail($id);

        DB::beginTransaction();
        try {
            $cuahang->update($info);
            DB::commit();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
        }
        catch(Exeption $exception){
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_error'));
        }
    }

    public function delete($id)
    {
        Auth::user();
        CuaHang::query()->findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function syncByExcel(Request $request) {
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

            \Excel::filter('chunk')->selectSheetsByIndex(0)->load(storage_path('app/public/imports/'.$fileName))->chunk(250, function ($reader){
                $heading = $reader->getHeading();
                if(in_array('ma', $heading)) {
                    $reader->each(function ($row){
                        $info = $row->all();
                        try{
                            if(isset($info['ma'])) {
                                $info['ma'] = $this->code($info['ma']);
                                $cuahang = CuaHang::query()->where('ma', $info['ma'])->first();
                                if(isset($cuahang)) {
                                    if(isset($info['ten_cua_hang'])) {
                                        $info['ten'] = $this->cappitalizeEachWord($info['ten_cua_hang']);
                                    }
                                    if(isset($info['so_dien_thoai'])) {
                                        $info['so_dien_thoai'] = $this->trimALl($info['so_dien_thoai']);
                                    }
                                    if(isset($info['fax'])) {
                                        $info['fax'] = $this->trimALl($info['fax']);
                                    }
                                    if(isset($info['zip_code'])) {
                                        $info['zip_code'] = $this->trimALl($info['zip_code']);
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
                                    if(isset($info['kinh_do'])) {
                                        $info['long'] = $this->trimALl($info['kinh_do']);
                                    }
                                    if(isset($info['vi_do'])) {
                                        $info['lat'] = $this->trimALl($info['vi_do']);
                                    }
                                    if(isset($info['ten_chi_nhanh'])) {
                                        $info['ten_chi_nhanh'] = $this->cappitalizeEachWord($info['ten_chi_nhanh']);
                                        $chinhanh = ToChuc::query()->whereHas('loaiToChuc',function($query){
                                            $query->where('ma','CN');
                                        })->where('ten','ilike',"%{$info['ten_chi_nhanh']}%")->first();
                                        $info['id_chi_nhanh'] = empty($chinhanh)?null:$chinhanh->id;
                                    }
                                    else $info['id_chi_nhanh']=null;
                                    if(isset($info['ten_tinh'])) {
                                        $info['ten_tinh'] = $this->cappitalizeEachWord($info['ten_tinh']);
                                        $tinh = ToChuc::query()->whereHas('loaiToChuc',function($query){
                                            $query->where('ma','TINH');
                                        })->where('ten','ilike',"%{$info['ten_tinh']}%")->first();
                                        if(isset($tinh)){
                                            if($tinh->parent_id == $info['id_chi_nhanh']||$info['id_chi_nhanh']==null){
                                                $info['id_tinh'] = $tinh->id;
                                                $info['id_chi_nhanh'] = $tinh->parent_id;
                                            }
                                            else $info['id_tinh'] = null;
                                        }
                                        else $info['id_tinh'] = null;
                                    }
                                    if(isset($info['quoc_gia'])) {
                                        $quocgia = QuocTich::query()->where('ma','ilike',$info['quoc_gia'])->first();
                                        $info['quoc_gia'] = empty($quocgia)?null:$quocgia->ma;
                                    }
                                    $cuahang->update($info);
                                }
                            }
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

    public function indexDoanhSo(Request $request, $id){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $query = DoanhSoCuaHang::query()->where('id_cua_hang',$id);

        if(isset($search)){
            $query->where(function ($query) use ($search) {
                $query->orWhere('nam',$search);
            });
        }

        $query->orderBy('updated_at','desc');
        $data = $query->paginate($perPage, ['*'], 'page', $page);
            return view('danhmuc.cuahang.doanhso.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'cuahang'=>CuaHang::findOrFail($id),
            'search'=> $search,
            'perPage' => $perPage,
        ]);    
    }
    public function addDoanhSo(Request $request,$id)
    {
        Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'thang' => 'required',
            'nam' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['id_cua_hang']=$id;
        DB::beginTransaction();
        try {
            DoanhSoCuaHang::query()->create($info);
            DB::commit();

            return redirect()
                ->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));
        }
        catch(Exeption $exception){
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_error'));
        }
    }

    public function updateDoanhSo(Request $request, $id)
    {
        Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'nam' => 'required',
            'thang' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $doanhso = DoanhSoCuaHang::query()->findOrFail($id);

        DB::beginTransaction();
        try {
            $doanhso->update($info);
            DB::commit();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
        }
        catch(Exeption $exception){
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_error'));
        }
    }

    public function deleteDoanhSo($id)
    {
        Auth::user();
        DoanhSoCuaHang::query()->findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }    

    public function indexDangKyUngDungChamCong(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_mien = $request->get('search_mien');
        $search_chi_nhanh = $request->get('search_chi_nhanh');
        $search_tinh = $request->get('search_tinh');
        $search_cua_hang = $request->get('search_cua_hang');
        $search_created = $request->get('search_created');
        $query = DangKyUngDungChamCong::query()->with(['mien','tinh','chinhanh','cuaHang']);

        if(isset($search)){
            $query->where(function ($query) use ($search) {
                $query->orWhere('ho_ten',$search);
            });
        }
        if(isset($search_mien)){
            $query->where('id_mien',$search_mien);
        }
        if(isset($search_chi_nhanh)){
            $query->where('id_chi_nhanh',$search_chi_nhanh);
        }
        if(isset($search_tinh)){
            $query->where('id_tinh',$search_tinh);
        }
        if(isset($search_cua_hang)){
            $query->where('id_cua_hang', $search_cua_hang);
        }
        if(isset($search_created)){
            $query->whereIn('created', $search_created);
        }

        $query->orderBy('updated_at','desc');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

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

        $cuahangs = CuaHang::query()->get();
        $nhansus = NhanSu::query()->get();

        return view('danhmuc.cuahang.dangkyungdungchamcong.index', [
                'menus' => $this->getMenusForUser($user),
                'data' => $data,
                'search'=> $search,
                'perPage' => $perPage,
                'miens'=>$miens,
                'chinhanhs'=>$chinhanhs,
                'tinhs'=>$tinhs,
                'cuahangs'=>$cuahangs,
                'nhansus'=>$nhansus,
                'search_mien'=>$search_mien,
                'search_chi_nhanh'=>$search_chi_nhanh,
                'search_tinh'=>$search_tinh,
                'search_cua_hang'=>$search_cua_hang,
                'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
                'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
                'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
                'search_created' => $search_created
            ]);
        }
        public function addDangKyUngDungChamCong(Request $request)
        {
            $user = Auth::user();
            $info = $request->all();
            $validator = Validator::make($info, [
                'id_nhan_su' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validator)
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', __('system.validator'));
            }
            $nhansu = NhanSu::findOrFail($info['id_nhan_su']);
            if(!empty($nhansu)){
                $machamcong = BangMaChamCong::query()->where('inactive',false)->orderBy('index')->first();
                if(empty($machamcong)) {
                    return redirect()
                    ->back()
                    ->withInput()                    
                    ->with('alert-type', 'alert-warning')
                    ->with('alert-content', 'Hết mã thẻ chấm công.');
                }                            

                try{
                    DB::beginTransaction();
                    DangKyUngDungChamCong::create([
                        'ho_ten'=>$nhansu->ho_ten,
                        'ngay_sinh'=>$nhansu->ngay_sinh,
                        'cmnd'=>$nhansu->cmnd,
                        'ma'=> $nhansu->ma,
                        'so_dien_thoai'=>$nhansu->so_dien_thoai,
                        'email'=>$nhansu->email,
                        'id_mien'=> $nhansu->id_mien,
                        'id_chi_nhanh' => $nhansu->id_chi_nhanh,
                        'id_tinh'=> $nhansu->id_tinh,
                        'id_cua_hang'=> $nhansu->id_cua_hang,
                        'company_id' => $user->company_id,
                        'inactive' => false,
                        'created' => true,
                        'ma_the_cham_cong' => $machamcong->ma
                    ]);

                    $machamcong->inactive = true;
                    $machamcong->save();

                    $nhansu->ma_the_cham_cong=$machamcong->ma;
                    $nhansu->save();
                       
                    DB::commit();
            
                    return back()->withInput()
                        ->with('alert-type', 'alert-success')
                        ->with('alert-content',__('system.create_success'));
                }
        
                catch(Exception $exception){
                    DB::rollBack();
        
                    return back()                
                        ->withInput()
                        ->with('alert-type', 'alert-warning')
                        ->with('alert-content', __('system.create_error'));
                }  
            }

        return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }
    
    public function updateDangKyUngDungChamCong(Request $request, $id)
    {
        Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'cmnd' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $dkchamcong = DangKyUngDungChamCong::query()->findOrFail($id);

        DB::beginTransaction();
        try {
         
            if(!empty($info['ma_confirm'])){
                $nhansu=NhanSu::where('ma',$info['ma_confirm'])->firstOrFail();
                if(empty($nhansu->ma_the_cham_cong)){
                    $machamcong=BangMaChamCong::query()->where('inactive',false)->first();
                    if(empty($machamcong)) {
                        return redirect()
                        ->back()
                        ->withInput()                    
                        ->with('alert-type', 'alert-warning')
                        ->with('alert-content', 'Hết mã thẻ chấm công.');
                    }                            
    
                    $nhansu->ma_the_cham_cong=$machamcong->ma;
                    $nhansu->save();
                    $machamcong->inactive=true;
                    $machamcong->save();
                    $dkchamcong->ma_the_cham_cong=$machamcong->ma;
                    $dkchamcong->save();
                }  
                else{
                    $dkchamcong->ma_the_cham_cong=$nhansu->ma_the_cham_cong;
                    $dkchamcong->save();
                }   
            }
            $dkchamcong->update($info);
            DB::commit();
            return redirect()
                ->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
        }
        catch(Exeption $exception){
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_error'));
        }
    }
        
    public function deleteDangKyUngDungChamCong($id)
    {
        Auth::user();
        $dangky = DangKyUngDungChamCong::query()->findOrFail($id);
        $chamcongs = ChamCong::query()->get();
        $count = 0;

        foreach ($chamcongs as $chamcong){
            $nhansuforcount = DB::table($chamcong->ten_bang)->where('ma',$dangky->ma)->first();
            if(!empty($nhansuforcount)){
                $count+=1;
            }
        }

        DB::beginTransaction();
        try{
            if($count>0){
                $dangky->inactive = true;
                $dangky->save();
            }
            else{
                $dangky->delete();
            }

            $nhansu = NhanSu::query()->where('ma',$dangky->ma)->first();
            if(!empty($nhanSu)){
                $nhansu['ma_the_cham_cong']=null;
                $nhansu->save();
            }
           

            DB::commit();
            return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.delete_success'));
        }
        catch(Exception $ex){
            DB::rollback();
            return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.delete_error'));
        }

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function searchNhanSu($id){
        $dkchamcong = DangKyUngDungChamCong::findOrFail($id);
        $nhansu = NhanSu::query()->where('cmnd','<>',null)->where('cmnd',$dkchamcong->cmnd)
            ->orWhere('ma',$dkchamcong->ma)->first();
        $data = [];
        
       if(!empty($nhansu)){
           $data[] = $nhansu;
       }
        return response()->json($data);
    }

    public function indexChiTietChamCong(Request $request, $ma){

        $user = Auth::user();       
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_thang = $request->get('search_thang');
        $search_nam = $request->get('search_nam');
        $search_start_time = $request->get('search_start_time');
        $search_end_time = $request->get('search_end_time');
        $search_hop_le = $request->get('search_hop_le');
        $search_canh_bao = $request->get('search_canh_bao');
        $query = ChamCongCuaHang::query()->where('ma_the_cham_cong',$ma);

        if(!empty($search_start_time)&&!empty($search_end_time)){
            $search_start_time = Carbon::createFromFormat(config('app.format_date'),$search_start_time )->startOfDay();
            $search_end_time = Carbon::createFromFormat(config('app.format_date'),$search_end_time)->endOfDay();
            $query->whereBetween('thoi_gian_check_in',[$search_start_time,$search_end_time]);
        }
        else{
            if(empty($search_thang)){   
                $search_thang = Carbon::now()->month;
            }

            if(empty($search_nam)){
                $search_nam = Carbon::now()->year;
            }

            $query->where('thang',$search_thang)->where('nam',$search_nam);
        }

        if(isset($search_hop_le)){
            $query->whereIn('hop_le',$search_hop_le);   
        }

        if(isset($search_canh_bao)){
            $query->where('warning',$search_canh_bao);
        }

        if(isset($search)){
            $query->orWhere('ghi_chu','ilike',"%{$search}%");
        }

        $query->orderBy('thoi_gian_check_in','desc');
        $data = $query->paginate($perPage, ['*'], 'page', $page);
        return view('danhmuc.cuahang.dangkyungdungchamcong.chitietchamcong.index',[
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
            'dangkichamcong' => DangKyUngDungChamCong::where('ma_the_cham_cong',$ma)->firstOrFail(),
            'search_thang' => $search_thang,
            'search_nam' => $search_nam,
            'search_start_time' => $search_start_time,
            'search_end_time' => $search_end_time,
            'search_hop_le' => $search_hop_le,
            'search_canh_bao' => $search_canh_bao,
        ]);
    }

    public function updateChiTietChamCong(Request $request,$id){
        Auth::user();
        $info = $request->all();

        $chitiet = ChamCongCuaHang::query()->findOrFail($id);

        DB::beginTransaction();
        try {
            $info['warning'] = false;
            $chitiet->update($info);
            DB::commit();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
        }
        catch(Exeption $exception){
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.update_error'));

        }
    }

    public function deleteChiTietChamCong($id){
        Auth::user();
        ChamCongCuaHang::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }
}
