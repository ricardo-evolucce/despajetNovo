<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();
            $table->string('servico', 1); // emplacamento ou usado   ('E' ou 'U')]
            $table->date('data')->nullable();     
            $table->unsignedBigInteger('tiposervico_id')->nullable();  //tipo de serviço de usado (transferencia, 2 via dut...)
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->unsignedBigInteger('loja_id')->nullable();   
            $table->unsignedBigInteger('numeroPedido')->nullable();
            $table->unsignedBigInteger('nfe')->nullable();
            $table->string('placa', 8)->nullable();
            $table->string('renavam', 11)->nullable();
            $table->string('chassi', 17)->nullable();
            $table->string('modelo', 30)->nullable();

            $table->unsignedBigInteger('trocaPlaca')->nullable();
            $table->unsignedBigInteger('carhouseOuCliente')->nullable();            
            $table->decimal('valorServico', 15,2)->nullable();
            $table->unsignedBigInteger('servicoPago')->nullable();           
            $table->unsignedBigInteger('ipvaPago')->nullable();
            $table->decimal('valorIpva',15,2)->nullable();
            $table->decimal('valorGuia',15,2)->nullable();
            $table->unsignedBigInteger('guiaPago')->nullable();
            $table->decimal('valorPlacaEsp',15,2)->nullable();
            $table->unsignedBigInteger('placaEspPago')->nullable();
            $table->decimal('valorProvisorio',15,2)->nullable();
            $table->unsignedBigInteger('provisorioPago')->nullable();            
            $table->unsignedBigInteger('outrosPago')->nullable();
            $table->decimal('valorOutros',15,2)->nullable();            
            $table->decimal('valorNfe',15,2)->nullable();
            $table->unsignedBigInteger('nfe_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicos');
    }
}
