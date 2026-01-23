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
        Schema::create('leave_application_amendments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('leave_id');
            $table->integer('empid');
            $table->integer('leave_type');
            $table->integer('created_by');
            $table->dateTime('created_at')->useCurrent();
            $table->string('comment', 500);
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_application_amendments');
    }
};
