<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('processing_plants', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('type', ['composting', 'recycling', 'hazardous']);
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('processing_plants');
    }
};
