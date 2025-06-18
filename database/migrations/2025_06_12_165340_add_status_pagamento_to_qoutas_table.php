<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPagamentoToQoutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qoutas', function (Blueprint $table) {
            $table->string('status_pagamento')->default('Pago')->after('data_pagamento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qoutas', function (Blueprint $table) {
            $table->dropColumn('status_pagamento');
        });
    }
}
