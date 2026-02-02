<?php

use App\Http\Controllers\Admin\InvItemCardCategories\InvItemCardCategoryController;
use App\Http\Controllers\Admin\InvItemCards\InvItemCardController;
use App\Http\Controllers\Admin\SalesMatrial\SalesMatrialTypesController;
use App\Http\Controllers\Admin\Settings\SettingController;
use App\Http\Controllers\Admin\Stores\StoreController;
use App\Http\Controllers\Admin\Treasuries\TreasuryController;
use App\Http\Controllers\Admin\Uoms\InvUomController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::get('/main', function () {
    return view('admin.index');
})->middleware(['auth:admin', 'verified'])->name('dashboard');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'verified']], function () {

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

    // Uoms
    Route::group(['prefix' => 'uoms'], function () {
       Route::get('/', [InvUomController::class, 'index'])->name('uoms.index');
       Route::get('/get-uoms-data', [InvUomController::class, 'getUomData']);
       //Create
       Route::get('/create', [InvUomController::class, 'create']);
       Route::post('/store', [InvUomController::class, 'store']);
       // Edit
       Route::get('{id}/edit', [InvUomController::class, 'edit']);
       Route::put('{id}/update', [InvUomController::class, 'update']);
       //Show
       Route::get('{id}/show', [InvUomController::class, 'show']);
       // Delete
       Route::delete('{id}/destroy', [InvUomController::class, 'destroy']);
       // Exports
       Route::get('export-excel', [InvUomController::class, 'exportExcel']);
       Route::get('export-pdf', [InvUomController::class, 'exportPdf']);
       // Search
       Route::get('search', [InvUomController::class, 'searchByName']);
       // Filter By Type
       Route::get('filter-by-type', [InvUomController::class, 'filterByType']);
    });

    // Inv Item Card Categories
    Route::group(['prefix' => 'item-card-categories'], function () {
        Route::get('/', [InvItemCardCategoryController::class, 'index'])->name('item-card-categories.index');
        Route::get('/get-item-card-categories-data', [InvItemCardCategoryController::class, 'getItemCardCategoryData']);
        // Create
        Route::get('/create', [InvItemCardCategoryController::class, 'create']);
        Route::post('/store', [InvItemCardCategoryController::class, 'store']);
        // Edit
        Route::get('{id}/edit', [InvItemCardCategoryController::class, 'edit']);
        Route::put('{id}/update', [InvItemCardCategoryController::class, 'update']);
        // Show
        Route::get('{id}/show', [InvItemCardCategoryController::class, 'show']); // blade
        Route::get('{id}/get-data-show', [InvItemCardCategoryController::class, 'showJson']); // json
        // Delete
        Route::delete('{id}/destroy', [InvItemCardCategoryController::class, 'destroy']);
        // Exports
        Route::get('export-excel', [InvItemCardCategoryController::class, 'exportExcel']);
        Route::get('export-pdf', [InvItemCardCategoryController::class, 'exportPdf']);
        // Search
        Route::get('search', [InvItemCardCategoryController::class, 'searchByName']);
    });

    // Inv Item Cards
    Route::group(['prefix' => 'item-cards'], function () {
       Route::get('/', [InvItemCardController::class, 'index'])->name('item-cards.index'); 
       Route::get('/get-item-cards-data', [InvItemCardController::class, 'getItemCardData']);

       Route::get('/get-categories-names', [InvItemCardController::class, 'getCategoriesNames']); 

       Route::get('/get-categories-data', [InvItemCardController::class, 'getDataForCreate']);
    //    Route::get('/get-child-uoms/{parentId}', [InvItemCardController::class, 'getChildUom']);
       Route::get('/create', [InvItemCardController::class, 'create']);
       Route::post('/store', [InvItemCardController::class, 'store']);

       Route::get('/{id}/show', [InvItemCardController::class, 'showPage']); // blade
       Route::get('/{id}/show-data', [InvItemCardController::class, 'show']); // json

       Route::get('/{id}/edit', [InvItemCardController::class, 'edit']);
       Route::post('/{id}/update', [InvItemCardController::class, 'update']);

       Route::delete('/{id}/destroy', [InvItemCardController::class, 'destroy']);

       // filter Item Cards
       Route::get('/filter', [InvItemCardController::class, 'filter']);

       // Exports
       Route::get('export-excel', [InvItemCardController::class, 'exportExcel']);
       Route::get('export-pdf', [InvItemCardController::class, 'exportPdf']);

       // Text Search
       Route::get('search',[InvItemCardController::class, 'textSearch']);
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

