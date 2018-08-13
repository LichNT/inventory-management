<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 23/06/2018
 * Time: 11:25
 */

namespace App\Http\Controllers;


use App\Bac;
use App\ChamCong;
use App\ChiTietLuong;
use App\ChiTietPhat;
use App\CongNo;
use App\LichSuThanhToan;
use App\LoaiPhat;
use App\LoaiPhuCap;
use App\LoaiTarget;
use App\Menu;
use App\ChiTietBaoLanh;
use App\NhanSu;
use App\CuaHang;
use App\PhuCapBacLuong;
use App\LoaiChamCong;
use App\ChamCongCuaHang;
use App\Target;
use App\Traits\ExecuteExcel;
use App\Traits\ExecuteString;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Traits\GetDataCache;
use Illuminate\Support\Facades\DB;

class LuongController extends Controller
{
    use ExecuteString, ExecuteExcel, GetDataCache;    


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexPhuCapBacLuong(Request $request,$id_bac_luong){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');


        $query = PhuCapBacLuong::query()->where("bac_id",$id_bac_luong);

        if(isset($search)) {
        }
        $query->orderBy('id');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('luong.ngachluong.bacluong.phucap.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'loaiphucaps' => $this->getDataByName('LoaiPhuCap'),
            'search'=> $search,
            'bac_id'=> $id_bac_luong,
            'perPage' => $perPage,
        ]);
    }

    public function addPhuCapBacLuong(Request $request,$id_bac_luong){
        $user = Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'id_loai_phu_cap' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['bac_id']=$id_bac_luong;
        PhuCapBacLuong::query()
            ->create($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updatePhuCapBacLuong(Request $request, $id){
        $user = Auth::user();
        $bac = PhuCapBacLuong::query()->findOrFail($id);

        $info = $request->only([ 'id_loai_phu_cap','so_tien']);
        $bac->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deletePhuCapBacLuong($id){
        $user = Auth::user();
        $bac = PhuCapBacLuong::findOrFail($id);
        PhuCapBacLuong::destroy($id);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }


    public function indexLoaiPhuCap(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');


        $query = LoaiPhuCap::query();

        if(isset($search)) {
            $query->where(function($query) use($search){
                $query->orWhere('ten', 'ilike', "%{$search}%");
                $query->orWhere('mo_ta', 'ilike', "%{$search}%");
            });
        }
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('luong.danhmuc.loaiphucap.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
        ]);
    }

    public function addLoaiPhuCap(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        LoaiPhuCap::query()
            ->create($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updateLoaiPhuCap(Request $request, $id){
        $loaiphucap = LoaiPhuCap::query()->findOrFail($id);

        $info = $request->only([ 'ten','mo_ta']);

        $loaiphucap->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteLoaiPhuCap($id){
        Auth::user();
        LoaiPhuCap::findOrFail($id)->delete();

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }



    public function indexTarget(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_thang = empty($request->get('search_thang'))?Carbon::now()->format('m/Y'):$request->get('search_thang');
        $search_cua_hang = $request->get('search_cua_hang');
        $search_loai_target = $request->get('search_loai_target');

        $query = Target::query();

        if(isset($search)) {
            $query->where(function($query) use($search){
            });
        }

        if(isset($search_thang)) {
            $thang = Carbon::createFromFormat(config('app.format_month'),$search_thang)->startOfMonth();
            $query->where('tu_ngay',$thang);
        }
        if(isset($search_cua_hang)) {
            $query->whereIn('id_cua_hang',$search_cua_hang);
        }
        if(isset($search_loai_target)) {
            $query->whereIn('id_loai_target',$search_loai_target);
        }
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('luong.target.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'cuahangs' => CuaHang::query()->get(),
            'loaitargets' => LoaiTarget::query()->get(),
            'search'=> $search,
            'search_thang'=> $search_thang,
            'search_cua_hang'=> $search_cua_hang,
            'search_loai_target'=> $search_loai_target,
            'perPage' => $perPage,
        ]);
    }

    public function addTarget(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id'] = $user->company_id;
        $info['tu_ngay'] = empty($info['tu_ngay'])?null: Carbon::createFromFormat(config('app.format_month'),$info['tu_ngay'])->startOfMonth();
        $validator = Validator::make($info, [
            'id_cua_hang' => 'required',
            'id_loai_target' => 'required',
            'so_tien' => 'required',
            'tu_ngay' => 'required|unique_with:targets,id_cua_hang,id_loai_target,company_id'
        ],
        [
            'tu_ngay.required' => 'Tháng bắt buộc phải nhập',
            'tu_ngay.unique_with' => 'Tháng đã tồn tại target được chọn'
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        Target::query()
            ->create($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function coppyTarget(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'thang_current'=>'required',
            'thang_old'=>'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
            $thang_old = Carbon::createFromFormat(config('app.format_month'),$info['thang_old'])->startOfMonth();
            $thang_current = Carbon::createFromFormat(config('app.format_month'),$info['thang_current'])->startOfMonth();
            DB::beginTransaction();
            try{
                $target_olds = Target::query()->where('tu_ngay',$thang_old)->select('id_cua_hang','id_loai_target','so_tien','company_id')->get();
                Target::query()->where('tu_ngay',$thang_current)->delete();
            foreach ($target_olds->toArray() as $target_old){
                $target_old['tu_ngay']= $thang_current;
                Target::query()
                    ->create($target_old);
            }
            DB::commit();
                return back()
                    ->with('alert-type', 'alert-success')
                    ->with('alert-content', __('system.create_success'));
            }catch (\Exception $exception){
                DB::rollback();

            }
    }

    public function updateTarget(Request $request, $id){
        $target = Target::query()->findOrFail($id);
        $info = $request->all();
        $info['tu_ngay'] = empty($info['tu_ngay'])?null: Carbon::createFromFormat(config('app.format_month'),$info['tu_ngay'])->startOfMonth();
        $validator = Validator::make($info, [
            'id_cua_hang' => 'required',
            'id_loai_target' => 'required',            
            'tu_ngay' => 'required|unique_with:targets,id_cua_hang,id_loai_target,company_id,' . $id,
            'so_tien' => 'required',
        ],
        [
            'tu_ngay.required' => 'Tháng bắt buộc phải nhập',
            'tu_ngay.unique_with' => 'Tháng đã tồn tại target được chọn'
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $target->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteTarget($id){
        Auth::user();
        Target::findOrFail($id)->delete();

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }


    public function indexLoaiTarget(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');


        $query = LoaiTarget::query();

        if(isset($search)) {
            $query->where(function($query) use($search){
                $query->orWhere('ten', 'ilike', "%{$search}%");
                $query->orWhere('ma', 'ilike', "%{$search}%");
            });
        }
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('luong.danhmuc.loaitarget.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
        ]);
    }

    public function addLoaiTarget(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ma' => 'required|max:255',
            'ten' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        LoaiTarget::query()
            ->create($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updateLoaiTarget(Request $request, $id){
        $user = Auth::user();
        $loaitarget = LoaiTarget::query()->findOrFail($id);

        $info = $request->all();
        $validator = Validator::make($info, [
            'ma' => 'required|max:255',
            'ten' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $loaitarget->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteLoaiTarget($id){
        Auth::user();
        LoaiTarget::findOrFail($id)->delete();

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function indexLoaiPhat(Request $request){
        $user = Auth::user();        

        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');


        $query = LoaiPhat::query();

        if(isset($search)) {
            $query->where(function($query) use($search){
                $query->orWhere('ten', 'ilike', "%{$search}%");
                $query->orWhere('mo_ta', 'ilike', "%{$search}%");
            });
        }
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('luong.danhmuc.loaiphat.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
        ]);
    }

    public function addLoaiPhat(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        LoaiPhat::query()->create($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updateLoaiPhat(Request $request, $id){

        $loaiphat = LoaiPhat::query()->findOrFail($id);
        $user = Auth::user();
        $info = $request->only([ 'ten','mo_ta','so_tien','inactive']);
       
        $loaiphat->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteLoaiPhat($id){
        Auth::user();
        LoaiPhat::findOrFail($id)->delete();

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }


    public function indexPhat(Request $request){
        $user = Auth::user();       
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_loai_phat = $request->get('search_loai_phat');
        $search_thang = $request->get('search_thang');


        $query = ChiTietPhat::query()->with(['loaiPhat','nhanSu:id,ma,ho_ten']);

        if(isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhereHas('nhanSu', function($query) use ($search){
                    $query->where('ho_ten','ilike',"%{$search}%");
                });
            });
        }

        if(isset($search_loai_phat)){
            $query->whereIn('id_loai_phat',$search_loai_phat);
        }

        if(isset($search_thang)){
            $search_thang = Carbon::createFromFormat(config('datetime.format', config('app.format_month')), $search_thang);
            $query->whereMonth('ngay',$search_thang->month)->whereYear('ngay',$search_thang->year);
        }

        $query->orderBy('ngay','desc')->orderBy('id_nhan_su');
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
        return view('luong.phat.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'loaiphats' => $this->getDataByName('LoaiPhat'),
            'nhansus' =>NhanSu::query()->get(['id','ma','ho_ten','id_mien','id_chi_nhanh','id_tinh','id_cua_hang']),
            'search'=> $search,
            'perPage' => $perPage,
            'search_loai_phat' => $search_loai_phat,
            'search_thang' => $search_thang,
            'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
            'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
            'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            'miens'=>$miens,
            'chinhanhs'=>$chinhanhs,
            'tinhs'=>$tinhs,
            'cuahangs'=>$cuahangs,

        ]);
    }

    public function addPhat(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'id_nhan_su' => 'required|exists:nhan_sus,id',
            'id_loai_phat' => 'required|exists:loai_phats,id',
            'ngay' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $loaiphat = LoaiPhat::find($info['id_loai_phat']);
        $info['so_tien']=$loaiphat->so_tien;
        ChiTietPhat::query()
            ->create($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updatePhat(Request $request, $id){
        $user = Auth::user();
        $phat = ChiTietPhat::query()->findOrFail($id);
        $info = $request->only([ 'id_nhan_su','id_loai_phat','ngay']);
        $validator = Validator::make($info, [
            'id_loai_phat' => 'required|exists:loai_phats,id',
            'ngay' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $loaiphat = LoaiPhat::find($info['id_loai_phat']);
        $info['so_tien']=$loaiphat->so_tien;
        $phat->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deletePhat($id){
        $user = Auth::user();
        ChiTietPhat::findOrFail($id);
        ChiTietPhat::destroy($id);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function syncByExcelPhat(Request $request) {
        $user = Auth::user();
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
                    $reader->each(function ($row){
                        $info = $row->all();
                        try{
                            if(isset($info['stt'])) {
                                    if(isset($info['ma_nhan_su'])) {
                                        $info['ma_nhan_su'] = $this->cappitalizeEachWord($info['ma_nhan_su']);
                                       $nhan_su= NhanSu::query()->where('ma',$info['ma_nhan_su'])->first();
                                        $info['id_nhan_su'] = $nhan_su->id;
                                    }
                                    if(isset($info['ly_do_bi_phat'])) {
                                        $ly_do = $this->cappitalizeEachWord($info['ly_do_bi_phat']);
                                        $loai= LoaiPhat::where('ten','ilike',$ly_do)->first();
                                        $info['id_loai_phat'] = $loai->id;
                                        $info['so_tien'] = $loai->so_tien;
                                    }
                                    if(isset($info['ngay'])) {
                                        $info['ngay'] = $this->toTimeStamp($info['ngay']);
                                    }
                            ChiTietPhat::create($info);
                            }
                        }
                        catch(Exception $exception) {
                            Log::error($exception);
                        }
                    });

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



    public function indexLoaiChamCong(Request $request){
        $user = Auth::user();        
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');


        $query = LoaiChamCong::query();

        if(isset($search)) {
            $query->where(function($query) use($search){
                $query->orWhere('ten', 'ilike', "%{$search}%");
                $query->orWhere('mo_ta', 'ilike', "%{$search}%");
            });
        }
        $query->orderBy('ten');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('luong.danhmuc.loaichamcong.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
        ]);
    }

    public function addLoaiChamCong(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ty_le_huong_luong' => 'required',
            'huong_luong_co_ban' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        LoaiChamCong::query()->create($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updateLoaiChamCong(Request $request, $id){
        $user = Auth::user();
        $loaichamcong = LoaiChamCong::query()->findOrFail($id);

        $info = $request->all();

        $loaichamcong->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteLoaiChamCong($id){
        Auth::user();
        LoaiChamCong::findOrFail($id)->delete();

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function indexTheoDoiChamCong(Request $request){
        $user = Auth::user();       
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_thang = $request->get('search_thang');
        $search_nam = $request->get('search_nam');
        $search_mien = $request->get('search_mien');
        $search_chi_nhanh = $request->get('search_chi_nhanh');
        $search_tinh = $request->get('search_tinh');
        $search_cua_hang = $request->get('search_cua_hang');
        $search_start_time = $request->get('search_start_time');
        $search_end_time = $request->get('search_end_time');
        $search_hop_le = $request->get('search_hop_le');
        $search_canh_bao = $request->get('search_canh_bao');
        $query = ChamCongCuaHang::query()->with('nhanSu');
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

        if(isset($search_mien)){
            $query->where(function ($query) use ($search_mien) {
                $query->whereHas('nhanSu', function ($query) use ($search_mien){
                    $query->where('id_mien',$search_mien);
                });
            });
        }
        if(isset($search_chi_nhanh)){
            $query->where(function ($query) use ($search_chi_nhanh) {
                $query->whereHas('nhanSu', function ($query) use ($search_chi_nhanh){
                    $query->where('id_chi_nhanh',$search_chi_nhanh);
                });
            });
        }
        if(isset($search_tinh)){
            $query->where(function ($query) use ($search_tinh) {
                $query->whereHas('nhanSu', function ($query) use ($search_tinh){
                    $query->where('id_tinh',$search_tinh);
                });
            });
        }
        if(isset($search_cua_hang)){
            $query->where('cua_hang_id',$search_cua_hang);
        }

        if(isset($search)){
            $query->where(function ($query) use ($search) {
                $query->orWhere('ghi_chu','ilike',"%{$search}%");
                $query->orWhere('ma_the_cham_cong','ilike',"%{$search}%");
                $query->orWhereHas('nhanSu', function ($query) use ($search){
                    $query->where('ho_ten','ilike',"%{$search}%");
                });
            });
        }

        $tochus = $this->getDataByName('ToChuc');
        $loaiToChucs = $this->getDataByName('LoaiToChuc');
        $loaiMien = $loaiToChucs->where('ma', 'MIEN')->first();
        $loaiChiNhanh = $loaiToChucs->where('ma', 'CN')->first();
        $loaiTinh = $loaiToChucs->where('ma', 'TINH')->first();
        $miens= collect([]);
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

        $query->orderBy('thoi_gian_check_in','desc');
        $data = $query->paginate($perPage, ['*'], 'page', $page);
        return view('luong.theodoichamcong.index',[
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
            'search_thang' => $search_thang,
            'search_nam' => $search_nam,
            'search_mien' => $search_mien,
            'search_chi_nhanh' => $search_chi_nhanh,
            'search_tinh' => $search_tinh,
            'search_cua_hang' => $search_cua_hang,
            'search_start_time' => $search_start_time,
            'search_end_time' => $search_end_time,
            'search_hop_le' => $search_hop_le,
            'search_canh_bao' => $search_canh_bao,
            'ten_hien_thi_mien' => empty($ten_hien_thi_mien) ? 'Miền' : $ten_hien_thi_mien->ten_hien_thi,
            'ten_hien_thi_chi_nhanh' => empty($ten_hien_thi_chi_nhanh) ? 'Chi nhánh' : $ten_hien_thi_chi_nhanh->ten_hien_thi,
            'ten_hien_thi_tinh' => empty($ten_hien_thi_tinh) ? 'Tỉnh' : $ten_hien_thi_tinh->ten_hien_thi,
            'tinhs' => $tinhs,
            'chinhanhs' => $chinhanhs,
            'miens' => $miens,
            'cuahangs' => CuaHang::query()->get(),

        ]);
    }


    public function indexDanhSachTienBaoLanh(Request $request){
        $user = Auth::user();       
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_mien = $request->get('search_mien');
        $search_chi_nhanh = $request->get('search_chi_nhanh');
        $search_tinh = $request->get('search_tinh');
        $search_cua_hang = $request->get('search_cua_hang');

        $query = NhanSu::query()->whereHas('chucVu',function($query){
            $query->where('so_tien_bao_lanh','>',0);
        })->with('chucVu');

        if(isset($search)) {
           $query->where('ho_ten','ilike',"%{$search}%");          
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
            $query->where('id_cua_hang',$search_cua_hang);
        }

        $query->orderBy('ho_ten');
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
        $cuahangs = $this->getDataByName('CuaHang');
        return view('luong.danhsachtienbaolanh.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
            'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
            'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
            'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            'miens'=>$miens,
            'chinhanhs'=>$chinhanhs,
            'tinhs'=>$tinhs,
            'cuahangs'=>$cuahangs,
            'search_mien' => $search_mien,
            'search_chi_nhanh' => $search_chi_nhanh,
            'search_tinh' => $search_tinh,
            'search_cua_hang' => $search_cua_hang,

        ]);
    }

    public function indexChiTietBaoLanh(Request $request,$id){
        $user = Auth::user();       
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        
        $query = ChiTietBaoLanh::query()->where('id_nhan_su',$id);

        if(isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhereHas('nhanSu', function($query) use ($search){
                    $query->where('ho_ten','ilike',"%{$search}%");
                });
            });
        }
        $nhansu=NhanSu::findOrFail($id);
        $query->orderBy('ngay_thang','desc');
        $data = $query->paginate($perPage, ['*'], 'page', $page);
        
        return view('luong.danhsachtienbaolanh.chitietbaolanh.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
            'nhansu'=>$nhansu,

        ]);
    }

    public function addChiTietBaoLanh(Request $request,$id){
        $user = Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'so_tien' => 'required',
            'ngay_thang' => 'required',
            'loai' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['id_nhan_su']=$id;
      
        DB::beginTransaction();
        try{
         ChiTietBaoLanh::create($info);
        $nhansu=NhanSu::findOrFail($id);
        if(!empty($info['so_tien'])){
            $info['so_tien'] = str_replace(',', '', $info['so_tien']);
        }
        if($info['loai']==1) {
            $nhansu->tong_so_tien_bao_lanh_da_nop+=$info['so_tien'];
        }
        else{
            $nhansu->tong_so_tien_bao_lanh_da_tra+=$info['so_tien'];
        }
        $nhansu->save();
        
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


    public function deleteChiTietBaoLanh($id){
        $user = Auth::user();
        $chitietbaolanh = ChiTietBaoLanh::findOrFail($id);
        $nhansu=NhanSu::findOrFail($chitietbaolanh->id_nhan_su);
        DB::beginTransaction();
        try{
        
        if($chitietbaolanh->loai==true) {
            $nhansu->tong_so_tien_bao_lanh_da_nop-=$chitietbaolanh->so_tien;
        }
        else{
            $nhansu->tong_so_tien_bao_lanh_da_tra-=$chitietbaolanh->so_tien;
        }
        $nhansu->save();
        $chitietbaolanh->delete();
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

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function indexLichSuThanhToan(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_thang = empty($request->get('search_thang'))?Carbon::now()->format('m/Y'):$request->get('search_thang');
        $search_mien = $request->get('search_mien');
        $search_chi_nhanh = $request->get('search_chi_nhanh');
        $search_tinh = $request->get('search_tinh');
        $search_lan_tra_luong = $request->get('search_lan_tra_luong');
        $query = LichSuThanhToan::query();

        if(isset($search)) {
            $query->where(function($query) use($search){
            });
        }

        if(isset($search_thang)) {
            $dau_thang = Carbon::createFromFormat(config('app.format_month'),$search_thang)->startOfMonth();
            $cuoi_thang = Carbon::createFromFormat(config('app.format_month'),$search_thang)->endOfMonth();
            $query->where('ngay_giao_dich','>=',$dau_thang);
            $query->where('ngay_giao_dich','<',$cuoi_thang);
        }
        if(isset($search_mien)){                   
            $query->whereHas('nhanSu',function($query) use($search_mien){
                $query->where('id_mien',$search_mien); 
           });                                
        }
        if(isset($search_chi_nhanh)){   
            $query->whereHas('nhanSu',function($query) use($search_chi_nhanh){                
                $query->where('id_chi_nhanh',$search_chi_nhanh); 
            });      
        }
        if(isset($search_tinh)){     
            $query->whereHas('nhanSu',function($query) use($search_tinh){                
                $query->where('id_tinh',$search_tinh); 
            });                        
        }

        if(isset($search_lan_tra_luong)){                            
            $query->whereIn('lan_tra_luong',$search_lan_tra_luong);                                   
        }

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

        return view('luong.lichsuthanhtoan.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search_mien'=>$search_mien,
            'search'=>$search,
            'search_chi_nhanh'=>$search_chi_nhanh,
            'search_tinh'=>$search_tinh,
            'search_thang'=> $search_thang,
            'search_lan_tra_luong'=>$search_lan_tra_luong,
            'perPage' => $perPage,
            'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
            'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
            'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            'miens'=>$miens,
            'chinhanhs'=>$chinhanhs,
            'tinhs'=>$tinhs,
            'lantraluongs'=> [
                (object)['ten' => 'Lần 1', 'id' => 1],
                (object)['ten' => 'Lần 2', 'id' => 2],
            ]  
        ]);

    }

    function traLuong1(Request $request,$ten_bang){
        $user = Auth::user();
        $ngay_giao_dich =Carbon::createFromFormat(config('app.format_date'),$request->get('ngay_giao_dich'))->startOfDay();
        $noi_dung =$request->get('noi_dung');
         $datas = DB::table($ten_bang)->select('nhan_su_id','tra_luong_lan_1')->get();
         DB::beginTransaction();
         try {
             $lichsuthanhtoan = array();
             foreach ($datas as $data) {
                 $lichsuthanhtoan[] = [
                     'id_nhan_su' => $data->nhan_su_id,
                     'noi_dung' => $noi_dung,
                     'so_tien' => $data->tra_luong_lan_1,
                     'ngay_giao_dich' => $ngay_giao_dich,
                     'lan_tra_luong' => 1,
                     'company_id' => $user->company_id
                 ];
             }
             ChamCong::where('ten_bang',$ten_bang)->update(['trang_thai_tra_luong_lan_1'=>true]);
             LichSuThanhToan::query()->insert($lichsuthanhtoan);
             DB::commit();
             return redirect()
                 ->back()
                 ->with('alert-type', 'alert-success')
                 ->with('alert-content', __('system.create_success'));
         }catch (\Exception $exception){
             DB::rollback();
             dd($exception);
             return redirect()
                 ->back()
                 ->withInput()
                 ->with('alert-type', 'alert-warning')
                 ->with('alert-content', __('system.update_error'));
         }
    }

    function traLuong2(Request $request,$ten_bang){
        $user = Auth::user();
        $ngay_giao_dich =Carbon::createFromFormat(config('app.format_date'),$request->get('ngay_giao_dich'))->startOfDay();
        $noi_dung =$request->get('noi_dung');
        $datas = DB::table($ten_bang)->select('nhan_su_id','tra_luong_lan_2')->get();
        DB::beginTransaction();
        try {
            $lichsuthanhtoan = array();
            foreach ($datas as $data) {
                $lichsuthanhtoan[] = [
                    'id_nhan_su' => $data->nhan_su_id,
                    'noi_dung' => $noi_dung,
                    'so_tien' => $data->tra_luong_lan_2,
                    'ngay_giao_dich' => $ngay_giao_dich,
                    'lan_tra_luong' => 2,
                    'company_id' => $user->company_id
                ];
            }
            ChamCong::where('ten_bang',$ten_bang)->update(['trang_thai_tra_luong_lan_2'=>true]);
            LichSuThanhToan::query()->insert($lichsuthanhtoan);
            DB::commit();
            return redirect()
                ->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));
        }catch (\Exception $exception){
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.update_error'));
        }
    }


    function showFormTraLuongLan1(Request $request,$ten_bang){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $chamcong = ChamCong::query()->where('ten_bang',$ten_bang)->first();

        $query = DB::table($ten_bang);

        if(isset($search)) {
            $query->where(function ($query) use ($search) {
            });
        }
        $query->orderBy('id','desc');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('luong.chamcong.traluong.index1', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'ten_bang'=> $ten_bang,
            'trang_thai_thanh_toan'=> $chamcong->trang_thai_tra_luong_lan_1,
            'perPage' => $perPage,
        ]);
    }

    function updateLuongLan1($ten_bang){
        $datas = DB::table($ten_bang)->select('nhan_su_id')->get();
        $cham_cong = ChamCong::query()->where('ten_bang',$ten_bang)->first();
        $ngay=Carbon::createFromFormat(config('app.format_date'),'15/'.$cham_cong->thang.'/'.$cham_cong->nam);

            foreach ($datas as $data) {
                $luong_co_ban = 0;
                $chitietluong = ChiTietLuong::where('nhan_su_id', $data->nhan_su_id)->where('ngay_huong_luong', '<=', $ngay)->orderBy('ngay_huong_luong', 'desc')->first();

                if (isset($chitietluong->bac_id)) {
                    $luong_co_ban = $chitietluong->bacLuong->muc_luong_co_ban;
                }
                    DB::table($ten_bang)->update(['tra_luong_lan_1' => $luong_co_ban]);
            }
        return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateLuongNhanSuLan1(Request $request,$ten_bang,$id){
        $tra_luong_lan_1 = $request->get('tra_luong_lan_1');
        if(!empty( $tra_luong_lan_1)){
            $tra_luong_lan_1 = str_replace(',', '', $tra_luong_lan_1);
        }
                    DB::table($ten_bang)->where('id',$id)->update(['tra_luong_lan_1' => $tra_luong_lan_1]);
        return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateLuongNhanSuLan2(Request $request,$ten_bang,$id){
        $tra_luong_lan_2 = $request->get('tra_luong_lan_2');
        if(empty(!$tra_luong_lan_2)){
            $tra_luong_lan_2=str_replace(',', '', $tra_luong_lan_1);
        }
        DB::table($ten_bang)->where('id',$id)->update(['tra_luong_lan_2' => $tra_luong_lan_2]);
        return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function showFormTraLuongLan2(Request $request,$ten_bang){
        $user = Auth::user();
        $chamcong=ChamCong::query()->where('ten_bang',$ten_bang)->firstOrFail();
        if(!$chamcong->duyet_bang_luong){
            return redirect()
            ->back()
            ->with('alert-type', 'alert-warning')
            ->with('alert-content', __('Chưa duyệt bảng lương'));
        }
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $chamcong = ChamCong::query()->where('ten_bang',$ten_bang)->first();

        $query = DB::table($ten_bang);

        if(isset($search)) {
            $query->where(function ($query) use ($search) {
            });
        }
        $query->orderBy('id','desc');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('luong.chamcong.traluong.index2', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'ten_bang'=> $ten_bang,
            'trang_thai_thanh_toan'=> $chamcong->trang_thai_tra_luong_lan_2,
            'perPage' => $perPage,
        ]);
    }

    function updateLuongLan2($ten_bang){
        $datas = DB::table($ten_bang)->select('nhan_su_id','tra_luong_lan_1','thuc_linh')->get();
        foreach ($datas as $data) {
            $tra_luong_lan_2= ($data->thuc_linh - $data->tra_luong_lan_1)>0?($data->thuc_linh - $data->tra_luong_lan_1):0;
            DB::table($ten_bang)->update(['tra_luong_lan_2' => $tra_luong_lan_2]);
        }
        return redirect()
            ->back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function indexCongNo(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_thang = empty($request->get('search_thang'))?Carbon::now()->format('m/Y'):$request->get('search_thang');

        $query = CongNo::query();

        if(isset($search)) {
            $query->where(function($query) use($search){
            });
        }

        if(isset($search_thang)) {
            $thang = Carbon::createFromFormat(config('app.format_month'),$search_thang)->startOfMonth();
            $query->where('thang_nam',$thang);
        }
        $loaiToChucs = $this->getDataByName('LoaiToChuc');
        $tochus = $this->getDataByName('ToChuc');
        $loaiMien = $loaiToChucs->where('ma', 'MIEN')->first();
        $loaiChiNhanh = $loaiToChucs->where('ma', 'CN')->first();
        $loaiTinh = $loaiToChucs->where('ma', 'TINH')->first();
        $search_mien = $request->get('search_mien');
        $search_chi_nhanh = $request->get('search_chi_nhanh');
        $search_tinh = $request->get('search_tinh');
        $search_nhan_su = $request->get('search_nhan_su');
        $search_cua_hang = $request->get('search_cua_hang');
        if(isset($search_mien)){
            $query->whereHas('nhanSu',function ($query) use ($search_mien){
               $query->where('id_mien',$search_mien);
            });
        }
        if(isset($search_chi_nhanh)){
            $query->whereHas('nhanSu',function ($query) use ($search_chi_nhanh){
               $query->where('id_chi_nhanh',$search_chi_nhanh);
            });
        }
        if(isset($search_tinh)){
            $query->whereHas('nhanSu',function ($query) use ($search_tinh){
               $query->where('id_tinh',$search_tinh);
            });
        }
        if(isset($search_cua_hang)){
            $query->whereHas('nhanSu',function ($query) use ($search_cua_hang){
               $query->where('id_cua_hang',$search_cua_hang);
            });
        }
        if(isset($search_nhan_su)){
                $query->where('id_nhan_su',$search_nhan_su);
        }
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
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('luong.congno.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_thang'=> $search_thang,
            'search_mien'=> $search_mien,
            'search_tinh'=> $search_tinh,
            'search_chi_nhanh'=> $search_chi_nhanh,
            'search_cua_hang'=> $search_cua_hang,
            'search_nhan_su'=> $search_nhan_su,
            'nhansus'=> NhanSu::query()->get(),
            'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
            'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
            'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            'perPage' => $perPage,
            'miens' => $miens,
            'chinhanhs' => $chinhanhs,
            'tinhs' => $tinhs,
            'cuahangs' => CuaHang::query()->get()
        ]);
    }

    public function addCongNo(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id'] = $user->company_id;
        $info['thang_nam'] = empty($info['thang_nam'])?null: Carbon::createFromFormat(config('app.format_month'),$info['thang_nam'])->startOfMonth();
        $validator = Validator::make($info, [
            'id_nhan_su' => 'required',
            'so_tien' => 'required',
            'thang_nam' => 'required|unique_with:cong_nos,id_nhan_su,company_id'
        ],
            [
                'thang_nam.unique_with' => 'Tháng đã tồn tại target được chọn'
            ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        CongNo::query()
            ->create($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updateCongNo(Request $request, $id){
        $congno = CongNo::query()->findOrFail($id);
        $info = $request->all();
        $info['thang_nam'] = empty($info['thang_nam'])?null: Carbon::createFromFormat(config('app.format_month'),$info['thang_nam'])->startOfMonth();
        $validator = Validator::make($info, [
            'thang_nam' => 'required|unique_with:cong_nos,id_nhan_su,company_id,' . $id,
            'so_tien' => 'required',
        ],
            [
                'thang_nam.required' => 'Tháng bắt buộc phải nhập',
                'thang_nam.unique_with' => 'Tháng đã tồn tại target được chọn'
            ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $congno->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteCongNo($id){
        Auth::user();
        CongNo::findOrFail($id)->delete();

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }


}