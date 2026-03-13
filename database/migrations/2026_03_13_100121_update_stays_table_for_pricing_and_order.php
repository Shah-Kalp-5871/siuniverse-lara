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
            $table->renameColumn('rent', 'deposit');
            $table->dropColumn(['broker_name', 'broker_number']);
            
            // PG Pricing
            $table->unsignedInteger('single_sharing_rent')->nullable()->after('type');
            $table->unsignedInteger('double_sharing_rent')->nullable()->after('single_sharing_rent');
            $table->unsignedInteger('triple_sharing_rent')->nullable()->after('double_sharing_rent');
            $table->unsignedInteger('food_charges')->nullable()->after('triple_sharing_rent');
            
            // Flat Pricing
            $table->unsignedInteger('flat_rent')->nullable()->after('food_charges');
            
            // Reordering
            $table->integer('sort_order')->default(0)->after('distance');
            
            // Customization
            $table->json('visit_form_custom_fields')->nullable()->after('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stays', function (Blueprint $table) {
            $table->renameColumn('deposit', 'rent');
            $table->string('broker_name')->nullable();
            $table->string('broker_number')->nullable();
            
            $table->dropColumn([
                'single_sharing_rent',
                'double_sharing_rent',
                'triple_sharing_rent',
                'food_charges',
                'flat_rent',
                'sort_order',
                'visit_form_custom_fields'
            ]);
        });
    }
};
