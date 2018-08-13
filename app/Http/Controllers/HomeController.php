<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Menu;
use App\RoleMenu;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = Auth::user();     
        
        $menuHome = RoleMenu::query()
            ->where('home_router', true)
            ->where('role_id', $user->role_id)            
            ->firstOrFail();            
        
        if(isset($menuHome->menu->router_link)) {
            return redirect()->route($menuHome->menu->router_link); 
        }
                
        return redirect('auth.login');
    }
}
