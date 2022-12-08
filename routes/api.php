<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BankController;
use App\Http\Controllers\Api\PayerController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)
    ->prefix('auth')
    ->as('auth.')
    ->group(function () {
        Route::post('login', 'store')->name('login');
        Route::delete('logout', 'destroy')->middleware('auth')->name('logout');
    });

Route::controller(UserController::class)
    ->prefix('user')
    ->as('user.')
    ->group(function () {
        Route::get('/', 'index')->middleware('auth')->name('profile');
        Route::post('/', 'store')->name('register');
        Route::put('/', 'update')->middleware('auth')->name('update');
        Route::delete('/', 'destroy')->middleware('auth')->name('delete');
    });

Route::controller(BankController::class)
    ->prefix('bank')
    ->middleware('auth')
    ->as('bank.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::prefix('{id}')->group(function () {
            Route::put('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('delete');
            Route::get('/', 'show')->name('show');
        });
    });

Route::controller(PayerController::class)
    ->prefix('payer')
    ->middleware('auth')
    ->as('payer.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::prefix('{id}')->group(function () {
            Route::put('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('delete');
            Route::get('/', 'show')->name('show');
        });
    });

Route::controller(TransactionController::class)
    ->prefix('transaction')
    ->middleware('auth')
    ->as('transaction.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::prefix('{id}')->group(function () {
            Route::put('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('delete');
            Route::get('/', 'show')->name('show');
        });
    });
