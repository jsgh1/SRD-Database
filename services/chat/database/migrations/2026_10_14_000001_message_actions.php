<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->uuid('reply_to_id')->nullable()->index();
        });
        Schema::create('message_user_states', function (Blueprint $table) {
            $table->uuid('organization_id');
            $table->uuid('conversation_id');
            $table->uuid('message_id');
            $table->uuid('user_id');
            $table->dateTime('pinned_at')->nullable();
            $table->dateTime('hidden_at')->nullable();
            $table->primary(['message_id', 'user_id']);
            $table->index(['organization_id', 'conversation_id', 'user_id', 'pinned_at'], 'message_pins');
        });
        Schema::create('conversation_user_states', function (Blueprint $table) {
            $table->uuid('organization_id');
            $table->uuid('conversation_id');
            $table->uuid('user_id');
            $table->unsignedBigInteger('cleared_sequence')->default(0);
            $table->primary(['conversation_id', 'user_id']);
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
