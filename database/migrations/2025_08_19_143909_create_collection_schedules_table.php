<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('locality_id')->nullable()->constrained('localities')->onDelete('set null');
            $table->foreignId('waste_type_id')->nullable()->constrained('waste_types')->onDelete('set null');
            $table->string('day_of_week', 20)->nullable();
            $table->enum('frequency', ['weekly', 'monthly']);
            $table->boolean('is_automatic')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_schedules');
    }
};
