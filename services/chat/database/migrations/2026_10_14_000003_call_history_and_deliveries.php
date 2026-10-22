<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->string('system_kind', 24)->nullable();
            $table->unsignedInteger('call_duration_seconds')->nullable();
        });
        Schema::table('chat_delivery_jobs', function (Blueprint $table) {
            $table->dropUnique('chat_delivery_jobs_message_id_unique');
            $table->string('kind', 24)->default('chat_message');
            $table->unique(['kind', 'message_id'], 'chat_delivery_kind_reference');
        });
    }

    public function down(): void
    {
        throw new RuntimeException('La reversión del historial de llamadas requiere revisión manual.');
    }
};
