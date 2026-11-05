<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('organizations', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('code', 40)->unique();
            $t->string('name', 160);
            $t->boolean('active')->default(true);
            $t->string('timezone', 40)->default('America/Bogota');
            $t->string('accent', 7)->default('#245bce');
            $t->unsignedInteger('version')->default(1);
            $t->timestamps();
        });
        Schema::create('terms_versions', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->foreignUuid('organization_id')->constrained('organizations');
            $t->unsignedInteger('version');
            $t->text('body');
            $t->dateTime('published_at');
            $t->unique(['organization_id', 'version']);
        });

    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
