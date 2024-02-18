<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashbaordController as AdminDashboardController;
use App\Http\Controllers\Sales\DashbaordController as SalesDashbaordController;
use Illuminate\Foundation\Application;
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
        if(auth()->user()){
            redirect()->route('dashboard');
        }
    });

    Route::middleware('role:admin')->prefix('admin')->controller(AdminDashboardController::class)->group(function () {
        Route::get('/', 'index')->name('admin.dashboard');
    });

    Route::middleware('role:sales')->prefix('sales')->controller(SalesDashbaordController::class)->group(function () {
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

require __DIR__.'/auth.php';
