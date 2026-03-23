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
            $table->string('single_sharing_rent')->nullable()->change();
            $table->string('double_sharing_rent')->nullable()->change();
            $table->string('triple_sharing_rent')->nullable()->change();
            $table->string('weekday_meals_price')->nullable()->change();
            $table->string('weekend_meals_price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stays', function (Blueprint $table) {
            $table->integer('single_sharing_rent')->nullable()->change();
            $table->integer('double_sharing_rent')->nullable()->change();
            $table->integer('triple_sharing_rent')->nullable()->change();
            $table->integer('weekday_meals_price')->nullable()->change();
            $table->integer('weekend_meals_price')->nullable()->change();
        });
    }
};
