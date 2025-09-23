<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

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
        // Use Bootstrap 5 pagination views to match public theme styling
        Paginator::useBootstrapFive();

        // Blade directive for currency formatting: @currency(12345) -> Rp 12.345
        Blade::directive('currency', function ($expression) {
            return "<?php echo 'Rp ' . number_format(($expression) ?? 0, 0, ',', '.'); ?>";
        });
    }
}
