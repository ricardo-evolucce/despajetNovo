<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaUsados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('clientes', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('cpf', 11)->unique();
            $table->string('rg', 10)->unique();
            $table->string('endereco', 100);
            $table->string('cidade', 30);
            $table->string('uf', 2);
            $table->string('nome', 100);
            $table->string('telefone', 15);
            $table->string('celular', 15);
            $table->string('email', 70);
            $table->string('bairro', 40);
            $table->string('cep', 8);
            $table->string('numero', 6);
            $table->string('complemento');
            $table->string('cnpj', 15);
        });












        Schema::create('usados', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->string('placa', 8)->nullable();
            $table->string('modelo', 30)->nullable();
            $table->unsignedBigInteger('tiposervico_id')->nullable();
            $table->decimal('valorServico', 15,2)->nullable();
            $table->unsignedBigInteger('loja_id')->nullable();
            $table->date('data')->nullable();
            $table->unsignedBigInteger('servicoPago')->nullable();
            $table->unsignedBigInteger('trocaPlaca')->nullable();
            $table->unsignedBigInteger('ipvaPago')->nullable();
            $table->decimal('valorIpva',15,2)->nullable();
            $table->unsignedBigInteger('outrosPago')->nullable();
            $table->decimal('valorOutros',15,2)->nullable();
            $table->string('renavam', 11)->nullable();
            $table->unsignedBigInteger('numeroPedido')->nullable();
            $table->decimal('valorNfe',15,2)->nullable();
            $table->unsignedBigInteger('nfe_id')->nullable();


    }); 

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
