<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chat_socket_closures', function (Blueprint $table) {
            $table->uuid('session_id')->primary();
            $table->dateTime('created_at');
            $table->dateTime('confirmed_at')->nullable();
            $table->foreign('session_id')->references('id')->on('auth_sessions');
            $table->index(['confirmed_at', 'created_at'], 'chat_closures_pending');
        });

        // Older revoked sessions may still own a socket if Reverb was reachable by clients.
        DB::table('auth_sessions')->whereNotNull('revoked_at')->select('id', 'revoked_at')
            ->orderBy('id')->chunkById(500, function ($rows) {
                DB::table('chat_socket_closures')->insertOrIgnore($rows->map(fn ($row) => [
                    'session_id' => $row->id, 'created_at' => $row->revoked_at, 'confirmed_at' => null,
                ])->all());
            });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperacion revisada.');
    }
};
