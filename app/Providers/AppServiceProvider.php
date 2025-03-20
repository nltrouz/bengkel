<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
    public function boot()
    {
        Blade::directive('alert', function ($expression) {
            return "<?php echo '<script>Swal.fire('.$expression.')</script>'; ?>";
        });

        // View::composer(['welcome', 'dashboard'], function ($view) {
        //     $user = Auth::user();
        //     $kendaraanUser = $user ? ($user->kendaraan ?? []) : []; // Pastikan defaultnya array
        //     $view->with('kendaraanUser', $kendaraanUser);
        // });
    }
}
