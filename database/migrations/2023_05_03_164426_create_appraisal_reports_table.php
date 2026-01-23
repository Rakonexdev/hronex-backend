<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppraisalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisal_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->date('evaluation_date');
            $table->string('evaluation_type');
            $table->string('evaluation_period');
            $table->string('appraisal_data')->nullable();
            $table->string('hod_rating')->nullable();
            $table->string('principal_rating')->nullable();
            $table->string('future_targets_data')->nullable();
            $table->string('future_target_review_date')->nullable();
            $table->string('future_targets_recommended')->nullable();
            $table->string('training_title')->nullable();
            $table->string('training_due_date')->nullable();
            $table->string('training_recommended')->nullable();
            $table->string('employee_comments')->nullable();
            $table->string('hod_comments')->nullable();
            $table->string('principal_comments')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('employee_id')
                    ->references('id')
                    ->on('employees')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appraisal_reports');
    }
}
