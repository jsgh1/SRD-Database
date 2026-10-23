<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::create('person_field_schemas', function (Blueprint $t) {
            $t->uuid('organization_id')->primary();
            $t->unsignedInteger('version')->default(0);
            $t->json('fields');
            $t->timestamps();
        });
        Schema::create('person_field_values', function (Blueprint $t) {
            $t->uuid('person_id')->primary();
            $t->uuid('organization_id');
            $t->json('snapshots');
            $t->foreign(['organization_id', 'person_id'])->references(['organization_id', 'id'])->on('persons')->cascadeOnDelete();
        });
    }
    public function down(): void { throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.'); }
};
