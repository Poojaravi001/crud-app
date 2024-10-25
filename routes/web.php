<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

// Home Route
Route::get("/", [ProductController::class, 'index'])->name('home');

// Product Routes
Route::resource('products', ProductController::class)->except(['show', 'create', 'store', 'edit', 'update', 'destroy']);

// Show Product
Route::get("products/{id}/show", [ProductController::class, 'show'])->name('products.show');

// Create Product
Route::get("products/create", [ProductController::class, 'create'])->name('products.create');
Route::post("products/store", [ProductController::class, 'store'])->name('products.store');

// Edit Product
Route::get("products/{id}/edit", [ProductController::class, 'edit'])->name('products.edit');
Route::put("products/{id}/update", [ProductController::class, 'update'])->name('products.update');

// Delete Product
Route::delete("products/{id}/destroy", [ProductController::class, 'destroy'])->name('products.destroy');

// Delete Product Image
Route::delete("products/{product}/images/{image}", [ProductController::class, 'destroyImage'])->name('products.image.destroy');

// Purchase Routes
Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store'); // Use this for submission
// List All Purchases
Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');

// Create Purchase Form
Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');

// Store Purchase Data
Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');

