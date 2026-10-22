<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->uuid('sender_id')->nullable();
            $table->string('sender_name', 120)->nullable();
            $table->uuid('message_id')->nullable();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('La reversión de detalles de avisos requiere revisión manual.');
    }
};
