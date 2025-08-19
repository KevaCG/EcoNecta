<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('message');
            $table->enum('type', ['registration', 'day_before', 'collection_day', 'completed']);
            $table->enum('channel', ['whatsapp', 'email'])->default('whatsapp');
            $table->enum('status', ['sent', 'failed'])->default('sent');
            $table->integer('time_to_send')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
