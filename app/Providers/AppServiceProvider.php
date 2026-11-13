<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::setLocale(config('app.locale'));
        Paginator::defaultView('pagination.site');

        // Pemakaian di Blade: @rupiah($order->total)
        Blade::directive('rupiah', fn (string $expression) => "<?php echo e(\\App\\Support\\Format::rupiah({$expression})); ?>");
    }
}
