<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conversation_activities', function (Blueprint $table) {
            $table->uuid('conversation_id');
            $table->uuid('organization_id');
            $table->uuid('user_id');
            $table->string('kind', 16);
            $table->dateTime('expires_at', 6);
            $table->primary(['conversation_id', 'user_id']);
            $table->index(['organization_id', 'expires_at']);
            $table->foreign('conversation_id')->references('id')->on('conversations');
        });
    }

    public function down(): void
    {
        throw new RuntimeException('La reversión de estados temporales requiere revisión manual.');
    }
};
