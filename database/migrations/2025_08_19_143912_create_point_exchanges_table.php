<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_exchanges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('points_redeemed');
            $table->string('coupon_code', 50)->nullable();
            $table->float('discount_applied')->nullable();
            $table->timestamp('exchange_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_exchanges');
    }
};
