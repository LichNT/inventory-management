<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\Menu;
use App\RoleMenu;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement('TRUNCATE role_menus, roles, menus RESTART IDENTITY CASCADE;');                

        $sysadmin = Role::create(array(                
            'name' => 'syssysadmin',
            'description'    => 'Quản trị hệ thống',
            'code' => 'admin'           
        ));   
        
        User::create(array(
            'name'     => 'System admin',
            'username' => 'sysadmin',
            'email'    => 'sysadmin@hp.com',
            'password' => Hash::make('12345678'),            
            'role_id' => $sysadmin->id,
            'active' => true          
        ));

        $menuDanhMuc = Menu::create(array(
            'name' => 'Danh mục',
            'parent_id' => null,
            'router_link' => null,
            'fa_icon' => 'fa-book',
            'active' => true,
            'order' => 1
        ));

        RoleMenu::create(array(
            'role_id' => $sysadmin->id,
            'menu_id' => $menuDanhMuc->id,
            'home_router' => false
        ));

        $menuDanhMucChung = Menu::create(array(
            'name' => 'Danh mục dùng chung',
            'parent_id' => $menuDanhMuc->id,
            'router_link' => 'lookup',
            'fa_icon' => 'fa-folder-open',
            'active' => true,
            'order' => 1
        ));

        RoleMenu::create(array(
            'role_id' => $sysadmin->id,
            'menu_id' => $menuDanhMucChung->id,
            'home_router' => false
        ));

        $menuHeThong = Menu::create(array(
            'name' => 'Hệ thống',
            'parent_id' => null,
            'router_link' => null,
            'fa_icon' => 'fa-cog',
            'active' => true,
            'order' => 2
        ));

        RoleMenu::create(array(
            'role_id' => $sysadmin->id,
            'menu_id' => $menuHeThong->id,
            'home_router' => false
        ));

        $menuChucNang = Menu::create(array(
            'name' => 'Chức năng',
            'parent_id' => $menuHeThong->id,
            'router_link' => 'system.menus',
            'fa_icon' => 'fa-book',
            'active' => true,
            'order' => 1
        ));

        RoleMenu::create(array(
            'role_id' => $sysadmin->id,
            'menu_id' => $menuChucNang->id,
            'home_router' => false
        ));

        $menuQuyen = Menu::create(array(
            'name' => 'Quyền',
            'parent_id' => $menuHeThong->id,
            'router_link' => 'system.roles',
            'fa_icon' => 'fa-book',
            'active' => true,
            'order' => 2
        ));

        RoleMenu::create(array(
            'role_id' => $sysadmin->id,
            'menu_id' => $menuQuyen->id,
            'home_router' => false
        ));

        $menuBangPhanQuyen = Menu::create(array(
            'name' => 'Bảng phân quyền',
            'parent_id' => $menuHeThong->id,
            'router_link' => 'system.functions',
            'fa_icon' => 'fa-book',
            'active' => true,
            'order' => 3
        ));

        RoleMenu::create(array(
            'role_id' => $sysadmin->id,
            'menu_id' => $menuBangPhanQuyen->id,
            'home_router' => false
        ));

        $menuNguoiDung = Menu::create(array(
            'name' => 'Người dùng',
            'parent_id' => $menuHeThong->id,
            'router_link' => 'users',
            'fa_icon' => 'fa-users',
            'active' => true,
            'order' => 4
        ));  
        
        RoleMenu::create(array(
            'role_id' => $sysadmin->id,
            'menu_id' => $menuNguoiDung->id,
            'home_router' => true
        ));
    }
}