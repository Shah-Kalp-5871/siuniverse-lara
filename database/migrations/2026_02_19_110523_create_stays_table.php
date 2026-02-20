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
        Schema::create('stays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['PG', 'Flat']);
            $table->integer('rent');
            $table->string('image_path')->nullable();
            $table->string('link')->nullable();
            $table->string('broker_number');
            $table->string('broker_name');
            $table->json('rules');
            $table->json('amenities');
            $table->decimal('distance', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stays');
    }
};
