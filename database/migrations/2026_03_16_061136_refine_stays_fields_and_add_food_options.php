<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stays', function (Blueprint $table) {
            $table->dropColumn(['link', 'broker_name', 'broker_number']);
            $table->enum('food_type', ['None', 'Food Service', 'Tiffin Service'])->default('None');
            $table->integer('weekday_meals_price')->nullable();
            $table->integer('weekend_meals_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stays', function (Blueprint $table) {
            $table->string('link')->nullable();
            $table->string('broker_name')->nullable();
            $table->string('broker_number')->nullable();
            $table->dropColumn(['food_type', 'weekday_meals_price', 'weekend_meals_price']);
        });
    }
};
