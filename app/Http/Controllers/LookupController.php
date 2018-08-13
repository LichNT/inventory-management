<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Menu;
use App\User;
use Validator;
use App\Role;
use App\Lookup;
use App\Traits\GetDataCache;

class LookupController extends Controller
{
    use GetDataCache;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function indexLookup(Request $request)
    {   
        $user = Auth::user();               
        $query = Lookup::query();
        $query->with('type_lookup');
        $perPage = $request->get('perpage', 10);
        $page = $request->get('page', 1);
        $search = $request->get('search');
        $search_loai = $request->get('search_loai');
        $search_trang_thai = $request->get('search_trang_thai');

        if(isset($search_loai)){
        $query->where(function ($query) use ($search_loai) {
            $query->orWhere('loai', $search_loai);
        });
        }

        if(isset($search_trang_thai)){
            $query->whereIn('active',$search_trang_thai);
        }

        if(isset($search)) {           
            $query->where(function($query) use($search){
                $query->orWhere('ma', 'ilike', "%{$search}%");
                $query->orWhere('ten', 'ilike', "%{$search}%");
            });            
        }                        
        $query->orderBy('loai');

        $data = $query->paginate($perPage, ['*'], 'page', $page);
        $lookups = $this->getDataByName('Lookup')->where('active', true);
        return view('lookup.shared.index',[
            'menus' => $this->getMenusForUser($user),
            'data'=> $data,
            'search'=> $search,            
            'loaiLookups' => $lookups->where('loai','root'),            
            'search_trang_thai'=>$search_trang_thai,
            'search_loai'=>$search_loai,
            'perPage'=>$perPage
        ]);
    }
 
    public function updateLookup(Request $request,$id)
    {             
        $info = $request->all();
        $user = Auth::user();
        if(!empty($user->company_id)){
            $info['company_id']=$user->company_id;
        }
        $validator = Validator::make($info, [
            'ma' => 'required|max:255|unique_with:lookup,loai,company_id,'.$id,
            'ten' => 'required|max:255',
            'loai' => 'required|max:255',
            'active' => 'required|boolean',
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại'
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }     

        if(empty($info['active'])) {
            $info['active'] = false; 
        }

        Lookup::findOrFail($id)->update($info);

        return back()->withInput()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.update_success'));
    }

    public function deleteLookup($id) {
        Auth::user();
        Lookup::findOrFail($id)->delete();

        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.delete_success'));
    }

    public function addLookup(Request $request){
        $info = $request->all();
        $user = Auth::user();
        $info['company_id']=$user->company_id;
        $validator = Validator::make($info, [
            'ma' => 'required|max:255|unique_with:lookup,loai,company_id',
            'ten' => 'required|max:255',
            'loai' => 'required|max:255',
            'active' => 'required|boolean',
        ],
            [
                'ma.unique_with' => 'Trường mã đã tồn tại',
            ]);

        if ($validator->fails()) {
            return back()->withInput()
                ->withErrors($validator)
                ->with('alert-type', 'alert-warning')
                ->with('alert-content', __('system.validator'));
        }              

        Lookup::create($info);
        
        return back()
            ->with('alert-type', 'alert-success')
            ->with('alert-content', __('system.create_success'));       
    }
}
