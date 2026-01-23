<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLeaveApplicationAmendmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leave_application_amendments', function (Blueprint $table) {
            $table->renameColumn('empid', 'employee_id');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leave_application_amendments', function (Blueprint $table) {
            $table->renameColumn('empid', 'employee_id');
            $table->dropColumn(['updated_by']);
            $table->softDeletes();
        });
    }
}