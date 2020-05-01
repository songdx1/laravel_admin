<?php

use Illuminate\Database\Seeder;
use App\Models\Administrator;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Menu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
                // create a user.
                Administrator::truncate();
                Administrator::create([
                    'username' => 'admin',
                    'password' => bcrypt('admin'),
                    'name'     => 'Administrator',
                ]);
        
                // create a role.
                Role::truncate();
                Role::create([
                    'name' => '管理员',
                    'slug' => 'administrator',
                ]);
        
                // add role to user.
                Administrator::first()->roles()->save(Role::first());
        
                //create a permission
                Permission::truncate();
                Permission::insert([
                    [
                        'name'        => '所有权限',
                        'slug'        => '*',
                        'http_method' => '',
                        'http_path'   => '*',
                    ],
                    [
                        'name'        => '仪表盘',
                        'slug'        => 'dashboard',
                        'http_method' => 'GET',
                        'http_path'   => '/',
                    ],
                    [
                        'name'        => '登录',
                        'slug'        => 'auth.login',
                        'http_method' => '',
                        'http_path'   => "/auth/login\r\n/auth/logout",
                    ],
                    [
                        'name'        => '用户设置',
                        'slug'        => 'auth.setting',
                        'http_method' => 'GET,PUT',
                        'http_path'   => '/auth/setting',
                    ],
                    [
                        'name'        => '权限管理',
                        'slug'        => 'auth.management',
                        'http_method' => '',
                        'http_path'   => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs",
                    ],
                ]);
        
                Role::first()->permissions()->save(Permission::first());
        
                // add default menus.
                Menu::truncate();
                Menu::insert([
                    [
                        'parent_id' => 0,
                        'order'     => 1,
                        'title'     => '仪表盘',
                        'icon'      => 'fa-bar-chart',
                        'uri'       => '/',
                    ],
                    [
                        'parent_id' => 0,
                        'order'     => 2,
                        'title'     => '管理员',
                        'icon'      => 'fa-tasks',
                        'uri'       => '',
                    ],
                    [
                        'parent_id' => 2,
                        'order'     => 3,
                        'title'     => '用户',
                        'icon'      => 'fa-users',
                        'uri'       => 'auth/users',
                    ],
                    [
                        'parent_id' => 2,
                        'order'     => 4,
                        'title'     => '角色',
                        'icon'      => 'fa-user',
                        'uri'       => 'auth/roles',
                    ],
                    [
                        'parent_id' => 2,
                        'order'     => 5,
                        'title'     => '权限',
                        'icon'      => 'fa-ban',
                        'uri'       => 'auth/permissions',
                    ],
                    [
                        'parent_id' => 2,
                        'order'     => 6,
                        'title'     => '菜单',
                        'icon'      => 'fa-bars',
                        'uri'       => 'auth/menu',
                    ],
                    [
                        'parent_id' => 2,
                        'order'     => 7,
                        'title'     => '操作日志',
                        'icon'      => 'fa-history',
                        'uri'       => 'auth/logs',
                    ],
                ]);
        
                // add role to menu.
                Menu::find(2)->roles()->save(Role::first());
    }
}
