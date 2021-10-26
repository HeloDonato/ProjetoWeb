<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortariaController;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\RelatorioController;
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

Route::get('/',[PortariaController::class,'index']);
Route::get('/portarias/create',[PortariaController::class,'create']);
Route::post('/portarias',[PortariaController::class,'store']);


Route::group(['middleware' => 'auth'], function(){

    Route::group(['prefix' => 'portaria'], function(){
        Route::get('/show',  [PortariaController::class, 'index']);
        //Route::get('/delete/{id}',  [PortariaController::class, 'delete']);
        //Route::get('/edit/{id}',  [PortariaController::class, 'edit']);
        //Route::put('/edit/update/{id}',  [PortariaController::class, 'update']);
        //Route::any('/busca',  [PortariaController::class, 'search']);
        //Route::get('/create',  [PortariaController::class, 'create']);
        //Route::post('/create/novo',  [PortariaController::class, 'store']);

    });

    Route::group(['prefix' => 'servidor'], function(){
        //Route::get('/show',  [ServidorController::class, 'index']);
        //Route::get('/delete/{id}',  [ServidorController::class, 'delete']);
        //Route::get('/edit/{id}',  [ServidorController::class, 'edit']);
        //Route::put('/edit/update/{id}',  [ServidorController::class, 'update']);
        //Route::any('/busca',  [ServidorController::class, 'search']);
        //Route::get('/create',  [ServidorController::class, 'create']);
        //Route::post('/create/novo',  [ServidorController::class, 'store']);
    });

    Route::group(['prefix' => 'relatorios'], function(){
        //Route::get('/show',  [PortariaController::class, 'index']);
        //Route::any('/busca',  [ServidorController::class, 'search']);

    });


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
