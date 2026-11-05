<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('audit_events', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('organization_id')->nullable()->index();
            $t->uuid('actor_id')->nullable();
            $t->string('service', 30);
            $t->string('action', 100);
            $t->uuid('resource_id')->nullable();
            $t->string('result', 20);
            $t->uuid('correlation_id');
            $t->dateTime('occurred_at', 6);
            $t->unsignedInteger('event_version');
        });

    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
