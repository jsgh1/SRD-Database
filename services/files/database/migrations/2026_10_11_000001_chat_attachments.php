<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chat_attachments', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('organization_id');
            $t->uuid('conversation_id');
            $t->uuid('sender_id');
            $t->string('name', 255);
            $t->string('mime', 120);
            $t->unsignedInteger('bytes');
            $t->string('source_sha256', 64);
            $t->string('sha256', 64);
            $t->longText('content_base64');
            $t->dateTime('created_at');
            $t->index(['organization_id', 'conversation_id'], 'chat_attachment_conversation');
        });
    }
    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
