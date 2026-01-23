<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGratuityFieldToMonthlysalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthlysalaries', function (Blueprint $table) {
            //
            $table->integer('total_leave_accural_amount')->nullable()->after('paid_reason');
            $table->integer('total_gratuity_amount')->nullable()->after('total_leave_accural_amount');
        });
    }
   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthlysalaries', function (Blueprint $table) {
            //
        });
    }
}
