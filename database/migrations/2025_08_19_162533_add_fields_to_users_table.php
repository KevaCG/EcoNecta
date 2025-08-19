<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('neighborhood')->after('address')->nullable();
            $table->string('postal_code', 20)->after('neighborhood')->nullable();
            $table->foreignId('locality_id')->after('postal_code')->nullable()->constrained('localities')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['locality_id']);
            $table->dropColumn(['neighborhood', 'postal_code', 'locality_id']);
        });
    }
};
