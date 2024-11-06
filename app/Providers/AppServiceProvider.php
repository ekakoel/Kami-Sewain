<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::if('isVerified', function () {
            return auth()->check() && auth()->user()->email_verified_at;
        });
        Blade::directive('isAuthor', function () {
            return "<?php if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position === 'Author'): ?>";
        });

        Blade::directive('isDeveloper', function () {
            return "<?php if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position === 'Developer'): ?>";
        });

        Blade::directive('isReservation', function () {
            return "<?php if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position === 'Reservation'): ?>";
        });

        Blade::directive('isManager', function () {
            return "<?php if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->position === 'Manager'): ?>";
        });

        // End directives
        Blade::directive('endIsAuthor', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('endIsDeveloper', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('endIsReservation', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('endIsManager', function () {
            return "<?php endif; ?>";
        });
    }
}
