<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->string('code', 40);
            $table->string('type', 16);
            $table->string('name', 160);
            $table->string('category', 80)->nullable();
            $table->string('unit', 40)->nullable();
            $table->text('description')->nullable();
            $table->string('location', 180);
            $table->string('condition', 80);
            $table->string('responsible_name', 120)->nullable();
            $table->unsignedInteger('quantity');
            $table->string('status', 16)->default('active');
            $table->unsignedInteger('version')->default(1);
            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->timestamp('retired_at')->nullable();
            $table->timestamps();
            $table->unique(['organization_id', 'code']);
            $table->index(['organization_id', 'type', 'status']);
        });
        Schema::create('asset_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->uuid('asset_id');
            $table->unsignedInteger('sequence');
            $table->string('type', 16);
            $table->integer('delta');
            $table->unsignedInteger('quantity_before');
            $table->unsignedInteger('quantity_after');
            $table->string('reason', 500);
            $table->uuid('performed_by');
            $table->string('performer_name', 120);
            $table->uuid('idempotency_key');
            $table->char('payload_hash', 64);
            $table->timestamps();
            $table->foreign('asset_id')->references('id')->on('assets');
            $table->unique(['organization_id', 'idempotency_key']);
            $table->unique(['asset_id', 'sequence']);
            $table->index(['organization_id', 'asset_id', 'created_at']);
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
