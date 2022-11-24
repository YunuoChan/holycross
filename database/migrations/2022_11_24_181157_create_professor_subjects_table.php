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
        Schema::create('professor_subject', function (Blueprint $table) {
            $table->id();
            $table->string('professor_id_no');
            $table->string('subject_id');
            $table->string('status')->default('ACT');
            $table->timestamps();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('course');
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('schoolyear_id');
            $table->foreign('schoolyear_id')->references('id')->on('schoolyears');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professor_subject');
    }
};
