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
                    'Người khuyết tật',
                    [
                        'text' => 'Danh sách người khuyết tật',
                        'url'  => 'users',
                        'icon'  => 'user',
                        'active' => ['users']
                    ],
                    [
                        'text' => 'Thêm người khuyết tật',
                        'url'  => 'users/create',
                        'icon'  => 'plus-square',
                        'active' => ['users/create']
                    ],
                    [
                        'text' => 'Import người khuyết tật',
                        'url'  => 'users/import',
                        'icon'  => 'upload',
                        'active' => ['users/import']
                    ],
                    [
                        'text' => 'Export người khuyết tật',
                        'url'  => 'users/export',
                        'icon'  => 'download',
                        'active' => ['users/export']
                    ],
                    'Cán bộ quản lý',
                    [
                        'text'   => 'Danh sách cán bộ quản lý',
                        'url'    => 'admins',
                        'icon'   => 'user',
                        'active' => ['admins']
                    ],
                    'Báo cáo',
                    [
                        'text'    => 'Biểu đồ',
                        'icon'    => 'bar-chart',
                        'url'     => 'reports',
                        'active'  => ['reports'],
                    ],
                    'Tài khoản cá nhân',
                    [
                        'text'    => 'Thông tin',
                        'icon'    => 'user',
                        'url'     => 'info',
                        'active'  => ['info'],
                    ],
                    [
                        'text'    => 'Đổi mật khẩu',
                        'icon'    => 'cog',
                        'url'     => 'info/reset-password',
                        'active'  => ['info/reset-password'],
                    ],
                ];
            } else {
                $items = [
                    'Người khuyết tật',
                    [
                        'text' => 'Danh sách người khuyết tật',
                        'url'  => 'users',
                        'icon'  => 'user',
                        'active' => ['users']
                    ],
                    [
                        'text' => 'Export người khuyết tật',
                        'url'  => 'users/export',
                        'icon'  => 'download',
                        'active' => ['users/export']
                    ],
                    'Cán bộ quản lý',
                    [
                        'text' => 'Danh sách cán bộ quản lý',
                        'url'  => 'admins',
                        'icon'  => 'user',
                        'active' => ['admins']
                    ],
                    [
                        'text' => 'Thêm cán bộ quản lý',
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
                    'Tài khoản cá nhân',
                    [
                        'text'    => 'Thông tin',
                        'icon'    => 'user',
                        'url'     => 'info',
                        'active'  => ['info'],
                    ],
                    [
                        'text'    => 'Đổi mật khẩu',
                        'icon'    => 'cog',
                        'url'     => 'info/reset-password',
                        'active'  => ['info/reset-password'],
                    ],
                ];
            }
            $event->menu->add(...$items);
        });
    }
}
