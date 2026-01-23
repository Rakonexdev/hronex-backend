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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->tinyInteger('applicable_to')->default(0)->comment('0: Others, 1: Academic, 2: Admin');
            $table->string('leave_days', 25);
            $table->integer('academic_year')->default(0);
            $table->string('description', 200);
            $table->integer('created_by');
            $table->dateTime('created_at')->useCurrent();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave types');
    }
};
