<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ExpenseController;

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

Route::prefix('v1')->group(function(){
    
    Route::post('login',[AuthController::class, 'Login']);
    Route::post('register',[AuthController::class, 'Register']);

    Route::group(['middleware' => 'auth:api'], function() {
        Route::apiResources([
        'members'    => MemberController::class,
        'invoices'   => InvoiceController::class,
        'expenses'   => ExpenseController::class,
       ]);

    });

    
});
