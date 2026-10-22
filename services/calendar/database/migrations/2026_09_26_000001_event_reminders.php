<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->boolean('remind_24h')->default(true);
            $table->boolean('remind_1h')->default(true);
        });
    }
    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
