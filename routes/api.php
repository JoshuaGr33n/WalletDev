<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Public routes
Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::get('/list_areas', 'App\Http\Controllers\API\AreaController@listAreas')->name('api.listareas');

Route::get('/get_categories', 'App\Http\Controllers\API\CategoryController@listCategories')->name('api.listcategories');

Route::get('/get_menu_list', 'App\Http\Controllers\API\MenuController@listMenus')->name('api.listmenus');

Route::get('/get_outlet_list', 'App\Http\Controllers\API\OutletController@listOutlets')->name('api.listoutlets');

Route::get('/check_qr_status', 'App\Http\Controllers\API\CouponcodeController@checkQRStatus')->name('api.checkqrstatus');

Route::post('/get_userinfo_by_qrcode', 'App\Http\Controllers\API\CouponcodeController@getUserInfoByQrcode');

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/resend-otp', [AuthController::class, 'resendOTP']);
    
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
    
    Route::get('/get-profile', [AuthController::class, 'getProfile']);
    
    Route::post('/update-user', [AuthController::class, 'updateUser']);
    
    Route::post('/set-pin', [AuthController::class, 'setPIN']);
    
    Route::post('/forgot-pin', [AuthController::class, 'forgotPIN']);
    
    Route::post('/reset-pin', [AuthController::class, 'resetPIN']);
    
    Route::post('/change-pin', [AuthController::class, 'changePIN']);

    Route::post('/profilepic-upload', [AuthController::class, 'profilepicUpload']);

    Route::post('/logout', [AuthController::class, 'logout']);

    // user profile
    Route::get('/get-total-reward-point', 'App\Http\Controllers\API\ProfileController@getUserTotalRewardPoints');
    Route::get('/get-reward-history', 'App\Http\Controllers\API\ProfileController@getUserRewardHistory');
    Route::get('/get-wallet-balance', 'App\Http\Controllers\API\ProfileController@getUserWalletBalance');
    Route::post('/add-credit-to-wallet', 'App\Http\Controllers\API\ProfileController@addCreditToWallet');

    //POS SYSTEM
    Route::get('/generate_qr_code', 'App\Http\Controllers\API\CouponcodeController@getCoupon');

    Route::post('/set_transaction_pin', 'App\Http\Controllers\API\TransactionController@setTransactionPin');
    Route::get('/check_transaction_pin', 'App\Http\Controllers\API\TransactionController@checkTransactionPin');

    Route::get('/get_user_notification', 'App\Http\Controllers\API\CommonController@getUserNotification');

    // Transactions
    Route::post('/top_up', 'App\Http\Controllers\API\CouponcodeController@topUp');
    Route::post('/pay_amount', 'App\Http\Controllers\API\CouponcodeController@payAmount');
    Route::get('/get_transaction_list', 'App\Http\Controllers\API\CouponcodeController@listTransactions');
    Route::post('/add_transaction', 'App\Http\Controllers\API\CouponcodeController@addTransaction');

    // Vouchers
    Route::post('/redeem_voucher', 'App\Http\Controllers\API\CouponcodeController@redeemVoucher');
    Route::post('/cancel_voucher', 'App\Http\Controllers\API\CouponcodeController@cancelVoucher');
    Route::get('/get_voucher_list', 'App\Http\Controllers\API\VoucherController@listVouchers');
    Route::post('/redeem_vouchers', 'App\Http\Controllers\API\VoucherController@redeemVouchers');
    Route::get('/get_redeemed_voucher_list', 'App\Http\Controllers\API\VoucherController@getRedeemedVouchers');

     // Bills
     Route::post('/pay-bill', 'App\Http\Controllers\API\BillController@payBill');
});