<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->uuid('event_id')->nullable()->change();
            $table->uuid('conversation_id')->nullable();
        });
        Schema::table('notification_preferences', function (Blueprint $table) {
            $table->boolean('chat_messages')->default(true);
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
