<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderedController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiverReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WasteController;
use App\Http\Middleware\ValidateRole;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if(!auth()->user()){
        $settings = DB::table('settings')->where('id', 1)->first();
        return view('auth.login', compact('settings'));
    }else{
        if(auth()->user()->role == '1'){
            return redirect()->route('dashboard');
        }else if(auth()->user()->role == '2'){
            return redirect()->route('pos.index');
        }else if(auth()->user()->role == '3'){
            return redirect()->route('kitchen.display');
        }else if(auth()->user()->role == '4'){
            return redirect()->route('inventory.index');
        }
    }
});

Route::middleware("role:1,2")->group(function(){

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/change-timeframe', [DashboardController::class, 'change'])->name('dashboard.change');

    // REPORTS
    Route::get('/reports', [ReportController::class, 'index'])->name('areport.index');
    Route::post('/report/generate', [ReportController::class, 'generate'])->name('areport.generate');
    Route::post('/report/generate/pay-expenses', [ReportController::class, 'payExpenses'])->name('payExpenses');
    Route::post('/report/generate/update-expenses', [ReportController::class, 'updateExpenses'])->name('updateExpenses');
    Route::post('/report/generate/delete-expenses', [ReportController::class, 'deleteExpenses'])->name('deleteExpenses');
    Route::post('/report/generate/update-sales', [ReportController::class, 'updateSales'])->name('updateSales');
    Route::post('/report/generate/delete-sales', [ReportController::class, 'deleteSales'])->name('deleteSales');
    Route::get('/report/print/{start}/{end}/{category}/{report}', [ReportController::class, 'print']);
    
    Route::get('/financial-report', [ReportController::class, 'financialReport'])->name('financialReport');
    Route::post('/financial-report', [ReportController::class, 'generateFinancialReport'])->name('generateFinancialReport');
    Route::post('/get-actual', [ReportController::class, 'getActual'])->name('getActual');
    Route::post('/update-actual', [ReportController::class, 'updateActual'])->name('updateActual');

    // USERS
    Route::get('/system-management/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/system-management/user/add', [UserController::class, 'add'])->name('user.add');
    Route::post('/system-management/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/system-management/user/edit/{slug}', [UserController::class, 'edit']);
    Route::post('/system-management/user/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/system-management/user/delete/{slug}', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/system-management/user/{page}', [UserController::class, 'paginate']);
    Route::get('/system-management/user/{page}/{search}', [UserController::class, 'search']);

    // TABLE
    Route::get('/system-management/table', [TableController::class, 'index'])->name('table.index');
    Route::get('/system-management/table/add', [TableController::class, 'add'])->name('table.add');
    Route::post('/system-management/table/store', [TableController::class, 'store'])->name('table.store');
    Route::get('/system-management/table/edit/{slug}', [TableController::class, 'edit']);
    Route::post('/system-management/table/update', [TableController::class, 'update'])->name('table.update');
    Route::get('/system-management/table/delete/{slug}', [TableController::class, 'delete'])->name('table.delete');
    Route::get('/system-management/table/{page}', [TableController::class, 'paginate']);
    Route::get('/system-management/table/{page}/{search}', [TableController::class, 'search']);

    // INVENTORY CATEGORY
    Route::get('/system-management/inventory-category', [CategoryController::class, 'index'])->name('inventory.category.index');
    Route::get('/system-management/inventory-category/add', [CategoryController::class, 'add'])->name('inventory.category.add');
    Route::post('/system-management/inventory-category/store', [CategoryController::class, 'store'])->name('inventory.category.store');
    Route::get('/system-management/inventory-category/edit/{slug}', [CategoryController::class, 'edit']);
    Route::post('/system-management/inventory-category/update', [CategoryController::class, 'update'])->name('inventory.category.update');
    Route::get('/system-management/inventory-category/delete/{slug}', [CategoryController::class, 'delete'])->name('inventory.category.delete');
    Route::get('/system-management/inventory-category/{page}', [CategoryController::class, 'paginate']);
    Route::get('/system-management/inventory-category/{page}/{search}', [CategoryController::class, 'search']);

    // MENU CATEGORY
    Route::get('/system-management/menu-category', [MenuCategoryController::class, 'index'])->name('menu.category.index');
    Route::get('/system-management/menu-category/add', [MenuCategoryController::class, 'add'])->name('menu.category.add');
    Route::post('/system-management/menu-category/store', [MenuCategoryController::class, 'store'])->name('menu.category.store');
    Route::get('/system-management/menu-category/edit/{slug}', [MenuCategoryController::class, 'edit']);
    Route::post('/system-management/menu-category/update', [MenuCategoryController::class, 'update'])->name('menu.category.update');
    Route::get('/system-management/menu-category/delete/{slug}', [MenuCategoryController::class, 'delete'])->name('menu.category.delete');
    Route::get('/system-management/menu-category/{page}', [MenuCategoryController::class, 'paginate']);
    Route::get('/system-management/menu-category/{page}/{search}', [MenuCategoryController::class, 'search']);

    // SETTINGS
    Route::get('/system-management/settings', [SettingController::class, 'settings'])->name('settings.index');
    Route::post('/system-management/settings/store', [SettingController::class, 'store'])->name('settings.store');
});


Route::middleware("role:1,3,2")->group(function(){
    // DASHBOARD
    Route::get('/kitchen-display', [KitchenController::class, 'index'])->name('kitchen.display');
    Route::post('/kitchen-display/change-status', [KitchenController::class, 'change'])->name('kitchen.change');
    Route::post('/kitchen-display/check', [KitchenController::class, 'check'])->name('kitchen.check');
    Route::post('/kitchen-display/serve', [KitchenController::class, 'serve'])->name('kitchen.serve');

    // MENU
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/add', [MenuController::class, 'add'])->name('menu.add');
    Route::POST('/menu/add/change-ing', [MenuController::class, 'changeIng'])->name('menu.changeIng');
    Route::POST('/menu/add/add-ing', [MenuController::class, 'addIng'])->name('menu.addIng');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/edit/{slug}', [MenuController::class, 'edit']);
    Route::post('/menu/update', [MenuController::class, 'update'])->name('menu.update');
    Route::post('/menu/view', [MenuController::class, 'view'])->name('menu.view');
    Route::post('/menu/move', [MenuController::class, 'move'])->name('menu.move');
    Route::post('/menu/compute-quantity', [MenuController::class, 'computeqty'])->name('menu.computeqty');
    Route::post('/menu/change-quantity', [MenuController::class, 'changeqty'])->name('menu.changeqty');
    Route::get('/menu/delete/{slug}', [MenuController::class, 'delete'])->name('menu.delete');
    Route::post('/menu/dispose', [MenuController::class, 'dispose'])->name('menu.dispose');
    Route::get('/menu/{page}', [MenuController::class, 'paginate']);
    Route::get('/menu/{page}/{search}', [MenuController::class, 'search']);
});


Route::middleware('role:1,4,2')->group(function(){
    // INVENTORY
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/add', [InventoryController::class, 'add'])->name('inventory.add');
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::post('/inventory/add-qty', [InventoryController::class, 'addqty'])->name('inventory.addqty');
    Route::post('/inventory/minus-qty', [InventoryController::class, 'minusqty'])->name('inventory.minusqty');
    Route::get('/inventory/edit/{slug}', [InventoryController::class, 'edit']);
    Route::post('/inventory/update', [InventoryController::class, 'update'])->name('inventory.update');
    Route::get('/inventory/delete/{slug}', [InventoryController::class, 'delete'])->name('inventory.delete');
    Route::post('/inventory/dispose', [InventoryController::class, 'dispose'])->name('inventory.dispose');
    Route::get('/inventory/{page}', [InventoryController::class, 'paginate']);
    Route::get('/inventory/{page}/{search}', [InventoryController::class, 'search']);

    // EXPENSES
    Route::get('/expenses', [ExpensesController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/add', [ExpensesController::class, 'add'])->name('expenses.add');
    Route::post('/expenses/store', [ExpensesController::class, 'store'])->name('expenses.store');
    Route::post('/expenses/add-qty', [ExpensesController::class, 'addqty'])->name('expenses.addqty');
    Route::post('/expenses/minus-qty', [ExpensesController::class, 'minusqty'])->name('expenses.minusqty');
    Route::get('/expenses/edit/{id}', [ExpensesController::class, 'edit']);
    Route::post('/expenses/update', [ExpensesController::class, 'update'])->name('expenses.update');
    Route::get('/expenses/delete/{id}', [ExpensesController::class, 'delete'])->name('expenses.delete');
    Route::get('/expenses/{page}', [ExpensesController::class, 'paginate']);
    Route::get('/expenses/{page}/{search}', [ExpensesController::class, 'search']);



    Route::get('/report/inventory', [ReceiverReportController::class, 'invIndex'])->name('report.inventory.index');
    Route::get('/report/inventory/print', [ReceiverReportController::class, 'invPrint'])->name('report.inventory.print');
    Route::get('/report/inventory/{page}', [ReceiverReportController::class, 'invPaginate']);
    Route::get('/report/inventory/{page}/{search}', [ReceiverReportController::class, 'invSearch']);



    Route::get('/report/menu', [ReceiverReportController::class, 'menuIndex'])->name('report.menu.index');
    Route::get('/report/menu/print', [ReceiverReportController::class, 'menuPrint'])->name('report.menu.print');
    Route::get('/report/menu/{page}', [ReceiverReportController::class, 'menuPaginate']);
    Route::get('/report/menu/{page}/{search}', [ReceiverReportController::class, 'menuSearch']);
});


Route::middleware('role:1,2')->group(function(){

    // POS
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos/add', [POSController::class, 'add'])->name('pos.add');
    Route::post('/pos/inc', [POSController::class, 'inc'])->name('pos.inc');
    Route::post('/pos/desc', [POSController::class, 'desc'])->name('pos.desc');
    Route::post('/pos/remove', [POSController::class, 'remove'])->name('pos.remove');
    Route::post('/pos/pay', [POSController::class, 'pay'])->name('pos.pay');
    Route::post('/pos/paylater', [POSController::class, 'paylater'])->name('pos.paylater');
    Route::post('/pos/discount/update', [POSController::class, 'updateDiscount'])->name('pos.updateDiscount');
    Route::get('/pos/discount/delete', [POSController::class, 'deleteDiscount'])->name('pos.deleteDiscount');
    Route::get('/pos/sales/send', [POSController::class, 'send'])->name('pos.send');
    Route::get('/pos/print/{id}', [POSController::class, 'print']);

    // ORDERS
    Route::get('/orders', [OrderedController::class, 'index'])->name('orders.index');
    Route::post('/orders/reduce', [OrderedController::class, 'reduce'])->name('orders.reduce');
    Route::post('/orders/remove', [OrderedController::class, 'remove'])->name('orders.remove');
    Route::post('/orders/cancel', [OrderedController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/open', [OrderedController::class, 'open'])->name('orders.open');
    Route::post('/orders/occupy', [OrderedController::class, 'occupy'])->name('orders.occupy');
    Route::post('/orders/paid', [OrderedController::class, 'paid'])->name('orders.paid');
    Route::post('/orders/get-menu', [OrderedController::class, 'getMenu'])->name('orders.getMenu');
    Route::post('/orders/get-amount', [OrderedController::class, 'getAmount'])->name('orders.getAmount');
    Route::get('/orders/print/{id}', [OrderedController::class, 'print']);

    // TRANSACTIONS
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/view', [TransactionController::class, 'view'])->name('transactions.view');
    Route::post('/transactions/generate', [TransactionController::class, 'generate'])->name('transactions.generate');
    Route::get('/transactions/print/{id}', [TransactionController::class, 'print']);

    // WASTE
        // INVENTORY
        Route::get('/waste/inventory', [WasteController::class, 'inventoryIndex'])->name('waste.inventory.index');
        Route::get('/waste/inventory/restore/{id}', [WasteController::class, 'inventoryRestore'])->name('waste.inventory.restore');
        Route::get('/waste/inventory/{page}', [WasteController::class, 'inventoryPaginate']);
        Route::get('/waste/inventory/{page}/{search}', [WasteController::class, 'inventorySearch']);

        // MENU
        Route::get('/waste/menu', [WasteController::class, 'menuIndex'])->name('waste.menu.index');
        Route::get('/waste/menu/restore/{id}', [WasteController::class, 'menuRestore'])->name('waste.menu.restore');
        Route::get('/waste/menu/{page}', [WasteController::class, 'menuPaginate']);
        Route::get('/waste/menu/{page}/{search}', [WasteController::class, 'menuSearch']);
    // WASTE END

});

Route::view('error', 'error');

require __DIR__.'/auth.php';
