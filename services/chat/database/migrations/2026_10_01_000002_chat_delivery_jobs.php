<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chat_delivery_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->uuid('conversation_id');
            $table->uuid('message_id')->unique();
            $table->uuid('user_id');
            $table->char('delivery_key', 64)->unique();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->dateTime('next_attempt_at', 6);
            $table->dateTime('delivered_at', 6)->nullable();
            $table->timestamps();
            $table->index(['delivered_at', 'next_attempt_at', 'id'], 'chat_delivery_due');
            $table->foreign('conversation_id')->references('id')->on('conversations');
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
