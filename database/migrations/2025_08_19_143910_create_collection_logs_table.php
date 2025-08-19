<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->nullable()->constrained('collection_schedules')->onDelete('set null');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->foreignId('waste_type_id')->constrained('waste_types')->onDelete('cascade');
            $table->float('quantity_kg');
            $table->enum('status', ['scheduled', 'completed'])->default('scheduled');
            $table->timestamp('collection_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_logs');
    }
};
