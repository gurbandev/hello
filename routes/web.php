<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::controller(RegisteredUserController::class)
    ->middleware('guest')
    ->group(function (){
       Route::get('register', 'create')->name('register');
       Route::post('register', 'store');
    });

Route::controller(AuthenticatedSessionController::class)
    ->middleware('guest')
    ->group(function (){
       Route::get('login', 'create')->name('login');
       Route::post('login', 'store');
    });

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')->name('logout');

Route::get('/', [CategoryController::class, 'index'])->name('home');


Route::controller(ProductController::class)
    ->prefix('/products')
    ->name('products.')
    ->group(function(){
       Route::get('/{id}', 'show')->name('show')->where('id', '[0-9]+');
       Route::middleware('auth')
           ->prefix('/auth')
           ->group(function (){
              Route::get('/create', 'create')->name('create');
              Route::post('', 'store')->name('store');
              Route::get('/edit/{id}', 'edit')->name('edit')->where('id', '[0-9]+');
              Route::put('/{id}', 'update')->name('update')->where('id', '[0-9]+');
              Route::delete('/{id}', 'delete')->name('delete')->where('id', '[0-9]+');
           });
    });

Route::controller(CategoryController::class)
    ->name('categories.')
    ->prefix('/categories')
    ->group(function (){
        Route::get('/{id}', 'show')->name('show')->where('id', '[0-9]+');
        Route::middleware('auth')
            ->prefix('/auth')
            ->group(function (){
                Route::get('/create', 'create')->name('create');
                Route::post('', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit')->where('id', '[0-9]+');
                Route::put('/{id}', 'update')->name('update')->where('id', '[0-9]+');
                Route::delete('/{id}', 'delete')->name('delete')->where('id', '[0-9]+');
            });
    });
