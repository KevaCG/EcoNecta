<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('category', ['organic', 'inorganic', 'hazardous']);
            $table->string('subcategory', 100)->nullable();
            $table->integer('points_per_kg');
            $table->enum('collection_frequency', ['weekly', 'monthly']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_types');
    }
};
