<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');
Route::get('/purchase/{item_id}', [PurchaseController::class, 'index']);
Route::post('/purchase/{item_id}', [PurchaseController::class, 'confirm']);
Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress']);
Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress']);

Route::get('/sell', [ItemController::class, 'create']);
Route::post('/sell', [ItemController::class, 'store']);
Route::get('/?tab=mylist', [ItemController::class, 'myList'])->middleware('auth');

Route::post('/items/{item}/comments', [CommentController::class, 'store'])->middleware('auth');

Route::post('/items/{item}/like', [LikeController::class, 'toggle'])->middleware('auth')->name('items.like');

Route::get('/mypage', [MypageController::class, 'index']);
Route::get('/mypage/profile', [MypageController::class, 'edit']);
Route::post('/mypage/profile', [MypageController::class, 'update']);