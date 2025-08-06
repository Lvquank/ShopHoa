<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use App\Models\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Sửa lỗi HTTPS (Mixed Content) trên server production
        if ($this->app->environment('production')) {
            URL::forceScheme('httpss');
        }

        try {
            // Tối ưu: Lấy cấu hình và dùng cache cho tất cả các view
            View::composer('*', function ($view) {
                $configs = Cache::rememberForever('site_configs', function () {
                    return Config::pluck('value', 'key')->all();
                });
                $view->with('configs', $configs);
            });

            // Tách biệt: Chỉ chia sẻ menu cho các view admin
            View::composer('admin.*', function ($view) {
                $menus = config('admin_menu');
                $view->with('menus', $menus);
            });
        } catch (\Exception $e) {
            Log::error('Lỗi khi thiết lập View Composer: ' . $e->getMessage());

            // Chia sẻ một mảng rỗng để tránh lỗi nếu database chưa sẵn sàng
            View::share('configs', []);
            View::share('menus', []);
        }
    }
}
