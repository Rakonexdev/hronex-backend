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
        Schema::create('employee_emergency_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userid');
            $table->string('emergency_primary_name', 100);
            $table->smallInteger('relationship_primary');
            $table->string('emergency_primary_contact', 100);
            $table->string('emergency_secondary_name', 100)->nullable();
            $table->smallInteger('relationship_secondary')->nullable();
            $table->string('emergency_secondary_contact', 100)->nullable();
            $table->text('comment')->nullable();
            $table->boolean('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_emergency_details');
    }
};
