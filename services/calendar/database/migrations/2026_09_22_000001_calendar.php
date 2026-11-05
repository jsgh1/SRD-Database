<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calendar_settings', function (Blueprint $table) {
            $table->uuid('organization_id')->primary();
            $table->unsignedInteger('version')->default(0);
            $table->json('editor_roles');
            $table->timestamps();
        });
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->string('type', 24);
            $table->string('title', 160);
            $table->text('description')->nullable();
            $table->string('location', 160)->nullable();
            $table->dateTime('starts_at', 6);
            $table->dateTime('ends_at', 6);
            $table->dateTime('cancelled_at', 6)->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->timestamps();
            $table->index(['organization_id', 'starts_at', 'id'], 'calendar_window');
            $table->index(['organization_id', 'ends_at'], 'calendar_overlap');
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
