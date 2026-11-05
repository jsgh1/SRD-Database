<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->uuid('user_a_id');
            $table->uuid('user_b_id');
            $table->string('user_a_name', 120);
            $table->string('user_b_name', 120);
            $table->timestamps();
            $table->unique(['organization_id', 'user_a_id', 'user_b_id'], 'conversation_pair');
            $table->index(['organization_id', 'user_a_id', 'updated_at'], 'conversation_a_list');
            $table->index(['organization_id', 'user_b_id', 'updated_at'], 'conversation_b_list');
        });
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('sequence');
            $table->uuid('id')->unique();
            $table->uuid('organization_id');
            $table->uuid('conversation_id');
            $table->uuid('sender_id');
            $table->uuid('client_id');
            $table->text('body');
            $table->dateTime('created_at', 6);
            $table->unique(['conversation_id', 'sender_id', 'client_id'], 'message_retry');
            $table->index(['organization_id', 'conversation_id', 'sequence'], 'message_history');
            $table->foreign('conversation_id')->references('id')->on('conversations');
        });
        Schema::create('outbox_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id')->nullable()->index();
            $table->uuid('actor_id')->nullable();
            $table->string('action', 100);
            $table->uuid('resource_id')->nullable();
            $table->string('result', 20);
            $table->uuid('correlation_id');
            $table->dateTime('occurred_at', 6);
            $table->dateTime('published_at', 6)->nullable();
            $table->unsignedInteger('attempts')->default(0);
            $table->dateTime('next_attempt_at', 6);
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
