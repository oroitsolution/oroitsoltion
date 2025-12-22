<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\user\payment\PaymentController;
use App\Http\Controllers\user\UserdashboardController;
use App\Http\Controllers\admin\charges\ChargesController;
use App\Http\Controllers\Permission\PermissionController;
use App\Http\Controllers\Permission\RoleController;

// Route::get('/', function () {
//     return view('welcome');
// });

//Route::get('/dashboard', function () {
  //  return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

 Route::get('/', [FrontController::class, 'index'])->name('/');



 Route::middleware('auth')->group(function () 
  {
    Route::middleware('superadmin')->prefix('superadmin')->group(function () 
      {

          Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
          Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
          Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
          Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
          Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');
          
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
        // end

          Route::get('/charges/list/{id}', [ChargesController::class, 'getUserCharges']);
          Route::resource('charges',        ChargesController::class);

      });

      Route::middleware('user')->prefix('user')->group(function ()
      {
          Route::get('/dashboard',  [UserdashboardController::class, 'index'])->name('user.dashboard');
          Route::get('/payment-send',  [PaymentController::class, 'index'])->name('payment.send');
          Route::get('/get-bank-details', [PaymentController::class, 'getbankdata'])->name('get.bankdetail');
          Route::post('/payment-request-send', [PaymentController::class, 'sendpayment'])->name('payment.request.send');
          Route::get('/payment-show', [PaymentController::class, 'show'])->name('payment.show');
          
      });
  });

  require __DIR__.'/auth.php';
