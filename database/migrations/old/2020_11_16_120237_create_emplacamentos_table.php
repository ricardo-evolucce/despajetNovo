<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmplacamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emplacamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->string('placa', 8)->nullable();
            $table->string('chassi', 17)->nullable();
            $table->string('modelo', 30)->nullable();
            $table->string('nfe', 7)->nullable();
            $table->decimal('valorGuia', 15,2)->nullable();
            $table->unsignedBigInteger('guiaPago')->nullable();
            $table->decimal('valorIpva', 15,2)->nullable();
            $table->unsignedBigInteger('ipvaPago')->nullable();
            $table->decimal('valorPlacaEsp', 15,2)->nullable();
            $table->unsignedBigInteger('placaEspPago')->nullable();
            $table->decimal('valorOutros', 15,2)->nullable();
            $table->unsignedBigInteger('outrosPago')->nullable();
            $table->decimal('valorProvisorio', 15,2)->nullable();
            $table->unsignedBigInteger('provisorioPago')->nullable();
            $table->unsignedBigInteger('loja_id')->nullable();
            $table->date('data')->nullable();            
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
        Schema::dropIfExists('emplacamentos');
    }
}
