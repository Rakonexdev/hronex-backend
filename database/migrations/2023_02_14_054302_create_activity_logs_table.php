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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title', 100);
            $table->string('type', 100);
            $table->integer('taken_by');
            $table->string('description', 500)->nullable();
            $table->integer('id_from')->default(0);
            $table->integer('id_to')->default(0);
            $table->dateTime('created_at')->useCurrent();
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
        Schema::dropIfExists('activity_logs');
    }
};
