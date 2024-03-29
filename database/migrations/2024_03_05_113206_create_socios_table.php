<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo');
            $table->string('endereco');
            $table->string('genero');
            $table->date('data_nasciemnto');
            $table->string('telefone');
            $table->string('telefone_opcional');
            $table->string('email')->unique();
            $table->string('nacionalidade');
            $table->string('tipo_documento_de_identificacao');
            $table->string('documento_de_identificacao');
            $table->string('categoria_socio');
            $table->float('valor_quota_anual');
            $table->float('valor_quota_contribuido');
            $table->string('estado_socio');
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
        Schema::dropIfExists('socios');
    }
}
