<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\Income\IncomeController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Pricing\PricingController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::post('/register', [UserController::class, 'register']);
Route::post('/user_data', [AuthController::class, 'getUserData']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/payments', [PaymentController::class, 'getPayments']);
    Route::post('/change_user/accounts', [PaymentController::class, 'blockOrUnblockerUser']);

    Route::get('/check_user/accounts', [PaymentController::class, 'getUserAccountInfo']);

    Route::post('/incomes', [IncomeController::class, 'store']);
    Route::put('/incomes', [IncomeController::class, 'update']);
    Route::get('/incomes', [IncomeController::class, 'getIncomes']);
    Route::delete('/incomes', [IncomeController::class, 'destroy']);
    Route::get('/chartdata', [IncomeController::class, 'getChartData']);

    Route::post('/expenses', [ExpenseController::class, 'store']);
    Route::put('/expenses', [ExpenseController::class, 'update']);
    Route::get('/expenses', [ExpenseController::class, 'getExpenses']);
    Route::delete('/expenses', [ExpenseController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/pricings', [PricingController::class, 'getPricings']);

});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
