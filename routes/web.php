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

Route::group(['middleware' => 'auth'], function(){

    Route::group(['prefix' => 'portaria'], function(){
        Route::get('/show/{id}',[PortariaController::class, 'show'])->name('portaria.show');
        Route::get('/myportarias',[PortariaController::class,'myportarias'])->name('portaria.myportarias');
        Route::get('/dowload/{doc}',[PortariaController::class,'download'])->name('portaria.download');
        Route::get('/view/{doc}',[PortariaController::class,'view'])->name('portaria.view');
        Route::get('/search',[PortariaController::class,'search'])->name('portaria.search');
    });

    Route::group(['middleware' => 'admin'], function(){
        Route::group(['prefix' => 'admin/portaria'], function(){
            Route::get('/destroy/{id}', [PortariaController::class, 'destroy'])->name('portaria.destroy');
            Route::get('/edit/{id}',  [PortariaController::class, 'edit'])->name('portaria.edit');
            Route::put('/update/{id}',  [PortariaController::class, 'update'])->name('portaria.update');
            Route::get('/create',  [PortariaController::class, 'create'])->name('portaria.create');
            Route::post('/store',  [PortariaController::class, 'store'])->name('portaria.store');
        });
    
        Route::group(['prefix' => 'servidor'], function(){
            Route::get('/show',  [ServidorController::class, 'index'])->name('servidor.show');
            Route::get('/delete/{id}',  [ServidorController::class, 'destroy'])->name('servidor.destroy');
            Route::get('/edit/{id}',  [ServidorController::class, 'edit'])->name('servidor.edit');
            Route::put('/update/{id}',  [ServidorController::class, 'update'])->name('servidor.update');
            //Route::any('/busca',  [ServidorController::class, 'search']);
            Route::get('/create',  [ServidorController::class, 'create'])->name('servidor.create');
            Route::post('/create/novo',  [ServidorController::class, 'store'])->name('servidor.store');
        });
    
        Route::group(['prefix' => 'relatorios'], function(){
            //Route::get('/show',  [PortariaController::class, 'index']);
            //Route::any('/busca',  [ServidorController::class, 'search']);
    
        });
        Route::group(['middleware' => 'super'], function(){ 
            Route::group(['prefix' => 'super'], function(){
                Route::put('/update/{id}',  [ServidorController::class, 'alterarGrupo'])->name('grupo.update');
            });
        });
    });
});
