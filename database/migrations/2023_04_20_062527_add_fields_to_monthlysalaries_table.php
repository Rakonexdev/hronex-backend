<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToMonthlysalariesTable extends Migration
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
            $table->integer('no_of_leave_days')->nullable()->after('total_leave_deduction');
            $table->string('leave_deduction_amount')->nullable()->after('no_of_leave_days');
            $table->string('paid_reason')->nullable()->after('leave_deduction_amount');
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
