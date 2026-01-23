<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGratuityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gratuity', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');/*->unsigned();*/
            $table->date('joining_date');
            $table->date('last_working_day');
            $table->decimal('notice_pay', 8, 2);
            $table->string('total_days_employment');    
            $table->string('notice_period');              
            $table->string('notice_period_remarks')->nullable();
            $table->string('net_days_worked');   
            $table->integer('total_days_last_month')->default(0); 
            $table->decimal('current_month_salary', 8, 2);
            $table->string('eligible_days');  
            $table->decimal('gratuity_add', 8, 2)->default(0);
            $table->decimal('gratuity_ded', 8, 2)->default(0);
            $table->decimal('gratuity_total', 8, 2)->default(0); 
            $table->decimal('leave_accrual_amount', 8, 2)->default(0);     
            $table->decimal('ticket_accrual_amount', 8, 2)->default(0);  
            $table->decimal('return_ticket_amount', 8, 2)->default(0);  
            $table->decimal('net_pay', 8, 2)->default(0);    
            $table->decimal('net_pay_round_off', 8, 2)->default(0);        
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->enum('status', ['Initiated', 'Assigned To Review', 'Reviewed', 'Assigned To Approve', 'Approved'])->default('Initiated');
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
        Schema::dropIfExists('gratuity');
    }
}
