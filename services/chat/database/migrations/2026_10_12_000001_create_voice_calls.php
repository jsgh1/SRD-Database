<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('voice_calls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->uuid('conversation_id');
            $table->uuid('caller_id');
            $table->uuid('callee_id');
            $table->string('status', 16);
            $table->dateTime('created_at', 6);
            $table->dateTime('answered_at', 6)->nullable();
            $table->dateTime('ended_at', 6)->nullable();
            $table->index(['organization_id', 'callee_id', 'status'], 'voice_incoming');
            $table->index(['conversation_id', 'status'], 'voice_conversation');
            $table->foreign('conversation_id')->references('id')->on('conversations');
        });
        Schema::create('voice_call_signals', function (Blueprint $table) {
            $table->bigIncrements('sequence');
            $table->uuid('call_id');
            $table->uuid('sender_id');
            $table->string('kind', 16);
            $table->text('payload');
            $table->dateTime('created_at', 6);
            $table->index(['call_id', 'sequence'], 'voice_signal_poll');
            $table->foreign('call_id')->references('id')->on('voice_calls');
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
