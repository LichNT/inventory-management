<?php

namespace App\Http\Controllers;

use App\ToChuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Menu;
use App\User;
use App\Role;
use App\Company;
use App\ConfigToChuc;
use App\Traits\GetDataCache;

class UserController extends Controller
{
    use GetDataCache;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);        
    }

    public function index(Request $request){        
        $user = Auth::user();                                
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_quyen = $request->get('search_quyen');
        $search_trang_thai = $request->get('search_trang_thai');

        $query = User::query()->with([
            'role',
            'company',           
            'mien'
        ]);
        $roles = $this->getDataByName('Role');
        $roleSysAdmin = $roles->firstWhere('code','sysadmin');

        if(isset($roleSysAdmin) && $user->role_id != $roleSysAdmin->id) {
            $query->where('company_id', $user->company_id);
        }

        if(isset($search)) {
            $query->where(function($query) use($search){
                $query->orWhere('name', 'ilike', "%{$search}%");
                $query->orWhere('username', 'ilike', "%{$search}%");
                $query->orWhere('email', 'ilike', "%{$search}%");
            });
        }
        if(isset($search_quyen)){
            $query->whereIn('role_id',$search_quyen);
        }

        if(isset($search_trang_thai)){
            $query->whereIn('active',$search_trang_thai);
        }

        $tochus = $this->getDataByName('ToChuc');
        $loaiToChucs = $this->getDataByName('LoaiToChuc');
        $loaiMien = $loaiToChucs->where('ma', 'MIEN')->first();
        $loaiChiNhanh = $loaiToChucs->where('ma', 'CN')->first();
        $loaiTinh = $loaiToChucs->where('ma', 'TINH')->first();
        $miens = collect([]);
        $chinhanhs = collect([]);
        if(!empty($loaiMien)) {
            $miens = $tochus->where('loai_to_chuc_id', $loaiMien->id);
        }
        if(!empty($loaiChiNhanh)) {
            $chinhanhs = $tochus->where('loai_to_chuc_id', $loaiChiNhanh->id);
        }

        $configToChucs = $this->getDataByName('ConfigToChuc');
        $ten_hien_thi_mien = $configToChucs->where('id_loai_to_chuc', $loaiMien->id)->first();
        $ten_hien_thi_chi_nhanh = $configToChucs->where('id_loai_to_chuc', $loaiChiNhanh->id)->first();
        $ten_hien_thi_tinh = $configToChucs->where('id_loai_to_chuc', $loaiTinh->id)->first();

        $query->orderBy('updated_at','desc');
        $users = $query->paginate($perPage, ['*'], 'page', $page);        
        
        return view('system.user.index', [
            'menus' => $this->getMenusForUser($user), 
            'data' => $users,
            'miens'=>$miens,
            'chinhanhs'=>$chinhanhs,
            'search'=> $search,
            'search_trang_thai'=> $search_trang_thai,
            'search_quyen'=> $search_quyen,
            'roles' => $roles->where('code','<>','sysadmin'),
            'companies' => $this->getDataByName('Company')->where('active', true),
            'ten_hien_thi_mien'=>empty($ten_hien_thi_mien)?'Miền':$ten_hien_thi_mien->ten_hien_thi,
            'ten_hien_thi_chi_nhanh'=>empty($ten_hien_thi_chi_nhanh)?'Chi nhánh':$ten_hien_thi_chi_nhanh->ten_hien_thi,
            'ten_hien_thi_tinh'=>empty($ten_hien_thi_tinh)?'Tỉnh':$ten_hien_thi_tinh->ten_hien_thi,
        ]);
    }

    public function show($id){        
        return view('system.user-detail', 
            ['user' => User::findOrFail($id)]
        );
    }

    public function update(Request $request, $id){        
        $user = User::query()->findOrFail($id);
        
        $info = $request->only(['name','username', 'email', 'role_id', 'password', 'active','id_chi_nhanh','id_mien','company_id']);
        if(isset($info['username'])) {
            $info['username'] = strtoupper($info['username']);
        }
        $validator = Validator::make($info, [           
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username,'.$id,
            'email' => 'required|email|max:255',
            'role_id' => 'required|exists:roles,id',
            'active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('user.update_user_error'));
        }

        if(!empty($info['password'])) {
            $info['password'] = Hash::make($request->password);
        }
        else{
            unset($info['password']);
        }        
        
        if(empty($info['active'])) {
            $info['active'] = false;
        }

        $user->update($info);

        return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
    }

    public function delete($id) {                
        $user = Auth::user();

        if($user->id == $id){   
            return back()->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('user.delete_user_error_yourself'));
        }
        else{
            User::find($id)->update(['active' => false]);

            return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('user.delete_user_success'));
        }                        
    }

    /**
     * Thêm mới người dùng
     */
    public function add(Request $request) {
        $user = Auth::user();
        $info = $request->all();
        if(isset($info['username'])) {
            $info['username'] = strtoupper($info['username']);
        }
        
        $validator = Validator::make($info, [
            'username' => 'required|unique:users|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|max:255|min:6|confirmed', 
            'active' => 'boolean'           
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('user.create_user_error'));
        }            
        
        if(isset($info['password'])) {
            $info['password'] = Hash::make($info['password']);
        }

        if(empty($info['active'])) {
            $info['active'] = true;
        }
       
        if($user->role->code != 'sysadmin') {
            $info['company_id']=$user->company_id;
        }
         User::query()
            ->create($info);
        
        return back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('user.create_user_success'));
    }
}
