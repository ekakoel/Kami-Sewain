<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Direktif untuk memeriksa apakah pengguna adalah admin
        Blade::directive('isAdmin', function () {
            return "<?php if(auth()->check() && auth()->user()->role === 'admin'): ?>";
        });

        // Direktif untuk memeriksa apakah pengguna adalah user
        Blade::directive('isUser', function () {
            return "<?php if(auth()->check() && auth()->user()->role === 'user'): ?>";
        });

        // Tutup kondisi
        Blade::directive('endIsAdmin', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('endIsUser', function () {
            return "<?php endif; ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
