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
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\SalesReturnController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseCategoryController;
use Illuminate\Support\Facades\Route;



Route::get("/", function () {
    return view('login');
});




// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/migrate', [MigrationController::class, 'show'])->name('migrate.show');
    Route::post('/migrate', [MigrationController::class, 'migrate'])->name('migrate.run');
});

require __DIR__.'/auth.php';

Route::middleware(['auth' , 'role:user', 'set.user.database'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
    Route::resource('shops', ShopController::class);


    Route::get('/dashboard/roles', [RoleController::class, 'index'])->name('roles.view');
    Route::get('/dashboard/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/dashboard/roles/create', [RoleController::class, 'store'])->name('roles.store');
    Route::resource('roles', RoleController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::resource('warehouse_stock', WarehouseStockController::class);
    Route::post('/warehouses/stock-out', [WarehouseController::class, 'stockOut'])->name('warehouses.stockOut');
    Route::get('/warehouses/stock-out/view', [WarehouseStockController::class, 'indexStockOut'])->name('warehouses.stockOutview');

    Route::get('/stock_out/create', [WarehouseStockController::class, 'createStockOut'])->name('warehouse_stock_out.create');
    Route::post('/stock_out', [WarehouseStockController::class, 'stockOut'])->name('warehouse_stock_out.store');

    Route::get('/adjustments', [WarehouseStockController::class, 'showAdjustments'])->name('warehouse_stock.adjustments');
    Route::get('/adjustments/create', [WarehouseStockController::class, 'createAdjustStock'])->name('warehouse_stock.adjustments.create');
    Route::post('/adjust', [WarehouseStockController::class, 'adjustStock'])->name('warehouse_stock.adjust');

    Route::get('/current_stock', [WarehouseStockController::class, 'showCurrentStock'])->name('warehouse_stock.current_stock');

    Route::post('/import', [WarehouseStockController::class, 'importStock'])->name('warehouse_stock.import');
    Route::get('/export', [WarehouseStockController::class, 'exportStock'])->name('warehouse_stock.export');
    Route::get('/show', [WarehouseStockController::class, 'showStock'])->name('warehouse_stock.show');


    Route::resource('products', ProductController::class);
    Route::resource('product_categories', ProductCategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('uoms', UomController::class);
   
    
    Route::resource('inventory', InventoryController::class);
    // Adjust stock
    Route::get('/inventory/adjust', [InventoryController::class, 'createAdjustStock'])->name('inventory.adjustments.create');
    Route::post('/inventory/adjust', [InventoryController::class, 'adjustStock'])->name('inventory.adjustments.store');

    // Show adjustments
    Route::get('/inventory/adjustments', [InventoryController::class, 'showAdjustments'])->name('inventory.adjustments.index');


    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::resource('suppliers', SupplierController::class);

    Route::resource('customers', CustomerController::class);

    Route::resource('sales', SaleController::class);

    Route::resource('sales_items', SalesItemController::class);
    Route::resource('payments', PaymentController::class);

    Route::resource('purchases', PurchaseController::class);
    Route::resource('purchase_items', PurchaseItemController::class);

    // Routes for purchase returns
    Route::resource('purchase_returns', PurchaseReturnController::class);

    // Routes for sales returns
    Route::resource('sales_returns', SalesReturnController::class);

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');


    //Expenses
    Route::resource('expenses', ExpenseController::class);
    Route::post('/categories', [ExpenseCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories', [ExpenseCategoryController::class, 'index'])->name('categories.index');
});


//Super Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [SuperAdminController::class, 'index'])->name('admin.dashboard');
    // Add more admin-specific routes here
});


// Salesperson Dashboard
Route::middleware(['auth', 'role:salesperson'])->group(function () {
    Route::get('/salesperson/dashboard', [SuperAdminController::class, 'index'])->name('salesperson.dashboard');
});