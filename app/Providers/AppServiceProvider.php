<?php

namespace App\Providers;

use App\Http\View\Composer\MenuComposer;
use App\Http\View\Composer\RolePermission;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('reporttcpdf', function () {
            return config('reporttcpdf');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(views: '*', callback: RolePermission::class);
        View::composer(views: [
            'layout.valuation-main-menu',
            'layout.propman-main-menu',
            'layout.setup-main-menu',
            'layout.hc.hc-main-menu'
        ], callback: MenuComposer::class);
    }
}
