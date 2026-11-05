<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('auth_sessions', function (Blueprint $table) {
            $table->dateTime('reauthenticated_at')->nullable();
        });
        Schema::create('security_notices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->uuid('user_id');
            $table->text('destination_encrypted')->nullable();
            $table->string('kind', 40);
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->dateTime('next_attempt_at');
            $table->dateTime('sent_at')->nullable();
            $table->dateTime('created_at');
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Usar recuperación revisada para datos de seguridad.');
    }
};
