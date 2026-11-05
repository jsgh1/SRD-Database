<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('auth_sessions', function (Blueprint $table) {
            $table->dateTime('presence_seen_at')->nullable();
            $table->index(['user_id', 'presence_seen_at'], 'sessions_presence');
        });
    }
    public function down(): void {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperacion revisada.');
    }
};
