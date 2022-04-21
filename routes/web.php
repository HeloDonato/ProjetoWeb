<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortariaController;
use App\Http\Controllers\ServidorController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;


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
    return redirect()->route('welcome');
});

Auth::routes([
    'register' => false,
]);



Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::group(['prefix' => 'portaria'], function(){
    Route::get('/',[PortariaController::class,'index'])->name('welcome');
    Route::get('/dowload/{id}',[PortariaController::class,'download'])->name('portaria.download');
    Route::get('/view/{id}/pdf/doc',[PortariaController::class,'view'])->name('portaria.view');
    Route::any('/search',[PortariaController::class,'search'])->name('portaria.search');
    Route::get('/show/portariasServidores/{id}',  [PortariaController::class, 'portariasServidor'])->name('servidor.portarias');
    Route::get('/show/alunosPortarias/{id}',  [PortariaController::class, 'portariasAlunos'])->name('aluno.portarias');
});

Route::group(['prefix' => 'servidor'], function(){
    Route::get('/show',  [ServidorController::class, 'index'])->name('servidor.show');
    Route::any('/search',[ServidorController::class,'search'])->name('servidor.search');
});

Route::group(['prefix' => 'aluno'], function(){
    Route::get('/show',  [AlunoController::class, 'index'])->name('aluno.show');
    Route::any('/search',[AlunoController::class,'search'])->name('aluno.search');
});

Route::group(['middleware' => 'auth'], function(){

    Route::group(['prefix' => 'portaria'], function(){
        Route::get('/myportarias',[PortariaController::class,'myportarias'])->name('portaria.myportarias');
    });
    
    Route::group(['prefix' => 'usuario'], function(){
        Route::get('/profile/{id}',  [UserController::class, 'editProfile'])->name('usuario.editProfile');
        Route::put('/profile/edit/{id}',  [UserController::class, 'updateProfile'])->name('usuario.updateProfile');
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
            Route::get('/delete/{id}',  [ServidorController::class, 'destroy'])->name('servidor.destroy');
            Route::get('/edit/{id}',  [ServidorController::class, 'edit'])->name('servidor.edit');
            Route::put('/update/{id}',  [ServidorController::class, 'update'])->name('servidor.update');
            //Route::any('/busca',  [ServidorController::class, 'search']);
            Route::get('/create',  [ServidorController::class, 'create'])->name('servidor.create');
            Route::post('/create/novo',  [ServidorController::class, 'store'])->name('servidor.store');
        });

        Route::group(['prefix' => 'aluno'], function(){
            Route::get('/delete/{id}',  [AlunoController::class, 'destroy'])->name('aluno.destroy');
            Route::get('/edit/{id}',    [AlunoController::class, 'edit'])->name('aluno.edit');
            Route::put('/update/{id}',  [AlunoController::class, 'update'])->name('aluno.update');
            //Route::any('/busca',  [ServidorController::class, 'search']);
            Route::get('/create',       [AlunoController::class, 'create'])->name('aluno.create');
            Route::post('/create/novo', [AlunoController::class, 'store'])->name('aluno.store');
        });
    
        Route::group(['prefix' => 'relatorios'], function(){
            Route::get('/options',  [RelatorioController::class, 'index'])->name('relatorios.options');
            Route::get('/ranking',  [RelatorioController::class, 'rankingServidores'])->name('relatorios.ranking');
            Route::get('/rankingAlunos',  [RelatorioController::class, 'rankingAlunos'])->name('relatorios.rankingA');
            Route::get('/relatorioGeral',  [RelatorioController::class, 'relatorioGeral'])->name('relatorios.relatorioGeral');
            Route::post('/individual',  [RelatorioController::class, 'servidorIndividual'])->name('relatorios.individual');
            //Route::any('/busca',  [ServidorController::class, 'search']);
    
        });

        Route::group(['middleware' => 'super'], function(){ 
            Route::group(['prefix' => 'super'], function(){
                Route::put('/update/{id}',  [UserController::class, 'alterarGrupo'])->name('grupo.update');
                Route::post('/create',  [AlunoController::class, 'adicionarCurso'])->name('curso.store');
            });
        });
    });
});
