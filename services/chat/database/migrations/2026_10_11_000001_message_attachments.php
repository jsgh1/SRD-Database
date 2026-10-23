<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $t) {
            $t->uuid('attachment_id')->nullable();
            $t->string('attachment_name', 255)->nullable();
            $t->string('attachment_mime', 120)->nullable();
            $t->unsignedInteger('attachment_bytes')->nullable();
            $t->string('attachment_source_sha256', 64)->nullable();
        });
    }
    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
