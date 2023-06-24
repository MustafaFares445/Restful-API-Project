<?php

use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
 * Buyers
 */

Route::group(['middleware' => ['api', 'changeLanguage']], function () {

    Route::resource('buyers', App\Http\Controllers\Buyer\BuyerController::class)->only(['index', 'show']);
    Route::resource('buyers.sellers', App\Http\Controllers\Buyer\BuyerSellerController::class)->only('index');
    Route::resource('buyers.products', App\Http\Controllers\Buyer\BuyerProductController::class)->only('index');
    Route::resource('buyers.categories', App\Http\Controllers\Buyer\BuyerCategorytController::class)->only('index');
    Route::resource('buyers.transactions', App\Http\Controllers\Buyer\BuyerTransactionController::class)->only('index');

    /*
     * Categories
     */
    Route::resource('categories', \App\Http\Controllers\Category\CategoryController::class)->except('create');
    Route::resource('categories.products', App\Http\Controllers\Category\CategoryProductController::class)->only('index');
    Route::resource('categories.sellers', App\Http\Controllers\Category\CategorySellerController::class)->only('index');
    Route::resource('categories.transactions', App\Http\Controllers\Category\CategoryTransactionController::class)->only('index');
    Route::resource('categories.buyer', App\Http\Controllers\Category\CategoryBuyerController::class)->only('index');

    /*
     * Seller
     */
    Route::resource('sellers.', App\Http\Controllers\Seller\SellerController::class)->only(['index', 'show']);
    Route::resource('sellers.transactions', App\Http\Controllers\Seller\SellerTransactionController::class)->only('index');
    Route::resource('sellers.buyers', App\Http\Controllers\Seller\SellerBuyerController::class)->only('index');
    Route::resource('seller.product', App\Http\Controllers\Seller\SellerProductController::class)->except(['create', 'show']);
    Route::resource('seller.categories', App\Http\Controllers\Seller\SellerCategoryController::class)->only('index');

    /*
     * Product
     */
    Route::resource('product.transactions', \App\Http\Controllers\Product\ProductTransactionController::class)->only('index');
    Route::resource('products.categories', \App\Http\Controllers\Product\ProductCategoryController::class)->only(['index', 'update', 'destroy']);

    Route::resource('seller', SellerController::class)->only(['index', 'show']);

    Route::resource('transactions', App\Http\Controllers\Transaction\TransactionController::class)->only('index', 'show');
    Route::resource('transactions.categories', App\Http\Controllers\Transaction\TransactionCategoryController::class)->only('index');
    Route::resource('transactions.sellers', \App\Http\Controllers\Transaction\TransactionSellerController::class)->only('index');

    /*
     * User
     */
    Route::name('me')->get('users/me', [UserController::class , 'me']);
    Route::resource('users', UserController::class);
    Route::name('verify')->get('users/verify/{token}', [App\Http\Controllers\User\UserController::class, 'verify']);
    Route::name('resend')->get('users/{user}/resend', [App\Http\Controllers\User\UserController::class, 'resend']);
    Route::post('oauth/token', [ \Laravel\Passport\Http\Controllers\AccessTokenController::class, 'issueToken']);

});
