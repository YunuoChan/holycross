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
        Schema::table('section_subject', function (Blueprint $table) {
            $table->string('status')->default('ACT');
        });

        Schema::table('subject', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
            $table->smallInteger('availability_per_week')->default(1);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additional_column_subject_and_subj_sect');
    }
};
