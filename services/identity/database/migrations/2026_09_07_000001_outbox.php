<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outbox_events', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('organization_id')->nullable()->index();
            $t->uuid('actor_id')->nullable();
            $t->string('action', 100);
            $t->uuid('resource_id')->nullable();
            $t->string('result', 20);
            $t->uuid('correlation_id');
            $t->dateTime('occurred_at', 6);
            $t->dateTime('published_at', 6)->nullable();
            $t->unsignedInteger('attempts')->default(0);
            $t->dateTime('next_attempt_at', 6);
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
