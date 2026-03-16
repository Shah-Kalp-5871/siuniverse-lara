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
            $table->string('deposit')->change(); // Allow alphanumeric like "1.5 months"
            $table->string('food_inclusion')->default('Excluded')->after('food_type'); // Included or Excluded
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stays', function (Blueprint $table) {
            $table->integer('deposit')->change();
            $table->dropColumn('food_inclusion');
        });
    }
};
