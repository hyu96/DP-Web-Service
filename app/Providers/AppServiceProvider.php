<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (Auth::user()->role === ADMIN::DISTRICT_ADMIN) {
                $items = [
                    'Người dùng',
                    [
                        'text' => 'Danh sách người dùng',
                        'url'  => 'users',
                        'icon'  => 'user',
                        'active' => ['users']
                    ],
                    [
                        'text' => 'Thêm người dùng',
                        'url'  => 'users/create',
                        'icon'  => 'plus-square',
                        'active' => ['users/create']
                    ],
                    [
                        'text' => 'Import người dùng',
                        'url'  => 'users/import',
                        'icon'  => 'upload',
                        'active' => ['users/import']
                    ],
                    [
                        'text' => 'Export người dùng',
                        'url'  => 'users/export',
                        'icon'  => 'download',
                        'active' => ['users/export']
                    ],
                    'Admin',
                    [
                        'text' => 'Danh sách quản trị viên',
                        'url'  => 'admins',
                        'icon'  => 'user',
                        'active' => ['admins']
                    ],
                    'Báo cáo',
                    [
                        'text'    => 'Biểu đồ',
                        'icon'    => 'bar-chart',
                        'url'  => 'reports',
                        'active'  => ['reports'],
                    ],
                ];
            } else {
                $items = [
                    'Người dùng',
                    [
                        'text' => 'Danh sách người dùng',
                        'url'  => 'users',
                        'icon'  => 'user',
                        'active' => ['users']
                    ],
                    [
                        'text' => 'Export người dùng',
                        'url'  => 'users/export',
                        'icon'  => 'download',
                        'active' => ['users/export']
                    ],
                    'Admin',
                    [
                        'text' => 'Danh sách quản trị viên',
                        'url'  => 'admins',
                        'icon'  => 'user',
                        'active' => ['admins']
                    ],
                    [
                        'text' => 'Thêm quản trị viên',
                        'url'  => 'admins/create',
                        'icon'  => 'plus-square',
                        'active' => ['admins/create']
                    ],
                    'Báo cáo',
                    [
                        'text'    => 'Biểu đồ',
                        'icon'    => 'bar-chart',
                        'url'  => 'reports',
                        'active'  => ['reports'],
                    ],
                ];
            }
            $event->menu->add(...$items);
        });
    }
}
