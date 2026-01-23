<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResignApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resign_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');/*->unsigned();*/
            $table->tinyInteger('resign_type')->default(0)->comment('0: Normal, 1: Termination');
            $table->date('request_date');
            $table->date('join_date');
            $table->date('last_working_date');              
            $table->string('reason')->nullable();
            $table->integer('notice_period');          
            $table->string('notice_period_remarks')->nullable();
            $table->timestamps();
            $table->enum('status', ['Requested', 'Pending', 'Approved', 'Rejected'])->default('Requested');
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
        Schema::dropIfExists('resign_applications');
    }
}
