<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AgentController as AdminAgentController;
use App\Http\Controllers\Admin\CustomerTransactionController as AdminCustomerTransactionController;
use App\Http\Controllers\Admin\DashbaordController as AdminDashboardController;
use App\Http\Controllers\Admin\SalesPackageController as AdminSalesPackageController;
use App\Http\Controllers\Sales\DashbaordController as SalesDashbaordController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        if (auth()->user()) {
            redirect()->route('dashboard');
        }
    });

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::controller(AdminDashboardController::class)->group(function () {
            Route::get('/', 'index')->name('admin.dashboard');
        });

        Route::prefix('agent')->controller(AdminAgentController::class)->group(function () {
            Route::get('/', 'index')->name('admin.agent.index');
            Route::post('/', 'store')->name('admin.agent.store');
            Route::delete('/{agent}/destroy', 'destroy')->name('admin.agent.destroy');
        });

        Route::prefix('sales-package')->controller(AdminSalesPackageController::class)->group(function () {
            Route::get('/', 'index')->name('admin.sales-package.index');
            Route::post('/', 'store')->name('admin.sales-package.store');
            Route::put('/{sales_package}/update', 'update')->name('admin.sales-package.update');
            Route::delete('/{sales_package}/destory', 'destroy')->name('admin.sales-package.destroy');
        });

        Route::prefix('customer-transaction')->controller(AdminCustomerTransactionController::class)->group(function () {
           Route::get('/', 'index')->name('admin.customer-transaction.index');
           Route::delete('/{customer_transaction}/destory', 'destroy')->name('admin.customer-transaction.destroy');
        });
    });

    Route::middleware('role:agent')->prefix('sales')->controller(SalesDashbaordController::class)->group(function () {
        Route::get('/', 'index')->name('sales.dashboard');
    });
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
