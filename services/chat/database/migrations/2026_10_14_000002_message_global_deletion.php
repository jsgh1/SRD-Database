<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dateTime('deleted_for_all_at', 6)->nullable();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('La reversión de borrados globales requiere revisión manual.');
    }
};
