<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('privacy_requests')) Schema::create('privacy_requests', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('organization_id');
            $t->uuid('person_id');
            $t->string('kind', 16);
            $t->string('status', 32);
            $t->string('summary', 500);
            $t->uuid('created_by');
            $t->uuid('responsible_id')->nullable();
            $t->string('decision', 500)->nullable();
            $t->dateTime('decided_at')->nullable();
            $t->unsignedInteger('version')->default(1);
            $t->timestamps();
            $t->index(['organization_id', 'created_at', 'id']);
            $t->index(['organization_id', 'person_id']);
        });
        if (!Schema::hasTable('privacy_request_history')) Schema::create('privacy_request_history', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('organization_id');
            $t->uuid('request_id');
            $t->uuid('actor_id');
            $t->string('status', 32);
            $t->string('decision', 500)->nullable();
            $t->dateTime('created_at');
            $t->index(['organization_id', 'request_id', 'created_at'], 'privacy_history_scope_idx');
        });
        if (!Schema::hasIndex('privacy_request_history', 'privacy_history_scope_idx')) {
            Schema::table('privacy_request_history', function (Blueprint $t) {
                $t->index(['organization_id', 'request_id', 'created_at'], 'privacy_history_scope_idx');
            });
        }
    }
    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
