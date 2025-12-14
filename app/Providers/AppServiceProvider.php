<?php

namespace App\Providers;

use App\Models\Invoice;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        app('router')->aliasMiddleware('permission', \App\Http\Middleware\CheckPermission::class);
        View::composer('*', function ($view) {

            $cartInvoices = Invoice::with('invoiceItems.product')
                ->where('status', 'pending')
                ->orWhereColumn('paid_amount', '<', 'total')
                ->latest()
                ->take(5) // limit for dropdown/box
                ->get();

            $cartCount = $cartInvoices->count();

            $view->with(compact('cartInvoices', 'cartCount'));
        });
    }
}
