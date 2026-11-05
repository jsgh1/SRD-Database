<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('users', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('email', 254)->unique();
            $t->string('name', 120);
            $t->string('password');
            $t->boolean('active')->default(true);
            $t->boolean('superadmin')->default(false);
            $t->string('theme', 10)->default('light');
            $t->string('presence', 15)->default('online');
            $t->timestamps();
        });
        Schema::create('memberships', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('organization_id');
            $t->foreignUuid('user_id')->constrained('users');
            $t->string('role', 30);
            $t->boolean('active')->default(true);
            $t->unique(['organization_id', 'user_id']);
        });
        Schema::create('auth_challenges', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->foreignUuid('user_id')->constrained('users');
            $t->uuid('organization_id');
            $t->string('purpose', 20);
            $t->string('destination', 254);
            $t->string('digest', 64);
            $t->uuid('terms_version_id')->nullable();
            $t->unsignedTinyInteger('attempts')->default(0);
            $t->dateTime('expires_at');
            $t->dateTime('consumed_at')->nullable();
            $t->dateTime('sent_at')->nullable();
            $t->dateTime('created_at');
            $t->index(['user_id', 'purpose', 'created_at']);
        });
        Schema::create('auth_sessions', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->foreignUuid('user_id')->constrained('users');
            $t->uuid('organization_id');
            $t->string('token_hash', 64)->unique();
            $t->dateTime('last_activity_at');
            $t->dateTime('expires_at');
            $t->dateTime('revoked_at')->nullable();
            $t->dateTime('created_at');
        });
        Schema::create('terms_acceptances', function (Blueprint $t) {
            $t->id();
            $t->foreignUuid('user_id')->constrained('users');
            $t->uuid('organization_id');
            $t->uuid('terms_version_id');
            $t->dateTime('accepted_at');
            $t->unique(['user_id', 'organization_id', 'terms_version_id'], 'acceptance_unique');
        });

    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
