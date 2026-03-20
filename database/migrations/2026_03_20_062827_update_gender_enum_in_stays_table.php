<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE stays MODIFY COLUMN gender ENUM('Boys', 'Girls', 'Co-living', 'Couples') DEFAULT 'Co-living'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE stays MODIFY COLUMN gender ENUM('Boys', 'Girls', 'Co-living') DEFAULT 'Co-living'");
    }
};
