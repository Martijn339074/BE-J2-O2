<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MagazijnController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('index');
});

Route::get('/leveranciers', function () {
    return view('leveranciers');
});


Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
Route::get('/suppliers/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
Route::delete('/suppliers/{supplierId}/products/{productId}', [SupplierController::class, 'deleteProduct'])->name('suppliers.delete-product');

Route::get('/suppliers/{supplier}/products', [SupplierController::class, 'showProducts'])->name('suppliers.products');
Route::get('/suppliers/{supplier}/products/{product}/delivery', [SupplierController::class, 'showDeliveryForm'])->name('suppliers.delivery-form');
Route::post('/suppliers/{supplier}/products/{product}/delivery', [SupplierController::class, 'processDelivery'])->name('suppliers.process-delivery');Route::get('/suppliers/{supplier}/products', [SupplierController::class, 'showProducts'])->name('suppliers.products');
Route::get('/suppliers/{supplier}/products/{product}/delivery', [SupplierController::class, 'showDeliveryForm'])->name('suppliers.delivery-form');
Route::post('/suppliers/{supplier}/products/{product}/delivery', [SupplierController::class, 'processDelivery'])->name('suppliers.process-delivery');

Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
