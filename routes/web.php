<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseStockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UomController;
use App\Http\Controllers\StockCategoryController;
use App\Http\Controllers\StockUomController;
use App\Http\Controllers\StockBrandController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    Route::get('/dashboard/roles', [RoleController::class, 'index'])->name('roles.view');
    Route::get('/dashboard/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/dashboard/roles/create', [RoleController::class, 'store'])->name('roles.store');
    Route::resource('roles', RoleController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::resource('warehouse_stock', WarehouseStockController::class);

    Route::resource('products', ProductController::class);
    Route::resource('product_categories', ProductCategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('uoms', UomController::class);

    Route::resource('stock_categories', StockCategoryController::class);
    Route::resource('stock_uoms', StockUomController::class);
    Route::resource('stock_brands', StockBrandController::class);

    Route::resource('inventory', InventoryController::class);

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::resource('suppliers', SupplierController::class);

    Route::resource('customers', CustomerController::class);

    Route::resource('sales', SaleController::class);

    Route::resource('sales_items', SalesItemController::class);
    Route::resource('payments', PaymentController::class);

    Route::resource('purchases', PurchaseController::class);
    Route::resource('purchase_items', PurchaseItemController::class);

    // Routes for purchase returns
    Route::get('purchases/{purchase}/return', [PurchaseController::class, 'returnCreate'])->name('purchases.returnCreate');
    Route::post('purchases/{purchase}/return', [PurchaseController::class, 'returnStore'])->name('purchases.returnStore');
    Route::get('purchases/{purchase}/returns', [PurchaseController::class, 'viewReturns'])->name('purchases.viewReturns');

    // Routes for sales returns
    Route::get('sales/{sale}/return', [SaleController::class, 'returnCreate'])->name('sales.returnCreate');
    Route::post('sales/{sale}/return', [SaleController::class, 'returnStore'])->name('sales.returnStore');
    Route::get('sales/{sale}/returns', [SaleController::class, 'viewReturns'])->name('sales.viewReturns');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

});
