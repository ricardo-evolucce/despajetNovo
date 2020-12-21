<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLojasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lojas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('razaoSocial', 100);
            $table->unsignedBigInteger('cnpj');
            $table->unsignedBigInteger('cep');
            $table->string('logradouro', 100);
            $table->string('numero', 8);
            $table->string('complemento', 100);
            $table->string('bairro', 100);
            $table->string('municipio', 100);
            $table->string('estado', 2);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lojas');
    }
}
