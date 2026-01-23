<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGratuityStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gratuity_status', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gratuity_id')->unsigned();
            $table->integer('source_id')->default(0);
            $table->integer('dest_id')->default(0);                      
            $table->string('comment')->nullable(); 
            $table->dateTime('timing')->useCurrent();
            $table->timestamps();
            $table->enum('gratuity_status', ['Initiated', 'Assigned To Review', 'Reviewed', 'Assigned To Approve', 'Approved'])->default('Initiated');
            $table->foreign('gratuity_id')
                            ->references('id')
                            ->on('gratuity')
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
        Schema::dropIfExists('gratuity_status');
    }
}
