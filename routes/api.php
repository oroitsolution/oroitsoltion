<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Payin\PayinController;




Route::middleware('header_auth')->group(function () {
    
Route::get('/payin/data', [PayinController::class, 'payindata']);

});