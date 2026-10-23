<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('person_export_jobs', function (Blueprint $table) {
            $table->dateTime('notification_sent_at')->nullable();
            $table->unsignedInteger('notification_attempts')->default(0);
            $table->dateTime('notification_next_attempt_at')->nullable();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
