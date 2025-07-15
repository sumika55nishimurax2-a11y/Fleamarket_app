<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;



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
// トップページ
Route::get('/', [ItemController::class, 'index'])->name('home');

// 認証関連
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// 認証後にアクセス可能なページ
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [MypageController::class, 'show'])->name('mypage.show');
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

    // プロフィール関連
    Route::get('/mypage/profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/mypage/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::get('/purchase/complete', [PurchaseController::class, 'complete'])->name('purchase.complete');

    Route::get('/purchase/{item}', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::post('/purchase/{item}/confirm', [PurchaseController::class, 'confirm'])->name('purchase.confirm');

    Route::get('/purchase/address/{item}', [PurchaseController::class, 'editAddress'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');

    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])->name('purchase.store');
});
// 商品詳細・コメント（ログイン不要でアクセス可能）
Route::get('/item/{id}', [ItemController::class, 'show'])->name('items.show');

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::post('/items/{item}/like', [LikeController::class, 'toggle'])->name('items.like')->middleware('auth');
