<?php

namespace App\Http\Controllers;

use App\LoaiPhongBan;
use App\MucDongBaoHiem;
use Illuminate\Http\Request;
use App\NhanSu;
use App\CuaHang;
use App\LoaiHopDong;
use App\PhongBan;
use App\ChiTietBaoHiem;
use App\TheoDoiHopDong;
use App\ChiTietGiamTruGiaCanh;
use App\ToChuc;
use Carbon\Carbon;
use App\ThamSoHeThong;
use App\Menu;
use Illuminate\Support\Facades\Auth;
use App\Traits\ExecuteExcel;
use Illuminate\Support\Facades\DB;
use App\ConfigToChuc;
use App\Traits\GetDataCache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

class ReportController extends Controller
{
    use ExecuteExcel, GetDataCache;

    protected $keys =['chinh_thuc','thu_viec','hoc_viec','nghi_viec','tong'];

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request) {
        $user = Auth::user();        
        return view('report.index',[
            'menus' => $this->getMenusForUser($user),                                    
        ]);                
    }

    public function reportnhansu(Request $request) {
        $user = Auth::user();
        $search_time_start = $request->get('search_time_start');
        $search_time_end = $request->get('search_time_end');
        if(empty($search_time_start)){
            $search_time_start = Carbon::now()->addMonth(-12);
        }
        else{
            $search_time_start = Carbon::createFromFormat(config('app.format_date'), $search_time_start);
        }
    
        if(empty($search_time_end)){
            $search_time_end = Carbon::now();
        }
        else{
            $search_time_end = Carbon::createFromFormat(config('app.format_date'), $search_time_end);
        }

        $tochus = $this->getDataByName('ToChuc');
        $loaiToChucs = $this->getDataByName('LoaiToChuc');
        $loaiMien = $loaiToChucs->where('ma', 'MIEN')->first();
        $loaiChiNhanh = $loaiToChucs->where('ma', 'CN')->first();
        $loaiTinh = $loaiToChucs->where('ma', 'TINH')->first();
        $to_chucs = collect([]);
        if(!empty($loaiChiNhanh)) {
            $to_chucs = $tochus->where('loai_to_chuc_id', $loaiChiNhanh->id);
        }

        $configToChucs = $this->getDataByName('ConfigToChuc');
        $ten_hien_thi_mien = $configToChucs->where('id_loai_to_chuc', $loaiMien->id)->first();
        $ten_hien_thi_chi_nhanh = $configToChucs->where('id_loai_to_chuc', $loaiChiNhanh->id)->first();
        $ten_hien_thi_tinh = $configToChucs->where('id_loai_to_chuc', $loaiTinh->id)->first();
        $bo_phans = PhongBan::query()->whereHas('loai_phong_ban',function ($query) {
            $query->where('ma','BP');
        })->get();
        $tong_cua_hang=0;
        $cuahangIds=[];
        foreach ($to_chucs as $to_chuc){
                $cuahangs = CuaHang::where('id_chi_nhanh',$to_chuc->id);
                $tong_cua_hang = $tong_cua_hang+$cuahangs->count();
                foreach ($cuahangs->get() as $cuahang){
                    $cuahangIds[] = $cuahang->id;
                }
            $to_chuc['tong_cua_hang']=$tong_cua_hang;
            $to_chuc['cua_hang_ids'] = $cuahangIds;
        }
        $nhansuQuery = NhanSu::query();
        $nhansuQuery->where('created_at','>=',$search_time_start);
        $nhansuQuery->where('created_at','<=',$search_time_end);
        foreach ($bo_phans as $bo_phan){
            $data_chi_nhanh =[];
            foreach ($to_chucs as $to_chuc){
                $tong=0;
                $tong_thu_viec=0;
                $tong_hoc_viec=0;
                $tong_nghi_viec=0;
                $a[]=$to_chuc->to_chuc_ids;
                $nhansus = $nhansuQuery->get();
                foreach ($nhansus as $nhansu){
                    if($nhansu->id_chi_nhanh==$to_chuc->id || in_array($nhansu->id_cua_hang,$to_chuc->cua_hang_ids) )
                        {
                            if($nhansu->id_bo_phan === $bo_phan->id) {
                                $tong = $tong + 1;
                                if ($nhansu->da_nghi_viec) {
                                    $tong_nghi_viec = $tong_nghi_viec + 1;
                                } elseif ($nhansu->thu_viec) {
                                    $tong_thu_viec = $tong_thu_viec + 1;
                                } elseif ($nhansu->hoc_viec) {
                                    $tong_hoc_viec = $tong_hoc_viec + 1;
                                    }
                            }
                        }
                }
                $data_chi_nhanh[]=['ten'=>$to_chuc->ten,
                    'tong'=>$tong,
                    'hoc_viec'=>$tong_hoc_viec,
                    'thu_viec'=>$tong_thu_viec,
                    'nghi_viec'=>$tong_nghi_viec,
                    'chinh_thuc'=>$tong-$tong_hoc_viec-$tong_nghi_viec-$tong_thu_viec,
                    ];
            }
            $data[]=['bophan'=>$bo_phan['ten'],
                    'chinhanh'=>$data_chi_nhanh,
            ];
        }
        
        if($request->headers->get('accept')!='xlsx')
        {
            $user = Auth::user();            
            $perPage = $request->get('perpage', 10);
            $page = $request->get('page', 1);
            $search = $request->get('search');
            
            return view('report.reportnhansu',[
                'menus' => $this->getMenusForUser($user),
                'data' => $data,
                'search_time_start' => $search_time_start,
                'search_time_end' => $search_time_end,
                'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
                'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
                'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            ]);
        }
        else{
            $excelFile = public_path() . '/report/tem_tong_hop_nhan_su.xlsx';
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$data, &$input) {
                $header_data=[null,null];
                foreach($data[1]['chinhanh'] as $chinhanh ){
                   $header=[ 
                       $chinhanh['ten'],
                        null,
                        null,
                        null,
                        null
                   ];
                  $header_data =array_merge($header_data,$header);
                    
                }  
                $sheet->row(4,
                    $header_data                                        
                );
                $key=0;
             foreach($data as  $bophan){
                 $data_all =[
                     $key+1,
                     $bophan['bophan']];
                 foreach ($bophan['chinhanh'] as $chinhanh){
                    $row_data = [
                        $chinhanh['chinh_thuc'],
                        $chinhanh['thu_viec'],
                        $chinhanh['hoc_viec'],
                        $chinhanh['nghi_viec'],
                        $chinhanh['tong'],
                    ];
                     $data_all=array_merge($data_all,$row_data);
                 }
                 $rowKey= $key;
                
                $sheet->row($rowKey + 6,
                    $data_all
                );
                 $key++;
                }
               
             })->download('xlsx');
         }
    }


    public function reportnhansubophan(Request $request) {
        $user = Auth::user();
        $search_time_start = $request->get('search_time_start');
        $search_time_end = $request->get('search_time_end');
      
        $search_mien = $request->get('search_mien');
        $search_chi_nhanh = $request->get('search_chi_nhanh');
        $search_tinh = $request->get('search_tinh');
        if(empty($search_time_start)){
            $search_time_start = Carbon::now()->addMonth(-12);
        }
        else{
            $search_time_start = Carbon::createFromFormat(config('app.format_date'), $search_time_start);
        }
    
        if(empty($search_time_end)){
            $search_time_end = Carbon::now();
        }
        else{
            $search_time_end = Carbon::createFromFormat(config('app.format_date'), $search_time_end);
        }

        
        $query = PhongBan::query();
        $loaiphongban=LoaiPhongBan::query()->where('ma','BP')->firstOrFail();
        $query->where('loai_phong_ban_id', $loaiphongban->id);

        // lay full len
        $query->withCount([
            'bophannhansus as soluong'=>function($query) use ($search_tinh,$search_time_start,$search_time_end,$search_mien,$search_chi_nhanh){
                if(isset($search_mien)){
                    $query->where(function($query) use($search_mien){
                        $query->where('id_mien',$search_mien);   
                    });
                }
                if(isset($search_chi_nhanh)){
                    $query->where(function($query) use($search_chi_nhanh){
                        $query->where('id_chi_nhanh',$search_chi_nhanh);   
                    });
                }
                if(isset($search_tinh)){
                    $query->where(function($query) use($search_tinh){
                        $query->where('id_tinh',$search_tinh);
                    });
                }
                $query->where('created_at','>=',$search_time_start);
                $query->where('created_at','<=',$search_time_end);
             },
            'bophannhansus as thuviec'=>function($query) use ($search_tinh,$search_time_start,$search_time_end,$search_mien,$search_chi_nhanh){
            $query->where('thu_viec',true);
                if(isset($search_mien)){
                    $query->where(function($query) use($search_mien){
                        $query->where('id_mien',$search_mien);   
                    });
                }
                if(isset($search_chi_nhanh)){
                    $query->where(function($query) use($search_chi_nhanh){
                        $query->where('id_chi_nhanh',$search_chi_nhanh);   
                    });
                }
                if(isset($search_tinh)){
                    $query->where(function($query) use($search_tinh){
                        $query->where('id_tinh',$search_tinh);
                    });
                }
                $query->where('created_at','>=',$search_time_start);
                $query->where('created_at','<=',$search_time_end);
            },
            'bophannhansus as nghiviec'=>function($query) use($search_tinh,$search_time_start,$search_time_end,$search_mien,$search_chi_nhanh){
                $query->where('da_nghi_viec',true);
                if(isset($search_mien)){
                    $query->where(function($query) use($search_mien){
                        $query->where('id_mien',$search_mien);   
                    });
                }
                if(isset($search_chi_nhanh)){
                    $query->where(function($query) use($search_chi_nhanh){
                        $query->where('id_chi_nhanh',$search_chi_nhanh);   
                    });
                }
                if(isset($search_tinh)){
                    $query->where(function($query) use($search_tinh){
                        $query->where('id_tinh',$search_tinh);
                    });
                }
                $query->where('created_at','>=',$search_time_start);
                $query->where('created_at','<=',$search_time_end);
            },
            'bophannhansus as hocviec'=>function($query) use($search_tinh,$search_time_start,$search_time_end,$search_mien,$search_chi_nhanh){
                $query->where('hoc_viec',true);
                $query->where('created_at','>=',$search_time_start);
                $query->where('created_at','<=',$search_time_end);
                if(isset($search_mien)){
                    $query->where(function($query) use($search_mien){
                        $query->where('id_mien',$search_mien);   
                    });
                }
                if(isset($search_chi_nhanh)){
                    $query->where(function($query) use($search_chi_nhanh){
                        $query->where('id_chi_nhanh',$search_chi_nhanh);   
                    });
                }
                if(isset($search_tinh)){
                    $query->where(function($query) use($search_tinh){
                        $query->where('id_tinh',$search_tinh);
                    });
                }
            },
            'bophannhansus as chinhthuc'=>function($query) use($search_tinh,$search_time_start,$search_time_end,$search_mien,$search_chi_nhanh){
                $query->where('chinh_thuc',true);
                if(isset($search_mien)){
                    $query->where(function($query) use($search_mien){
                        $query->where('id_mien',$search_mien);   
                    });
                }
                if(isset($search_chi_nhanh)){
                    $query->where(function($query) use($search_chi_nhanh){
                        $query->where('id_chi_nhanh',$search_chi_nhanh);   
                    });
                }
                if(isset($search_tinh)){
                    $query->where(function($query) use($search_tinh){
                        $query->where('id_tinh',$search_tinh);
                    });
                }
                $query->where('created_at','>=',$search_time_start);
                $query->where('created_at','<=',$search_time_end);
            }
        ]);
        $data = $query->get();
    
        $total = 0;
        $total_chinh_thuc = 0;
        $total_nghi_viec = 0;
        $total_thu_viec = 0;
        $total_hoc_viec = 0;
        foreach ($data as $item){
            $total = $total+$item->soluong;
            $total_chinh_thuc = $total_chinh_thuc+$item->chinhthuc;
            $total_nghi_viec = $total_nghi_viec+$item->nghiviec;
            $total_thu_viec = $total_thu_viec+$item->thuviec;
            $total_hoc_viec = $total_hoc_viec+$item->hocviec;
        }
        $tong =
            ['soluong'=>$total,
            'chinhthuc'=>$total_chinh_thuc,
            'nghiviec'=>$total_nghi_viec,
            'thuviec'=>$total_thu_viec,
            'hocviec'=>$total_hoc_viec
            ];

        if($request->headers->get('accept')!='xlsx')
        {
            $user = Auth::user();            
            $perPage = $request->get('perpage', 10);
            $page = $request->get('page', 1);
            $search = $request->get('search');

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

            return view('report.reportnhansubophan',[
                'menus' => $this->getMenusForUser($user),
                'data' => $data,
                'tong'=>$tong,
                'miens'=>$miens,
                'tinhs'=>$tinhs,
                'chinhanhs'=>$chinhanhs,
                'search_tinh'=>$search_tinh,
                'search_time_start' => $search_time_start,
                'search_time_end' => $search_time_end,
                'all_to_chuc' => ToChuc::withoutGlobalScope('active')->get(),
                'search_mien' => $search_mien, 
                'search_chi_nhanh' => $search_chi_nhanh,
                'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
                'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
                'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            ]);
        }
        else{           
            $excelFile = public_path() . '/report/bao_cao_nhan_su_bo_phan.xlsx';            
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$data, &$tong, &$input,&$search_time_start,&$search_time_end,&$ten_truc_thuoc,&$temp) {
                $this->setValue($sheet, 'C4', $search_time_start);                  
                $this->setValue($sheet, 'E4', $search_time_end);
                $this->setValue($sheet, 'D5', $temp);    
                $this->setWidth($sheet, array(
                    'A' => 5,
                    'B' => 30,
                    'C' => 15,
                    'D' => 15,
                    'E' => 15,
                    'F' => 15,
                    'G' => 15,
                    'H' => 15,
                    'I' => 50,
                ));
                
                $key=0;
             foreach($data as $item) {
                    $rowKey = $key;
                    $sheet->row($rowKey + 8, [
                    $rowKey + 1,
                     $item->ten,
                     $item->soluong,
                     $item->chinhthuc,
                     $item->thuviec,
                     $item->hocviec,
                     $item->nghiviec,
                    ]);
                    $key++;
                }
                $sheet->row($key + 8, [
                    $key + 1,
                    'Tổng',
                    $tong['soluong'],
                    $tong['chinhthuc'],
                    $tong['thuviec'],
                    $tong['hocviec'],
                    $tong['nghiviec'],
                ]);
             })->download('xlsx');
         }
    }

    public function reporttonghopbaohiem(Request $request) {
        $user = Auth::user();
        $search_time_start = $request->get('search_time_start');
        $search_time_end = $request->get('search_time_end');
        if(empty($search_time_start)){
            $search_time_start = Carbon::now()->startOfYear()->addMonth(-12);
        }
        else{
            $search_time_start = Carbon::createFromFormat(config('app.format_date'), $search_time_start);
        }
    
        if(empty($search_time_end)){
            $search_time_end = Carbon::now()->endOfYear()->addMonth(-12);
        }
        else{
            $search_time_end = Carbon::createFromFormat(config('app.format_date'), $search_time_end);
        }

        $query = ToChuc::query()->whereHas('loaiToChuc',function($query){
            $query->where('ma','TINH');
        });

        $loaiToChucs = $this->getDataByName('LoaiToChuc');
        $loaiMien = $loaiToChucs->where('ma', 'MIEN')->first();
        $loaiChiNhanh = $loaiToChucs->where('ma', 'CN')->first();
        $loaiTinh = $loaiToChucs->where('ma', 'TINH')->first();

        $configToChucs = $this->getDataByName('ConfigToChuc');
        $ten_hien_thi_mien = $configToChucs->where('id_loai_to_chuc', $loaiMien->id)->first();
        $ten_hien_thi_chi_nhanh = $configToChucs->where('id_loai_to_chuc', $loaiChiNhanh->id)->first();
        $ten_hien_thi_tinh = $configToChucs->where('id_loai_to_chuc', $loaiTinh->id)->first();

        $query->withCount(['nhanSuTinh as tong_so_tham_gia_bao_hiem' =>function($query)use($search_time_start,$search_time_end){
            $query->whereHas('chiTietBaoHiems',function($query) use($search_time_start,$search_time_end){
                $query->where('thang_bat_dau','>=',$search_time_start)
                ->where('thang_dung_dong_bao_hiem','<=',$search_time_end);
            });
        }])->withCount(['nhanSuTinh as tong_so_nhan_su' =>function($query){

        }]);
      
      
        $data=$query->get();
       
        $data=$data->groupBy(['parent.id']);
       
        foreach($data as $id=> $chinhanh){
            $query=NhanSu::where('id_chi_nhanh',$id);
            $tong_nhan_su= $query->count();
            $chinhanh1=ToChuc::findOrFail($id);
            $chinhanh['ten']=$chinhanh1->ten;
            $chinhanh['tong_so_tham_gia_bao_hiem_chi_nhanh']=$query->whereHas('chiTietBaoHiems',function($query) use($search_time_start,$search_time_end){
                $query->where('thang_bat_dau','>=',$search_time_start)
                ->where('thang_dung_dong_bao_hiem','<=',$search_time_end);
            })->count();
           $chinhanh['tong_so_khong_tham_gia_bao_hiem_chi_nhanh']=$tong_nhan_su- $chinhanh['tong_so_tham_gia_bao_hiem_chi_nhanh'];
            $chinhanh['rowspan']=count($chinhanh)-3;
            
           foreach($chinhanh as $tinh){
               if(isset($tinh->id)){
               $mucdongbh=MucDongBaoHiem::query()->withCount(['chiTietBaoHiems'=>function($query)use($search_time_start,$search_time_end,$tinh){
                   $query->where('thang_bat_dau','>=',$search_time_start)
                    ->where('thang_dung_dong_bao_hiem','<=',$search_time_end)
                    ->whereHas('nhanSu',function($query)use($search_time_start,$search_time_end,$tinh){                      
                        $query->where('id_tinh',$tinh['id']);                 
                    });
               }]);
              
               $tinh['muc']=($mucdongbh->get()->where('chi_tiet_bao_hiems_count','>',0)->toArray());
               if(count($tinh['muc'])>1){
                $chinhanh['rowspan']+=count($tinh['muc'])-1;
               }
               $tinh['tong_quy_luong']=0;
               foreach($tinh['muc'] as $muc){
                   $tinh['tong_quy_luong']+=$muc['so_tien']*$muc['chi_tiet_bao_hiems_count'];
               }
            }
           }
           
        }

        if($request->headers->get('accept')!='xlsx')
        {
            $user = Auth::user();            
            $perPage = $request->get('perpage', 10);
            $page = $request->get('page', 1);
            $search = $request->get('search');
            
            return view('report.reporttonghopbaohiem',[
                'menus' => $this->getMenusForUser($user),
                'data' => $data,
                'search_time_start' => $search_time_start,
                'search_time_end' => $search_time_end,
                'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
                'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
                'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            ]);
        }
        else{           
            $excelFile = public_path() . '/report/tem_bao_cao_ho_so_nhan_su.xlsx';
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$data, &$input) {
                $key=0;
             foreach($data as $ten => $noidangky) {
                    $rowKey = $key;
                    $sheet->row($rowKey + 9, [
                    $rowKey + 1,
                    $ten,
                    count($noidangky),
                    $noidangky['count_ketQuaXetHoSo_dat'],
                    $noidangky['count_ketQuaXetHoSo_khongdat'] ,      
                    ]);
                    $key++;
                }
             })->download('xlsx');
         }
    }

    public function reportdanhsachthamgiabaohiem(Request $request) {
        $user = Auth::user();
        $search_time_start = $request->get('search_time_start');
        $search_time_end = $request->get('search_time_end');
        if(empty($search_time_start)){
            $search_time_start = Carbon::now()->addMonth(-12);
        }
        else{
            $search_time_start = Carbon::createFromFormat(config('app.format_date'), $search_time_start);
        }
    
        if(empty($search_time_end)){
            $search_time_end = Carbon::now();
        }
        else{
            $search_time_end = Carbon::createFromFormat(config('app.format_date'), $search_time_end);
        }
        
        $data = NhanSu::query()->whereBetween('ngay_nhan',[$search_time_start, $search_time_end])            
            ->with(['noiDangKySatHach', 'ketQuaThiSatHach', 'ketQuaXetHoSo'])
            ->get();

        $data = $data->groupBy(['noiDangKySatHach.ten']);

        foreach($data as $noidangky) {             
            $noidangky->group_by_ket_qua_xet_ho_so = $noidangky->groupBy('ketQuaXetHoSo.ten'); 
            $noidangky->group_by_ket_qua_thi_sat_hach = $noidangky->groupBy('ketQuaThiSatHach.ten'); 
            $noidangky->count_qua_han_ngay_nhan = $noidangky->where('qua_han_ngay_nhan', '>=', 0)->count(); 
            $noidangky->count_den_han_ngay_nhan = $noidangky->where('qua_han_ngay_nhan', '<', 0)->count(); 
            $noidangky->count_qua_han_ngay_sach_hach = $noidangky->where('qua_han_ngay_thi', '>=', 0)->count(); 
            $noidangky->count_den_han_ngay_sach_hach = $noidangky->where('qua_han_ngay_thi', '<', 0)->count(); 
        }

        if($request->headers->get('accept')!='xlsx')
        {
            $user = Auth::user();            
            $perPage = $request->get('perpage', 10);
            $page = $request->get('page', 1);
            $search = $request->get('search');
            
            return view('report.index',[
                'menus' => $this->getMenusForUser($user),
                'data' => $data,
                'search_time_start' => $search_time_start,
                'search_time_end' => $search_time_end,                        
            ]);
        }
        else{           
            $excelFile = public_path() . '/report/tem_bao_cao_ho_so_nhan_su.xlsx';
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$data, &$input) {
                $key=0;
             foreach($data as $ten => $noidangky) {
                    $rowKey = $key;
                    $sheet->row($rowKey + 9, [
                    $rowKey + 1,
                    $ten,
                    count($noidangky),
                    $noidangky['count_ketQuaXetHoSo_dat'],
                    $noidangky['count_ketQuaXetHoSo_khongdat'] ,      
                    ]);
                    $key++;
                }
             })->download('xlsx');
         }
    }

    public function reportbaohiemthegioisuatheonam(Request $request) {
        $user = Auth::user();
        $search_time_start = $request->get('search_time_start');
        $search_time_end = $request->get('search_time_end');
        $search_mien = $request->get('search_mien');
        $search_chi_nhanh = $request->get('search_chi_nhanh');
        $search_tinh = $request->get('search_tinh');
        if(empty($search_time_start)){
            $search_time_start = Carbon::now()->startOfYear()->addMonth(-12);
        }
        else{
            $search_time_start = Carbon::createFromFormat(config('app.format_date'), $search_time_start);
        }
    
        if(empty($search_time_end)){
            $search_time_end = Carbon::now()->endOfYear()->addMonth(-12);
        }
        else{
            $search_time_end = Carbon::createFromFormat(config('app.format_date'), $search_time_end);
        }

        $query = NhanSu::query()->with(['chiNhanh','chucVu'])->whereExists(function ($query){
            $query->select(DB::raw(1))
                ->from('chi_tiet_bao_hiems')
                ->whereRaw('id_nhan_su=nhan_sus.id');
        });
        if(isset($search_mien)){
            $query->where('id_mien',$search_mien);
        }
        if(isset($search_chi_nhanh)){
                $query->where('id_chi_nhanh',$search_chi_nhanh);
        }
        if(isset($search_tinh)){
            $query->where('id_tinh',$search_tinh);
        }
           $data=$query->get();
        $datas=[];
        $mucs = $this->getDataByName('MucDongBaoHiem');
        $dsbaohiem= ChiTietBaoHiem::query()->get();
        foreach ($data as $item){
           $baohiems=$dsbaohiem->where('id_nhan_su',$item->id);
           $dt=[];
           $dt['ho_ten']=$item->ho_ten;
           $dt['ma']=$item->ma;
           $dt['so_so_bao_hiem']=$item->so_so_bao_hiem;
           $dt['chuc_vu']=$item->chucVu->ten;
           $dt['chi_nhanh']=$item->chiNhanh->ten;
           foreach ($baohiems as $baohiem){
               foreach ($mucs as $muc){
                   if($baohiem->muc_dong_bao_hiem_id == $muc->id) {
                       $dt['muc_'.$muc->id] = $baohiem->muc_dong_bao_hiem_xa_hoi;
                       $dt['muc_'.$muc->id.'_tu_thang'] = $baohiem->thang_bat_dau;
                       $dt['muc_'.$muc->id.'_den_thang' ] = $baohiem->thang_dung_dong_bao_hiem;
                   }else if(!isset($dt['muc_'.$muc->id])){
                       $dt['muc_'.$muc->id] = null;
                       $dt['muc_'.$muc->id.'_tu_thang'] = null;
                       $dt['muc_'.$muc->id.'_den_thang']= null;
                   }
               }

           }
           $datas[]= $dt;
        }
        if($request->headers->get('accept')!='xlsx')
        {
            $user = Auth::user();            
            $perPage = $request->get('perpage', 10);
            $page = $request->get('page', 1);
            $search = $request->get('search');

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
            return view('report.reportbaohiemthegioisuatheonam',[
                'menus' => $this->getMenusForUser($user),
                'data' => $this->paginate($data,$perPage,$page),
                'all_to_chuc' => ToChuc::withoutGlobalScope('active')->get(),
                'search_time_start' => $search_time_start,
                'search_time_end' => $search_time_end,
                'search_mien' => $search_mien,  
                'search_chi_nhanh' => $search_chi_nhanh,  
                'search_tinh' => $search_tinh, 
                'miens'=>$miens,
                'tinhs'=>$tinhs,
                'chinhanhs'=>$chinhanhs, 
                'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
                'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
                'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            ]);
        }
        else {

            $excelFile = public_path() . '/report/tem_bao_cao_bao_hiem_theo_nam.xlsx';
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$datas, &$input) {
                $key = 0;
                foreach ($datas as $key => $baohiem) {
                    $rowKey = $key;
                    $sheet->row($rowKey + 5, [
                        $rowKey + 1,
                        $baohiem['ho_ten'],
                        $baohiem['ma'],
                        $baohiem['so_so_bao_hiem'],
                        $baohiem['chuc_vu'],
                        $baohiem['chi_nhanh'],
                        $baohiem['muc_1'],
                        $baohiem['muc_1_tu_thang'],
                        $baohiem['muc_1_den_thang'],
                        $baohiem['muc_2_tu_thang'],
                        $baohiem['muc_2_den_thang'],
                    ]);
                    $key++;
                }
            })->download('xlsx');
        }
    }

    public function indexHopDongHetHan(Request $request){
       
        $user = Auth::user();
        $month = Carbon::now()->month;   

        $query = TheoDoiHopDong::query()->whereNotNull('ngay_het_hieu_luc')->where('trang_thai',true)
        ->whereMonth('ngay_het_hieu_luc',$month)->whereHas('nhanSu');
     
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_tinh = $request->get('search_tinh');
        $search_chi_nhanh = $request->get('search_chi_nhanh');

        if(isset($search_tinh)) {
            $query->whereHas('nhanSu',function ($query) use ($search_tinh) {
                $query->where('id_tinh',$search_tinh);
        });
        }
        if(isset($search_chi_nhanh)) {
            $query->whereHas('nhanSu',function ($query) use ($search_chi_nhanh) {
                $query->where('id_chi_nhanh',$search_chi_nhanh);
        });
        }
        if(isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('so_quyet_dinh', 'like', "%$search%");
                $query->orWhereHas('nhanSu',function ($query) use ($search) {
                    $query->where('ho_ten','like', "%$search%");
                });
            });
        }

        $tochus = $this->getDataByName('ToChuc');
        $loaiToChucs = $this->getDataByName('LoaiToChuc');
        $loaiMien = $loaiToChucs->where('ma', 'MIEN')->first();
        $loaiChiNhanh = $loaiToChucs->where('ma', 'CN')->first();
        $loaiTinh = $loaiToChucs->where('ma', 'TINH')->first();
        $chi_nhanhs = collect([]);
        $tinhs = collect([]);
        if(!empty($loaiChiNhanh)) {
            $chi_nhanhs = $tochus->where('loai_to_chuc_id', $loaiChiNhanh->id);
        }
        if(!empty($loaiTinh)) {
            $tinhs = $tochus->where('loai_to_chuc_id', $loaiTinh->id);
        }

        $configToChucs = $this->getDataByName('ConfigToChuc');
        $ten_hien_thi_mien = $configToChucs->where('id_loai_to_chuc', $loaiMien->id)->first();
        $ten_hien_thi_chi_nhanh = $configToChucs->where('id_loai_to_chuc', $loaiChiNhanh->id)->first();
        $ten_hien_thi_tinh = $configToChucs->where('id_loai_to_chuc', $loaiTinh->id)->first();

        if($request->headers->get('accept')!='xlsx')
        {            
            $query->orderBy('updated_at','desc');
            $hopdong = $query->paginate($perPage, ['*'], 'page', $page);
            return view('report.hopdonghethan',[
                'menus' => $this->getMenusForUser($user),
                'data'=>$hopdong,
                'chi_nhanhs'=>$chi_nhanhs,
                'tinhs'=>$tinhs,
                'search'=>$search,
                'search_chi_nhanh'=>$search_chi_nhanh,
                'search_tinh'=>$search_tinh,
                'perPage' => $perPage,
                'loaihopdongs'=>$this->getDataByName('LoaiHopDong'),
                'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
                'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
                'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
                ]);
        }
        else{
            
            $query->orderBy('updated_at','desc');
            
            $data=$query->get();
            $excelFile = public_path() . '/report/tem_hop_dong_het_han.xlsx';

            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$data, &$input) {
                $key=0;
             foreach($data as $hopdong ) {
                $rowKey = $key;
                $sheet->row($rowKey + 9, [
                $rowKey + 1,
                empty($hopdong->nhansu->ho_ten)?null:$hopdong->nhansu->ho_ten,
                empty($hopdong->loaiHopDong)?null:$hopdong->loaiHopDong->ten,
                $hopdong->so_quyet_dinh,
                $hopdong->ngay_quyet_dinh,
                $hopdong->ngay_hieu_luc,
                $hopdong->ngay_het_hieu_luc,
                ($hopdong->trang_thai)? 'Hiệu lực':'Hết hiệu lực',
                ]);
                $key++;
             }
             $rowKey=$key;
            
             })->download('xlsx');
         }
        
    }

    function reportnhansuTGS(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $query = NhanSu::query()
            ->with(['tinh','chucVu','boPhan','cuaHang','loaiHopDong','chiTietBaoHiemHienTai','phongBan','trinhDoVanHoa']);
        $search_time_start = $request->get('search_time_start');
        $search_time_end = $request->get('search_time_end');
        $search_mien = $request->get('search_mien');
        $search_chi_nhanh= $request->get('search_chi_nhanh');
        $search_tinh= $request->get('search_tinh');
        if (isset($search)) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('ho_ten', 'ilike', "%{$search}%");
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('cmnd', 'ilike', "%{$search}%");
                $query->orWhere('ma_so_thue', 'ilike', "%{$search}%");
            });
        }
        if(empty($search_time_start)){
            $search_time_start = Carbon::now()->addMonth(-12);
        }
        else{
            $search_time_start = Carbon::createFromFormat(config('app.format_date'), $search_time_start)->startOfDay();
        }

        if(empty($search_time_end)){
            $search_time_end = Carbon::now();
        }
        else{
            $search_time_end = Carbon::createFromFormat(config('app.format_date'), $search_time_end)->endOfDay();
        }

       $query->where('created_at','>=',$search_time_start);
       $query->where('created_at','<=',$search_time_end);


        if(isset($search_mien)){
            $query->where('id_mien',$search_mien);
        }
        if(isset($search_chi_nhanh)){
            $query->where('id_chi_nhanh',$search_chi_nhanh);
        }
        if(isset($search_tinh)){
            $query->where('id_tinh',$search_tinh);
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

        $query->orderBy('updated_at','desc');
        if($request->headers->get('accept')!='xlsx')
        {
            $data = $query->paginate($perPage, ['*'], 'page', $page);
            $user = Auth::user();            

            return view('report.reportnhansutgs',[
                'menus' => $this->getMenusForUser($user),
                'data' => $data,
                'perPage' => $perPage,
                'miens'=>$miens,
                'chinhanhs'=>$chinhanhs,
                'tinhs'=>$tinhs,
                'search_time_start' => $search_time_start,
                'search_time_end' => $search_time_end,
                'search_mien' => $search_mien,
                'search_tinh' => $search_tinh,
                'search_chi_nhanh' => $search_chi_nhanh,
                'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
                'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
                'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            ]);
        }
        else{
            if(isset($search_mien)){
                $mien = ToChuc::query()->where('id',$search_mien)->first();
            }
            if(isset($search_chi_nhanh)){
                $chi_nhanh = ToChuc::query()->where('id',$search_chi_nhanh)->first();
            }
            if(isset($search_tinh)){
                $tinh = ToChuc::query()->where('id',$search_tinh)->first();
            }
            $excelFile = public_path() . '/report/bao_cao_nhan_su_TGS.xlsx';
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$query, &$search_time_start,&$search_time_end,&$mien,&$tinh,&$chi_nhanh) {
                $sheet->setCellValue('D2',Carbon::parse($search_time_start)->format(config('app.format_date')));
                $sheet->setCellValue('E2',Carbon::parse($search_time_end)->format(config('app.format_date')));
                $sheet->setCellValue('D3',empty($mien)?null:$mien->ten);
                $sheet->setCellValue('D4',empty($chi_nhanh)?null:$chi_nhanh->ten);
                $sheet->setCellValue('D5',empty($tinh)?null:$tinh->ten);
                $key=0;
                foreach($query->get() as $nhansu ) {
                    $baoHiemCurrent = ChiTietBaoHiem::query()->where('id_nhan_su',$nhansu->id)->orderBy('thang_bat_dau','desc')->first();
                    $songuoiphuthuoc = ChiTietGiamTruGiaCanh::query()->where('id_nhan_su',$nhansu->id)
                        ->where(function ($query){$query->orWhere('thoi_diem_ket_thuc','>=', Carbon::now());
                        $query->orWhere('thoi_diem_ket_thuc',null);})->count();
                    $rowKey = $key;
                    $sheet->row($rowKey + 8, [
                        $rowKey + 1,
                        $nhansu->tinh->ten,
                        $nhansu->ma,
                        $nhansu->ho_ten,
                        $nhansu->chucVu->ten,
                        $nhansu->boPhan->ten,
                        $nhansu->cuaHang->ten,
                        $nhansu->loaiHopDong->ten,
                        $nhansu->ngay_hoc_viec,
                        $nhansu->ngay_thu_viec,
                        $nhansu->ngay_chinh_thuc,
                        $nhansu->ngay_nghi_viec,
                        '',
                        '',
                        '',
                        '',
                        $nhansu->tai_khoan_ngan_hang,
                        $nhansu->chi_nhanh_ngan_hang,
                        $nhansu->ngay_sinh,
                        $nhansu->cmnd,
                        $nhansu->ngay_cap,
                        $nhansu->noi_cap,
                        $nhansu->ho_khau_thuong_tru,
                        $nhansu->cho_o_hien_tai,
                        $nhansu->so_so_bao_hiem,
                        empty($baoHiemCurrent)?'':$baoHiemCurrent->thang_bat_dau,
                        empty($baoHiemCurrent)?'':$baoHiemCurrent->thang_chuyen_bao_hiem_ve_chi_nhanh,
                        empty($baoHiemCurrent)?'':$baoHiemCurrent->thang_dung_dong_bao_hiem,
                        $nhansu->ma_so_thue,
                        $songuoiphuthuoc,
                        $nhansu->so_dien_thoai,
                        $nhansu->email,
                        isset($nhansu->trinhDoVanHoa->ten)?$nhansu->trinhDoVanHoa->ten:'',
                        isset($nhansu->trinhDoChuyenMon->ten)?$nhansu->trinhDoChuyenMon->ten:'',
                    ]);
                    $key++;
                }
                $rowKey=$key;

            })->download('xlsx');
        }
    }
    
    public function ThueTNCN(Request $request){
        $search_time_start=$request->input('search_time_start');
        if(empty($search_time_start)){
            $search_time_start=Carbon::now()->addYear(-1)->startOfYear();
            $search_time_end=Carbon::now()->addYear(-1)->endOfYear();
        }
        else{
            $search_time_start=Carbon::createFromFormat(config('app.format_month'),$request->input('search_time_start'))->startOfMonth();
            $search_time_end=Carbon::createFromFormat(config('app.format_month'),$request->input('search_time_end'))->endOfMonth();
          
           
        }
        if($search_time_end>Carbon::now()){
            $search_time_end=Carbon::now();
        }
       
        $input = $request->all();

        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_mien = $request->get('search_mien');
        $search_chi_nhanh = $request->get('search_chi_nhanh');
        $search_tinh = $request->get('search_tinh');

        $query=NhanSu::query();
        if(isset($search_mien)){                   
            $query->where('id_mien',$search_mien);                      
        }
        if(isset($search_chi_nhanh)){                   
            $query->where('id_chi_nhanh',$search_chi_nhanh);   
        }
        if(isset($search_tinh)){                  
            $query->where('id_tinh',$search_tinh);                   
        }

        $data=$query->orderBy('ho_ten')->get();
        $hopdongCollects=TheoDoiHopDong::query()->get();
        foreach($data as $nhansu){
            $nhansu['so_thang_lam_viec']=0;

            if(empty($hopdong)){
                $nhansu['loai_hop_dong']='';
            }
            elseif(empty($hopdong->ngay_het_hieu_luc)){
                $nhansu['loai_hop_dong']='KXĐ';
            }
            else{
                $nhansu['loai_hop_dong']='Có XĐ';
            }
                $hopdongs = $hopdongCollects->filter(function ($hopdongCollect) use ($nhansu, $search_time_end, $search_time_start) {
                    return
                        (
                            ($hopdongCollect->ngay_het_hieu_luc = null && $hopdongCollect->id_nhan_su = $nhansu->id && $hopdongCollect->ngay_hieu_luc > $search_time_end)
                            ||
                            ($hopdongCollect->ngay_het_hieu_luc > $search_time_start && $hopdongCollect->id_nhan_su = $nhansu->id && $hopdongCollect->ngay_hieu_luc > $search_time_end)
                        );
                });

            foreach($hopdongs as $hopdong ){
                if($search_time_start<Carbon::now()){
                    $ngay_hieu_luc=Carbon::createFromFormat(config('app.format_date'),$hopdong->ngay_hieu_luc);
                
                    if($ngay_hieu_luc<$search_time_start){
                        $ngay_hieu_luc=$search_time_start;
                    }
                    if(!empty($hopdong->ngay_het_hieu_luc)&&Carbon::createFromFormat(config('app.format_date'),$hopdong->ngay_het_hieu_luc)<$search_time_end){
                        $ngay_het_hieu_luc=Carbon::createFromFormat(config('app.format_date'),$hopdong->ngay_het_hieu_luc);
                    }
                    else{
                        $ngay_het_hieu_luc=$search_time_end;
                    }
                    $nhansu['so_thang_lam_viec']+=$ngay_het_hieu_luc->month - $ngay_hieu_luc->month +1;             
                    }              
                }
                
        }   
        $thamsohethong= ThamSoHeThong::query()->first();
        $giam_tru_ban_than=0;
        if(!empty($thamsohethong)&&!empty($thamsohethong->giam_tru_ban_than)){
            $giam_tru_ban_than=$thamsohethong->giam_tru_ban_than/1000000;
        }
        if($request->headers->get('accept')!='xlsx')
        {
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
        return view('report.thuethunhapcanhan',[
            'menus' => $menus,
            'data'=>$this->paginate($data,$perPage,$page),
            'search_time_start'=>$search_time_start, 
            'search_time_end'=>$search_time_end, 
            'giam_tru_ban_than'=>$giam_tru_ban_than,
            'search_mien'=>$search_mien,
            'search'=>$search,
            'search_chi_nhanh'=>$search_chi_nhanh,
            'search_tinh'=>$search_tinh,
            'perPage'=>$perPage,
            'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
            'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
            'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
            'miens'=>$miens,
            'chinhanhs'=>$chinhanhs,
            'tinhs'=>$tinhs,
            ]);

        }
        else{
            $excelFile = public_path() . '/report/tem_bang_doi_chieu_phuc_vu_quyet_toan_thue_TNCN.xlsx';
            $this->load($excelFile, 'Sheet1', function ($sheet) use (&$data,&$giam_tru_ban_than) {
                $count=0;
                
                foreach($data as  $nhansu) {   
                    if(count($nhansu->chiTietGiamTruGiaCanhs)!=0){
                        $sheet->mergeCells('A'.($count + 9).':A'.($count + 9+count($nhansu->chiTietGiamTruGiaCanhs)-1));
                        $sheet->mergeCells('B'.($count + 9).':B'.($count + 9+count($nhansu->chiTietGiamTruGiaCanhs)-1));
                        $sheet->mergeCells('C'.($count + 9).':C'.($count + 9+count($nhansu->chiTietGiamTruGiaCanhs)-1));
                        $sheet->mergeCells('D'.($count + 9).':D'.($count + 9+count($nhansu->chiTietGiamTruGiaCanhs)-1));
                        $sheet->mergeCells('E'.($count + 9).':E'.($count + 9+count($nhansu->chiTietGiamTruGiaCanhs)-1));
                        $sheet->mergeCells('F'.($count + 9).':F'.($count + 9+count($nhansu->chiTietGiamTruGiaCanhs)-1));
                        $sheet->mergeCells('G'.($count + 9).':G'.($count + 9+count($nhansu->chiTietGiamTruGiaCanhs)-1));
                        foreach( $nhansu->chiTietGiamTruGiaCanhs  as $key => $giamtrugiacanh){
                            $rowKey = $count;
                            $sheet->row($rowKey + 9, [
                                $rowKey + 1,
                                $nhansu->ho_ten,
                                $nhansu->ma_so_thue,
                                $nhansu['loai_hop_dong'],
                                $nhansu['so_thang_lam_viec'],
                                ($nhansu['so_thang_lam_viec']==0)?'0':$giam_tru_ban_than,
                                count($nhansu->chiTietGiamTruGiaCanhs),
                                $giamtrugiacanh->ho_ten,
                                $giamtrugiacanh->ma_so_thue,
                                empty($giamtrugiacanh->ngay_sinh)? '':Carbon::parse($giamtrugiacanh->ngay_sinh)->format(config('app.format_date')) ,
                                $giamtrugiacanh->quan_he,
                                empty($giamtrugiacanh->thoi_diem_bat_dau)? '':Carbon::parse($giamtrugiacanh->thoi_diem_bat_dau)->format(config('app.format_date')) ,
                                ]);
                                $count++;
                        }
                    }
                    else{
                       
                        $rowKey = $count;
                        $sheet->row($rowKey + 9, [
                            $rowKey + 1,
                            $nhansu->ho_ten,
                            $nhansu->ma_so_thue,
                           $nhansu['loai_hop_dong'],
                            $nhansu['so_thang_lam_viec'],
                            ($nhansu['so_thang_lam_viec']==0)?'0':$giam_tru_ban_than,
                            count($nhansu->chiTietGiamTruGiaCanhs),
                            '',
                            '',
                            '',
                            '',
                            '',
                            ]);
                            $count++;
                        }
                        
                    
                }
             })->download('xlsx');
         }
    } 
    
    public function paginate($items, $perPage, $page, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
            ]);
    }
}
