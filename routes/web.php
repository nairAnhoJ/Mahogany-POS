<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ValidateRole;
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
        return view('auth.login');
    }else{

        if(auth()->user()->role == 1){
            return redirect()->route('dashboard');
        }else if(auth()->user()->role == 2){
            return redirect()->route('dashboard');
        }else if(auth()->user()->role == 3){
            return redirect()->route('kitchen.display');
        }else if(auth()->user()->role == 4){
            return redirect()->route('dashboard');
        }
    }
});

Route::middleware("role:1")->group(function(){

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
});


Route::middleware("role:1,3")->group(function(){

    // DASHBOARD
    Route::get('/kitchen-display', [KitchenController::class, 'index'])->name('kitchen.display');

    // MENU
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/add', [MenuController::class, 'add'])->name('menu.add');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/edit/{slug}', [MenuController::class, 'edit']);
    Route::post('/menu/update', [MenuController::class, 'update'])->name('menu.update');
    Route::post('/menu/view', [MenuController::class, 'view'])->name('menu.view');
    Route::post('/menu/compute-quantity', [MenuController::class, 'computeqty'])->name('menu.computeqty');
    Route::post('/menu/change-quantity', [MenuController::class, 'changeqty'])->name('menu.changeqty');
    Route::get('/menu/delete/{slug}', [MenuController::class, 'delete'])->name('menu.delete');
    Route::get('/menu/{page}', [MenuController::class, 'paginate']);
    Route::get('/menu/{page}/{search}', [MenuController::class, 'search']);

    
});


Route::middleware('role:1,4')->group(function(){

    // INVENTORY
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/add', [InventoryController::class, 'add'])->name('inventory.add');
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/edit/{slug}', [InventoryController::class, 'edit']);
    Route::post('/inventory/update', [InventoryController::class, 'update'])->name('inventory.update');
    Route::get('/inventory/delete/{slug}', [InventoryController::class, 'delete'])->name('inventory.delete');
    Route::get('/inventory/{page}', [InventoryController::class, 'paginate']);
    Route::get('/inventory/{page}/{search}', [InventoryController::class, 'search']);

});

Route::view('error', 'error');

require __DIR__.'/auth.php';
