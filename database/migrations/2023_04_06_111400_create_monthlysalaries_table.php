<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlysalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthlysalaries', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->date('month_year')->nullable();
            $table->bigInteger('total_gross_salary')->default('0');
            $table->bigInteger('total_other_addition')->default('0');
            $table->bigInteger('total_leave_deduction')->default('0');
            $table->bigInteger('net_salary')->default('0');
            $table->string('remarks');
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthlysalaries');
    }
}
