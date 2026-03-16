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
            $table->boolean('is_luxury')->default(false);
            $table->integer('luxury_order')->nullable();
            $table->string('area')->nullable();
            $table->enum('gender', ['Boys', 'Girls', 'Co-living'])->default('Co-living');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stays', function (Blueprint $table) {
            $table->dropColumn(['is_luxury', 'luxury_order', 'area', 'gender']);
        });
    }
};
