<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treasury_accounts', function (Blueprint $table) {
            $table->uuid('organization_id')->primary();
            $table->unsignedBigInteger('balance_cents')->default(0);
            $table->unsignedBigInteger('next_number')->default(1);
            $table->dateTime('opened_at', 6)->nullable();
            $table->timestamps();
        });
        Schema::create('treasury_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->unsignedBigInteger('number');
            $table->string('kind', 16);
            $table->smallInteger('sign');
            $table->unsignedBigInteger('amount_cents');
            $table->unsignedBigInteger('balance_after_cents');
            $table->date('effective_date');
            $table->string('concept', 500);
            $table->string('support_note', 500)->nullable();
            $table->uuid('actor_id');
            $table->string('actor_name', 120);
            $table->uuid('reverses_id')->nullable();
            $table->uuid('idempotency_key');
            $table->char('payload_hash', 64);
            $table->timestamps();
            $table->foreign('organization_id')->references('organization_id')->on('treasury_accounts');
            $table->foreign('reverses_id')->references('id')->on('treasury_movements');
            $table->unique(['organization_id', 'number']);
            $table->unique(['organization_id', 'idempotency_key'], 'treasury_idempotency');
            $table->unique('reverses_id');
            $table->index(['organization_id', 'effective_date', 'number'], 'treasury_history');
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
