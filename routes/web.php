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


Route::get('/clientes', 'ClientesController@index');
Route::get('/clientes/cadastrar', 'ClientesController@create');
Route::post('clientes/cadastrar', 'ClientesController@store');
Route::get('/clientes/{id}', 'ClientesController@edit')->name('editarCliente');
Route::post('/clientes/atualizar', 'ClientesController@update');


Route::get('/usados', 'UsadosController@index')->name('listarUsados');
Route::get('/usados/cadastrar', 'UsadosController@create');
Route::post('usados/cadastrar', 'UsadosController@store');
Route::post('usados/pesquisar', 'UsadosController@search');
Route::post('usados/atualizar', 'UsadosController@update');
Route::delete('/usados/remover/{id}', 'UsadosController@destroy');

Route::get('/live_search', 'UsadosController@action')->name('live_search.action');
Route::post('/usados/filtrar', 'UsadosController@filter');
Route::get('/usados/{id}', 'UsadosController@edit')->name('editarServico');



Route::get('/emplacamentos', 'EmplacamentosController@index')->name('listarEmplacamentos');
Route::get('emplacamentos/cadastrar', 'EmplacamentosController@create');
Route::post('emplacamentos/cadastrar', 'EmplacamentosController@store');
Route::post('/emplacamentos/atualizar', 'EmplacamentosController@update');
Route::get('/emplacamentos/{id}', 'EmplacamentosController@edit')->name('editarEmplacamento');
Route::delete('/emplacamentos/remover/{id}', 'EmplacamentosController@destroy');

















