<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
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
        Carbon::setLocale('pt_BR');

        Blade::directive('money', function (string $expression) {
            return "<?php echo e(\\App\\Support\\Labels::money($expression)); ?>";
        });

        Blade::directive('km', function (string $expression) {
            return "<?php echo e(\\App\\Support\\Labels::km($expression)); ?>";
        });

        View::composer('layouts.app', function ($view): void {
            $user = auth()->user();
            $view->with(
                'unreadCount',
                $user ? $user->alerts()->where('read_status', false)->count() : 0,
            );
        });
    }
}
