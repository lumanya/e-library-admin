<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[API\User\UserController::class,'register']);
Route::post('login',[API\User\UserController::class,'login']);

Route::get('dashboard-detail',[API\Dashboard\DashboardController::class,'getDashboardDetail']);

Route::get('book-list',[API\Book\BookController::class,'getBookList']);
Route::get('author-book-list',[API\Book\BookController::class,'getBookAuthorWise']);
Route::post('book-detail',[API\Book\BookController::class,'getBookDetail']);
Route::get('author-list',[API\Author\AuthorController::class,'getAuthorList']);

Route::post('book-rating-list',[API\Book\BookController::class,'getBookRating']);

// Category Subcategory and author
Route::get('category-list',[API\Category\CategoryController::class,'getCategoryList']);
Route::post('sub-category-list',[API\SubCategory\SubCategoryController::class,'getSubCategoryList']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    //Book
    Route::post('update-book-rating',[API\Book\BookController::class,'updateBookRating']);
    Route::post('add-book-rating',[API\Book\BookController::class,'addBookRating']);

    Route::get('user-wishlist-book',[API\Book\BookController::class,'getUserWishlistBook']);
    Route::post('add-remove-wishlist-book',[API\Book\BookController::class,'addRemoveWishlistBook']);
    Route::post('delete-book-rating',[API\Book\BookController::class,'deleteBookRating']);

    //Cart
    Route::post('add-to-cart',[API\Cart\CartController::class,'addToCart']);
    Route::post('remove-from-cart',[API\Cart\CartController::class,'removeFromCart']);
    Route::get('user-cart',[API\Cart\CartController::class,'getUserCart']);


    // Transaction
    Route::post('generate-check-sum',[API\Transaction\TransactionController::class,'checkSumGenerator']);
    Route::post('save-transaction',[API\Transaction\TransactionController::class,'saveTransaction']);
    Route::get('get-transaction-history',[API\Transaction\TransactionController::class,'getTransactionDetail']);
    Route::get('user-purchase-book',[API\Transaction\TransactionController::class,'getUserPurchaseBookList']);
    
    Route::get('generate-client-token',[API\Transaction\TransactionController::class,'generateClientToken']);
    Route::post('braintree-payment-process',[API\Transaction\TransactionController::class,'braintreePaymentProcess']);

    //Change Password
    Route::post('change-password',[API\Password\PasswordController::class,'changePassword']);
    Route::post('save-user-profile',[API\User\UserController::class,'updateUserProfile']);

    //Logout
    Route::post('logout',[API\User\UserController::class,'logout']);
});

Route::post('add-feedback',[API\User\UserController::class,'saveFeedback']);
Route::post('forgot-password',[API\Password\PasswordController::class,'forgotPassword']);
Route::post('verify-token',[API\Password\PasswordController::class,'VerificationOTPCheck']);
Route::post('resend-otp',[API\Password\PasswordController::class,'ResendOTP']);
Route::post('update-password',[API\Password\PasswordController::class,'updatePassword']); 