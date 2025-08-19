<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('localities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('postal_code', 20)->nullable();
            $table->json('collection_days')->nullable();
            $table->timestamps();
            $table->unique(['name', 'postal_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('localities');
    }
};
