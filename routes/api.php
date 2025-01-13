<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/updateProfile',[CustomerController::class,'updateUserProfile'])->middleware('auth:sanctum');
Route::post('/register',[CustomerController::class,'registerUser']);
Route::post('/login',[CustomerController::class,'loginUser']);
Route::post('/logout',[CustomerController::class,'logoutUser']);
Route::get('/merchants',[CustomerController::class,'getMerchants'])->middleware('auth:sanctum');
Route::get('/routeCount/{id}',[CustomerController::class,'getRouteCount'])->middleware('auth:sanctum');
Route::get('/routes/{id}',[CustomerController::class,'getMerchantRoutes'])->middleware('auth:sanctum');
Route::get('/busCount/{id}',[CustomerController::class,'getBusCount'])->middleware('auth:sanctum');
Route::get('/buses/{id}',[CustomerController::class,'getMerchantBuses'])->middleware('auth:sanctum');

Route::post('/deposit',[TransactionController::class,'makeDeposit'])->middleware('auth:sanctum');
Route::post('/transfer',[TransactionController::class,'makeTransfer'])->middleware('auth:sanctum');
Route::get('/getbalance',[TransactionController::class,'getBalance'])->middleware('auth:sanctum');
Route::get('/transactionHistory',[TransactionController::class,'getHistory'])->middleware('auth:sanctum'); 

