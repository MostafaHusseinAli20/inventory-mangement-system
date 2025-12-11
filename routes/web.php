<?php

use App\Http\Controllers\Admin\SalesMatrial\SalesMatrialTypesController;
use App\Http\Controllers\Admin\Settings\SettingController;
use App\Http\Controllers\Admin\Stores\StoreController;
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
        // Deatails
        Route::get('{id}/details', [TreasuryController::class, 'detailsPage']); // blade
        Route::get('{id}/get_details', [TreasuryController::class, 'details']); // => json
        // Add TreasuryDelivery
        Route::get('{id}/delivery/create', [TreasuryController::class, 'treasury_delivery_create']); // blade
        Route::post('{id}/store-treasury-delivery', [TreasuryController::class, 'treasury_delivery_store']); // => json
        Route::get('get-treasury-delivery-data', [TreasuryController::class, 'get_treasury_delivery_data']); // => json
        // Delete
        Route::delete('{id}/treasury-delivery-destroy', [TreasuryController::class, 'treasury_delivery_destroy']);
    });

    // Sales Matrial Types
    Route::group(['prefix' => 'sales-matrial-types'], function () {
        Route::get('/',[SalesMatrialTypesController::class, 'index'])->name('sales-matrial-types.index');
        // Get Data
        Route::get('get-sales-matrial-types-data', [SalesMatrialTypesController::class, 'getSalesMatrialTypeData']);
        // Create
        Route::get('/create', [SalesMatrialTypesController::class, 'create']);
        // Store
        Route::post('/store', [SalesMatrialTypesController::class, 'storeData']);
        //Show
        Route::get('/{id}/show', [SalesMatrialTypesController::class, 'show']);
        //Edit
        Route::get('/{id}/edit', [SalesMatrialTypesController::class, 'edit']);
        Route::put('/{id}/update', [SalesMatrialTypesController::class, 'updateData']);
        // Delete
        Route::delete('{id}/destroy', [SalesMatrialTypesController::class, 'destroy']);
        // Exports
        Route::get('export-excel', [SalesMatrialTypesController::class, 'exportExcel']);
        Route::get('export-pdf', [SalesMatrialTypesController::class, 'exportPdf']);
    });

    // Stores
    Route::group(['prefix' => 'stores'], function () {
       Route::get('/', [StoreController::class, 'index'])->name('stores.index');
       Route::get('/get-stores-data', [StoreController::class, 'getStoreData']);
       //Create
       Route::get('/create', [StoreController::class, 'create']);
       Route::post('/store-data', [StoreController::class, 'store']);
       // Edit
       Route::get('/{id}/edit', [StoreController::class, 'edit']);
       Route::put('/{id}/update-data', [StoreController::class, 'update']);
       //Show
       Route::get('/{id}/show', [StoreController::class, 'show']);
       // Delete
       Route::delete('/{id}/destroy', [StoreController::class, 'destroy']);
       // Exports
       Route::get('export-excel', [StoreController::class, 'exportExcel']);
       Route::get('export-pdf', [StoreController::class, 'exportPdf']);
       // Search
       Route::get('search', [StoreController::class, 'searchByName']);
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
