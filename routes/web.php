<?php

use App\Http\Controllers\BusInfoController;
use App\Http\Controllers\BusRouteController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('admin/dashboard',[UserTypeController::class,'index'])->name('admin.dashboard');
    Route::get('admin/merchantList',[MerchantController::class,'show'])->name('admin.showMerchants');
    Route::get('admin/routeList',[BusRouteController::class,'show'])->name('admin.showBusRoutes');
    Route::post('admin/addBusRoute',[BusRouteController::class,'store']);
    Route::get('admin/deleteBusRoute/{id}',[BusRouteController::class, 'destroy']);
    Route::get('admin/busList',[BusInfoController::class,'show'])->name('admin.showBuses');
    Route::post('admin/addBusInfo',[BusInfoController::class,'store']);
    Route::get('admin/deleteBusInfo/{id}',[BusInfoController::class, 'destroy']);
});

Route::middleware(['auth','role:merchant'])->group(function () {
    Route::get('merchant/dashboard',[MerchantController::class,'index'])->name('merchant.dashboard');
    Route::get('merchant/busRouteList/{phone}',[BusRouteController::class,'showMerchantRoutes'])->name('merchant.showBusRoutes');
    Route::get('merchant/busList/{phone}',[BusInfoController::class,'showMerchantBuses'])->name('merchant.showBuses');
    Route::get('merchant/transDetails/{id}',[MerchantController::class,'displayTransDetails'])->name('merchant.transDetails');
    Route::get('merchant/transSummary/{id}',[MerchantController::class,'displayTransSummary'])->name('merchant.transSummary');
});