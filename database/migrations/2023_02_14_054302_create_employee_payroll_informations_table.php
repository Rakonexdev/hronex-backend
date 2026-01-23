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
        Schema::create('employee_payroll_informations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userid');
            $table->decimal('basic_salary', 20);
            $table->decimal('accomodation_allowance', 20);
            $table->decimal('transport_allowance', 20);
            $table->decimal('other_allowance', 20)->nullable();;
            $table->decimal('gross_total', 20)->nullable();;
            $table->string('bank_name')->nullable();;
            $table->string('account_no', 25)->nullable();;
            $table->string('iban_no', 50)->nullable();;
            $table->date('salary_effective_from')->nullable();;
            $table->string('bank_docs', 200)->nullable();;
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
        Schema::dropIfExists('employee_payroll_informations');
    }
};