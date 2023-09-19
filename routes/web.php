<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user/list', [UserController::class, 'list'])->name('user.list')
    ->middleware('can:user read');
    Route::view('role/list', 'role.list')->name('role.list')
    ->middleware('can:role read');
    Route::view('seller/list', 'seller.list')->name('seller.list')
    ->middleware('can:seller read');
    Route::view('client/list', 'client.list')->name('client.list')
    ->middleware('can:client read');
});


