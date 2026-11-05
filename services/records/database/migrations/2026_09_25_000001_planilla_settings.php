<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('planilla_settings', function (Blueprint $table) {
            $table->uuid('organization_id')->primary();
            $table->unsignedInteger('version')->default(0);
            $table->json('allowed_columns');
            $table->string('h1', 120);
            $table->string('h2', 120);
            $table->string('h3', 120);
            $table->json('delegated_roles');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planilla_settings');
    }
};
