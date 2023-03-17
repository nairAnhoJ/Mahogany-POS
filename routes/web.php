<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
        return view('dashboard');
    }
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // INVENTORY
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/{page}', [InventoryController::class, 'paginate']);
    Route::get('/inventory/{page}/{search}', [InventoryController::class, 'search']);
    Route::get('/inventory/add', [InventoryController::class, 'add'])->name('inventory.add');
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/edit/{slug}', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::post('/inventory/update', [InventoryController::class, 'update'])->name('inventory.update');
    Route::post('/inventory/delete', [InventoryController::class, 'delete'])->name('inventory.delete');
});

require __DIR__.'/auth.php';
