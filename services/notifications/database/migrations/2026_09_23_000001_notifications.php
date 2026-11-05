<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->uuid('user_id');
            $table->uuid('event_id');
            $table->string('kind', 24);
            $table->string('title', 160);
            $table->char('delivery_key', 64)->unique();
            $table->dateTime('read_at', 6)->nullable();
            $table->dateTime('dismissed_at', 6)->nullable();
            $table->timestamps();
            $table->index(['organization_id', 'user_id', 'dismissed_at', 'created_at'], 'notification_inbox');
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
