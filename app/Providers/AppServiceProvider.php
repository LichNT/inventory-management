<?php

namespace App\Providers;

use App\Bac;
use App\ChucVu;
use App\Company;
use App\CuaHang;
use App\DangKyUngDungChamCong;
use App\DanToc;
use App\HeDaoTao;
use App\HopDongChucVu;
use App\LoaiChamCong;
use App\LoaiHopDong;
use App\LoaiLamThemGio;
use App\LoaiNghiDacBiet;
use App\LoaiPhat;
use App\LoaiPhongBan;
use App\LoaiPhuCap;
use App\LoaiToChuc;
use App\Lookup;
use App\Menu;
use App\MucDongBaoHiem;
use App\NhanSu;
use App\Observers\BacObserver;
use App\Observers\ChucVuObserver;
use App\Observers\CompanyObserver;
use App\Observers\CuaHangObserver;
use App\Observers\DanTocObserver;
use App\Observers\HeDaoTaoObserver;
use App\Observers\HopDongChucVuObserver;
use App\Observers\LoaiChamCongObserver;
use App\Observers\LoaiHopDongObserver;
use App\Observers\LoaiLamThemGioObserver;
use App\Observers\LoaiNghiDacBietObserver;
use App\Observers\LoaiPhatObserver;
use App\Observers\LoaiPhongBanObserver;
use App\Observers\LoaiPhuCapObserver;
use App\Observers\LoaiToChucObserver;
use App\Observers\LookupObserver;
use App\Observers\MenuObserver;
use App\Observers\MucDongBaoHiemObserver;
use App\Observers\PhanLoaiNhanVienObserver;
use App\Observers\PhongBanObserver;
use App\Observers\QuanHuyenObserver;
use App\Observers\QuocTichObserver;
use App\Observers\RoleMenuObserver;
use App\Observers\RoleObserver;
use App\Observers\ToChucObserver;
use App\Observers\TonGiaoObserver;
use App\Observers\TrinhDoChuyenMonObserver;
use App\Observers\TrinhDoNgoaiNguObserver;
use App\Observers\TrinhDoVanHoaObserver;
use App\Observers\TinhThanhObserver;
use App\PhanLoaiNhanVien;
use App\PhongBan;
use App\QuanHuyen;
use App\QuocTich;
use App\Role;
use App\RoleMenu;
use App\TinhThanh;
use App\ToChuc;
use App\TonGiao;
use App\TrinhDoChuyenMon;
use App\TrinhDoNgoaiNgu;
use App\TrinhDoVanHoa;
use Illuminate\Support\ServiceProvider;
use App\Observers\DangKyUngDungChamCongObservers;
use App\Observers\NhanSuObserver;
use Illuminate\Support\Facades\View;
use App\Traits\GetDataCache;

class AppServiceProvider extends ServiceProvider
{
    use GetDataCache;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DangKyUngDungChamCong::observe(DangKyUngDungChamCongObservers::class);
        NhanSu::observe(NhanSuObserver::class);        
        TrinhDoVanHoa::observe(TrinhDoVanHoaObserver::class);
        TrinhDoChuyenMon::observe(TrinhDoChuyenMonObserver::class);
        TrinhDoNgoaiNgu::observe(TrinhDoNgoaiNguObserver::class);
        TonGiao::observe(TonGiaoObserver::class);
        ToChuc::observe(ToChucObserver::class);
        TinhThanh::observe(TinhThanhObserver::class);
        QuocTich::observe(QuocTichObserver::class);
        QuanHuyen::observe(QuanHuyenObserver::class);
        Role::observe(RoleObserver::class);
        PhongBan::observe(PhongBanObserver::class);
        PhanLoaiNhanVien::observe(PhanLoaiNhanVienObserver::class);
        MucDongBaoHiem::observe(MucDongBaoHiemObserver::class);
        Menu::observe(MenuObserver::class);
        RoleMenu::observe(RoleMenuObserver::class);
        Lookup::observe(LookupObserver::class);
        LoaiToChuc::observe(LoaiToChucObserver::class);
        LoaiPhuCap::observe(LoaiPhuCapObserver::class);
        LoaiPhongBan::observe(LoaiPhongBanObserver::class);
        LoaiPhat::observe(LoaiPhatObserver::class);
        LoaiNghiDacBiet::observe(LoaiNghiDacBietObserver::class);
        LoaiLamThemGio::observe(LoaiLamThemGioObserver::class);
        LoaiHopDong::observe(LoaiHopDongObserver::class);
        LoaiChamCong::observe(LoaiChamCongObserver::class);
        HopDongChucVu::observe(HopDongChucVuObserver::class);
        HeDaoTao::observe(HeDaoTaoObserver::class);
        DanToc::observe(DanTocObserver::class);
        CuaHang::observe(CuaHangObserver::class);
        Company::observe(CompanyObserver::class);
        ChucVu::observe(ChucVuObserver::class);
        Bac::observe(BacObserver::class);
        View::share('roles', $this->getDataByName('Role'));
        View::share('companies', $this->getDataByName('Company'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
