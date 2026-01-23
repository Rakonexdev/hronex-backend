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
        Schema::create('leave_application_status', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('leave_id');
            $table->integer('applier_id');
            $table->integer('approver_id')->default(0);
            $table->dateTime('action_time')->useCurrent();
            $table->integer('leave_status');
            $table->string('comment', 500);
            $table->integer('assigned_to_role')->default(0);
            $table->integer('assigned_to_id')->default(0);
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
        Schema::dropIfExists('leave_application_status');
    }
};
