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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stay_id')->constrained()->onDelete('cascade');
            $table->string('user_name');
            $table->string('user_contact_number');
            $table->date('visit_date');
            $table->string('visit_time');
            $table->string('visiting_schedule'); // Snapshot of schedule at time of inquiry
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
