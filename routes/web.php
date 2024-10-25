<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesItemController;


Route::get("/", [ProductController::class, 'index']);
Route::get("products/create", [ProductController::class, 'create']);
Route::post("products/store", [ProductController::class, 'store'])->name('products.store');
Route::get("products/{id}/show", [ProductController::class, 'show']);
Route::get("products/{id}/edit", [ProductController::class, 'edit']);
Route::put("products/{id}/update", [ProductController::class, 'update'])->name('products.update');
Route::get("products/{id}/delete", [ProductController::class, 'destroy']);

//  route for customers
Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
Route::post('/customers/store', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/sales/create', [CustomerController::class, 'create'])->name('sales.create');
Route::post('/sales', [CustomerController::class, 'store'])->name('sales.store');
Route::post('/sales/items', [SalesItemController::class, 'store'])->name('sales.items.store');
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::get('/product-details/{id}', [ProductController::class, 'getProductDetails']);



