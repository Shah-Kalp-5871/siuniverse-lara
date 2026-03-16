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
            $table->integer('single_sharing_rent')->nullable()->after('rent');
            $table->integer('double_sharing_rent')->nullable()->after('single_sharing_rent');
            $table->integer('triple_sharing_rent')->nullable()->after('double_sharing_rent');
            $table->integer('food_charges')->nullable()->after('triple_sharing_rent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stays', function (Blueprint $table) {
            $table->dropColumn(['single_sharing_rent', 'double_sharing_rent', 'triple_sharing_rent', 'food_charges']);
        });
    }
};
