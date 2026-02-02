<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\user\payment\PaymentController;
use App\Http\Controllers\user\UserdashboardController;
use App\Http\Controllers\user\kyc\UserkycController;
use App\Http\Controllers\user\Payin\UserPayinController;
use App\Http\Controllers\admin\charges\ChargesController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Permission\RoleController;
use App\Http\Controllers\admin\payment\AdminPaymentController;
use App\Http\Controllers\admin\Payout\PayoutController;
use App\Http\Controllers\admin\Payin\PayinController;
use App\Http\Controllers\admin\Kyc\KycdataController;

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::get('/dashboard', function () {
  //  return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');


// For Test MAIL OTP IS SENDING OR NOT
// Route::get('/test-mail', function () {
//     try {

//         $otp = rand(100000, 999999);

//         Mail::raw("Your OTP is: $otp", function ($message) {
//             $message->to('amanmalviya7701@gmail.com')
//                     ->subject('Your OTP Verification Code');
//         });

//         return response()->json([
//             'status' => true,
//             'message' => 'OTP sent successfully!'
//         ]);

//     } catch (\Exception $e) {

//         return response()->json([
//             'status' => false,
//             'message' => 'Failed to send OTP',
//             'error' => $e->getMessage() // remove in production
//         ], 500);
//     }
// });



Route::get('/', [FrontController::class, 'index'])->name('/');

Route::get('/software', [FrontController::class, 'software'])->name('front.software');

Route::get('/privacy-policy', [FrontController::class, 'ppc'])->name('front.ppc');
Route::get('/about-us', [FrontController::class, 'aboutus'])->name('front.aboutus');
Route::get('/terms-condition', [FrontController::class, 'term_condition'])->name('front.tnc');
Route::get('/cancellation-refund-policy', [FrontController::class, 'cancel_refundpolicy'])->name('front.crp');
Route::get('/contact-us', [FrontController::class, 'contact_us'])->name('front.contactus');
Route::post('/contact', [FrontController::class, 'contactstore'])->name('contact.store');


Route::post('/payin/status', [PayinController::class, 'payinstatus'])->name('payin.status');


 Route::middleware('auth')->group(function () 
  {
  
    Route::middleware('superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {

          Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
          Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
          Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
          Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');
          Route::get('/contact',    [DashboardController::class, 'contact'])->name('contact');
          
        //Permission Route
          Route::get('/permissions',           [PermissionController::class, 'index'])->name('permissions.index');
          Route::get('/permissions/create',    [PermissionController::class, 'create'])->name('permissions.create');
          Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
          Route::post('/permissions',          [PermissionController::class, 'store'])->name('permissions.store');
          Route::post('/permissions/{id}',     [PermissionController::class, 'update'])->name('permissions.update');
          Route::delete('/permissions',        [PermissionController::class, 'destroy'])->name('permissions.destroy');
        //end

        //Role Route
          Route::get('/roles',        [RoleController::class, 'index'])->name('roles.index');
          Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
          Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
          Route::post('/roles',       [RoleController::class, 'store'])->name('roles.store');
          Route::post('/roles/{id}',  [RoleController::class, 'update'])->name('roles.update');
          Route::delete('/roles',     [RoleController::class, 'destroy'])->name('roles.destroy');
        //end
        
        
        //User Route
        Route::get('/users',           [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/{id}',     [UserController::class, 'update'])->name('users.update');
        Route::get('/usersenter/{id}', [UserController::class, 'enter'])->name('users.enter');
        Route::get('/back-to-admin',   [UserController::class, 'backToAdmin'])->name('back.to.admin');
        // end
        
        
        Route::get('/charges/list/{id}', [ChargesController::class, 'getUserCharges']);
        Route::resource('charges',        ChargesController::class);
        Route::get('/payment',           [AdminPaymentController::class, 'index'])->name('payment');


        Route::get('/payout',           [PayoutController::class, 'index'])->name('payout.index');
        Route::get('/payout/refund',    [PayoutController::class, 'refund'])->name('payout.refund');


        Route::get('/payin',            [PayinController::class, 'payindata'])->name('payin.index');
        Route::get('/settlement',       [PayinController::class, 'settlementdata'])->name('settlement.index');
        Route::post('/settle/request/withdraw', [PayinController::class, 'settleapproved'])->name('settle.withdraw');
        Route::get('/get-settlement-users', [PayinController::class, 'getUsersForSettlement'])->name('get.settelmentdata');
        Route::get('/freeze-amount',    [AdminPaymentController::class, 'freezeamount'])->name('freeze.index');
        Route::post('/freeze-store',    [AdminPaymentController::class, 'store'])->name('freeze.store');
        Route::put('/freeze-update/{id}', [AdminPaymentController::class, 'update'])->name('freezeamount.update');

        Route::delete('/freeze-store/{id}', [AdminPaymentController::class, 'destroy'])->name('freezeamount.destroy');


        

        Route::get('/get-kyc-users', [KycdataController::class, 'getkycdata'])->name('kyc.data');
        
        Route::post('/kyc/status/{id}', [KycdataController::class, 'updateStatus'])->name('kyc.status');


      });




      // ----------------------------------------------------------------//








      Route::middleware('user')->prefix('user')->name('user.')->group(function ()
      {
          Route::get('/dashboard',  [UserdashboardController::class, 'index'])->name('dashboard');
          Route::get('/payment-send',  [PaymentController::class, 'index'])->name('payment.send');
          Route::get('/get-bank-details', [PaymentController::class, 'getbankdata'])->name('get.bankdetail');
          Route::post('/payment-request-send', [PaymentController::class, 'sendpayment'])->name('payment.request.send');
          Route::get('/payment-show', [PaymentController::class, 'show'])->name('payment.show');
          // View Profile Route - By AMAN 
          Route::get('/profile-show', [UserdashboardController::class, 'view_profile'])->name('view.profile');
          Route::post('/regenerate-secret-key', [UserdashboardController::class, 'regenerateSecret'])->name('regenerate.secret');
          Route::post('/change-password', [UserdashboardController::class, 'changePassword'])->name('change.password');
          Route::post('/update-settings', [UserdashboardController::class, 'update_settings'])->name('client.settings.update');
          Route::post('/additional-bank-data', [UserdashboardController::class, 'additional_data'])->name('additional.bank.store');
          // View KYC Route - By AMAN
          Route::get('/kyc/user/form', [UserkycController::class, 'view_kycForm'])->name('view.kyc.form');
          Route::post('/kyc-request-send', [UserkycController::class, 'store_kyc'])->name('kyc.store');
          Route::post('/kyc-send-otp', [UserkycController::class, 'send_otp'])->name('kyc.sendOtp');
          Route::post('/kyc-verify-otp', [UserkycController::class, 'verify_otp'])->name('kyc.verifyOtp');

          Route::get('/payin/data', [UserPayinController::class, 'userpayindata'])->name('payin.data');
          


      });
  });

  require __DIR__.'/auth.php';

