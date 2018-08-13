<?php

namespace App\Http\Controllers;
use App\Bac;
use App\ChucVu;
use App\DanToc;
use App\HeDaoTao;
use App\HopDongChucVu;
use App\LoaiHopDong;
use App\LoaiNghiDacBiet;
use App\LoaiPhuCap;
use App\MucDongBaoHiem;

use App\PhanLoaiNhanVien;
use App\PhuCapBacLuong;
use App\QuanHuyen;
use App\QuocTich;
use App\TinhThanh;
use App\TonGiao;
use App\TrinhDoChuyenMon;
use App\TrinhDoNgoaiNgu;
use App\TrinhDoVanHoa;
use App\LoaiPhongBan;
use App\LoaiToChuc;
use App\ToChuc;
use App\ThueThuNhap;
use App\LoaiLamThemGio;
use App\NhanSu;
use App\Scopes\TrangThaiScope;
use App\Scopes\ActiveScope;
use App\ChiTietCongTac;
use App\CuaHang;
use App\ThamSoTinhLuong;
use App\DangKyUngDungChamCong;
use App\Traits\ExecuteString;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Menu;
use App\PhongBan;
use Illuminate\Http\Request;
use App\Traits\GetDataCache;

class DanhMucController extends Controller
{
    use ExecuteString, GetDataCache;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['indexToChuc']]);
    }

    public function indexPhongBan(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_don_vi = $request->get('search_don_vi');     
        $search_truc_thuoc = $request->get('search_truc_thuoc');     
        $search_phong_ban = $request->get('search_phong_ban');  
        $search_trang_thai = $request->get('search_trang_thai');      

        $query = PhongBan::query()->withoutGlobalScope(TrangThaiScope::class);
        if(isset($search)) {
            $query->where(function($query) use($search){
                $query->orWhere('ten', 'ilike', "%{$search}%");
                $query->orWhere('ma', 'ilike', "%{$search}%");
            });
        }

        if(isset($search_truc_thuoc) && is_array($search_truc_thuoc)) {                 
            $query->whereIn('parent_id', $search_truc_thuoc);
        }

        if(isset($search_trang_thai) && is_array($search_trang_thai)) {                 
            $query->whereIn('trang_thai', $search_trang_thai);
        }

        if(isset($search_phong_ban) && is_array($search_phong_ban)) {                 
            $query->whereIn('loai_phong_ban_id', $search_phong_ban);
        }
        $query->with(['loai_phong_ban:ten,id', 'myParent']);
        
        $query->orderBy('loai_phong_ban_id')->orderBy('ten');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.phongban.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
            'loai_phong_bans'=> $this->getDataByName('LoaiPhongBan'),
            'phongban_parents' => $this->getDataByName('PhongBan'),
            'tochucs'=> $this->getDataByName('ToChuc'),
            'search_don_vi' => $search_don_vi,
            'search_truc_thuoc' => $search_truc_thuoc,
            'search_phong_ban' => $search_phong_ban,
            'search_trang_thai' => $search_trang_thai,
        ]);
    }

    public function addPhongBan(Request $request){
        $info = $request->all();
        $user= Auth::user();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:phong_bans,company_id',
            'loai_phong_ban_id' => 'required',
            'trangthai' => 'boolean',
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        PhongBan::query()->create($info);
        return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));

    }

    public function updatePhongBan(Request $request, $id){
        
        $phongban = PhongBan::query()->withoutGlobalScope(TrangThaiScope::class)->findOrFail($id);
        $children = PhongBan::where('parent_id',$id);
        $user = Auth::user();
        $info = $request->all();
        if(!empty($user->company_id)){
            $info['company_id']=$user->company_id;
        }
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:phong_bans,company_id,'.$id,
            'trangthai' => 'boolean',
        ],
        [
            'ma.unique_with' => 'Trường mã đã tồn tại.'
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(empty($info['trang_thai'])) {
            $info['trang_thai'] = false;
        }
        $phongban->update($info);
        $children->update(['parent_id'=>$phongban->id]);
        return back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
    }

    public function deletePhongBan($id){
        Auth::user();
        $phongban=PhongBan::withoutGlobalScope(TrangThaiScope::class)->findOrFail($id);
        PhongBan::withoutGlobalScope(TrangThaiScope::class)->where('parent_id',$id)->update(['parent_id'=>$phongban->parent_id]);
        PhongBan::withoutGlobalScope(TrangThaiScope::class)->findOrFail($id)->delete();
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexChucVu(Request $request){
        $user = Auth::user();        
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = ChucVu::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }
        if(isset($search_trang_thai)){
            $query->whereIn('trang_thai',$search_trang_thai);
        }

        $data = $query->paginate($perPage, ['*'], 'page', $page);
        return view('danhmuc.chucvu.index', [
            'menus'=> $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'perPage' => $perPage,
        ]);
    }

    function addChucVu(Request $request){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:chuc_vus,company_id',
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        $info['ma'] = $this->code($info['ma']);
        $info['trang_thai'] = true;
        $info['ten'] = $this->ucfirst($info['ten']);
        $info['company_id']=$user->company_id;
        ChucVu::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateChucVu(Request $request,$id){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:chuc_vus,company_id,'.$id,
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }

        ChucVu::findOrFail($id)->update($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteChucVu($id){
        Auth::user();
        ChucVu::query()->findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }


    public function indexPhuCapBacLuong(Request $request,$id_bac_luong){
        $user = Auth::user();       
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        $bac=Bac::query()->findOrFail($id_bac_luong);
        $query = PhuCapBacLuong::query()->where("bac_id",$id_bac_luong);

        if(isset($search)) {
            $query->whereHas('loaiPhuCap', function ($query) use($search) {
              
                $query->where('ten','ilike',"%{$search}%");
            }); 
        }
        $query->orderBy('id');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.chucvu.bacluong.phucap.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'loaiphucaps' => $this->getDataByName('LoaiPhuCap'),
            'search'=> $search,
            'bac_id'=> $id_bac_luong,
            'perPage' => $perPage,
            'ten_bac'=>$bac->ten
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


    public function indexBacLuong(Request $request,$id_chuc_vu){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $query = Bac::query()->where("id_chuc_vu",$id_chuc_vu);
        $chuc_vu = ChucVu::findOrFail($id_chuc_vu);

        if(isset($search)) {
            $query->where(function($query) use($search){
                $query->orWhere('ten', 'ilike', "%{$search}%");
                $query->orWhere('mo_ta', 'ilike', "%{$search}%");
                $search = floatval($search);
                $query->orWhere('muc_luong_co_ban', $search);
            });
        }
        $query->orderBy('id');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.chucvu.bacluong.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'title'=>'Danh sách bậc lương chức vụ '.$chuc_vu->ten,
            'id_chuc_vu'=> $id_chuc_vu,
            'perPage' => $perPage,
        ]);
    }

    public function addBacLuong(Request $request,$id_chuc_vu){
        $user = Auth::user();
        $info = $request->all();
        $info['he_so_luong']= floatval($info['he_so_luong']);
        $info['id_chuc_vu']=$id_chuc_vu;
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'he_so_luong' => 'required|unique_with:bacs,id_chuc_vu,company_id',
        ],
        [
            'he_so_luong.unique_with' => 'Hệ số lương cơ bản đã tồn tại.',
           
        ]);
        

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
      
       
        Bac::query()
            ->create($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updateBacLuong(Request $request, $id){

        $bac = Bac::query()->findOrFail($id);
        $user = Auth::user();
        $info = $request->only([ 'ten','he_so_luong','mo_ta','muc_luong_co_ban']);
        $info['he_so_luong']= floatval($info['he_so_luong']);
        $bac->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteBacLuong($id){
        Auth::user();
        Bac::findOrFail($id)->delete();

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }


    function indexPhanLoaiNhanVien(Request $request){
        $user = Auth::user();       
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = PhanLoaiNhanVien::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }
        if (isset($search_trang_thai)) {
            $query->whereIn('trang_thai',$search_trang_thai);
        }
        $query->orderBy('ma');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.phanloainhanvien.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'perPage' => $perPage,
        ]);
    }

    function addPhanLoaiNhanVien(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:phan_loai_nhan_viens,company_id'
        ],
        [
            'ma.unique_with' => 'Trường mã đã tồn tại.'
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);

        PhanLoaiNhanVien::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updatePhanLoaiNhanVien(Request $request, $id){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'max:255',
            'ma' => 'max:255|unique_with:phan_loai_nhan_viens,company_id,' . $id,
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }

        PhanLoaiNhanVien::findOrFail($id)->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deletePhanLoaiNhanVien($id){
        Auth::user();
        PhanLoaiNhanVien::findOrFail($id)->delete();
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexTinhThanh(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = TinhThanh::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }

        if(isset($search_trang_thai)){
            $query->whereIn('trang_thai',$search_trang_thai);
        }

        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.tinhthanh.index', [
            'menus'=> $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'perPage' => $perPage,
        ]);
    }

    function addTinhThanh(Request $request){
        Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:tinh_thanhs,ma',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        
        TinhThanh::create($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateTinhThanh(Request $request, $id){
        Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:tinh_thanhs,ma,' . $id,
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }

        TinhThanh::findOrFail($id)->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteTinhThanh($id){
        Auth::user();
        TinhThanh::findOrFail($id)->delete();
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }
    
    function indexDanToc(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = DanToc::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }

        if(isset($search_trang_thai)){
            $query->whereIn('trang_thai',$search_trang_thai);
        }
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.dantoc.index', [
            'menus'=> $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'perPage' => $perPage,
        ]);
    }

    function addDanToc(Request $request){
        $info = $request->all();
        $user = Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:dan_tocs,ma',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);

        DanToc::create($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('danhmuc.dantoc.create_success'));
    }

    function updateDanToc(Request $request,$id){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:dan_tocs,ma,' . $id,
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }
        DanToc::findOrFail($id)->update($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('danhmuc.dantoc.update_success'));
    }

    function deleteDanToc($id){
        Auth::user();
        DanToc::findOrFail($id)->delete();
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexTonGiao(Request $request){
        $user = Auth::user();         
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = TonGiao::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }

        if(isset($search_trang_thai)){
            $query->whereIn('trang_thai',$search_trang_thai);
        }
        $query->orderBy('ma');        

        $data = $query->paginate($perPage, ['*'], 'page', $page);
        return view('danhmuc.tongiao.index', [
            'menus'=> $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'perPage' => $perPage,
        ]);
    }

    function addTonGiao(Request $request){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:ton_giaos,ma',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);

        TonGiao::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('danhmuc.tongiao.create_success'));
    }

    function updateTonGiao(Request $request,$id){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:ton_giaos,ma,' . $id,
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }

        TonGiao::findOrFail($id)->update($info);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('danhmuc.tongiao.update_success'));
    }

    function deleteTonGiao($id){
        Auth::user();
        TonGiao::findOrFail($id)->delete();
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexTrinhDoChuyenMon(Request $request){
        $user = Auth::user();        
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = TrinhDoChuyenMon::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }
        if (isset($search_trang_thai)) {
            $query->whereIn('trang_thai',$search_trang_thai);
        }
        $query->orderBy('ma');

        $data = $query->paginate($perPage, ['*'], 'page', $page);
        return view('danhmuc.trinhdochuyenmon.index', [
            'menus'=>$this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'perPage' => $perPage,
        ]);
    }

    function addTrinhDoChuyenMon(Request $request){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:trinh_do_chuyen_mons,company_id',
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);

        TrinhDoChuyenMon::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateTrinhDoChuyenMon(Request $request,$id){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:trinh_do_chuyen_mons,company_id,' . $id,
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }
        TrinhDoChuyenMon::findOrFail($id)->update($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteTrinhDoChuyenMon($id){
        Auth::user();
        TrinhDoChuyenMon::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexTrinhDoVanHoa(Request $request){
        $user = Auth::user();       
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = TrinhDoVanHoa::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }
        if(isset($search_trang_thai)){
            $query->whereIn('trang_thai',$search_trang_thai);
        }
        $query->orderBy('ma');

        $data = $query->paginate($perPage, ['*'], 'page', $page);
        
        return view('danhmuc.trinhdovanhoa.index', [
            'menus'=> $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'perPage' => $perPage,
        ]);
    }

    function addTrinhDoVanHoa(Request $request){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:trinh_do_van_hoas,ma',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);

        TrinhDoVanHoa::create($info);        
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateTrinhDoVanHoa(Request $request, $id){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:trinh_do_van_hoas,ma,' . $id,
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }

        TrinhDoVanHoa::findOrFail($id)->update($info);        

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteTrinhDoVanHoa($id){
        Auth::user();
        TrinhDoVanHoa::findOrFail($id)->delete();        
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexTrinhDoNgoaiNgu(Request $request){
        $user = Auth::user();        
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = TrinhDoNgoaiNgu::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }
        if(isset($search_trang_thai)){
            $query->whereIn('trang_thai',$search_trang_thai);
        }
        $query->orderBy('ma');

        $data = $query->paginate($perPage, ['*'], 'page', $page);
        return view('danhmuc.trinhdongoaingu.index', [
            'menus'=> $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'perPage' => $perPage,
        ]);
    }

    function addTrinhDoNgoaiNgu(Request $request){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:trinh_do_ngoai_ngus,ma',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);

        TrinhDoNgoaiNgu::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateTrinhDoNgoaiNgu(Request $request,$id){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:trinh_do_ngoai_ngus,ma,' . $id,
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }

        TrinhDoNgoaiNgu::findOrFail($id)->update($info);
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteTrinhDoNgoaiNgu($id){
        Auth::user();
        TrinhDoNgoaiNgu::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexQuanHuyen(Request $request){
        $user = Auth::user();        
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = QuanHuyen::query()->with('tinh_thanh');

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }
        if(isset($search_trang_thai)){
            $query->whereIn('trang_thai',$search_trang_thai);
        }
        $query->orderBy('tinh_thanh_id')->orderBy('ma')->orderBy('ten');

        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.quanhuyen.index', [
            'menus'=> $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'tinhthanhs' => $this->getDataByName('TinhThanh'),
            'perPage' => $perPage,
        ]);
    }

    function addQuanHuyen(Request $request){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:quan_huyens,ma',            
            'tinh_thanh_id' => 'required|exists:tinh_thanhs,id'
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);

        QuanHuyen::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateQuanHuyen(Request $request,$id){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:quan_huyens,ma,'.$id,
            'tinh_thanh_id' => 'required|exists:tinh_thanhs,id'
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }

        QuanHuyen::findOrFail($id)->update($info);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteQuanHuyen($id){
        Auth::user();
        QuanHuyen::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexQuocTich(Request $request){
        $user = Auth::user();        
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = QuocTich::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }
        if(isset($search_trang_thai)){
            $query->whereIn('trang_thai',$search_trang_thai);
        }
        $query->orderBy('ma');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.quoctich.index', [
            'menus'=>$this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'perPage' => $perPage,
        ]);
    }

    function addQuocTich(Request $request){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:quoc_tichs,ma',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);

        QuocTich::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateQuocTich(Request $request,$id){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:quoc_tichs,ma,' . $id,
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }
        QuocTich::findOrFail($id)->update($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteQuocTich($id){
        Auth::user();
        QuocTich::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexHeDaoTao(Request $request){
        $user = Auth::user();        
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = HeDaoTao::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }
        if(isset($search_trang_thai)){
            $query->whereIn('trang_thai',$search_trang_thai);
        }
        $query->orderBy('ma');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.hedaotao.index', [
            'menus'=>$this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'perPage' => $perPage,
        ]);
    }

    function addHeDaoTao(Request $request){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:he_dao_taos,ma',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);

        HeDaoTao::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateHeDaoTao(Request $request,$id){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:he_dao_taos,ma,' . $id,
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }
        HeDaoTao::findOrFail($id)->update($info);
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteHeDaoTao($id){
        Auth::user();
        HeDaoTao::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexLoaiPhongBan(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = LoaiPhongBan::query();
        if (isset($search_trang_thai)) {
            $query -> whereIn('trang_thai',$search_trang_thai);
        }
        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");               
            });
        }
        $query->orderBy('ma');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.loaiphongban.index', [
            'menus'=>$this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
            'search_trang_thai' => $search_trang_thai,
        ]);
    }

    function addLoaiPhongBan(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:loai_phong_bans,company_id',
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);

        LoaiPhongBan::create($info);
        
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateLoaiPhongBan(Request $request,$id){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id']=$user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique:loai_phong_bans,ma,'.$id,
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }
        LoaiPhongBan::findOrFail($id)->update($info);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteLoaiPhongBan($id){
        Auth::user();
        LoaiPhongBan::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }


    function indexLoaiHopDong(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = LoaiHopDong::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");
            });
        }
        if(isset($search_trang_thai)){
            $query->whereIn('trang_thai',$search_trang_thai);
        }
        $query->with(['attachment']);
        $query->orderBy('ma');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.loaihopdong.index', [
            'menus'=>$this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'chucvus'=>$this->getDataByName('ChucVu'),
            'perPage' => $perPage,
        ]);
    }

    function addLoaiHopDong(Request $request){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:loai_hop_dongs,company_id',
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);

        LoaiHopDong::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateLoaiHopDong(Request $request,$id){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id']=$user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:loai_hop_dongs,company_id,'.$id,
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }
        LoaiHopDong::findOrFail($id)->update($info);
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteLoaiHopDong($id){
        Auth::user();
        LoaiHopDong::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }


    function indexLoaiNghiDacBiet(Request $request){
        $user = Auth::user();        
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        $query = LoaiNghiDacBiet::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");
            });
        }
        $query->orderBy('ma');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.loainghidacbiet.index', [
            'menus'=>$this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
        ]);
    }

    function addLoaiNghiDacBiet(Request $request){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:loai_nghi_dac_biets,company_id',
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        LoaiNghiDacBiet::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateLoaiNghiDacBiet(Request $request,$id){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id']=$user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:loai_nghi_dac_biets,company_id,'.$id,
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }
        LoaiNghiDacBiet::findOrFail($id)->update($info);
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteLoaiNghiDacBiet($id){
        Auth::user();
        LoaiNghiDacBiet::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexLoaiToChuc(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = LoaiToChuc::query();

        if (isset($search_trang_thai)) {
            $query -> whereIn('inactive',$search_trang_thai);
        }
        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");
                $query->orWhere('mo_ta', 'ilike', "%{$search}%");               
            });
        }
        $query->orderBy('ma');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.loaitochuc.index', [
            'menus'=>$this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
            'search_trang_thai' => $search_trang_thai,
        ]);
    }

    function addLoaiToChuc(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:loai_to_chucs,company_id',
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ma'] = $this->code($info['ma']);
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        LoaiToChuc::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateLoaiToChuc(Request $request,$id){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:loai_to_chucs,company_id,'.$id,
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ma'])) {
            $info['ma'] = $this->code($info['ma']);
        }
        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }
        LoaiToChuc::findOrFail($id)->update($info);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteLoaiToChuc($id){
        Auth::user();
        LoaiToChuc::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function indexToChuc(Request $request){
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');           
        $search_truc_thuoc = $request->get('search_truc_thuoc');     
        $search_loai_to_chuc = $request->get('search_loai_to_chuc');                  
        $search_ma_loai_to_chuc = $request->get('search_ma_loai_to_chuc');                  
        $search_company= $request->get('search_company');   
        $search_trang_thai = $request->get('search_trang_thai');                      

        if($request->headers->get('accept') =='application/json') {
            $query = ToChuc::query();
            $query->withoutGlobalScope('company');
            
            if(isset($search_ma_loai_to_chuc)) {                 
                $query->whereHas('loaiToChuc', function ($query) use($search_ma_loai_to_chuc) {
                    $query->where('ma', $search_ma_loai_to_chuc);
                });
            }
            
            return response()->json([
                'code'    => 200,
                'message' => 'Success',
                'result'  => $query->get()
            ], 200, []);
        }
        else{
            $query = ToChuc::query()->withoutGlobalScope(ActiveScope::class);

            if(isset($search)) {
                $query->where(function($query) use($search){
                    $query->orWhere('ten', 'ilike', "%{$search}%");
                    $query->orWhere('ma', 'ilike', "%{$search}%");
                    $query->orWhere('so_dien_thoai', 'ilike', "%{$search}%");
                    $query->orWhere('email', 'ilike', "%{$search}%");
                    $query->orWhere('nguoi_lien_he', 'ilike', "%{$search}%");
                    $query->orWhere('mo_ta', 'ilike', "%{$search}%");
                });
            }

            if(isset($search_truc_thuoc) && is_array($search_truc_thuoc)) {                 
                $query->whereIn('parent_id', $search_truc_thuoc);
            }

            if(isset($search_trang_thai) && is_array($search_trang_thai)) {                 
                $query->whereIn('inactive', $search_trang_thai);
            }

            if(isset($search_loai_to_chuc) && is_array($search_loai_to_chuc)) {                 
                $query->whereIn('loai_to_chuc_id', $search_loai_to_chuc);
            }

            $query->with(['loaiToChuc:ten,id,ma', 'parent']);               

            if(isset($search_company)) {                 
                $query->where('company_id', $search_company);
            }  
                    
            $query->orderBy('loai_to_chuc_id'); 
            $user = Auth::user();
            $data = $query->paginate($perPage, ['*'], 'page', $page);               
            $loai_to_chucs = LoaiToChuc::query()->with('configToChuc')->get();
            foreach ($loai_to_chucs as $item){
                $item->ten_hien_thi = $item->configToChuc->ten_hien_thi;
            }
          
            return view('danhmuc.tochuc.index', [
                'menus' => $this->getMenusForUser($user),
                'data' => $data,
                'search'=> $search,
                'loai_to_chucs'=> $loai_to_chucs,
                'all_to_chuc' => ToChuc::withoutGlobalScope('active')->get(),
                'search_truc_thuoc' => $search_truc_thuoc,
                'search_loai_to_chuc' => $search_loai_to_chuc,
                'perPage' => $perPage,
                'search_trang_thai'=>$search_trang_thai,
            ]);
        }                
    }

    public function addToChuc(Request $request){
        $info = $request->all();
        $user= Auth::user();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:to_chucs,company_id',
            'loai_to_chuc_id' => 'required|exists:loai_to_chucs,id',
            'inactive' => 'boolean',
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        ToChuc::create($info);
        return back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));
    }

    public function updateToChuc(Request $request, $id){

        $info = $request->all();
        $user= Auth::user();
        $info['company_id'] = $user->company_id;
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'ma' => 'required|max:255|unique_with:to_chucs,company_id,'.$id,
            'loai_to_chuc_id' => 'required|exists:loai_to_chucs,id',
            'inactive' => 'boolean',
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại.'
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        ToChuc::withoutGlobalScope(ActiveScope::class)->findOrFail($id)->update($info);
        return back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
    }

    public function deleteToChuc($id){
        Auth::user();
        $tochuc = ToChuc::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        ToChuc::withoutGlobalScope(ActiveScope::class)->where('parent_id', $tochuc->id)->update(['parent_id'=> $tochuc->parent_id]);
        ToChuc::withoutGlobalScope(ActiveScope::class)->findOrFail($id)->delete();
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function showFormDeleteToChuc($id){
        $data = [];
        $tochuc = ToChuc::where('parent_id',$id)->count();
        $chitietcongtac = ChiTietCongTac::where('id_mien_moi',$id)->orWhere('id_chi_nhanh_moi',$id)->orWhere('id_tinh_moi',$id)->where('id_mien_cu',$id)->orWhere('id_chi_nhanh_cu',$id)->orWhere('id_tinh_cu',$id)->count();
    
        $dkchamcongnhansu = DangKyUngDungChamCong::where('id_mien',$id)->orWhere('id_chi_nhanh',$id)->orWhere('id_tinh',$id)->count();
        $cuahang= CuaHang::where('id_mien',$id)->orWhere('id_chi_nhanh',$id)->orWhere('id_tinh',$id)->count();
       
        
        if($tochuc>0){
            $data[]=[
                'ten'=>'Tổ chức đã có '.$tochuc.' tổ chức trực thuộc.',
                'link'=>'tochuc?search_truc_thuoc='.$id
                ];
        }
        if($chitietcongtac>0){
            $data[]=[
                'ten'=>'Tổ chức đã có '.$chitietcongtac.' chi tiết công tác.',
                'link'=>'nhansu/update/chuyenmon/'.$id
            ];
        }

        if($dkchamcongnhansu>0){
            $data[]=[
                'ten'=>'Tổ chức đã có '.$dkchamcongnhansu.' đăng ký chấm công nhân sự.',
                'link'=>'nhansu/update/phongban/'.$id
            ];
        }
        if($cuahang>0){
            $data[]=[
                'ten'=>'Tổ chức đã có '.$cuahang.' cửa hàng trực thuộc.',
                'link'=>'nhansu/update/dongphuc/'.$id
            ];
        }
        return response()->json($data);
    }

    public function indexPhongBanToChuc(Request $request,$id){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_don_vi = $request->get('search_don_vi');
        $search_truc_thuoc = $request->get('search_truc_thuoc');
        $search_phong_ban = $request->get('search_phong_ban');
        $query = PhongBan::query()->where('to_chuc_id',$id);

        if(isset($search)) {
            $query->where(function($query) use($search){
                $query->orWhere('ten', 'ilike', "%{$search}%");
                $query->orWhere('ma', 'ilike', "%{$search}%");
            });
        }

        if(isset($search_truc_thuoc) && is_array($search_truc_thuoc)) {
            $query->whereIn('parent_id', $search_truc_thuoc);
        }

        if(isset($search_phong_ban) && is_array($search_phong_ban)) {
            $query->whereIn('loai_phong_ban_id', $search_phong_ban);
        }
        $query->with(['loai_phong_ban:ten,id', 'myParent']);

        $query->orderBy('loai_phong_ban_id');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.tochuc.phongban.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'loai_phong_bans'=> $this->getDataByName('LoaiPhongBan'),
            'phongban_parents' =>  $this->getDataByName('PhongBan'),
            'tochuc'=> ToChuc::query()->findOrFail($id),
            'truc_thuoc' =>  $this->getDataByName('PhongBan'),
            'search_don_vi' => $search_don_vi,
            'search_truc_thuoc' => $search_truc_thuoc,
            'search_phong_ban' => $search_phong_ban,
            'perPage'=>$perPage
        ]);
    }

    function indexThueThuNhap(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        $query = ThueThuNhap::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ten', 'ilike', "%{$search}%");
            });
        }
        $query->orderBy('can_tren');
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.thuethunhap.index', [
            'menus'=>$this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
        ]);
    }

    function addThueThuNhap(Request $request){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id'] = $user->company->id;
     
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'thue_suat' => 'required|numeric|min:0|max:100',
            'can_tren' => 'unique_with:thue_thu_nhaps,company_id',
        ],
            [
                'can_tren.unique_with' => 'Cận trên đã tồn tại.',
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        ThueThuNhap::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateThueThuNhap(Request $request,$id){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id'] = $user->company->id;
        $info['can_tren'] = str_replace(',', '', $info['can_tren']);
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'thue_suat' => 'required|numeric|min:0|max:100',
            'can_tren' => 'unique_with:thue_thu_nhaps,company_id,'.$id,
        ],
            [
                'can_tren.unique_with' => 'Cận trên đã tồn tại.',
            ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }

        ThueThuNhap::findOrFail($id)->update($info);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteThueThuNhap($id){
        Auth::user();
        ThueThuNhap::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }


    function indexMucDongBaoHiem(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        $query = MucDongBaoHiem::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ten', 'ilike', "%{$search}%");
            });
        }
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.mucdongbaohiem.index', [
            'menus' => $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage,
        ]);
    }

    function addMucDongBaoHiem(Request $request){
        $info = $request->all();
        Auth::user();

        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        MucDongBaoHiem::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateMucDongBaoHiem(Request $request,$id){
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        if(!empty($info['ten'])) {
            $info['ten'] = $this->cappitalizeEachWord($info['ten']);
        }
        MucDongBaoHiem::findOrFail($id)->update($info);
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteMucDongBaoHiem($id){
        Auth::user();
        MucDongBaoHiem::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }


    function indexHopDongChucVu(Request $request){
        $user = Auth::user();

        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        $query = HopDongChucVu::query()->with('loaihopdong','chucvu');

        if (isset($search)) {
            $query->where(function ($query) use ($search) {
               $query->orWhereHas('loaihopdong',function($query)use($search){
                $query->where('ten', 'ilike', "%{$search}%");
               })
               ->orWhereHas('chucVu',function($query)use($search){
                $query->where('ten', 'ilike', "%{$search}%");
               });
            });
        }
        $query->orderBy('id');
        $query->with(['attachment']);
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.hopdongchucvu.index', [
            'menus'=> $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'chucvus'=> $this->getDataByName('ChucVu'),
            'loaihopdongs'=> $this->getDataByName('LoaiHopDong'),
            'perPage' => $perPage,
        ]);
    }

    function addHopDongChucVu(Request $request){
        $info = $request->all();
        $validator = Validator::make($info, [
            'id_loai_hop_dong' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        HopDongChucVu::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateHopDongChucVu(Request $request,$id){
        $info = $request->all();
        $validator = Validator::make($info, [
            'id_loai_hop_dong' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        HopDongChucVu::findOrFail($id)->update($info);
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteHopDongChucVu($id){
        Auth::user();
        HopDongChucVu::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexLoaiLamThemGio(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');


        $query = LoaiLamThemGio::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {            
                $query->where('ten', 'ilike', "%{$search}%");
            });
        }
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('danhmuc.loailamthemgio.index', [
            'menus'=> $this->getMenusForUser($user),
            'data' => $data,
            'search'=> $search,
            'perPage' => $perPage
        ]);
    }

    function addLoaiLamThemGio(Request $request){
        $info = $request->all();
        $validator = Validator::make($info, [
            'ten' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        LoaiLamThemGio::create($info);
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    function updateLoaiLamThemGio(Request $request,$id){
        $info = $request->all();
        $validator = Validator::make($info, [
            'ten' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        LoaiLamThemGio::findOrFail($id)->update($info);
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteLoaiLamThemGio($id){
        Auth::user();
        LoaiLamThemGio::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    function indexThamSoTinhLuong(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        $query = ThamSoTinhLuong::query();

        if (isset($search)) {
            $query->where(function ($query) use ($search) {            
               
            });
        }
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        return view('luong.thamsotinhluong.index', [
            'menus'=> $this->getMenusForUser($user),
            'data' => $data,
            'chucvus'=>$this->getDataByName('ChucVu'),
            'loaihopdongs'=>$this->getDataByName('LoaiHopDong'),
            'search'=> $search,
            'perPage' => $perPage,
        ]);
    }

    function addThamSoTinhLuong(Request $request){
        $user = Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'id_chuc_vu' => 'required',
            'id_loai_hop_dong' => 'required',
        ]);
            $info['company_id']=$user->company_id;
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        DB::beginTransaction();
        try {
        $thamsotinhluong=ThamSoTinhLuong::query()->where('id_chuc_vu',$info['id_chuc_vu'])
        ->where('id_loai_hop_dong',$info['id_loai_hop_dong'])->first();
        if(!empty($thamsotinhluong)){
            $thamsotinhluong->inactive=true;
            $thamsotinhluong->save();
        }
        ThamSoTinhLuong::create($info);
        DB::commit();

        return  back()->with('alert-type', 'alert-success')
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

    function updateThamSoTinhLuong(Request $request,$id){
        $info = $request->all();
        $validator = Validator::make($info, [
            'id_chuc_vu' => 'required',
            'id_loai_hop_dong' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        ThamSoTinhLuong::findOrFail($id)->update($info);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    function deleteThamSoTinhLuong($id){
        Auth::user();
        ThamSoTinhLuong::findOrFail($id)->delete();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

}
