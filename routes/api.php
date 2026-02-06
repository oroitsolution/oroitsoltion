<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Payin\PayinController;
use App\Http\Controllers\Api\Payin\PayinresponseController;
use App\Http\Controllers\Api\Payout\PayoutController;
use App\Http\Controllers\Api\Payout\PayoutresponseController;


Route::post('/payin/response/data',  [PayinresponseController::class, 'payinresponse']);
Route::post('/payout/response/data', [PayoutresponseController::class, 'payoutresponse']);

Route::middleware('header_auth')->group(function () {
    Route::post('/payin/data',  [PayinController::class, 'payindata']);
    Route::post('/payout/data', [PayoutController::class, 'payoutdata']);
    // Created By AMAN
    Route::post('/payout/v1/check-status', [PayoutController::class, 'check_status']);
    Route::get('/payout/v2/check-status/{orderId}', [PayoutController::class, 'checkStatus']);
    
});