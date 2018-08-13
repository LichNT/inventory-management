<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Role;
use App\Menu;
use App\Company;
use App\RoleMenu;
use App\ThamSoHeThong;
use App\BangMaChamCong;
use DB;
use Illuminate\Validation\Rule;
use App\Traits\ExecuteString;
use App\Traits\GetDataCache;

class SystemController extends Controller
{
    use ExecuteString, GetDataCache;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['indexCompany']]);
    }

    public function clear(){
        $this->flush();
        return redirect(route('system.thamsohethong'))
            ->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content','Xóa cache thành công');
    }

    /**
     * Get listing menu
     * 
     * thangnv create
     */
    public function indexMenu(Request $request){
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        
        $query = Menu::query();

        if(isset($search)) {
            $query->where(function($query) use($search){                
                $query->orWhere('name', 'ilike', "%{$search}%");
                $query->orWhere('router_link', 'ilike', "%{$search}%");
                $query->orWhere('fa_icon', 'ilike', "%{$search}%");                
            });  
        }

        $query->with('parent');

        $query->orderBy('parent_id', 'desc');

        $data = $query->paginate($perPage, ['*'], 'page', $page);        
        
        return view('system.menus.index', [
            'menus' => $this->getMenusForUser($user), 
            'data' => $data, 
            'search'=> $search,
            'perPage' => $perPage,
            'menu_parents' => $this->getDataByName('Menu'),
        ]);
    }
 

    public function addMenu(Request $request){
        $info = $request->all();
        $user = Auth::user();
        $validator = Validator::make($info, [
            'name' => 'required|max:255',
            'router_link' => 'required|max:255',
            'fa_icon' => 'required',
            'order' => 'required|numeric|min:1'                        
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.create_menu_error'));
        }            
        
        $menu = Menu::query()
            ->create($info);
        
        return back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_menu_success'));
    
    }

    public function updateMenu(Request $request, $id){
       
        $menu = Menu::query()->findOrFail($id);
        $user = Auth::user();
        $info = $request->only([ 'parent_id','name','router_link', 'fa_icon','order', 'active']);
        $validator = Validator::make($info, [
            'name' => 'required|max:255',
            'router_link' => 'required|max:255',
            'fa_icon' => 'required',
            'order' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.update_menu_error'));
        }

        if(empty($info['active'])) {
            $info['active'] = false; 
        }

        $menu->update($info);

        return back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.update_success'));
    }

    public function deleteMenu(Request $request, $id){
        $user = Auth::user();
        try{
            DB::beginTransaction();

            RoleMenu::query()
                ->where('menu_id', $id)
                ->delete();
        
            Menu::destroy($id);

            DB::commit();
    
            return back()->withInput()
                ->with('alert-type', 'alert-success')
                ->with('alert-content',__('system.delete_menu_success'));
        }

        catch(Exception $exception){
            DB::rollBack();

            return back()                
                ->withInput()
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.delete_menu_error'));
        }  
    }        
    
    public function indexRole(Request $request) {
        $user = Auth::user();
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        
        $query = Role::query();

        if(isset($search)) {
            $query->where(function($query) use($search){
                $query->orWhere('name', 'ilike', "%{$search}%");
                $query->orWhere('code', 'ilike', "%{$search}%");
                $query->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        $data = $query->paginate($perPage, ['*'], 'page', $page);        
        
        return view('system.roles.index', [
            'menus' => $this->getMenusForUser($user), 
            'data' => $data, 
            'search'=> $search,
            'perPage' => $perPage,
        ]);
    }

    public function addRole(Request $request)
    {
        $info = $request->all();
        $user = Auth::user();
        $validator = Validator::make($info, [
            'code' => 'required|unique:roles,code|max:255',
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }

        Role::query()
            ->create($info);
        
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_role_success'));
    }


    public function updateRole(Request $request, $id)
    {
        $user = Auth::user();
        $role = Role::query()->findOrFail($id);
        $info = $request->only(['code', 'name', 'description']);
        $validator = Validator::make($info, [
            'code' => [
                Rule::unique('roles')->ignore($role->id),
                'max:255'
            ],
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.update_role_error'));
        }

        $role->update($info);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteRole($id)
    {
        $user = Auth::user();
        Role::destroy($id);
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function indexFunctions(Request $request) {
        $user = Auth::user();
        $search_chuc_nang = $request->get('search_chuc_nang');
        $search_danh_muc = $request->get('search_danh_muc');

        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        
        $query = RoleMenu::query()->orderBy('role_id', 'desc');

        if(isset($search_chuc_nang) && is_array($search_chuc_nang)){
            $query->whereIn('role_id', $search_chuc_nang);
        }

        if(isset($search_danh_muc) && is_array($search_danh_muc)){
            $query->whereIn('menu_id', $search_danh_muc);
        }

        $query->with(['role', 'menu']);

        $data = $query->paginate($perPage, ['*'], 'page', $page);        
        
        return view('system.functions.index', [
            'menus' => $this->getMenusForUser($user), 
            'data' => $data,
            'perPage' => $perPage,
            'name_role' => $this->getDataByName('Role'),
            'name_menu' => $this->getDataByName('Menu'),
            'search_chuc_nang' => $search_chuc_nang,
            'search_danh_muc' => $search_danh_muc
        ]);
    }

    public function deleteFunctions($id)
    {
        $user = Auth::user();
        RoleMenu::destroy($id);        
        $this->forget('menu', $user->role_id);
        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function addFunctions(Request $request)
    {
        $info = $request->all();
        $validator = Validator::make($info, [
            'role_id' => 'required|exists:roles,id|unique_with:role_menus,menu_id',
            'menu_id' => 'required|exists:menus,id'
        ],
            [
                'role_id.unique_with' => 'Danh mục đã tồn tại.'
            ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $rolemenu = RoleMenu::query()
            ->create($info);
        $user = Auth::user();
        $this->forget('menu', $user->role_id);

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }

    /**
     * Get listing menu
     * 
     * thangnv create
     */
    public function indexCompany(Request $request){
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        
        $query = Company::query()->with(['parent','childs']);

        if(isset($search)) {
            $query->where(function($query) use($search){                
                $query->orWhere('name', 'ilike', "%{$search}%");
                $query->orWhere('code', 'ilike', "%{$search}%");                           
            });  
        }
        $query->orderBy('parent_id', 'desc');
        $query->orderBy('code');
        $query->orderBy('name');

        if($request->headers->get('accept') =='application/json') {
            return response()->json([
                'code'    => 200,
                'message' => 'Success',
                'result'  => $query->get()
            ], 200, []);
        }
        else{
            $user = Auth::user();                
            $data = $query->paginate($perPage, ['*'], 'page', $page);        
            
            return view('system.company.index', [
                'menus' => $this->getMenusForUser($user), 
                'data' => $data, 
                'search'=> $search,
                'perPage' => $perPage,
                'companies' => $this->getDataByName('Company')->where('active', true),
            ]);
        }        
    }

     /**
     * Thêm mới công ty
     */
    public function addCompany(Request $request)
    {        
        $info = $request->all();
        $user = Auth::user();
        $validator = Validator::make($info, [
            'code' => 'required|unique:companies|max:100',
            'name' => 'required|max:500',
            'active' => 'boolean',
            'parent_id' => 'nullable|exists:companies,id',                      
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        } 

        $info['code'] = $this->code($info['code']);
        $info['name'] = $this->cappitalizeEachWord($info['name']);
        
        Company::query()->create($info);
        $this->forgetByName('Company');
        
        return back()
                ->with('alert-type', 'alert-success')
                ->with('alert-content', __('system.create_success'));
    }

    function updateCompany(Request $request, $id){
        $info = $request->all();
        $user = Auth::user();
        $validator = Validator::make($info, [
            'code' => 'max:100|unique:companies,code,' . $id,
            'name' => 'max:500',
            'active' => 'boolean',
            'parent_id' => 'nullable|exists:companies,id', 
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $company = Company::findOrFail($id);
        if(!empty($info['code'])) {
            $info['code'] = $this->code($info['code']);
        }
        if(!empty($info['name'])) {
            $info['name'] = $this->cappitalizeEachWord($info['name']);
        }
        $company->update($info); 
        $this->forgetByName('Company');       

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function indexThamSoHeThong(Request $request){
        $user = Auth::user();

        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $bangMaChamCongs = BangMaChamCong::query()->select('inactive')->get();        
        $thamsohethong = ThamSoHeThong::query()->first();        

        return view('system.thamsohethong.index', [
            'menus' => $this->getMenusForUser($user),
            'thamsohethong' => $thamsohethong, 
            'search'=> $search,
            'bangmachamcongs' => $bangMaChamCongs,                                  
        ]);
    }

    function updateThamSoHeThong(Request $request) {
        $user = Auth::user();
        $info = $request->all();

        $validator = Validator::make($info, [
            'BHXH_DN' => 'numeric|min:0|max:100',
            'BHXH_NLD' => 'numeric|min:0|max:100',
            'BHYT_DN' => 'numeric|min:0|max:100',
            'BHYT_NLD' => 'numeric|min:0|max:100',
            'BHTN_DN' => 'numeric|min:0|max:100',
            'BHTN_NLD' => 'numeric|min:0|max:100',
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
        $thamsohethong = ThamSoHeThong::query()->first();
        if(empty($thamsohethong)){
            $info['company_id']=$user->company_id;
            ThamSoHeThong::create($info);
        }
        else{
            $thamsohethong->update($info);  
        }
            
        return back()
            ->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    /**
     * Tạo mặc định mã chấm công với độ dài 4 ký tự
     * x.x.x.x bắt đầu từ 0001 -> 9999
     */
    function taoMaTheChamCong(Request $request){
        $info = $request->all();
        $user = Auth::user();
        $validator = Validator::make($info, [            
            'quantity' => 'numeric|min:0|max:1000',            
        ]);
        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }
       
        if(empty($info['quantity'])) {
            $info['quantity'] = 100;
        }

        $maChamCongGanNhat = BangMaChamCong::query()->max('index');
        if($maChamCongGanNhat + $info['quantity'] > 9999) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', 'Vượt quá số lượng mã. Hệ thống cung cấp tối đa 9999 mã chấm công.');
        }
        $data = [];
        for($i = 1; $i <= $info['quantity']; $i++) {
            $index = $maChamCongGanNhat + $i;
            $data[]  = [
                'ma' =>  str_pad((string)$index, 4 , "0", STR_PAD_LEFT),
                'inactive' => false, 
                'company_id' => $user->company_id,
                'index' => $index 
            ];            
        }

        DB::table('bang_ma_cham_congs')->insert($data);

        return back()            
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));
    }
}
