<?php

use App\Http\Controllers\productController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route:: get("/",[ProductController::class,'index']);

Route:: get("products/create",[ProductController::class,'create']);

Route:: post("products/store",[ProductController::class,'store'])->name('products.store');

Route:: get("products/{id}/show",[ProductController::class,'show']);

Route:: get("products/{id}/edit",[ProductController::class,'edit']);

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

