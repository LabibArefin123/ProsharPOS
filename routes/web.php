<?php

//Welcome Page Part
use App\Http\Controllers\Frontend\WelcomePageController;

use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AjaxController;

//Organization Management Part
use App\Http\Controllers\Backend\Organization_Management\OrganizationController;

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
use App\Http\Controllers\Backend\Product_Management\StorageController;

//Financial Management Part
use App\Http\Controllers\Backend\Financial_Management\BankBalanceController;
use App\Http\Controllers\Backend\Financial_Management\BankDepositController;
use App\Http\Controllers\Backend\Financial_Management\BankWithdrawController;

//People Management Part
use App\Http\Controllers\Backend\People_Management\CustomerController;
use App\Http\Controllers\Backend\People_Management\SupplierController;
use App\Http\Controllers\Backend\People_Management\ManufacturerController;

//Transaction Management Part
use App\Http\Controllers\Backend\Transaction_Management\ChallanController;
use App\Http\Controllers\Backend\Transaction_Management\PaymentController;
use App\Http\Controllers\Backend\Transaction_Management\InvoiceController;
use App\Http\Controllers\Backend\Transaction_Management\PettyCashController;

use Illuminate\Support\Facades\Route;

//Setting Management Part
use App\Http\Controllers\Backend\Setting_Management\ProfileController;
use App\Http\Controllers\Backend\Setting_Management\RoleController;
use App\Http\Controllers\Backend\Setting_Management\PermissionController;

use App\Http\Controllers\Backend\Setting_Management\CompanyController;
use App\Http\Controllers\Backend\Setting_Management\UserController;
use App\Http\Controllers\Backend\Setting_Management\UserCategoryController;
use App\Http\Controllers\Backend\Setting_Management\SearchController;
use App\Http\Controllers\Backend\Setting_Management\SystemInformationController;
use App\Http\Controllers\Backend\Setting_Management\SettingController;


// Landing page
Route::get('/', [WelcomePageController::class, 'index'])->name('welcome');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

// Authenticated routes
Route::middleware(['auth', 'permission'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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
    Route::resource('storages', StorageController::class);

    //people management menu
    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('manufacturers', ManufacturerController::class);

    //transaction management menu
    Route::resource('challans', ChallanController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('petty_cashes', PettyCashController::class);

    //financial management menu
    Route::resource('bank_balances', BankBalanceController::class);
    Route::resource('bank_deposits', BankDepositController::class);
    Route::resource('bank_withdraws', BankWithdrawController::class);

    //ajax menu
    Route::get('/get-division-by-branch', [AjaxController::class, 'getDivisionByBranch'])->name('ajax.get_division_by_branch');
    Route::get('/get-department-by-division', [AjaxController::class, 'getDepartmentByDivision'])->name('ajax.get_department_by_division');

    //setting menu
    Route::resource('companies', CompanyController::class);
    Route::resource('system_informations', SystemInformationController::class);
    Route::resource('user_categories', UserCategoryController::class);
    Route::resource('system_users', UserController::class);
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
});

// Route::middleware('auth')->group(function () {

//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

//     //top menu
//     Route::get('/user_profile', [ProfileController::class, 'user_profile_show'])->name('user_profile_show');
//     Route::get('/user_profile_edit', [ProfileController::class, 'user_profile_edit'])->name('user_profile_edit');
//     Route::put('/user_profile_edit', [ProfileController::class, 'user_profile_update'])->name('user_profile_update');
//     Route::get('/notifications/search', [SearchController::class, 'search'])->name('notifications.search');

//     //organization menu
//     Route::resource('organizations', OrganizationController::class);

//     //department menu
//     Route::resource('branches', BranchController::class);
//     Route::resource('divisions', DivisionController::class);
//     Route::resource('departments', DepartmentController::class);

//     //product management menu
//     Route::resource('units', UnitController::class);
//     Route::resource('categories', CategoryController::class);
//     Route::resource('brands', BrandController::class);
//     Route::resource('warranties', WarrantyController::class);
//     Route::get('/products/stock', [ProductController::class, 'stock'])->name('products.stock');
//     Route::resource('products', ProductController::class);
//     Route::resource('storages', StorageController::class);

//     //people management menu
//     Route::resource('customers', CustomerController::class);
//     Route::resource('suppliers', SupplierController::class);
//     Route::resource('manufacturers', ManufacturerController::class);

//     //transaction management menu
//     Route::resource('challans', ChallanController::class);
//     Route::resource('invoices', InvoiceController::class);
//     Route::resource('payments', PaymentController::class);
//     Route::resource('petty_cashes', PettyCashController::class);

//     //financial management menu
//     Route::resource('bank_balances', BankBalanceController::class);
//     Route::resource('bank_deposits', BankDepositController::class);
//     Route::resource('bank_withdraws', BankWithdrawController::class);

//     //ajax menu
//     Route::get('/get-division-by-branch', [AjaxController::class, 'getDivisionByBranch'])->name('ajax.get_division_by_branch');
//     Route::get('/get-department-by-division', [AjaxController::class, 'getDepartmentByDivision'])->name('ajax.get_department_by_division');

//     //setting menu
//     Route::resource('companies', CompanyController::class);
//     Route::resource('user_categories', UserCategoryController::class);
//     Route::resource('system_users', UserController::class);
//     Route::resource('roles', RoleController::class);
//     Route::resource('permissions', PermissionController::class);
//     Route::post('/permissions/delete-selected', [PermissionController::class, 'deleteSelected'])->name('permissions.deleteSelected');
//     Route::get('/newsletter-subscribers', [NewsletterController::class, 'index'])->name('newsletter-subscribers.index');
//     Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
//     Route::get('/settings/password_policy', [SettingController::class, 'password_policy'])->name('settings.password_policy');
//     Route::get('/settings/2fa', [SettingController::class, 'show2FA'])->name('settings.2fa');
//     Route::post('/settings/toggle-2fa', [SettingController::class, 'toggle2FA'])->name('settings.toggle2fa');
//     Route::get('/settings/2fa/resend', [SettingController::class, 'resend'])->name('settings.2fa.resend');
//     Route::post('/settings/2fa/verify', [SettingController::class, 'verify'])->name('settings.2fa.verify');
//     Route::get('/settings/timeout', [SettingController::class, 'showTimeout'])->name('settings.timeout');
//     Route::post('/settings/timeout', [SettingController::class, 'updateTimeout'])->name('settings.timeout.update');
//     Route::get('/settings/database-backup', [SettingController::class, 'databaseBackup'])->name('settings.database.backup');
//     Route::post('/settings/database-backup/download', [SettingController::class, 'downloadDatabase'])->name('settings.database.backup.download');
//     Route::get('/settings/logs', [SettingController::class, 'logs'])->name('settings.logs');
//     Route::post('/settings/logs/clear', [SettingController::class, 'clearLogs'])->name('settings.clearLogs');
//     Route::get('/settings/maintenance', [SettingController::class, 'maintenance'])->name('settings.maintenance');
//     Route::post('/settings/maintenance', [SettingController::class, 'maintenanceUpdate'])->name('settings.maintenance.update');
//     Route::get('/settings/language', [SettingController::class, 'language'])->name('settings.language');
//     Route::post('/settings/language/update', [SettingController::class, 'updateLanguage'])->name('settings.language.update');
//     Route::get('/settings/datetime', [SettingController::class, 'dateTime'])->name('settings.datetime');
//     Route::post('/settings/datetime/update', [SettingController::class, 'updateDateTime'])->name('settings.datetime.update');
//     Route::get('/settings/theme', [SettingController::class, 'theme'])->name('settings.theme');
//     Route::post('/settings/theme/update', [SettingController::class, 'updateTheme'])->name('settings.theme.update');
// });

// Breeze authentication
require __DIR__ . '/auth.php';

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
