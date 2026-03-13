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
        if (Schema::hasTable('inquiries') && !Schema::hasColumn('inquiries', 'user_contact_number')) {
            Schema::table('inquiries', function (Blueprint $table) {
                // Add the missing column after user_name
                $table->string('user_contact_number')->after('user_name')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('inquiries', 'user_contact_number')) {
            Schema::table('inquiries', function (Blueprint $table) {
                $table->dropColumn('user_contact_number');
            });
        }
    }
};
