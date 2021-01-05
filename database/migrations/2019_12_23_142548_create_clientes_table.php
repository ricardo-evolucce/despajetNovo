<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
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
            $table->string('cpf', 14)->unique();
            $table->string('rg', 10)->unique();
            $table->string('endereco', 100);
            $table->string('cidade', 30);
            $table->string('uf', 2);
            $table->string('nome', 100);
            $table->string('telefone', 15)->nullable();
            $table->string('celular', 15);
            $table->string('email', 70)->nullable();
            $table->string('bairro', 40);
            $table->string('cep', 8);
            $table->string('numero', 6);
            $table->string('complemento')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
