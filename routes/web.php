<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChallanController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WarrantyController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SystemUserController;


// Landing page
Route::get('/', function () {
    return view('welcome');
});


// Authenticated routes
Route::group(['middleware' => ['auth', 'permission']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/products/stock', [ProductController::class, 'stock'])->name('products.stock');
    Route::resource('products', ProductController::class);

    Route::resource('units', UnitController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('warranties', WarrantyController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('challans', ChallanController::class);
    Route::resource('invoices', InvoiceController::class);

    Route::get('/user_profile', [ProfileController::class, 'user_profile'])->name('user_profile_show');
    Route::get('/user_profile_edit', [ProfileController::class, 'user_profile_edit'])->name('user_profile_edit');
    Route::put('/user_profile_edit', [ProfileController::class, 'user_profile_update'])->name('user_profile_update');
    Route::resource('companies', CompanyController::class);
    Route::resource('system_users', SystemUserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});

// Breeze authentication
require __DIR__ . '/auth.php';
