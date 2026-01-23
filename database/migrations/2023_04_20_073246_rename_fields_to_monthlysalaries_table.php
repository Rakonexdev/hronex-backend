<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFieldsToMonthlysalariesTable extends Migration
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
            $table->renameColumn('total_other_addition', 'total_addtional_amount');
            $table->renameColumn('total_leave_deduction', 'total_deduction_amount');
            $table->renameColumn('leave_deduction_amount', 'total_leave_deduction_amount');
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
            $table->renameColumn( 'total_addtional_amount','total_other_addition');
            $table->renameColumn( 'total_deduction_amount','total_leave_deduction');
            $table->renameColumn('total_leave_deduction_amount','leave_deduction_amount' );
        });
    }
}
