<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\SystemInformation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Middleware\CheckPermission;

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
        // Middleware alias
        app('router')->aliasMiddleware('permission', CheckPermission::class);

        View::composer('*', function ($view) {

            // Cache cart invoices for 30 seconds (safe & fast)
            $cartData = cache()->remember('cart_invoices_dropdown', 30, function () {

                $cartInvoices = Invoice::with('invoiceItems.product')
                    ->where(function ($query) {
                        $query->where('status', 'pending')
                            ->whereColumn('paid_amount', '<', 'total');
                    })
                    ->latest()
                    ->limit(5)
                    ->get();

                return [
                    'cartInvoices' => $cartInvoices,
                    'cartCount' => $cartInvoices->count(),
                ];
            });

            $view->with($cartData);

            // System info (already cached in model)
            $view->with('systemInfo', SystemInformation::info());
        });
    }
}
