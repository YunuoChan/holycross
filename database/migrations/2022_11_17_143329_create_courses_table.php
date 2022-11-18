<?php

use App\Models\Course;
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
        Schema::create('course', function (Blueprint $table) {
            $table->id();
            $table->string('course_code');
            $table->string('course_name')->nullable();
            $table->string('status')->default('ACT');
            $table->timestamps();
        });

        Course::firstOrCreate([
            'course_code' => 'BSCS',
        ]);

        Course::firstOrCreate([
            'course_code' => 'BSED',
        ]);

        Course::firstOrCreate([
            'course_code' => 'BSCRIM',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course');
    }
};
