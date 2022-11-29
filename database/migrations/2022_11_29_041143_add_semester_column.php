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
        Schema::table('schoolyears', function (Blueprint $table) {
            $table->smallInteger('semester')->default(1);
        });

        Schema::disableForeignKeyConstraints();
        Schema::table('student', function (Blueprint $table) {
            $table->unsignedBigInteger('schoolyear_id');
            $table->foreign('schoolyear_id')->references('id')->on('schoolyears');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
