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
        Schema::create('section_subject', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('ACT');
            $table->timestamps();

            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subject');

            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('section');

            $table->unsignedBigInteger('schoolyear_id');
            $table->foreign('schoolyear_id')->references('id')->on('schoolyears');

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
        Schema::dropIfExists('section_subject');
    }
};
