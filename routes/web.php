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

Route::get('/', function () {
    return view('welcome');
});


//Clientes
Route::get('/clientes', 'ClientesController@index');
Route::get('/clientes/criar', 'ClientesController@create');
Route::post('clientes/armazenar', 'ClientesController@store');
Route::get('/clientes/{id}', 'ClientesController@edit')->name('editarCliente');
Route::post('/clientes/atualizar', 'ClientesController@update');

//Usados
Route::get('/usados', 'ServicosController@indexUsados')->name('listarUsados');
Route::get('/usados/criar', 'ServicosController@createUsado')->name('criarUsado');
Route::get('/usados/{id}', 'ServicosController@editUsado')->name('editarUsado');

//Emplacamentos
Route::get('/emplacamentos', 'ServicosController@indexEmplacamentos')->name('listarEmplacamentos');
Route::get('/emplacamentos/criar', 'ServicosController@createEmplacamento')->name('criarEmplacamento');
Route::get('/emplacamentos/{id}', 'ServicosController@editEmplacamento')->name('editarEmplacamento');


//Salvar e atualizar ambos
Route::post('/servicos/atualizar', 'ServicosController@update');
Route::post('/servicos/armazenar', 'ServicosController@store');
Route::delete('/servicos/deletar/{servico}/{id}', 'ServicosController@destroy');




Route::get('/live_search', 'ClientesController@action')->name('live_search.action');








Route::post('/usados/filtrar', 'UsadosController@filter');
Route::post('/servicos/filtrar', 'EmplacamentosController@filter');



Route::get('/servicos/{id}', 'ServicosController@edit')->name('editarServico');
Route::delete('/servicos/remover/{id}', 'ServicosController@destroy');
Route::post('/servicos/filtrar', 'ServicosController@filter');


Route::get('/geral', 'ServicosController@index')->name('listarServicos');
















