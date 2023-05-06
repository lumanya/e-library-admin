<?php

 use App\Http\Controllers\HomeController;
 use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\Admin\SettingController; 
 use App\Http\Controllers\Admin\CategoryController;
 use App\Http\Controllers\Admin\SubCategoryController;
 use App\Http\Controllers\Admin\AuthorController;
 use App\Http\Controllers\Admin\MobileSliderController;
 use App\Http\Controllers\Admin\BookController;
 use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\Admin\SubscriberController;
 use App\Http\Controllers\Admin\TransactionController;


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
Route::get('/storage-link', function ()
 {
    Artisan::call('storage:link');
});

Route::post('/check-environment',[HomeController::class,'checkEnvironment'])->name('check.environment');
Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified','xss']], function()
{
    
    Route::get('/', [HomeController::class,'index'])->name('home');

    Route::get('/test',function (){
        return view('auth.verify');
    });
});
Route::group([ 'prefix' => 'admin', 'middleware' => ['auth','xss']], function () {

     //Category Routes
    Route::resource('category', CategoryController::class);
    Route::get('category/edit/{id}', [CategoryController::class,'create'])->name('category.edit');
    Route::get('category-list', [CategoryController::class,'list'])->name('category.list');
    Route::delete('category/destroy/{id}',[CategoryController::class,'destroy'])->name('category.destroy');

    //Subcategory routes
    Route::get('subcategory/dropdown', [SubCategoryController::class,'getsubCategoryList'])->name('subcategory.dropdown');
    Route::resource('subcategory',SubCategoryController::class);
    Route::get('subcategory-list',[SubCategoryController::class,'list'])->name('subcategory.list');
    Route::get('subcategory/edit/{id}',[SubCategoryController::class,'create'])->name('subcategory.edit');
    Route::delete('subcategory/destroy/{id}',[SubCategoryController::class,'destroy'])->name('subcategory.destroy');

    //Author Routes
    Route::resource('author',AuthorController::class);
    Route::get('author-list/{type?}',[AuthorController::class,'dataList'])->name('dataList');
    Route::get('author-list/edit/{id}',[AuthorController::class,'create'])->name('author.edit');
    Route::get('author-view/{id}',[AuthorController::class,'show'])->name('author.show');
    Route::delete('author/destroy/{id}',[AuthorController::class,'destroy'])->name('author.destroy');

     //Mobile slider
    Route::resource('mobileslider', MobileSliderController::class);
    Route::get('mobileslider-list', [MobileSliderController::class,'list'])->name('mobileslider.list');
    Route::get('mobileslider/edit/{id}', [MobileSliderController::class,'create'])->name('mobileslider.edit');
    Route::get('mobileslider/destroy/{id}', [MobileSliderController::class,'destroy'])->name('mobileslider.destroy');

    //Book routes
    Route::resource('book', BookController::class);
    Route::get('book-edit/{id?}',[BookController::class,'create'])->name('book.update');    
    Route::get('book-list/{type?}',[BookController::class,'bookList'])->name('book.list');
     Route::get('book-view/{id}',[BookController::class,'view'])->name('book.view');
    Route::get('book-destroy/{id}',[BookController::class,'destroy'])->name('book.delete');
    Route::post('book-action',[BookController::class,'bookActions'])->name('book.actions');
    Route::get('book-removefile/{id}/{type}',[BookController::class,'trash'])->name('book.removefile');

    // Setting Controller
    Route::get('privacy-policy',[SettingController::class,'privacyPolicy'])->name('privacy-policy');
    Route::post('privacy-policy-save',[SettingController::class,'savePrivacyPolicy'])->name('privacy-policy-save');
    Route::get('term-condition',[SettingController::class,'termAndCondition'])->name('term-condition');
    Route::post('term-condition-save',[SettingController::class,'saveTermAndCondition'])->name('term-condition-save');

   // Feedback Routes
    Route::get('users/feedback',[UserController::class,'userFeedback'])->name('users_feedback');
   Route::get('users/feedback/datalist',[UserController::class,'userFeedbackDataList'])->name('users_feedback.list');

    // Subscriber Routes
    // Route::resource('subscriber',SubscriberController::class);
    // Route::get('subscriber-list', [SubscriberController::class,'list'])->name('subscriber.list');
    // Route::get('subscriber-destroy/{id}',[SubscriberController::class,'destroy'])->name('subscriber.delete');

     // Sales Routes

    Route::get('/transactions/list/{id?}/{record?}',[TransactionController::class,'list'])->name('transactions.list');
    Route::resource('transactions',TransactionController::class);
    Route::get('update-payment-status/{id}/{status}',[TransactionController::class,'updatePaymentStatus'])->name('transactions_update.payment_status');

   // User Details
    Route::resource('users',UserController::class);
    Route::get('user-list',[UserController::class,'list'])->name('user.list');

    Route::get('user-delete/{id}',[UserController::class,'destroy'])->name('user.delete');

    Route::post('/password/upadte', [UserController::class,'passwordUpadte'])->name('user.password.update');
    Route::post('/profile/save', [UserController::class,'updateUpdate'])->name('user.update');

     // Settings Route
    Route::get('settings', [SettingController::class,'settings'])->name('admin.settings');
    Route::post('/layout-page',[SettingController::class,'layoutPage'])->name('layout_page');
    Route::post('settings/save',[SettingController::class,'settingsUpdates'])->name('settingsUpdates');
    Route::post('contact-us', [SettingController::class,'contactus_settings'])->name('contactus_settings');
    Route::post('env-setting', [SettingController::class,'envSetting'])->name('envSetting');
    Route::get('mobile-app',[SettingController::class,'getMobileSetting'])->name('mobile_app.config');
    Route::post('mobile-app/save',[SettingController::class,'saveMobileSetting'])->name('mobile_app.config.save');

    


 });
