<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();

            $table->string('institute');
            $table->string('course');
            $table->string('section');

            $table->timestamp('datestamp')->useCurrent();

            $table->string('campus_location');

            $table->integer('current_study_year');

            // nullable because only hostel students use gym
            $table->string('gym_choice')->nullable();

            // national or international
            $table->enum('origin', ['national', 'international']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
