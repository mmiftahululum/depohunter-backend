<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\DepositProductController;
use App\Http\Controllers\Admin\DepositRateController;
use App\Http\Controllers\Admin\GlobalSettingController;
use App\Http\Controllers\Admin\RateMatrixController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Public Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/bank/{id}', [HomeController::class, 'detailBank'])->name('bank.detail');

// Authentication Routes (.com/login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Admin Panel Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resource('banks', BankController::class);
    Route::resource('deposit-products', DepositProductController::class);
    Route::resource('deposit-rates', DepositRateController::class);

    // Rate Matrix (Interactive Table)
    Route::get('/rate-matrix', [RateMatrixController::class, 'index'])->name('rate-matrix.index');
    Route::get('/banks/rate-matrix', [RateMatrixController::class, 'index'])->name('banks.rate-matrix');
    Route::get('/rate-matrix/data', [RateMatrixController::class, 'getData'])->name('rate-matrix.data');
    Route::post('/rate-matrix/update-rate', [RateMatrixController::class, 'updateRate'])->name('rate-matrix.update-rate');
    
    // Global Settings
    Route::get('/settings', [GlobalSettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/{setting}/edit', [GlobalSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/{setting}', [GlobalSettingController::class, 'update'])->name('settings.update');

    // Ajax helpers
    Route::get('/ajax/products-by-bank/{bankId}', [DepositRateController::class, 'getProductsByBank'])->name('ajax.products-by-bank');
});
