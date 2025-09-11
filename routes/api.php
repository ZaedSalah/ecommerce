<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// ==================== AUTH =======================
Route::post('/register', [ApiController:: class, 'register']);
Route::post('/login', [ApiController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [ApiController::class, 'logout']);

// ==================== PRODUCTS ===================
Route::get('/products', [ApiController::class, 'allProducts']);
Route::get('/products/{id}', [ApiController::class, 'singleProduct']);

// ==================== CATEGORIES =================
Route::get('/categories', [ApiController::class, 'allCategories']);
Route::get('/categories/{id}/products', [ApiController::class, 'categoryProducts']);

// ==================== CART =======================
Route::middleware('auth:sanctum')->get('/cart', [ApiController::class, 'cart']);
Route::middleware('auth:sanctum')->post('/cart/add', [ApiController::class, 'addToCart']);
Route::middleware('auth:sanctum')->delete('/cart/remove/{id}', [ApiController::class, 'deleteItem']);
Route::middleware('auth:sanctum')->put('/cart/update/{id}', [ApiController::class, 'updateQuantity']);

// ==================== ORDERS =====================
Route::middleware('auth:sanctum')->post('/order', [ApiController::class, 'storeOrder']);
Route::middleware('auth:sanctum')->get('/orders', [ApiController::class, 'userOrders']);
Route::middleware('auth:sanctum')->get('/orders/{id}', [ApiController::class, 'orderDetails']);

// ==================== USER =======================
Route::middleware('auth:sanctum')->get('/user', [ApiController::class, 'userInfo']);