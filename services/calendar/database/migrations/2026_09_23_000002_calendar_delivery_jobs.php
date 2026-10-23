<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calendar_delivery_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->uuid('user_id');
            $table->uuid('event_id');
            $table->string('kind', 24);
            $table->string('title', 160);
            $table->char('delivery_key', 64)->unique();
            $table->dateTime('due_at', 6);
            $table->dateTime('event_starts_at', 6)->nullable();
            $table->dateTime('next_attempt_at', 6);
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->dateTime('delivered_at', 6)->nullable();
            $table->timestamps();
            $table->index(['delivered_at', 'next_attempt_at', 'id'], 'delivery_due');
            $table->index(['event_id', 'user_id', 'delivered_at'], 'delivery_event_user');
            $table->foreign('event_id')->references('id')->on('calendar_events');
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
