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
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('student_id_no');
            $table->string('name');
            $table->smallInteger('year_level')->default('1');
            $table->string('status')->default('ACT');
            $table->timestamps();

            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('section');

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('course');
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
};
