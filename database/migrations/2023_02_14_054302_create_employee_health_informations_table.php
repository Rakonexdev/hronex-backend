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
        Schema::create('employee_health_informations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userid');
            $table->string('hmc_card_no', 50)->nullable();
            $table->string('hmc_card_atch', 200)->nullable();
            $table->string('health_insurance_status', 25)->nullable();
            $table->string('health_insurance_atch', 200)->nullable();
            $table->string('health_insurance_name', 100)->nullable();
            $table->string('blood_group', 50)->nullable();
            $table->string('medical_ailment_physical', 25)->nullable();
            $table->longText('physical_details')->nullable();
            $table->string('medical_ailment_mental', 25)->nullable();
            $table->longText('mental_details')->nullable();
            $table->string('medication_details', 100)->nullable();
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
        Schema::dropIfExists('employee_health_informations');
    }
};
