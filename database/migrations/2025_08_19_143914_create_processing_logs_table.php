<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('processing_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->nullable()->constrained('processing_plants')->onDelete('set null');
            $table->foreignId('waste_type_id')->constrained('waste_types')->onDelete('cascade');
            $table->float('quantity_kg');
            $table->timestamp('entry_date')->default(now());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('processing_logs');
    }
};
