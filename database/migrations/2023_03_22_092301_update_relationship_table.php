<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relationship', function (Blueprint $table) {
            //$table->renameColumn('userid', 'user_id');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
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
        Schema::table('relationship', function (Blueprint $table) {
            //$table->renameColumn('userid', 'user_id');
            $table->dropColumn(['updated_by','created_by']);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
