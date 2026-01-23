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
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('leave_type');
            $table->integer('empid');
            $table->date('date_from');
            $table->date('date_to');
            $table->string('time_from', 25);
            $table->string('time_end', 25);
            $table->string('no_days', 25);
            $table->integer('reason')->nullable();
            $table->longText('attachment')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->boolean('finalised')->default(false);
            $table->tinyInteger('amendment')->default(0);
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_applications');
    }
};
