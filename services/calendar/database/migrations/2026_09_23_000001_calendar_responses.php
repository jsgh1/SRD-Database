<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calendar_participants', function (Blueprint $table) {
            $table->string('response', 12)->default('pending');
            $table->unsignedInteger('response_version')->default(1);
            $table->dateTime('responded_at', 6)->nullable();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
