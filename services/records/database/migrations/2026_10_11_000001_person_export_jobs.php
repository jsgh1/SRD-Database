<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('person_export_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id');
            $table->uuid('user_id');
            $table->string('status', 16);
            $table->string('filename', 150);
            $table->string('language', 2);
            $table->unsignedInteger('row_count');
            $table->dateTime('cutoff_at');
            $table->longText('snapshot_json');
            $table->longText('content_base64')->nullable();
            $table->string('error_code', 40)->nullable();
            $table->dateTime('file_expires_at')->nullable();
            $table->timestamps();
            $table->index(['organization_id', 'user_id', 'created_at']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
