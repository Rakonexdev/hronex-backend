<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_status', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userid');
            $table->integer('empid');
            $table->smallInteger('current_status');
            $table->string('inactive_status', 100)->nullable();
            $table->date('inactive_date')->nullable();
            $table->integer('created_by');
            $table->string('inactive_reason', 100)->nullable();
            $table->longText('attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_status');
    }
};
