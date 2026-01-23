<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGratuityFieldToEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('earnings', function (Blueprint $table) {
            //
            $table->integer('ticket_accural_amount')->nullable()->after('remarks');
            $table->integer('return_tkt_amount')->nullable()->after('ticket_accural_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('earnings', function (Blueprint $table) {
            //
            $table->integer('ticket_accural_amount')->nullable()->after('remarks');
            $table->integer('return_tkt_amount')->nullable()->after('ticket_accural_amount');
        });
    }
}
