<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQoutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qoutas', function (Blueprint $table) {
            $table->id();
            $table->float('valor_contribuido');
            $table->date('data_pagamento');
            $table->string('nome_socio');
            $table->string('id_socio');
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
        Schema::dropIfExists('qoutas');
    }
}
