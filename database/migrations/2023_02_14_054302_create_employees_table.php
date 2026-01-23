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
        Schema::create('employees', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedInteger('userid')->unique('userid');
            $table->string('empid', 50);
            $table->string('name', 100);
            $table->string('lname', 100)->nullable();
            $table->string('gender', 50);
            $table->date('dob')->nullable();
            $table->smallInteger('age')->nullable();
            $table->string('email', 100);
            $table->smallInteger('nationality');
            $table->string('marital_status', 50);
            $table->string('mobile1_code', 15);
            $table->string('mobile1', 25);
            $table->string('mobile2_code', 15)->nullable();
            $table->string('mobile2', 25)->nullable();
            $table->string('qidno', 50);
            $table->date('qidexpiry')->nullable();
            $table->string('passportno', 50)->nullable();
            $table->date('passportexpiry')->nullable();
            $table->date('joiningdate');
            $table->integer('department');
            $table->integer('designation');
            $table->smallInteger('school_shift');
            $table->date('end_probation')->nullable();
            $table->tinyInteger('contract_type');
            $table->string('contract_length', 50);
            $table->date('end_contract')->nullable();
            $table->string('service_years', 25)->nullable();
            $table->text('hrcomment')->nullable();
            $table->integer('sponsorship_status')->default(0);
            $table->integer('fas_sponsor')->nullable();
            $table->date('fas_spo_date')->nullable();
            $table->string('tkt_allowance_dur', 100)->nullable();
            $table->integer('relevant_degree');
            $table->text('degree_attaches')->nullable();
            $table->integer('degree_attest_status');
            $table->longText('other_qualifications')->nullable();
            $table->string('disclaimer_ltr_moe', 25)->nullable();
            $table->string('disclaimer_ltr_moe_atch', 200)->nullable();
            $table->string('declaration_ltr_moe', 25)->nullable();
            $table->string('declaration_ltr_moe_atch', 200)->nullable();
            $table->smallInteger('moe_approval_status');
            $table->string('police_clearance_issuance', 25)->nullable();
            $table->string('police_clearance_atch', 200)->nullable();
            $table->string('noc', 25)->nullable();
            $table->string('noc_atch', 200)->nullable();
            $table->string('experience_letter', 15)->nullable();
            $table->integer('experience_letter_atch')->nullable();
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
        Schema::dropIfExists('employees');
    }
};