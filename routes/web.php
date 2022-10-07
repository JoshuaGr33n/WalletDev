<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard.index');
Route::post('/delete-area', 'App\Http\Controllers\Admin\AreaController@destroy')->name('deletearea');
Route::resource('/area', 'App\Http\Controllers\Admin\AreaController');

Route::post('/changeStatus', 'App\Http\Controllers\Admin\AppuserController@changeStatus')->name('changeStatus');
Route::resource('/appuser', 'App\Http\Controllers\Admin\AppuserController');
Route::get('/get-all-transaction', 'App\Http\Controllers\Admin\AppuserController@getAllTransaction')->name('getAllTransaction');
Route::get('/get-all-topup', 'App\Http\Controllers\Admin\AppuserController@getAllTopup')->name('getAllTopup');
Route::get('/get-all-paid', 'App\Http\Controllers\Admin\AppuserController@getAllPaid')->name('getAllPaid');
Route::post('/get-transaction-form', 'App\Http\Controllers\Admin\AppuserController@getTransactionForm')->name('getTransactionForm');
Route::post('/add-transaction', 'App\Http\Controllers\Admin\AppuserController@addTransaction')->name('addTransaction');

Route::post('/delete-category', 'App\Http\Controllers\Admin\CategoryController@destroy')->name('deletecategory');
Route::resource('/category', 'App\Http\Controllers\Admin\CategoryController');

Route::post('/delete-subcategory', 'App\Http\Controllers\Admin\SubcategoryController@destroy')->name('deletesubcategory');
Route::resource('/subcategory', 'App\Http\Controllers\Admin\SubcategoryController');

Route::post('/delete-menu', 'App\Http\Controllers\Admin\MenuController@destroy')->name('deleteMenu');
Route::post('menu/get_subcategory', 'App\Http\Controllers\Admin\MenuController@get_subcategory')->name('getSubcategory');
Route::resource('/menu', 'App\Http\Controllers\Admin\MenuController');

Route::post('/delete-merchant', 'App\Http\Controllers\Admin\MerchantController@destroy')->name('deleteMerchant');
Route::resource('/merchant', 'App\Http\Controllers\Admin\MerchantController');

Route::post('/delete-outlet', 'App\Http\Controllers\Admin\OutletController@destroy')->name('deleteOutlet');
Route::resource('/outlet', 'App\Http\Controllers\Admin\OutletController');

Route::post('/delete-announcement', 'App\Http\Controllers\Admin\AnnouncementController@destroy')->name('deleteAnnouncement');
Route::resource('/announcement', 'App\Http\Controllers\Admin\AnnouncementController');

Route::post('/delete-user', 'App\Http\Controllers\Admin\UserController@destroy')->name('deleteuser');
Route::resource('/user', 'App\Http\Controllers\Admin\UserController');

Route::post('/delete-voucher', 'App\Http\Controllers\Admin\VoucherController@destroy')->name('deleteVoucher');
Route::resource('/vouchers', 'App\Http\Controllers\Admin\VouchersController');

Route::post('/delete-vouchertype', 'App\Http\Controllers\Admin\VouchertypeController@destroy')->name('deleteVouchertype');
Route::resource('/vouchertype', 'App\Http\Controllers\Admin\VouchertypeController');

Route::post('/delete-role', 'App\Http\Controllers\Admin\RoleController@destroy')->name('deleterole');
Route::resource('/role', 'App\Http\Controllers\Admin\RoleController');

Route::resource('/setting', 'App\Http\Controllers\Admin\SettingController');
Route::post('/updatePoints', 'App\Http\Controllers\Admin\SettingController@updatePoints')->name('updatepoints');
Route::post('/updateTopupAmt', 'App\Http\Controllers\Admin\SettingController@updateTopupAmount')->name('updatetopupamt');
Route::post('/updateMaxWalletAmt', 'App\Http\Controllers\Admin\SettingController@updateMaxWalletAmount')->name('updatemaxwalletamt');
Route::post('/updateTopupAmtOpn', 'App\Http\Controllers\Admin\SettingController@updateTopupAmountOption')->name('updatetopupamtopn');

Route::post('/delete-notification', 'App\Http\Controllers\Admin\NotificationController@destroy')->name('deletenotification');
Route::resource('/notification', 'App\Http\Controllers\Admin\NotificationController');

Route::resource('/outletReport', 'App\Http\Controllers\Admin\OutletReportController');
Route::get('/get-outlet-transaction', 'App\Http\Controllers\Admin\OutletReportController@getAllTransaction')->name('getOutletTransaction');
Route::get('/get-outlet-topup', 'App\Http\Controllers\Admin\OutletReportController@getAllTopup')->name('getOutletTopup');
Route::get('/get-outlet-paid', 'App\Http\Controllers\Admin\OutletReportController@getAllPaid')->name('getOutletPaid');

Route::resource('/adminSettlement', 'App\Http\Controllers\Admin\SettlementController');
Route::get('/get-settlement-transaction', 'App\Http\Controllers\Admin\SettlementController@getAllSettlement')->name('getSettlementTransaction');
Route::post('/check-password-form', 'App\Http\Controllers\Admin\SettlementController@geVerifyPasswordForm')->name('getVerifyPasswordForm');
Route::post('/verify-password', 'App\Http\Controllers\Admin\SettlementController@verifyPassword')->name('verifyPassword');

Route::get('/firebase_sdk','FirebaseController@index')->name('firebase_sdk');
Route::get('/insert','FirebaseController@insert')->name('insert');
Route::get('/update','FirebaseController@update')->name('update');
Route::get('/delete','FirebaseController@delete')->name('delete');

Route::get('/validate_qr_code', 'App\Http\Controllers\Cron\QrvalidateController@couponValidate');
//Route::get('/resetpassword', 'App\Http\Controllers\Admin\ResetPasswordController@index')->name('resetpassword');




Route::get('db', function () {

    $user = User::create([
        'first_name' => "Admin",
        'last_name' => "John",
        'full_name' => "Admin John",
        'gender' => "M",
        'user_name' => "Admin",
        'role' => 'ADMIN',
        'dob' => "1912-02-13",
        'postal_code' => "10006",
        'country_code' => "+13",
        'phone_number' => "88888888809",
        'referral_code' => "",
        'email' => "admin@walletapp.com",
        'password' => Hash::make('admin'),
        'registered_date' => Carbon::now()->format('Y-m-d'),
        'user_unique_id' => "",
        'member_id' => ""
    ]);

});
