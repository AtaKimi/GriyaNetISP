<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AgentController as AdminAgentController;
use App\Http\Controllers\Admin\CustomerTransactionController as AdminCustomerTransactionController;
use App\Http\Controllers\Admin\DashbaordController as AdminDashboardController;
use App\Http\Controllers\Admin\SalesPackageController as AdminSalesPackageController;
use App\Http\Controllers\Agent\CustomerController as AgentCustomerController;
use App\Http\Controllers\Agent\CustomerTransactionController as AgentCustomerTransactionController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Http\Controllers\Agent\SalesPackageController as AgentSalesPackageController;
use Illuminate\Support\Facades\Route;

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
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } else if ($user->hasRole('agent')) {
            return redirect()->route('agent.dashboard');
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
            Route::delete('/{sales_package}/destroy', 'destroy')->name('admin.sales-package.destroy');
        });

        Route::prefix('customer-transaction')->controller(AdminCustomerTransactionController::class)->group(function () {
            Route::get('/', 'index')->name('admin.customer-transaction.index');
            Route::put('/{customer_transaction}/update-validation', 'updateValidation')->name('admin.customer-transaction.update-validation');
            Route::delete('/{customer_transaction}/destroy', 'destroy')->name('admin.customer-transaction.destroy');
        });
    });

    Route::middleware('role:agent')->prefix('agent')->group(function () {

        Route::controller(AgentDashboardController::class)->group(function () {
            Route::get('/', 'index')->name('agent.dashboard');
        });

        Route::prefix('sales-package')->controller(AgentSalesPackageController::class)->group(function () {
            Route::get('/', 'index')->name('agent.sales-package.index');
        });

        Route::prefix('customer-transaction')->controller(AgentCustomerTransactionController::class)->group(function () {
            Route::get('/', 'index')->name('agent.customer-transaction.index');
            Route::post('/', 'store')->name('agent.customer-transaction.store');
        });

        Route::prefix('customer')->controller(AgentCustomerController::class)->group(function () {
            Route::get('/', 'index')->name('agent.customer.index');
            Route::post('/', 'store')->name('agent.customer.store');
            Route::put('/{customer}/update', 'update')->name('agent.customer.update');
            Route::delete('/{customer}/destroy', 'destroy')->name('agent.customer.destroy');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
