<?php

use App\Http\Controllers\Admin\Settings\SettingController;
use App\Http\Controllers\Admin\Treasuries\TreasuryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::get('/main', function () {
    return view('admin.index');
})->middleware(['auth:admin', 'verified'])->name('dashboard');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin']], function () {

    define('PAGINATE_COUNT', 10);
    // Accounts
    Route::group(['prefix' => 'accounts'], function () {
        Route::get('/', function () {
            return view('admin.accounts.index');
        })->name('accounts.index');
    });

    // Settings
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', [SettingController::class, 'index'])
            ->name('settings.index');

        Route::get('/edit', [SettingController::class, 'edit'])
            ->name('settings.edit');

        Route::get('get_setting_data', [SettingController::class, 'get_setting_data']);
        Route::post('update_setting_data', [SettingController::class, 'update_setting_data']);
    });

    // Treasuries
    Route::group(['prefix' => 'treasuries'], function () {
        Route::get('/', [TreasuryController::class, 'index'])
            ->name('treasury.index');

        // Get
        Route::get('get_treasury_data', [TreasuryController::class, 'get_treasury_data']);

        // Store
        Route::get('/create', [TreasuryController::class, 'create']);
        Route::post('store_treasury_data', [TreasuryController::class, 'store']);

        // Edit
        Route::get('{id}/edit', [TreasuryController::class, 'edit']);
        Route::put('{id}/update', [TreasuryController::class, 'update']);

        // Show
        Route::get('{id}/show', [TreasuryController::class, 'show']);

        // Delete
        Route::delete('destroy_treasury/{id}', [TreasuryController::class, 'destroy']);

        // Search
        Route::get('search', [TreasuryController::class, 'searchByName']);
        // Exports
        Route::get('export-excel', [TreasuryController::class, 'exportExcel']);
        Route::get('export-pdf', [TreasuryController::class, 'exportPdf']);
    });

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
