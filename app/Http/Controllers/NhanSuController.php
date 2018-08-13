<?php

namespace App\Http\Controllers;

use App\Bac;
use App\ChamCongCuaHang;
use App\ChiTietChuyenMon;
use App\ChiTietCongTac;
use App\ChiTietLuong;
use App\ChiTietNghiDacBiet;
use App\ChiTietNgoaiNgu;
use App\ChucVu;
use App\LoaiHopDong;
use App\Lookup;
use App\QuocTich;
use App\ChiTietBaoHiem;
use App\HoSoNhanSu;
use App\DanToc;
use App\TonGiao;
use App\ChiTietGiamTruGiaCanh;
use App\TheoDoiHopDong;
use App\ChiTietDongPhuc;
use App\NhanSuLog;
use App\MucDongBaoHiem;
use App\Attachment;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\NhanSu;
use App\ChamCong;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Traits\ExecuteString;
use App\Traits\ExecuteExcel;
use Exception;
use App\Traits\GetDataCache;
use App\Traits\GenNo;

class NhanSuController extends Controller
{
    use ExecuteString, ExecuteExcel, GetDataCache, GenNo; 

    public function __construct()
    {
        $this->middleware('auth');        
    }

    public function index(Request $request){
        $user = Auth::user();
        $search = $request->get('search');
        $search_phong_ban = $request->get('search_phong_ban');
        $search_chuc_vu = $request->get('search_chuc_vu');
        $search_trinh_do_van_hoa = $request->get('search_trinh_do_van_hoa');
        $search_loai_hop_dong = $request->get('search_loai_hop_dong');
        $search_gioi_tinh = $request->get('search_gioi_tinh');
        $search_ngay_sinh = $request->get('search_ngay_sinh');
        $search_da_nghi_viec = $request->get('search_da_nghi_viec');
        $search_tinh= $request->get('search_tinh');
        $search_chi_nhanh = $request->get('search_chi_nhanh');
        $search_bo_phan = $request->get('search_bo_phan');        
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $query = NhanSu::query()->with(['chucVu:id,ten','phongBan:id,ten','chiNhanh:id,ten','loaiHopDong:id,ten']);
        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ho_ten', 'ilike', "%{$search}%");
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('cmnd', 'ilike', "%{$search}%");
                $query->orWhere('ma_so_thue', 'ilike', "%{$search}%");
            });
        }
        if(isset($search_phong_ban)){
            $query->where('id_phong_ban',$search_phong_ban);
        }

        if(isset($search_bo_phan)){
            $query->where('id_bo_phan',$search_bo_phan);
        }

        if(isset($search_chuc_vu)){
            $query->whereIn('id_chuc_vu',$search_chuc_vu);
        }

        if(isset($search_trinh_do_van_hoa)){
            $query->whereIn('id_trinh_do_van_hoa',$search_trinh_do_van_hoa);
        }
        if(isset($search_loai_hop_dong)){
            $query->whereIn('id_loai_hop_dong',$search_loai_hop_dong);
        }

        if(isset($search_gioi_tinh)){
            $gioi_tinhs = [];
                foreach ($search_gioi_tinh as $gioi_tinh){
                    if($gioi_tinh == '0')
                        $gioi_tinhs[] = false;
                    else
                        $gioi_tinhs[] = true;
                }
            $query->whereIn('gioi_tinh',$gioi_tinhs);
        }

        if(isset($search_ngay_sinh)){
            $search_ngay_sinh = Carbon::createFromFormat(config('datetime.format', config('app.format_date')), $search_ngay_sinh);
            $query->where('ngay_sinh',$search_ngay_sinh);
        }

        if(isset($search_da_nghi_viec)){
            $query->whereIn('da_nghi_viec',$search_da_nghi_viec);
        }

        if(isset($search_tinh)){
            $query->where('id_tinh',$search_tinh);
        }
        if(isset($search_chi_nhanh)){
            $query->where('id_chi_nhanh',$search_chi_nhanh);
        }

        $loaiPhongBans = $this->getDataByName('LoaiPhongBan');
        $phongBans = $this->getDataByName('PhongBan');
        $loaiPhong = $loaiPhongBans->where('ma', 'P')->first();
        $loaiBoPhan = $loaiPhongBans->where('ma', 'BP')->first();
        $phongs = collect([]);
        $bophans = collect([]);
        if(!empty($loaiPhong)) {
            $phongs = $phongBans->where('loai_phong_ban_id', $loaiPhong->id);
        }
        if(!empty($loaiBoPhan)) {
            $bophans = $phongBans->where('loai_phong_ban_id', $loaiBoPhan->id);
        }

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

        $query->orderBy('updated_at','desc')
            ->get(['id','ma','ho_ten','ngay_sinh','cmnd','ho_khau_thuong_tru','so_dien_thoai','gioi_tinh','ma_so_thue','id_chi_nhanh']);
        if($request->headers->get('accept')!='xlsx'){
            $data = $query->paginate($perPage, ['*'], 'page', $page);           
            return view('nhansu.index', [
                'menus' => $this->getMenusForUser($user),
                'tinhs'=> $tinhs,
                'chi_nhanhs'=> $chinhanhs,
                'phongbans'=> $phongs,
                'bophans' => $bophans,
                'chucvus'=> $this->getDataByName('ChucVu'),
                'loaihopdongs'=> $this->getDataByName('LoaiHopDong'),
                'trinhdovanhoas'=> $this->getDataByName('TrinhDoVanHoa'),
                'data' => $data,
                'search'=> $search,
                'perPage' => $perPage,
                'tinh_thanhs'=> $this->getDataByName('TinhThanh'),
                'quan_huyens'=> $this->getDataByName('QuanHuyen'),
                'search_phong_ban'=> $search_phong_ban,
                'search_chuc_vu'=> $search_chuc_vu,
                'search_loai_hop_dong'=> $search_loai_hop_dong,
                'search_trinh_do_van_hoa'=> $search_trinh_do_van_hoa,
                'search_gioi_tinh'=> $search_gioi_tinh,
                'search_ngay_sinh'=> $search_ngay_sinh,
                'search_da_nghi_viec'=>$search_da_nghi_viec,
                'search_tinh'=>$search_tinh,
                'search_chi_nhanh'=>$search_chi_nhanh,
                'search_bo_phan'=>$search_bo_phan,
                'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
                'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
                'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            ]);
        }
        else{
            $data = $query->get();
            $input = $request->all();
            $excelFile = public_path() . '/report/tem_nhan_su.xlsx';
            $this->load($excelFile, 'DANH_SACH_NHAN_SU', function ($sheet) use (&$data, &$input) {

                foreach($data as $key => $nhansu) {
                    $rowKey = (int)$key;
                    $sheet->row($rowKey + 8, [
                        $rowKey + 1,
                        $nhansu->ma,
                        $nhansu->ho_ten,
                        $nhansu->ngay_sinh,
                        $nhansu->gioi_tinh?'Nam':'Nữ',
                        $nhansu->cmnd,
                        $nhansu->que_quan,
                        $nhansu->ho_khau_thuong_tru,
                        $nhansu->so_dien_thoai,
                        isset($nhansu->chucvu->ten)?$nhansu->chucvu->ten:'',
                        isset($nhansu->phongban->ten)? $nhansu->phongban->ten:'',
                        isset($nhansu->trinhdovanhoa->ten)?$nhansu->trinhdovanhoa->ten:'',
                        isset($nhansu->loaihopdong->ten)?$nhansu->loaihopdong->ten:'',
                    ]);
                }
            })->download('xlsx');
        }
    }

    public function showFormAdd()
    {
        $user = Auth::user();        
        $lookups = $this->getDataByName('Lookup')
            ->where('active', true);
        return view('nhansu.add', [
            'menus' => $this->getMenusForUser($user),
            'trinh_do_van_hoas'=> $this->getDataByName('TrinhDoVanHoa'),
            'quoc_gias'=> $this->getDataByName('QuocTich'),
            'loai_cua_hangs'=> $lookups->where('loai','loai_cua_hang'),
            'gia_canhs'=> $lookups->where('loai','gia_canh'),
            'tinh_thanhs'=> $this->getDataByName('TinhThanh'),
            'quan_huyens'=> $this->getDataByName('QuanHuyen'),
            'dan_tocs'=> $this->getDataByName('DanToc'),
            'ton_giaos'=> $this->getDataByName('TonGiao'),
            'ma_nhan_su'=> $this->genCodeNhanSu(),
        ]);
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        $info = $request->all();
        $info['company_id']=$user->company_id;
        $info['id_chi_nhanh']=$user->id_chi_nhanh;
        $validator = Validator::make($info, [
            'ho_ten' => 'required',
            'ma' => 'required|unique_with:nhan_sus,company_id',
            'cmnd' => 'nullable|unique_with:nhan_sus,company_id',
            'ma_so_thue' => 'nullable|unique_with:nhan_sus,company_id',
            'tai_khoan_ngan_hang' => 'nullable|unique_with:nhan_sus,company_id',
            'email' => 'nullable|email'
        ],
        [
            'ma.unique_with' => 'Trường mã đã tồn tại.',
            'cmnd.unique_with' => 'Trường cmnd đã tồn tại.',
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

        DB::beginTransaction();
        try {
            if($request->hasFile('imageOrder')) {
                $imageOrder = $request->imageOrder;

                 $fileName = time() . '-' . $imageOrder->getClientOriginalName();
                 $imageOrder->storeAs(
                                'public/images/avatar/', $fileName
                            );

                $path = "storage/images/avatar/" . $fileName;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $info['hinh_anh']= $path;
                $info['anh'] = 1;
            }
            $info['nguoi_tao'] = $user->id;
            $info['nguoi_cap_nhat'] = $user->id;
            NhanSu::create($info);
            DB::commit();
            return redirect()->route('nhansu')->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));            
        }
        catch(Exeption $exception){
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
    }

    public function showFormUpdate($id)
    {
        $user = Auth::user();
        $nhansu = NhanSu::query()->where('id',$id)->first();
        $lookups = $this->getDataByName('Lookup')
            ->where('active', true);
        return view('nhansu.edit', [
            'menus' => $this->getMenusForUser($user),
            'nhansu'=>$nhansu,
            'trinh_do_van_hoas'=> $this->getDataByName('TrinhDoVanHoa'),
            'loai_hop_dongs'=> $this->getDataByName('LoaiHopDong'),
            'loai_cua_hangs'=> $lookups->where('loai','loai_cua_hang'),
            'gia_canhs'=> $lookups->where('loai','gia_canh'),
            'quoc_gias'=> $this->getDataByName('QuocTich'),
            'tinh_thanhs'=> $this->getDataByName('TinhThanh'),
            'quan_huyens'=> $this->getDataByName('QuanHuyen'),
            'activeMenu' => 'chung',
            'dan_tocs'=> $this->getDataByName('DanToc'),
            'ton_giaos'=> $this->getDataByName('TonGiao'),
            'trang_thai_nhan_su' => $this->getDataByName('PhanLoaiNhanVien'),
        ]);
    }

    public function updateNhanSu(Request $request, $id)
    {
        $info = $request->all();
        $user = Auth::user();
        if(!empty($user->company_id)){
            $info['company_id']=$user->company_id;
        }
        
        NhanSu::query()->findOrFail($id)->update($info);
        
        return redirect()
                ->back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
    }

    public function update(Request $request, $id)
    {
        $info = $request->all();
        $user = Auth::user();
        if(!empty($user->company_id)){
            $info['company_id']=$user->company_id;
        }
        $validator = Validator::make($info, [
            'ho_ten' => 'max:255|required',
            'ma' => 'unique_with:nhan_sus,company_id,' . $id,
            'cmnd' => 'nullable|unique_with:nhan_sus,company_id,' . $id,
            'ma_so_thue' => 'nullable|unique_with:nhan_sus,company_id,' . $id,
            'tai_khoan_ngan_hang' => 'nullable|unique_with:nhan_sus,company_id,' . $id,
            'email' => 'nullable|email'
        ],
        [
            'ma.unique_with' => 'Trường mã đã tồn tại.',
            'cmnd.unique_with' => 'Trường cmnd đã tồn tại.',
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
        
        $nhansu = NhanSu::query()->findOrFail($id);

        DB::beginTransaction();
        try {
            if($request->hasFile('urlImages')) {
                $urlImages = $request->urlImages;    
                $fileName = time() . '-' . $urlImages->getClientOriginalName();
                $urlImages->storeAs(
                    'public/images/avatar/', $fileName
                );    
                $path = "storage/images/avatar/" . $fileName;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $info['hinh_anh'] = $path;    
            } 
            $info['nguoi_cap_nhat'] = $user->id;      
            $nhansu->update($info);                      
            
            $nhansu->save();            
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
                ->with('alert-content', __('system.validator'));
        }
    }

    public function showFormDelete($id){
        $data = [];
        $chitietbaohiem = ChiTietBaoHiem::where('id_nhan_su',$id)->count();
        $chitietchuyenmon = ChiTietChuyenMon::where('id_nhan_su',$id)->count();
        $chitietcongtac = ChiTietCongTac::where('id_nhan_su',$id)->count();
        $chitietdongphuc = ChiTietDongPhuc::where('id_nhan_su',$id)->count();
        $chitietgiamtrugiacanh= ChiTietGiamTruGiaCanh::where('id_nhan_su',$id)->count();
        $chitietluong = ChiTietLuong::where('nhan_su_id',$id)->count();
        $chitietnghidacbiet= ChiTietNghiDacBiet::where('id_nhan_su',$id)->count();
        $chitietngoaingu = ChiTietNgoaiNgu::where('id_nhan_su',$id)->count();
        $hosonhansu = HoSoNhanSu::where('id_nhan_su',$id)->count();
        $theodoihopdong = TheoDoiHopDong::where('id_nhan_su',$id)->count();
        $nhansu = NhanSu::findOrFail($id);
        if(!empty($nhansu->ma_the_cham_cong)){
            $chitietchamcongs = ChamCongCuaHang::where('nhan_su_id',$id)->get();
            foreach ($chitietchamcongs as $chitietchamcong){
                if(!empty($chitietchamcong)){
                    $data[]=[
                        'ten'=>'Nhân sự đã có trong bảng chấm công với mã là '.$chitietchamcong->ma_the_cham_cong,
                        'link'=> 'dangkyungdungchamcong/chitiet/'.$chitietchamcong->ma_the_cham_cong,
                    ];
                }
            }
        }
        $chamcongs=ChamCong::query()->get();

        foreach($chamcongs as $chamcong){
            $chamcongnhansu = DB::table($chamcong->ten_bang)->where('nhan_su_id',$id)->first();
            if(!empty($chamcongnhansu)){
            $data[]=[
                'ten'=>'Nhân sự đã có trong bảng tháng '.$chamcong->thang.' năm '.$chamcong->nam,
                'link'=>'chamcong/chitiet/'.$chamcong->ten_bang
                ];
            }
        }
        if($chitietbaohiem>0){
            $data[]=[
                'ten'=>'Nhân sự đã có '.$chitietbaohiem.' chi tiết bảo hiểm.',
                'link'=>'nhansu/update/baohiem/'.$id
                ];
        }
        if($chitietchuyenmon>0){
            $data[]=[
                'ten'=>'Nhân sự đã có '.$chitietchuyenmon.' chi tiết chuyên môn.',
                'link'=>'nhansu/update/chuyenmon/'.$id
            ];
        }

        if($chitietcongtac>0){
            $data[]=[
                'ten'=>'Nhân sự đã có '.$chitietcongtac.' quá trình công tác.',
                'link'=>'nhansu/update/phongban/'.$id
            ];
        }
        if($chitietdongphuc>0){
            $data[]=[
                'ten'=>'Nhân sự đã có '.$chitietdongphuc.' chi tiết đồng phục.',
                'link'=>'nhansu/update/dongphuc/'.$id
            ];
        }
        if($chitietgiamtrugiacanh>0){
            $data[]=[
                'ten'=>'Nhân sự đã có '.$chitietgiamtrugiacanh.' chi tiết giảm trừ gia cảnh.',
                'link'=>'nhansu/update/giamtrugiacanh/'.$id
            ];
        }
        if($chitietnghidacbiet>0){
            $data[]=[
                'ten'=>'Nhân sự đã có '.$chitietnghidacbiet.' chi tiết nghỉ đặc biệt.',
                'link'=>'nhansu/update/nghidacbiet/'.$id
            ];
        }
        if($chitietluong>0){
            $data[]=[
                'ten'=>'Nhân sự đã có '.$chitietluong.' chi tiết lương.',
                'link'=>'nhansu/update/luong/'.$id
            ];
            }
        if($chitietngoaingu>0){
            $data[]=[
                'ten'=>'Nhân sự đã có '.$chitietngoaingu.' chi tiết ngoại ngữ.',
                'link'=>'nhansu/update/baohiem/'.$id
            ];
        }
        if($hosonhansu>0){
            $data[]=[
                'ten'=>'Nhân sự đã có '.$hosonhansu.'  hồ sơ nhân sự.',
                'link'=>'nhansu/update/hosonhansu/'.$id
            ];
        }
        if($theodoihopdong>0){
            $data[]=[
                'ten'=>'Nhân sự đã có '.$theodoihopdong.' hợp đồng.',
                'link'=>'nhansu/update/theodoihopdong/'.$id
            ];
        }
        return response()->json($data);
    }

    public function delete($id)
    {
        Auth::user();
        DB::beginTransaction();
        try{
            $nhansu = NhanSu::findOrFail($id);
            NhanSuLog::where('ma',$nhansu->ma)->delete();
            $nhansu->delete();
            DB::commit();
            return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.delete_success'));
        }
        catch(Exeption $exception){
            DB::rollBack();
            Log::error($exception);
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.delete_error'));
        }
        
    }

    public function indexPhongBan(Request $request,$id_nhan_su){
        $user = Auth::user();
        
        $query = ChiTietCongTac::query()->where('id_nhan_su',$id_nhan_su)
            ->with([
                'nhan_su:id,ho_ten',
                'mien_moi',
                'chi_nhanh_moi',
                'tinh_moi',
                'cua_hang_moi',
                'phong_ban_moi',
                'bo_phan_moi',
                'chuc_vu_moi']);

        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        if(isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhereHas('phong_ban', function($query) use ($search){
                    $query->where('ten','like',"%{$search}%");
                });
                $query->orWhere('so_quyet_dinh','ilike',"%{$search}%");
            });
        }

        $query->orderBy('updated_at');        

        $phong_ban_hien_tai = ChiTietCongTac::query()
            ->where('id_nhan_su',$id_nhan_su)
            ->where('active',true)
            ->first();

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
        $phongs = collect([]);
        $bophans = collect([]);
        if(!empty($loaiPhong)) {
            $phongs = $phongBans->where('loai_phong_ban_id', $loaiPhong->id);
        }
        if(!empty($loaiBoPhan)) {
            $bophans = $phongBans->where('loai_phong_ban_id', $loaiBoPhan->id);
        }

        return view('nhansu.phongban.detail',[
            'menus' => $this->getMenusForUser($user),
            'data'=> $query->paginate($perPage, ['*'], 'page', $page),
            'search'=> $search,
            'perPage' => $perPage,
            'nhansu'=> NhanSu::query()->find($id_nhan_su),
            'phongbans'=> $phongs,
            'chinhanhs'=> $chinhanhs,
            'bophans'=> $bophans,
            'miens'=> $miens,
            'ten_hien_thi_mien'=> empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
            'ten_hien_thi_chi_nhanh'=> empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
            'ten_hien_thi_tinh'=> empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            'tinhs'=> $tinhs,
            'cuahangs'=> $this->getDataByName('CuaHang'),
            'chucvus'=> $this->getDataByName('ChucVu'),
            'phong_ban_hien_tai'=> $phong_ban_hien_tai,
            'activeMenu' => 'congtac'
        ]);
    }

    public function addPhongban(Request $request, $id)
    {
        Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'so_quyet_dinh' => 'max:255',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        DB::beginTransaction();

        try{
            $nhansu = NhanSu::findOrFail($id);
            $info['id_nhan_su'] = $id;
            $info['active'] = true;
         
            if(!empty($info['id_tinh_moi'])){
                $info['to_chuc_id']=$info['id_tinh_moi'];
            }
            elseif(!empty($info['id_chi_nhanh_moi'])){
                $info['to_chuc_id']=$info['id_chi_nhanh_moi'];
            }
            elseif(!empty($info['id_mien_moi'])){
                $info['to_chuc_id']=$info['id_mien_moi'];
            }
            $chiTietCongTacActive = $nhansu->chiTietCongTacs->where('active', true)->first();
            if(!empty($chiTietCongTacActive)) {
                $chiTietCongTacActive->active = false;
                $chiTietCongTacActive->save();
                $info['id_mien_cu'] = $chiTietCongTacActive->id_mien_moi;
                $info['id_chi_nhanh_cu'] = $chiTietCongTacActive->id_chi_nhanh_moi;
                $info['id_tinh_cu'] = $chiTietCongTacActive->id_tinh_moi;
                $info['id_cua_hang_cu'] = $chiTietCongTacActive->id_cua_hang_moi;
                $info['id_phong_ban_cu'] = $chiTietCongTacActive->id_phong_ban_moi;
                $info['id_bo_phan_cu'] = $chiTietCongTacActive->id_bo_phan_moi;
                $info['id_chuc_vu_cu'] = $chiTietCongTacActive->id_chuc_vu_moi;
            }
            $chiTietCongTacCurrent =ChiTietCongTac::create($info);
            $nhansu->id_phong_ban = $chiTietCongTacCurrent->id_phong_ban_moi;
            $nhansu->id_chuc_vu = $chiTietCongTacCurrent->id_chuc_vu_moi;
            $nhansu->id_cua_hang = $chiTietCongTacCurrent->id_cua_hang_moi;
            $nhansu->id_bo_phan = $chiTietCongTacCurrent->id_bo_phan_moi;
            $nhansu->id_mien=$info['id_mien_moi'];
            $nhansu->id_chi_nhanh=$info['id_chi_nhanh_moi'];
            $nhansu->id_tinh=$info['id_tinh_moi'];
            $nhansu->save();
            DB::commit();
            return back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-danger')
                ->with('alert-content', __('system.error'));
        }
    }

    public function deletePhongBan($id)
    {       
        Auth::user();
        $phongban = ChiTietCongTac::query()->findOrFail($id);
        $phongban_truoc = ChiTietCongTac::query()->where('id_nhan_su',$phongban->id_nhan_su)->where('id','<',$id)->first();
        $phongban_sau = ChiTietCongTac::query()->where('id_nhan_su',$phongban->id_nhan_su)->where('id','>',$id)->first();

        DB::beginTransaction();

        try{
            if(!empty($phongban_truoc)&&!empty($phongban_sau)){
                $phongban_sau->id_phong_ban_cu=$phongban_truoc->id_phong_ban_moi;
                $phongban_sau->id_cua_hang_cu=$phongban_truoc->id_cua_hang_moi;
                $phongban_sau->id_chuc_vu_cu=$phongban_truoc->id_chuc_vu_moi;
                $phongban_sau->id_mien_cu=$phongban_truoc->id_mien_moi;
                $phongban_sau->id_chi_nhanh_cu=$phongban_truoc->id_chi_nhanh_moi;
                $phongban_sau->id_tinh_cu=$phongban_truoc->id_tinh_moi;
                $phongban_sau->id_bo_phan_cu=$phongban_truoc->id_bo_phan_moi;
                $phongban_sau->save();
            }
       
            if($phongban['active']){
                $nhansu=NhanSu::query()->findOrFail($phongban->id_nhan_su);
                $nhansu->id_phong_ban = null;
                $nhansu->id_cua_hang = null;
                $nhansu->id_chuc_vu = null;
                $nhansu->id_bo_phan = null;
                $nhansu->id_mien = null;
                $nhansu->id_tinh = null;
                $nhansu->id_chi_nhanh = null;
                $nhansu->save();
            }
            ChiTietCongTac::destroy($id);
            DB::commit();
            return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.delete_success'));
        }
        catch(Exception $ex){
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-danger')
                ->with('alert-content', __('system.error'));
        }
    }

    public function indexBaoHiem(Request $request,$id_nhan_su){
        $user = Auth::user();        
        $query = ChiTietBaoHiem::query()->where('id_nhan_su',$id_nhan_su)->with(['nhanSu','tinhThanh','mucDongBaoHiem']);
     
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
       
        if(isset($search)) {  
            $query->where(function ($query) use ($search) {
                $query->orWhere('ten', 'ilike', "%$search%");
            });
        }

        $query->orderBy('updated_at','desc');
        $baohiem = $query->paginate($perPage, ['*'], 'page', $page);
        return view('nhansu.baohiem.detail',[
            'menus' => $this->getMenusForUser($user),
            'data'=> $baohiem,
            'search'=>$search,
            'perPage' => $perPage,
            'tinhthanhs'=> $this->getDataByName('TinhThanh'),
            'mucdongbaohiems'=> $this->getDataByName('MucDongBaoHiem'),
            'nhansu'=> NhanSu::query()->where('id', $id_nhan_su)->first(['id','ho_ten','so_so_bao_hiem','so_the_bao_hiem']),
            'activeMenu' =>'baohiem'
            ]);
    }

    public function addBaoHiem(Request $request, $id)
    {
        $info = $request->all();
        $user = Auth::user();
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'muc_dong_bao_hiem_id'=>'required'
           
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ten'] = $this->ucfirst($info['ten']);
        $info['nguoi_cap_nhat']=$user->id;
        $info['nguoi_tao']=$user->id;
        $info['id_nhan_su']=$id;
        if(!empty($info['muc_dong_bao_hiem_id']))
        {
            $mucdongbaohiem=MucDongBaoHiem::findOrFail($info['muc_dong_bao_hiem_id']);
            $info['muc_dong_bao_hiem_xa_hoi']=$mucdongbaohiem->so_tien;
        }
        
        ChiTietBaoHiem::query()->create($info);
       
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updateBaoHiem(Request $request, $id)
    {
        
        $user = Auth::user();
        $baohiem = ChiTietBaoHiem::query()->findOrFail($id);
        
        $info = $request->only(['ten','thang_bat_dau','thang_chuyen_bao_hiem_ve_chi_nhanh','thang_dung_dong_bao_hiem',
        'muc_dong_bao_hiem_id','tu_ngay','toi_ngay','id_tinh_thanh']);
        $validator = Validator::make($info, [
            'ten' => 'required|max:255',
            'muc_dong_bao_hiem_id'=>'required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ten'] = $this->ucfirst($info['ten']);
        $info['nguoi_cap_nhat']=$user->id;
        $info['nguoi_tao']=$user->id;
        
        if(!empty($info['muc_dong_bao_hiem_id']))
        {
            $mucdongbaohiem=MucDongBaoHiem::findOrFail($info['muc_dong_bao_hiem_id']);
            $info['muc_dong_bao_hiem_xa_hoi']=$mucdongbaohiem->so_tien;
        }
        $baohiem->update($info);
       
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteBaoHiem($id)
    {
        Auth::user();
        ChiTietBaoHiem::findOrFail($id)->delete();

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function indexGiamTruGiaCanh(Request $request,$id_nhan_su){
        $user = Auth::user();        
        $query = ChiTietGiamTruGiaCanh::query()->where('id_nhan_su',$id_nhan_su);
     
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');


        if(isset($search)) {  
            $query->where(function ($query) use ($search) {
                $query->orWhere('ho_ten', 'ilike', "%$search%");
                $query->orWhere('quan_he', 'ilike', "%$search%");
        });
        }

        $query->orderBy('updated_at','desc');
        $baohiem = $query->paginate($perPage, ['*'], 'page', $page);
        return view('nhansu.giamtrugiacanh.detail',[
            'menus' => $this->getMenusForUser($user),
            'data'=>$baohiem,
            'nhansu'=>NhanSu::query()->where('id',$id_nhan_su)->first(['id']),
            'search'=>$search,
            'perPage' => $perPage,
            'activeMenu' =>'giamtrugiacanh'
        ]);
    }

    public function addGiamTruGiaCanh(Request $request, $id)
    {
        $info = $request->all();
    
        $user = Auth::user();
        $validator = Validator::make($info, [
            'ho_ten' => 'required|max:255',
            'gioi_tinh'=>'required',
           
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ho_ten'] = $this->cappitalizeEachWord($info['ho_ten']);
        $info['nguoi_cap_nhat']=$user->id;
        $info['nguoi_tao']=$user->id;
        $info['id_nhan_su']=$id;

        ChiTietGiamTruGiaCanh::query()->create($info);
       
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updateGiamTruGiaCanh(Request $request, $id)
    {
        
        $user = Auth::user();
        
        $info = $request->only([ 'ho_ten','ngay_sinh','gioi_tinh','quan_he','cmnd',
        'thoi_diem_bat_dau','thoi_diem_ket_thuc','ma_so_thue'
        ]);
        $validator = Validator::make($info, [
            'ho_ten' => 'required|max:255',
            'gioi_tinh'=>'required',

        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ho_ten'] = $this->cappitalizeEachWord($info['ho_ten']);
        $info['nguoi_cap_nhat']=$user->id;
        $info['nguoi_tao']=$user->id;

        ChiTietGiamTruGiaCanh::query()->findOrFail($id)->update($info);
       
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteGiamTruGiaCanh($id)
    {
        Auth::user();
        ChiTietGiamTruGiaCanh::destroy($id);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function indexGiaCanh(Request $request,$id_nhan_su){
        $user = Auth::user();        
        $query = ChiTietGiaCanh::query()->where('id_nhan_su',$id_nhan_su);
     
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
       
        if(isset($search)) {  
            $query->where(function ($query) use ($search) {
                $query->orWhere('ho_ten', 'ilike', "%$search%");
        });
        }

        $query->orderBy('updated_at','desc');
        $baohiem = $query->paginate($perPage, ['*'], 'page', $page);
        return view('nhansu.giacanh.detail',[
            'menus' => $this->getMenusForUser($user),
            'data'=>$baohiem,
            'nhansu'=>NhanSu::query()->where('id',$id_nhan_su)->first(),
            'search'=>$search,
            'perPage' => $perPage,
            'activeMenu' =>'giacanh'
        ]);
    }

    public function addGiaCanh(Request $request, $id)
    {
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ho_ten' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ho_ten'] = $this->cappitalizeEachWord($info['ho_ten']);
        $info['id_nhan_su']=$id;

        ChiTietGiaCanh::query()->create($info);
       
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updateGiaCanh(Request $request, $id)
    {
        Auth::user();
        $info = $request->only([ 'ho_ten','ngay_sinh','gioi_tinh','quan_he','nam_sinh',
        'da_chet','nghe_nghiep'
        ]);
        $validator = Validator::make($info, [
            'ho_ten' => 'required|max:255',

        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['ho_ten'] = $this->cappitalizeEachWord($info['ho_ten']);

        ChiTietGiaCanh::query()->findOrFail($id)->update($info);
       
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteGiaCanh($id)
    {
        Auth::user();
        ChiTietGiaCanh::findOrFail($id)->delete();

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }


    public function indexNghiDacBiet(Request $request,$id_nhan_su){
        $user = Auth::user();        
        $query = ChiTietNghiDacBiet::query()->where('id_nhan_su',$id_nhan_su)->with('loainghidacbiet:id,ten');

        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        if(isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ho_ten', 'ilike', "%$search%");
            });
        }

        $query->orderBy('updated_at','desc');
        $nghidacbiet = $query->paginate($perPage, ['*'], 'page', $page);
        return view('nhansu.nghidacbiet.detail',[
            'menus' => $this->getMenusForUser($user),
            'data'=>$nghidacbiet,
            'nhansu'=>NhanSu::query()->where('id',$id_nhan_su)->first(['id','ho_ten']),
            'search'=>$search,
            'perPage' => $perPage,
            'loainghidacbiets'=> $this->getDataByName('LoaiNghiDacBiet'),
            'activeMenu' =>'nghidacbiet'
        ]);
    }

    public function addNghiDacBiet(Request $request, $id)
    {
        Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'id_loai_nghi_dac_biet' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $info['id_nhan_su']=$id;

        ChiTietNghiDacBiet::query()->create($info);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function updateNghiDacBiet(Request $request, $id)
    {
        Auth::user();

        $info = $request->only([ 'id_loai_nghi_dac_biet', 'ngay_bat_dau','ngay_ket_thuc','trang_thai']);
        $validator = Validator::make($info, [
            'id_loai_nghi_dac_biet' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        ChiTietNghiDacBiet::query()->findOrFail($id)->update($info);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteNghiDacBiet($id)
    {
        Auth::user();
        ChiTietNghiDacBiet::findOrFail($id)->delete();

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function indexHoSoNhanSu(Request $request,$id_nhan_su){
        $user = Auth::user();        
        $query = HoSoNhanSu::query()->where('id_nhan_su',$id_nhan_su)->with('loaiHoSo');

        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        if(isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('file_name', 'ilike', "%$search%");
        });
        }

        $query->orderBy('updated_at','desc');
        $files = $query->paginate($perPage, ['*'], 'page', $page);
        return view('nhansu.hosonhansu.detail',[
            'menus' => $this->getMenusForUser($user),
            'data'=>$files,
            'loaihosonhansus'=> $this->getDataByName('Lookup')->where('loai','loai_ho_so_nhan_su')->where('active',true),
            'nhansu'=> NhanSu::query()->where('id', $id_nhan_su)->first(['id']),
            'search'=>$search,
            'perPage' => $perPage,
            'activeMenu' =>'hosonhansu'
        ]);
    }

    public function addHoSoNhanSu(Request $request, $id)
    {
        Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'file_ho_so_nhan_su' => 'required',
            'id_type' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        DB::beginTransaction();

        try{
            $nhansu=NhanSu::findOrFail($id);
            $type=Lookup::findOrFail($info['id_type']);
            switch($type->ma)
            {
                case '01' :
                    $nhansu->so_yeu_li_lich=true;
                    $nhansu->save();
                    break;
                case '02' :
                    $nhansu->ban_sao_cmnd=true;
                    $nhansu->save();
                    break;
                case '03' :
                    $nhansu->ban_sao_ho_khau=true;
                    $nhansu->save();
                    break;
                case '04' :
                    $nhansu->ban_sao_giay_khai_sinh=true;
                    $nhansu->save();
                    break;
                case '05' :
                    $nhansu->ban_sao_bang_cap_chung_chi=true;
                    $nhansu->save();
                    break;
                case '06' :
                    $nhansu->anh=true;
                    $nhansu->save();
                    break;
                case '07' :
                    $nhansu->so_so_bhxh=true;
                    $nhansu->save();
                    break;
                case '08' :
                    $nhansu->quyet_dinh_nghi_viec=true;
                    $nhansu->save();
                    break;
                case '09' :
                    $nhansu->tai_khoan_ca_nhan=true;
                    $nhansu->save();
                    break;
                case '10' :
                    $nhansu->co_giay_ksk=true;
                    $nhansu->save();
                    break;
            }
            
            $file=$info['file_ho_so_nhan_su'];
            if(!empty($file)){
                $file_id=time();
                $fileName = $file_id. '-' . $file->getClientOriginalName();
                $file->storeAs('public/files/', $fileName);

                HoSoNhanSu::create([
                    'id_nhan_su'=>$id,
                    'file_name'=>$file->getClientOriginalName(),
                    'link'=>'app/public/files/'.$fileName,
                    'file_id'=>$file_id,
                    'id_type'=>$info['id_type'],
                ]);
            }
            DB::commit();
            return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));
        }catch(Exception $ex){
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-danger')
                ->with('alert-content', __('system.error'));
        }
            
    }

    public function getDownload($file_id)
    {
        Auth::user();
        $file = HoSoNhanSu::query()
            ->where('file_id',  $file_id)->first();
            if(!empty($file)){
                if(Storage::exists('public/files/'.$file->file_id.'-'.$file->file_name))
                {
                    return response()->download(storage_path('app/public/files/'.$file->file_id.'-'.$file->file_name));
                }
        }
    }

    public function deleteHoSoNhanSu($id){
        Auth::user();
        $file=HoSoNhanSu::findOrFail($id);
        $nhansu=NhanSu::findOrFail($file->id_nhan_su);
        $count_file=HoSoNhanSu::query()->where('id_type',$file->id_type)->where('id_nhan_su',$file->id_nhan_su)->count();
        DB::beginTransaction();

        try{
            if($count_file==1){
                switch($file->loaiHoSo->ma)
                {
                    case '01' :
                        $nhansu->so_yeu_li_lich=false;
                        $nhansu->save();
                        break;
                    case '02' :
                        $nhansu->ban_sao_cmnd=false;
                        $nhansu->save();
                        break;
                    case '03' :
                        $nhansu->ban_sao_ho_khau=false;
                        $nhansu->save();
                        break;
                    case '04' :
                        $nhansu->ban_sao_giay_khai_sinh=false;
                        $nhansu->save();
                        break;
                    case '05' :
                        $nhansu->ban_sao_bang_cap_chung_chi=false;
                        $nhansu->save();
                        break;
                    case '06' :
                        $nhansu->anh=false;
                        $nhansu->save();
                        break;
                    case '07' :
                        $nhansu->so_so_bhxh=false;
                        $nhansu->save();
                        break;
                    case '08' :
                        $nhansu->quyet_dinh_nghi_viec=false;
                        $nhansu->save();
                        break;
                    case '09' :
                        $nhansu->tai_khoan_ca_nhan=false;
                        $nhansu->save();
                        break;
                    case '10' :
                    $nhansu->co_giay_ksk=false;
                    $nhansu->save();
                    break;
                }
            }
            if(!empty($file)){
                Storage::delete('public/files/'.$file->file_id.'-'.$file->file_name);
                HoSoNhanSu::destroy($id);
                DB::commit();
                return back()->withInput()
                    ->with('alert-type', 'alert-success')
                    ->with('alert-content', __('system.create_success'));
            }
            
        }catch(Exception $ex){
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-danger')
                ->with('alert-content', __('system.error'));
        }   
    }

    public function indexTheoDoiHopdong(Request $request,$id_nhan_su){
        $user = Auth::user();        
        $query = TheoDoiHopDong::query()->where('id_nhan_su',$id_nhan_su)->with(['nhanSu:id,ho_ten','loaiHopDong:id,ten','chucVu:id,ten','hopDongChucVu']);
     
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
       
        if(isset($search)) {  
            $query->where(function ($query) use ($search) {
                $query->orWhere('so_quyet_dinh', 'ilike', "%$search%");
        });
        }

        $query->orderBy('updated_at','desc');
        $hopdong = $query->paginate($perPage, ['*'], 'page', $page);
        $chitietcongtac= ChucVu::query()->whereHas('chiTietCongTacs',function($query) use($id_nhan_su){
            $query->where('id_nhan_su',$id_nhan_su);
        })->get();
        return view('nhansu.theodoihopdong.detail',[
            'menus' => $this->getMenusForUser($user),
            'data'=> $hopdong,
            'search'=> $search,
            'perPage' => $perPage,
            'loaihopdongs'=> $this->getDataByName('LoaiHopDong'),
            'chitietcongtacs'=>$chitietcongtac,
            'nhansu'=> NhanSu::query()->where('id',$id_nhan_su)->first(['id','ho_ten']),
            'activeMenu' => 'theodoihopdong'
        ]);
    }

    public function addTheoDoiHopDong(Request $request, $id)
    {
        $info = $request->all();
        Auth::user();
        $validator = Validator::make($info, [
            'ngay_hieu_luc'=>'required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        
        $info['id_nhan_su'] = $id;
        if($info['trang_thai']==1){
           if(!empty($info['ngay_het_hieu_luc'])&&Carbon::createFromFormat(config('app.format_date'),$info['ngay_het_hieu_luc'])<Carbon::now()){
            $info['trang_thai'] = 0;
           }
           else{
                $hopdong=TheoDoiHopDong::query()->where('id_nhan_su',$id)->where('trang_thai',1)->first();
                if(!empty($hopdong)){
                    if(Carbon::createFromFormat(config('app.format_date'),$hopdong->ngay_hieu_luc)<Carbon::createFromFormat(config('app.format_date'),$info['ngay_hieu_luc'])){
                        $hopdong->trang_thai=0;
                        $hopdong->save();
                    }
                    else{
                        $info['trang_thai']=0;
                    }
                }
           }
        }
        DB::beginTransaction();

        try{
            TheoDoiHopDong::query()->create($info);
            $hopdonghientai=TheoDoiHopDong::query()->where('id_nhan_su',$id)->where('trang_thai',1)->first();

            $nhansu=NhanSu::findOrFail($id);
            if(!empty($hopdonghientai)){
                $chinhthuc=LoaiHopDong::query()->where('ma','CT')->firstOrFail();
                $thuviec=LoaiHopDong::query()->where('ma','TV')->firstOrFail();
                $hocviec=LoaiHopDong::query()->where('ma','ĐTN')->firstOrFail();
                if($hopdonghientai->loai_hop_dong==$chinhthuc->id){
                    $nhansu->chinh_thuc=true;
                    $nhansu->hoc_viec=false;
                    $nhansu->thu_viec=false;
                    $nhansu->da_nghi_viec=false;
                }
                else if($hopdonghientai->loai_hop_dong==$thuviec->id){
                   
                    $nhansu->thu_viec=true;
                    $nhansu->hoc_viec=false;
                    $nhansu->chinh_thuc=false;
                    $nhansu->da_nghi_viec=false;
                    
                }
                else if($hopdonghientai->loai_hop_dong==$hocviec->id){
                    $nhansu->hoc_viec=true;
                    $nhansu->thu_viec=false;
                    $nhansu->chinh_thuc=false;
                    $nhansu->da_nghi_viec=false;                   
                }
                $nhansu->id_loai_hop_dong=$hopdonghientai->loai_hop_dong;
                $nhansu->save();
            }
            else{
                $nhansu->chinh_thuc=false;
                $nhansu->thu_viec=false;
                $nhansu->hoc_viec=false;
                $nhansu->id_loai_hop_dong = null;
                $nhansu->save();
            }
            DB::commit();
            return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
        }catch(Exception $ex){
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-danger')
                ->with('alert-content', __('system.error'));
        }
        
        
       
    }

    public function updateTheoDoiHopDong(Request $request, $id)
    {        
        Auth::user();
        $hopdongupdate = TheoDoiHopDong::query()->findOrFail($id);
        
        $info = $request->only(['loai_hop_dong','so_quyet_dinh','ngay_hieu_luc',
        'ngay_het_hieu_luc','ngay_quyet_dinh','trang_thai','id_chuc_vu']);

        $validator = Validator::make($info, [
            'ngay_hieu_luc'=>'required'
           
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        if($info['trang_thai']==1){
            if(!empty($info['ngay_het_hieu_luc'])&&Carbon::createFromFormat(config('app.format_date'),$info['ngay_het_hieu_luc'])<Carbon::now()){
             $info['trang_thai']=0;
            }
            else{
                 $hopdong=TheoDoiHopDong::query()->where('id_nhan_su',$hopdongupdate->id_nhan_su)->where('trang_thai',1)
                 ->where('id','<>',$id)->first();
                 if(!empty($hopdong)&&!empty($hopdong->ngay_hieu_luc)){
                     if(Carbon::createFromFormat(config('app.format_date'),$hopdong->ngay_hieu_luc)<Carbon::createFromFormat(config('app.format_date'),$info['ngay_hieu_luc'])){
                         $hopdong->trang_thai=0;
                         $hopdong->save();
                     }
                     else{
                        $info['trang_thai']=0;
                    }
                 }
            }
         }
        DB::beginTransaction();
        try{
            $hopdongupdate->update($info);
        
            $hopdonghientai=TheoDoiHopDong::query()->where('id_nhan_su',$hopdongupdate->id_nhan_su)->where('trang_thai',1)->first();

            $nhansu=NhanSu::findOrFail($hopdongupdate->id_nhan_su);
            if(!empty($hopdonghientai)){
                $chinhthuc=LoaiHopDong::query()->where('ma','CT')->firstOrFail();
                $thuviec=LoaiHopDong::query()->where('ma','TV')->firstOrFail();
                $hocviec=LoaiHopDong::query()->where('ma','ĐTN')->firstOrFail();
                if($hopdonghientai->loai_hop_dong==$chinhthuc->id){
                    $nhansu->chinh_thuc=true;
                    $nhansu->hoc_viec=false;
                    $nhansu->thu_viec=false;
                    $nhansu->da_nghi_viec=false;
                }
                else if($hopdonghientai->loai_hop_dong==$thuviec->id){
                   
                    $nhansu->thu_viec=true;
                    $nhansu->hoc_viec=false;
                    $nhansu->chinh_thuc=false;
                    $nhansu->da_nghi_viec=false;
                    
                }
                else if($hopdonghientai->loai_hop_dong==$hocviec->id){
                    $nhansu->hoc_viec=true;
                    $nhansu->thu_viec=false;
                    $nhansu->chinh_thuc=false;
                    $nhansu->da_nghi_viec=false;                   
                }
                $nhansu->id_loai_hop_dong=$hopdonghientai->loai_hop_dong;
                $nhansu->save();
            }
            else{
                $nhansu->chinh_thuc=false;
                $nhansu->thu_viec=false;
                $nhansu->hoc_viec=false;
                $nhansu->id_loai_hop_dong = null;
                $nhansu->save();
            }
                DB::commit();
                return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));
        }catch(Exception $ex){
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-danger')
                ->with('alert-content', __('system.error'));
        }
    }

    public function fileTheoDoiHopDong(Request $request, $id)
    {
        $info = $request->all();
        Auth::user();
        $hopdongnhansu = TheoDoiHopDong::findOrFail($id);

    
        if(!empty($info['file_hop_dong_nhan_su'])){
            $attachment=$info['file_hop_dong_nhan_su'];
            foreach($attachment as $attachment){
                $file=Attachment::query()->where('file_id',$attachment)->first();
                if(!empty($file)){
                    $file_copy_id=time()+Attachment::query()->count();
                    $attachment_copy=Attachment::create([
                    'reference_type'=>'hop_dong_nhan_su',
                    'reference_id'=>$hopdongnhansu->id,
                    'link'=>'storage/files/'.$file_copy_id.'-'.substr($file->name,11),
                    'name'=>$file_copy_id.'-'.substr($file->name,11),
                    'file_type'=>$file->file_type,
                    'file_size'=>$file->file_size,
                    'file_icon'=>$file->file_icon,
                    'file_id'=>$file_copy_id
                    ]);
                    
                    if(Storage::exists('public/files/'. $file->name))
                    {
                        Storage::copy('public/files/'. $file->name, 'public/files/'. $attachment_copy->name);
                    }
                    
                    
                }
            }
        }
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    public function deleteTheoDoiHopDong($id)
    {
        Auth::user();
        $hopdong=TheoDoiHopDong::findOrFail($id);
        DB::beginTransaction();
        try{

            TheoDoiHopDong::destroy($id);

            $hopdonghientai=TheoDoiHopDong::query()->where('id_nhan_su',$hopdong->id_nhan_su)->where('trang_thai',1)->first();
            $nhansu=NhanSu::findOrFail($hopdong->id_nhan_su);
            if(!empty($hopdonghientai)){
                $chinhthuc=LoaiHopDong::query()->where('ma','CT')->first();
                $thuviec=LoaiHopDong::query()->where('ma','TV')->first();
                $hocviec=LoaiHopDong::query()->where('ma','ĐTN')->first();
                if($hopdonghientai->loai_hop_dong==$chinhthuc->id){
                    $nhansu->chinh_thuc=true;
                    $nhansu->hoc_viec=false;
                    $nhansu->thu_viec=false;
                    $nhansu->da_nghi_viec=false;
                }
                else if($hopdonghientai->loai_hop_dong==$thuviec->id){
                   
                    $nhansu->thu_viec=true;
                    $nhansu->hoc_viec=false;
                    $nhansu->chinh_thuc=false;
                    $nhansu->da_nghi_viec=false;
                    
                }
                else if($hopdonghientai->loai_hop_dong==$hocviec->id){
                    $nhansu->hoc_viec=true;
                    $nhansu->thu_viec=false;
                    $nhansu->chinh_thuc=false;
                    $nhansu->da_nghi_viec=false;                   
                }
                $nhansu->id_loai_hop_dong=$hopdonghientai->loai_hop_dong;
                $nhansu->save();
            }
            else{
                $nhansu->chinh_thuc=false;
                $nhansu->thu_viec=false;
                $nhansu->hoc_viec=false;
                $nhansu->id_loai_hop_dong = null;
                $nhansu->save();
            }
            DB::commit();
            return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.delete_success'));
        }catch(Exception $ex){
            
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-danger')
                ->with('alert-content', __('system.error'));
        }
    }
    public function load($path, $sheetname, $callback)
    {
        Auth::user();
        return \Excel::load($path, function ($doc) use (&$sheetname, &$callback) {
            $doc->sheet($sheetname, function ($sheet) use (&$callback) {
                $callback($sheet);
            });
        });
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
                if(in_array('cmnd', $heading)) {
                    $reader->each(function ($row){                                          
                        $info = $row->all();                                         
                        try{                                                   
                            if(isset($info['cmnd'])) {
                                $info['cmnd'] = $this->code($info['cmnd']);
                                $nhansu = NhanSu::query()->where('cmnd', $info['cmnd'])->first();
                                if(isset($nhansu)) {
                                    if(isset($info['ho_ten'])) {
                                        $info['ho_ten'] = $this->cappitalizeEachWord($info['ho_ten']);
                                    }
                                    if(isset($info['ngay_sinh'])) {
                                        $info['ngay_sinh'] = $this->toTimeStamp($info['ngay_sinh']);
                                    }
                                    if(isset($info['ngay_cap'])) {
                                        $info['ngay_cap'] = $this->toTimeStamp($info['ngay_cap']);
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
                                    if(isset($info['email'])) {
                                        $info['email'] =  $this->trimAll($info['email']);
                                    }
                                    if(isset($info['gioi_tinh'])) {
                                        $info['gioi_tinh'] = $this->gioiTinh($info['gioi_tinh']);
                                    }
                                    if(isset($info['dan_toc'])) {
                                        $dantoc = DanToc::where('ten','ilike', "%{$info['dan_toc']}%")->first();
                                        $info['dan_toc'] = empty($dantoc)?null:$dantoc->id;
                                    }
                                    if(isset($info['quoc_tich'])) {
                                        $quoctich = QuocTich::where('ten','ilike', "%{$info['quoc_tich']}%")->first();
                                        $info['quoc_tich'] = empty($quoctich)?null:$quoctich->id;
                                    }
                                    if(isset($info['ton_giao'])) {
                                        $tongiao = TonGiao::where('ten','ilike', "%{$info['ton_giao']}%")->first();
                                        $info['id_ton_giao'] = empty($tongiao)?null:$tongiao->id;
                                    }
                                    $nhansu->update($info);
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

    public function indexDongPhuc(Request $request,$id_nhan_su){
        $user = Auth::user();        
        $query = ChiTietDongPhuc::query()->where('id_nhan_su',$id_nhan_su);

        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        if(isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('size','like',"%{$search}%");
            });
        }

        $query->orderBy('updated_at','desc');
        $dongphuc = $query->paginate($perPage, ['*'], 'page', $page);

        $lookups = $this->getDataByName('Lookup')->where('active', true);

        return view('nhansu.dongphuc.detail',[
            'menus' => $this->getMenusForUser($user),
            'data'=> $dongphuc,
            'search'=> $search,
            'perPage' => $perPage,
            'trangthaidongphucs'=> $lookups->where('loai','trang_thai_dong_phuc'),
            'sizes'=> $lookups->where('loai','size'),
            'nhansu'=> NhanSu::query()->where('id',$id_nhan_su)->first(),
            'activeMenu' => 'dongphuc'
        ]);
    }

    public function addDongPhuc(Request $request, $id)
    {
       
        $user = Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'so_luong' => 'required|min:0',
            'id_size' => 'required|exists:lookup,id',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        DB::beginTransaction();

        try{
            $nhansu = NhanSu::findOrFail($id);
            $nhansu->id_dong_phuc_size=$info['id_size'];
            $nhansu->save();
            $info['id_nhan_su'] = $id;
            $info['nguoi_tao_id'] = $user->id;
            $info['nguoi_sua_id'] = $user->id;
            if(isset($info['ngay'])){
                $info['ngay_cap_nhat']=$info['ngay'];
            }
            if(isset($info['trang_thai'])) {
                $info['id_trang_thai_dong_phuc'] = $info['trang_thai'];
            }
            if(!empty($info['trang_thai'])){
                if($info['trang_thai']==35){
                    $info['huy_dang_ky']=true;
                    $info['da_phat']=false;
                    $info['hoan_tra']=false;
                    $info['hong']=false;
                    $info['ngay_bao_huy']=$info['ngay'];

                    $nhansu->id_dong_phuc_size=$info['id_size'];
                    $nhansu->save();
                }
                else if($info['trang_thai']==32){
                    $nhansu->id_dong_phuc_size=$info['id_size'];
                    $nhansu->dong_phuc_so_luong=$nhansu->dong_phuc_so_luong+$info['so_luong'];
                    $nhansu->save();
                    $info['huy_dang_ky']=false;
                    $info['da_phat']=true;
                    $info['hoan_tra']=false;
                    $info['hong']=false;
                    $info['ngay_phat']=$info['ngay'];


                }
                else if($info['trang_thai']==33){
                    $nhansu->id_dong_phuc_size=$info['id_size'];
                    $nhansu->dong_phuc_so_luong=$nhansu->dong_phuc_so_luong-$info['so_luong'];
                    $nhansu->save();
                    $info['huy_dang_ky']=false;
                    $info['da_phat']=false;
                    $info['hoan_tra']=true;
                    $info['hong']=false;
                    $info['ngay_hoan']=$info['ngay'];

                }
                else if($info['trang_thai']==34){
                    $nhansu->save();
                    $info['huy_dang_ky']=false;
                    $info['da_phat']=false;
                    $info['hoan_tra']=false;
                    $info['hong']=true;
                    $info['ngay_bao_hong']=$info['ngay'];
                }
            }

            ChiTietDongPhuc::create($info);
            DB::commit();
            return back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-danger')
                ->with('alert-content', __('system.error'));
        }
    }

    public function editDongPhuc(Request $request, $id)
    {
        $user = Auth::user();
        $info = $request->all();
        $validator = Validator::make($info, [
            'trang_thai' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $chitietdongphuc =ChiTietDongPhuc::findOrFail($id);
        $nhansu = NhanSu::findOrFail($chitietdongphuc->id_nhan_su);
        DB::beginTransaction();
        
        try{
            $info['nguoi_tao_id'] = $user->id;
            $info['nguoi_sua_id'] = $user->id;
            if(isset($info['ngay'])){
                $info['ngay_cap_nhat']=$info['ngay'];
            }
            if(isset($info['trang_thai'])) {
                $info['id_trang_thai_dong_phuc'] = $info['trang_thai'];
            }
            if(!empty($info['trang_thai'])){
                if($info['trang_thai']==35){
                    $info['huy_dang_ky']=true;
                    $info['da_phat']=false;
                    $info['hoan_tra']=false;
                    $info['hong']=false;
                    $info['ngay_bao_huy']=$info['ngay'];

                    $nhansu->dong_phuc_size=$chitietdongphuc['size'];
                    $nhansu->save();
                }
                else if($info['trang_thai']==32){
                    $nhansu->dong_phuc_size=$chitietdongphuc->size;
                    if(!$chitietdongphuc->da_phat){ 
                        $nhansu->dong_phuc_so_luong=$nhansu->dong_phuc_so_luong+$chitietdongphuc->so_luong;
                    }
                    $nhansu->save();
                    $info['huy_dang_ky']=false;
                    $info['da_phat']=true;
                    $info['hoan_tra']=false;
                    $info['hong']=false;
                    $info['ngay_phat']=$info['ngay'];
                   
                   
                }
                else if($info['trang_thai']==33){
                    $nhansu->dong_phuc_size=$chitietdongphuc->size;
                    if(!$chitietdongphuc->hoan_tra){               
                        $nhansu->dong_phuc_so_luong=$nhansu->dong_phuc_so_luong-$chitietdongphuc->so_luong;                  
                        }
                        $nhansu->save();
                    $info['huy_dang_ky']=false;
                    $info['da_phat']=false;
                    $info['hoan_tra']=true;
                    $info['hong']=false;
                    $info['ngay_hoan']=$info['ngay'];
                   
                   
                }
                else if($info['trang_thai']==34){
                    $nhansu->save();
                    $info['huy_dang_ky']=false;
                    $info['da_phat']=false;
                    $info['hoan_tra']=false;
                    $info['hong']=true;
                    $info['ngay_bao_hong']=$info['ngay'];
                   
                }
            }
            $dongphucmoinhat=ChiTietDongPhuc::query()->where('id_nhan_su',$chitietdongphuc->id_nhan_su)
            ->orderBy('created_at')->first();
            if(empty($dongphucmoinhat)){
                $nhansu->id_dong_phuc_size=null;
                $nhansu->save();
            }
            else{
                $nhansu->id_dong_phuc_size=$dongphucmoinhat->id_size;
                $nhansu->save();
            }
           $chitietdongphuc->update($info);
            DB::commit();
            return back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-danger')
                ->with('alert-content', __('system.error'));
        }
    }

    public function deleteDongPhuc($id)
    {
        $chitietdongphuc =ChiTietDongPhuc::findOrFail($id);
        $nhansu = NhanSu::findOrFail($chitietdongphuc->id_nhan_su);
        DB::beginTransaction();
        
        try{
            if($chitietdongphuc['da_phat']){
                $nhansu->dong_phuc_so_luong=$nhansu->dong_phuc_so_luong-$chitietdongphuc->so_luong;
                $nhansu->save();                         
            }
            else if($chitietdongphuc['hoan_tra']){   
                $nhansu->dong_phuc_so_luong=$nhansu->dong_phuc_so_luong+$chitietdongphuc->so_luong;                  
                $nhansu->save();
            
                }
            
           
           $chitietdongphuc->destroy($id);
           $dongphucmoinhat=ChiTietDongPhuc::query()->where('id_nhan_su',$chitietdongphuc->id_nhan_su)
            ->orderBy('created_at','desc')->first();
           if(empty($dongphucmoinhat)){
                $nhansu->id_dong_phuc_size=null;
                $nhansu->save();
            }
            else{
                $nhansu->id_dong_phuc_size=$dongphucmoinhat->id_size;
                $nhansu->save();
            }
            DB::commit();
            return back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.success'));
        }
        catch(Exception $exception) {
            DB::rollback();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-danger')
                ->with('alert-content', __('system.error'));
        }
    }

    public function indexLuong(Request $request,$id_nhan_su){
        $user = Auth::user();        
        $query = ChiTietLuong::query()->where('nhan_su_id',$id_nhan_su)->with(['bacLuong']);

        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');


        if(isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('so_quyet_dinh', 'ilike', "%$search%");
            });
        }

        $query->orderBy('updated_at','desc');
        $luong = $query->paginate($perPage, ['*'], 'page', $page);
        $nhansu = NhanSu::find($id_nhan_su);
        return view('nhansu.luong.detail',[
            'menus' => $this->getMenusForUser($user),
            'bacs'=>isset($nhansu->id_chuc_vu)?Bac::query()->where('id_chuc_vu',$nhansu->id_chuc_vu)->get():Bac::query()->where('id','-1')->get(),
            'data'=>$luong,
            'nhansu'=>NhanSu::query()->where('id',$id_nhan_su)->first(),
            'search'=>$search,
            'perPage' => $perPage,
            'activeMenu' =>'luong'
        ]);
    }

    public function addLuong(Request $request, $id)
    {
        $info = $request->all();
        $user = Auth::user();
        $validator = Validator::make($info, [
            'ngay_huong_luong' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        if(isset($info['bac_id'])){
            $bac = Bac::find($info['bac_id']);
        }
        $info['nhan_su_id']=$id;
        DB::beginTransaction();
        try {
        if(!$info['inactive']){
            $chitietluong=ChiTietLuong::query()->where('nhan_su_id',$id)->where('inactive',false)->first();
            if(!empty($chitietluong)){
                if(Carbon::createFromFormat(config('app.format_date'),$chitietluong->ngay_huong_luong)>Carbon::createFromFormat(config('app.format_date'),$info['ngay_huong_luong'])){               
                    $info['inactive']=true;
                }
                else{
                    $chitietluong->inactive=true;
                    $chitietluong->save();
                }
            }
        }
    
        ChiTietLuong::query()
            ->create($info);
        $nhansu=NhanSu::findOrFail($id);
        $chitietluong=ChiTietLuong::query()->where('nhan_su_id',$id)->where('inactive',false)->first();
        if(!empty($chitietluong)){
            $nhansu->id_bac_luong=$chitietluong->bac_id;
        }
        else{
            $nhansu->id_bac_luong=null;
        }
        $nhansu->save();
        
        DB::commit();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
        } 
        catch(Exeption $exception){
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
    }

    public function updateLuong(Request $request, $id)
    {
        $user = Auth::user();
        $luong = ChiTietLuong::query()->findOrFail($id);

        $info = $request->only([ 'ngay_huong_luong','so_quyet_dinh','ngach_id','bac_id',
            'ngay_ky','dien_dai','he_so_phu_cap_chuc_vu','he_so_phu_cap_doc_hai','inactive'
        ]);
        $validator = Validator::make($info, [
            'ngay_huong_luong' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        if(isset($info['bac_id'])){
            $bac = Bac::find($info['bac_id']);
        }
        DB::beginTransaction();
        try {
        if(!$info['inactive']){
            $chitietluong=ChiTietLuong::query()->where('nhan_su_id',$luong->nhan_su_id)->where('inactive',false)->where('id','<>',$id)->first();
            if(!empty($chitietluong)){
                if(Carbon::createFromFormat(config('app.format_date'),$chitietluong->ngay_huong_luong)>Carbon::createFromFormat(config('app.format_date'),$info['ngay_huong_luong'])){               
                    $info['inactive']=true;
                }
                else{
                    $chitietluong->inactive=true;
                    $chitietluong->save();
                }
            }
        }
        $luong->update($info);

        $nhansu=NhanSu::findOrFail($luong->nhan_su_id);
        $chitietluong=ChiTietLuong::query()->where('nhan_su_id',$luong->nhan_su_id)->where('inactive',false)->first();
        if(!empty($chitietluong)){
            $nhansu->id_bac_luong=$chitietluong->bac_id;
        }
        else{
            $nhansu->id_bac_luong=null;
        }
        $nhansu->save();
       
        DB::commit();
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
        } 
        catch(Exeption $exception){
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
    }

    public function deleteLuong($id)
    {
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $luong=ChiTietLuong::findOrFail($id);
            $nhansu=NhanSu::findOrFail($luong->nhan_su_id);
            ChiTietLuong::destroy($id);
            $chitietluong=ChiTietLuong::query()->where('nhan_su_id',$luong->nhan_su_id)->where('inactive',false)->first();
            if(!empty($chitietluong)){
                $nhansu->he_so_luong=$chitietluong->he_so_luong;
            }
            else{
                $nhansu->he_so_luong=null;
            }
            $nhansu->save();
            DB::commit();
            return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));
            } 
        catch(Exeption $exception){
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
    }

    public function indexLichSuThayDoi(Request $request, $id_nhan_su){
        $user = Auth::user();        
        $nhansu = NhanSu::findOrFail($id_nhan_su);
        $query = NhanSuLog::query()->where('ma', $nhansu->ma);
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');

        if(isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ho_ten', 'ilike', "%$search%");
            });
        }

        $query->orderBy('updated_at','desc');
        $lichsu = $query->paginate($perPage, ['*'], 'page', $page);
        
        return view('nhansu.lichsuthaydoi.index',[
            'menus' => $this->getMenusForUser($user),
            'data'=> $lichsu,
            'nhansu'=> $nhansu,
            'search'=> $search,
            'perPage' => $perPage,
            'activeMenu' => 'lichsuthaydoi'
        ]);
    }

    public function detailLichSuThayDoi(Request $request, $id)
    {
        $user = Auth::user();        

        return view('nhansu.lichsuthaydoi.detail',[
            'menus' => $this->getMenusForUser($user),
            'nhansu'=> NhanSuLog::query()->findOrFail($id),
        ]);
    }
}
