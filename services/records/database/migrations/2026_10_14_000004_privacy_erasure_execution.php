<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('privacy_erasure_guards', function (Blueprint $table) {
            $table->uuid('organization_id')->primary();
        });
        Schema::table('photo_deletions', function (Blueprint $table) {
            $table->uuid('privacy_request_id')->nullable()->index();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('La reversión de supresiones requiere revisión manual.');
    }
};
