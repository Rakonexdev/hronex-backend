<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
    public function boot()
    {
        define('HR_ROLE', 'Hr');
        define('ADMIN_ROLE', 'Admin');
        define('SUPER_ADMIN_ROLE', 'Super-Admin');
        define('VP_ROLE', 'Vp');
        define('PRINCIPAL_ROLE', 'Principal');
        define('ACC_ROLE', 'Accounts');
        define('EMP_ROLE', 'Employee');
        define('EXAD_ROLE', 'Executive-Admin');

        Paginator::useBootstrap();
    }
}
