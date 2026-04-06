<?php

//Welcome Page Part
use App\Http\Controllers\Frontend\WelcomePageController;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AjaxController;

//Organization Management Part
use App\Http\Controllers\Backend\Organization_Management\OrganizationController;
use App\Http\Controllers\Auth\LoginController;

//Department Management Part
use App\Http\Controllers\Backend\Department_Management\BranchController;
use App\Http\Controllers\Backend\Department_Management\DivisionController;
use App\Http\Controllers\Backend\Department_Management\DepartmentController;

//Product Management Part
use App\Http\Controllers\Backend\Product_Management\CategoryController;
use App\Http\Controllers\Backend\Product_Management\BrandController;
use App\Http\Controllers\Backend\Product_Management\UnitController;
use App\Http\Controllers\Backend\Product_Management\WarrantyController;
use App\Http\Controllers\Backend\Product_Management\ProductController;
use App\Http\Controllers\Backend\Product_Management\ProductDamageController;
use App\Http\Controllers\Backend\Product_Management\ProductExpiredController;
use App\Http\Controllers\Backend\Product_Management\StorageController;
use App\Http\Controllers\Backend\Product_Management\WarehouseController;
use App\Http\Controllers\Backend\Product_Management\StockMovementController;
use App\Http\Controllers\Backend\Product_Management\ProductInspectionController;

//Financial Management Part
use App\Http\Controllers\Backend\Financial_Management\BankBalanceController;
use App\Http\Controllers\Backend\Financial_Management\BankDepositController;
use App\Http\Controllers\Backend\Financial_Management\BankWithdrawController;

//People Management Part
use App\Http\Controllers\Backend\People_Management\CustomerController;
use App\Http\Controllers\Backend\People_Management\SupplierController;
use App\Http\Controllers\Backend\People_Management\ManufacturerController;

use App\Http\Controllers\Backend\POS\POSController;

//Transaction Management Part
use App\Http\Controllers\Backend\Transaction_Management\ChallanController;
use App\Http\Controllers\Backend\Transaction_Management\PaymentController;
use App\Http\Controllers\Backend\Transaction_Management\PurchaseController;
use App\Http\Controllers\Backend\Transaction_Management\PurchaseReturnController;
use App\Http\Controllers\Backend\Transaction_Management\InvoiceController;
use App\Http\Controllers\Backend\Transaction_Management\PettyCashController;
use App\Http\Controllers\Backend\Transaction_Management\SalesReturnController;
use App\Http\Controllers\Backend\Transaction_Management\SupplierPaymentController;

use Illuminate\Support\Facades\Route;

//Setting Management Part
use App\Http\Controllers\Backend\Setting_Management\ProfileController;
use App\Http\Controllers\Backend\Setting_Management\RoleController;
use App\Http\Controllers\Backend\Setting_Management\PermissionController;

use App\Http\Controllers\Backend\Setting_Management\CompanyController;
use App\Http\Controllers\Backend\Setting_Management\ActivityLogController;
use App\Http\Controllers\Backend\Setting_Management\UserController;
use App\Http\Controllers\Backend\Setting_Management\BanUserController;
use App\Http\Controllers\Backend\Setting_Management\BannedDeviceController;
use App\Http\Controllers\Backend\Setting_Management\UserDeviceController;
use App\Http\Controllers\Backend\Setting_Management\UserCategoryController;
use App\Http\Controllers\Backend\Setting_Management\SearchController;
use App\Http\Controllers\Backend\Setting_Management\SystemInformationController;
use App\Http\Controllers\Backend\Setting_Management\SettingController;
use App\Http\Controllers\Backend\Setting_Management\SecurityController;


// Landing page
Route::get('/', [WelcomePageController::class, 'index'])->name('welcome');
Route::get('/help', [WelcomePageController::class, 'help'])->name('help');
Route::post('/system-problem/store', [WelcomePageController::class, 'system_problem_store'])->name('system_problem.store');

// Authenticated routes
Route::group(['middleware' => ['auth', 'check_banned_device', 'detect.attack', 'permission']],  function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/system_dashboard', [DashboardController::class, 'system_index'])->name('dashboard.system');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    //top menu
    Route::get('/user_profile', [ProfileController::class, 'user_profile_show'])->name('user_profile_show');
    Route::get('/user_profile_edit', [ProfileController::class, 'user_profile_edit'])->name('user_profile_edit');
    Route::put('/user_profile_edit', [ProfileController::class, 'user_profile_update'])->name('user_profile_update');
    Route::get('/notifications/search', [SearchController::class, 'search'])->name('notifications.search');

    //organization menu
    Route::resource('organizations', OrganizationController::class);

    //department menu
    Route::resource('branches', BranchController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('departments', DepartmentController::class);

    //product management menu
    Route::resource('units', UnitController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('warranties', WarrantyController::class);
    Route::get('/products/stock', [ProductController::class, 'stock'])->name('products.stock');
    Route::resource('products', ProductController::class);
    Route::post('/products/bulk-delete',[ProductController::class, 'bulkDelete'])->name('products.bulkDelete');
    Route::post('/products/bulk-export', [ProductController::class, 'bulkExport'])->name('products.bulkExport');
    Route::resource('products_damages', ProductDamageController::class);
    Route::resource('products_expirys', ProductExpiredController::class);
    Route::resource('storages', StorageController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::post('/storages/{id}/generate-barcode', [StorageController::class, 'generateBarcode'])->name('storages.generateBarcode');
    Route::resource('stock_movements', StockMovementController::class);
    Route::resource('product_inspections', ProductInspectionController::class);
    
    //people management menu
    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('manufacturers', ManufacturerController::class);
    
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    
    //transaction management menu
    Route::resource('purchases', PurchaseController::class);
    Route::resource('purchase_returns', PurchaseReturnController::class);
    Route::get('purchase/{purchase}/return', [PurchaseReturnController::class, 'create'])->name('purchase_returns.createP');
    Route::post('purchase/{purchase}/return', [PurchaseReturnController::class, 'store'])->name('purchase_returns.storeP');
    Route::post('/purchases/{purchase}/sync-stock', [PurchaseController::class, 'syncStock'])->name('purchases.syncStock');
    Route::resource('challans', ChallanController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoice-return', [InvoiceController::class, 'returnIndex'])->name('invoice-return.index');
    Route::get('/invoice-return/{id}', [InvoiceController::class, 'returnCreate'])->name('invoice-return.create');
    Route::post('/invoice-return/store/{id}', [InvoiceController::class, 'returnStore'])->name('invoice-return.store');
    Route::post('/undo/{id}', [InvoiceController::class, 'returnUndo'])->name('invoice-return.undo');
    Route::resource('payments', PaymentController::class);
    Route::get('/payment/history', [PaymentController::class, 'history'])->name('payments.history');
    Route::get('/payment/flow-diagram', [PaymentController::class, 'flowDiagram'])->name('payments.flow-diagram');
    Route::resource('supplier_payments', SupplierPaymentController::class);
    
    Route::resource('petty_cashes', PettyCashController::class);
    Route::resource('sales_returns', SalesReturnController::class);
    
    //financial management menu
    Route::resource('bank_balances', BankBalanceController::class);
    Route::post('/bank_deposits/bulk-delete',[BankDepositController::class, 'bulkDelete'])->name('bank_deposits.bulkDelete');
    Route::resource('bank_deposits', BankDepositController::class);
    Route::post('/bank_withdraws/bulk-delete',[BankWithdrawController::class, 'bulkDelete'])->name('bank_withdraws.bulkDelete');
    Route::resource('bank_withdraws', BankWithdrawController::class);
    
    //ajax menu
    Route::get('/get-division-by-branch', [AjaxController::class, 'getDivisionByBranch'])->name('ajax.get_division_by_branch');
    Route::get('/get-department-by-division', [AjaxController::class, 'getDepartmentByDivision'])->name('ajax.get_department_by_division');

    //Report Menu Challan
    Route::get('reports/challan/daily/', [ReportController::class, 'challanDaily'])->name('report.challan.daily');
    Route::get('reports/challan/daily/pdf', [ReportController::class, 'challanDailyPdf'])->name('report.challan.daily.pdf');
    Route::get('reports/challan/monthly', [ReportController::class, 'challanMonthly'])->name('report.challan.monthly');
    Route::get('reports/challan/monthly/pdf', [ReportController::class, 'challanMonthlyPdf'])->name('report.challan.monthly.pdf');
    //Report Menu Purchase
    Route::get('reports/purchase/daily/', [ReportController::class, 'purchaseDaily'])->name('report.purchase.daily');
    Route::get('reports/purchase/daily/pdf', [ReportController::class, 'purchaseDailyPdf'])->name('report.purchase.daily.pdf');
    Route::get('reports/purchase/monthly', [ReportController::class, 'purchaseMonthly'])->name('report.purchase.monthly');
    Route::get('reports/purchase/monthly/pdf', [ReportController::class, 'purchaseMonthlyPdf'])->name('report.purchase.monthly.pdf');
    //Report Menu Invoice
    Route::get('reports/invoice/daily/', [ReportController::class, 'invoiceDaily'])->name('report.invoice.daily');
    Route::get('reports/invoice/daily/pdf', [ReportController::class, 'invoiceDailyPdf'])->name('report.invoice.daily.pdf');
    Route::get('reports/invoice/monthly', [ReportController::class, 'invoiceMonthly'])->name('report.invoice.monthly');
    Route::get('reports/invoice/monthly/pdf', [ReportController::class, 'invoiceMonthlyPdf'])->name('report.invoice.monthly.pdf');

    //setting menu
    Route::resource('companies', CompanyController::class);
    Route::resource('system_informations', SystemInformationController::class);
    Route::resource('user_categories', UserCategoryController::class);
    Route::post('/system-users/{user}/change-password', [UserController::class, 'updatePassword'])->name('system_users.password.update');
    Route::resource('system_users', UserController::class);
    Route::resource('ban_users', BanUserController::class);
    Route::resource('banned_devices', BannedDeviceController::class);
    Route::post('/user_devices/{id}/ban', [UserDeviceController::class, 'ban'])->name('user_devices.ban');
    Route::post('/user_devices/{id}/unban', [UserDeviceController::class, 'unban'])->name('user_devices.unban');
    Route::resource('user_devices', UserDeviceController::class);
    Route::resource('security_logs', SecurityController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::post('/permissions/delete-selected', [PermissionController::class, 'deleteSelected'])->name('permissions.deleteSelected');
    Route::get('/newsletter-subscribers', [NewsletterController::class, 'index'])->name('newsletter-subscribers.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/password_policy', [SettingController::class, 'password_policy'])->name('settings.password_policy');
    Route::get('/settings/2fa', [SettingController::class, 'show2FA'])->name('settings.2fa');
    Route::post('/settings/toggle-2fa', [SettingController::class, 'toggle2FA'])->name('settings.toggle2fa');
    Route::get('/settings/2fa/resend', [SettingController::class, 'resend'])->name('settings.2fa.resend');
    Route::post('/settings/2fa/verify', [SettingController::class, 'verify'])->name('settings.2fa.verify');
    Route::get('/settings/timeout', [SettingController::class, 'showTimeout'])->name('settings.timeout');
    Route::post('/settings/timeout', [SettingController::class, 'updateTimeout'])->name('settings.timeout.update');
    Route::get('/settings/database-backup', [SettingController::class, 'databaseBackup'])->name('settings.database.backup');
    Route::post('/settings/database-backup/download', [SettingController::class, 'downloadDatabase'])->name('settings.database.backup.download');
    Route::get('settings/notifications', [SettingController::class, 'notificationSettings'])->name('settings.notification.index');
    Route::post('settings/notifications', [SettingController::class, 'notificationUpdate'])->name('settings.notification.update');
    Route::post('settings/notifications/test', [SettingController::class, 'sendTestNotification'])->name('settings.notification.test');
    Route::get('/settings/logs', [SettingController::class, 'logs'])->name('settings.logs');
    Route::post('/settings/logs/clear', [SettingController::class, 'clearLogs'])->name('settings.clearLogs');
    Route::get('/settings/maintenance', [SettingController::class, 'maintenance'])->name('settings.maintenance');
Route::post('/settings/maintenance', [SettingController::class, 'maintenanceUpdate'])->name('settings.maintenance.update');
    Route::get('/settings/language', [SettingController::class, 'language'])->name('settings.language');
    Route::post('/settings/language/update', [SettingController::class, 'updateLanguage'])->name('settings.language.update');
    Route::get('/settings/datetime', [SettingController::class, 'dateTime'])->name('settings.datetime');
    Route::post('/settings/datetime/update', [SettingController::class, 'updateDateTime'])->name('settings.datetime.update');
    Route::get('/settings/theme', [SettingController::class, 'theme'])->name('settings.theme');
    Route::post('/settings/theme/update', [SettingController::class, 'updateTheme'])->name('settings.theme.update');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs.index');
    Route::delete('/activity-logs/{id}', [ActivityLogController::class, 'destroy'])->name('activity.logs.destroy');
});

Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Include your register & password routes from auth.php
    require __DIR__ . '/auth.php';
});

// -----------------------------
// AUTH ROUTES
// -----------------------------
Route::middleware('auth')->group(function () {
    

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
