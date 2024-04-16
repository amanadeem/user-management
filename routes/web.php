<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TwilioSMSController;

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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/users', [UserController::class,'index']);
Route::post('/user/create', [UserController::class,'store']);
Route::get('/user/get/{user}', [UserController::class,'get']);
Route::post('/user/update', [UserController::class,'update']);
Route::get('/user/delete/{user}', [UserController::class,'delete']);
Route::get('sms-template', [TwilioSMSController::class, 'index']);
Route::post('/send/sms', [TwilioSMSController::class,'sendCustomMessage']);
