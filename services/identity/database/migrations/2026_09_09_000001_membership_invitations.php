<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->unsignedInteger('version')->default(1);
        });
        Schema::create('membership_guards', function (Blueprint $table) {
            $table->uuid('organization_id')->primary();
        });
        Schema::create('invitations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->uuid('invited_by');
            $table->string('email', 254);
            $table->string('role', 30);
            $table->string('secret_hash', 64);
            $table->text('secret_encrypted')->nullable();
            $table->dateTime('expires_at');
            $table->dateTime('consumed_at')->nullable();
            $table->dateTime('revoked_at')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->unsignedTinyInteger('delivery_attempts')->default(0);
            $table->unsignedTinyInteger('accept_attempts')->default(0);
            $table->dateTime('next_attempt_at');
            $table->dateTime('created_at');
            $table->index(['organization_id', 'email', 'created_at']);
            $table->index(['sent_at', 'next_attempt_at']);
        });
    }

    public function down(): void
    {
        throw new RuntimeException('La recuperación de membresías requiere un procedimiento revisado.');
    }
};
