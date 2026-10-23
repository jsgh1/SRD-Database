<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notification_preferences', function (Blueprint $table) {
            $table->string('quiet_start', 5)->nullable();
            $table->string('quiet_end', 5)->nullable();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
