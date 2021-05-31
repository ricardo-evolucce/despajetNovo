<?php

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



//Clientes
Route::get('/clientes', 'ClientesController@index')->middleware('auth');
Route::get('/clientes/criar', 'ClientesController@create')->middleware('auth');
Route::post('clientes/armazenar', 'ClientesController@store')->middleware('auth');
Route::get('/clientes/{id}', 'ClientesController@edit')->name('editarCliente')->middleware('auth');
Route::post('/clientes/atualizar', 'ClientesController@update')->middleware('auth');

//Usados
Route::get('/usados', 'ServicosController@indexUsados')->name('listarUsados')->middleware('auth');
Route::get('/usados/criar', 'ServicosController@createUsado')->name('criarUsado')->middleware('auth');
Route::get('/usados/{id}', 'ServicosController@editUsado')->name('editarUsado')->middleware('auth');

//Emplacamentos
Route::get('/emplacamentos', 'ServicosController@indexEmplacamentos')->name('listarEmplacamentos')->middleware('auth');
Route::get('/emplacamentos/criar', 'ServicosController@createEmplacamento')->name('criarEmplacamento')->middleware('auth');
Route::get('/emplacamentos/{id}', 'ServicosController@editEmplacamento')->name('editarEmplacamento')->middleware('auth');

//Salvar, atualizar e deletar ambos
Route::post('/servicos/atualizar', 'ServicosController@update')->middleware('auth');
Route::post('/servicos/armazenar', 'ServicosController@store')->middleware('auth');
Route::delete('/servicos/deletar/{servico}/{id}', 'ServicosController@destroy')->middleware('auth');

//filtros
Route::get('/live_search', 'ClientesController@action')->name('live_search.action')->middleware('auth');
Route::post('/servicos/filterUsados', 'ServicosController@filterUsados')->middleware('auth');
Route::post('/servicos/filterEmplacamentos', 'ServicosController@filterEmplacamentos')->middleware('auth');

Route::get('/geral', 'ServicosController@index')->name('listarServicos')->middleware('auth');
Route::post('/geral/filtrar', 'ServicosController@filterGeral')->middleware('auth');

Route::get('/servicos/{id}', 'ServicosController@edit')->name('editarServico')->middleware('auth');
Route::delete('/servicos/remover/{id}', 'ServicosController@destroy')->middleware('auth');
Route::post('/servicos/filtrar', 'ServicosController@filter')->middleware('auth');

Route::post('/servicos/filtrar', 'ServicosController@filter')->middleware('auth');

Route::get('/nota-fiscal', 'NfeController@index')->name('nota-fiscal.index')->middleware('auth');
Route::any('/nota-fiscal/central-acoes', 'NfeController@centraAcoes')->middleware('auth');
Route::get('/nota-fiscal/baixar/{ids}', 'NfeController@baixar')->middleware('auth');

Route::get('/pdfRecibo/{id}', 'PdfReciboController@geraRecibo')->name('pdfRecibo');


Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/register', function() {
    return redirect('/login');
});

Route::post('/register', function() {
    return redirect('/login');
});

require __DIR__.'/auth.php';
