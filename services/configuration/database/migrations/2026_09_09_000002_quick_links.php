<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_quick_links', function (Blueprint $table) {
            $table->foreignUuid('organization_id')->primary()->constrained('organizations');
            $table->string('mode', 16);
            $table->json('items');
            $table->unsignedInteger('version');
            $table->timestamps();
        });
        Schema::create('personal_quick_links', function (Blueprint $table) {
            $table->foreignUuid('organization_id')->constrained('organizations');
            $table->uuid('user_id');
            $table->json('items')->nullable();
            $table->unsignedInteger('version');
            $table->timestamps();
            $table->primary(['organization_id', 'user_id']);
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
