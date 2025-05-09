<?php

use App\Http\Controllers\{ItemController, AuthController, PurchaseController, MypageController, CommentController, LikeController, ShippingController};
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\{Route, Auth};

// 認証ルート + メール認証
Auth::routes(['verify' => true]);

// メール認証ルート
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn() => view('auth.verify-email'))->name('verification.notice');

    Route::post('/email/verification-notification', function () {
        request()->user()->sendEmailVerificationNotification();
        return back()->with('message', '認証リンクを再送しました。');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('mypage.edit');
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証必須ルート（未ログイン時 /guest にリダイレクト）
Route::middleware(['auth', 'verified'])->group(function () {
    // コメント・いいね
    Route::post('/items/{item}/comments', [CommentController::class, 'store']);
    Route::post('/items/{item}/like', [LikeController::class, 'toggle'])->name('items.like');

    // 出品
    Route::get('/sell', [ItemController::class, 'create'])->name('items.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');

    Route::get('/shipping/{item_id}/edit', [ShippingController::class, 'edit'])->name('shipping.edit');
    Route::post('/shipping/{item_id}/update', [ShippingController::class, 'update'])->name('shipping.update');
});

// トップ・商品表示・検索・マイリスト
Route::get('/', [ItemController::class, 'index'])->name('index');

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');
Route::get('/search', [ItemController::class, 'search'])->name('items.search');
Route::get('/?tab=mylist', [ItemController::class, 'myList'])->name('items.mylist');

// 購入
Route::get('/purchase/{item_id}', [PurchaseController::class, 'index'])->name('purchase.index');
Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');
Route::get('/purchase/address/{item_id}', [ShippingController::class, 'edit'])->name('shipping.edit');
Route::post('/purchase/address/{item_id}', [ShippingController::class, 'update'])->name('shipping.update');
Route::get('/purchase/success/{item_id}', [PurchaseController::class, 'success'])->name('purchase.success');

// マイページ
Route::prefix('mypage')->name('mypage.')->group(function () {
    Route::get('/', [MypageController::class, 'index']);
    Route::get('/purchase', [MypageController::class, 'purchaseItems'])->name('purchased_items');
    Route::get('/profile', [MypageController::class, 'edit'])->name('edit');
    Route::post('/profile', [MypageController::class, 'update'])->name('update');
});

// 認証不要（ログイン・登録）
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');