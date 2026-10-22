<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::create('persons', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('organization_id');
            $t->string('document_type', 5);
            $t->string('document_number', 30);
            $t->string('first_names', 120);
            $t->string('last_names', 120)->nullable();
            $t->boolean('affiliated')->nullable();
            $t->string('zone', 10)->nullable();
            $t->string('gender', 20)->nullable();
            $t->date('birth_date')->nullable();
            $t->string('phone', 20)->nullable();
            $t->string('email', 254)->nullable();
            $t->string('position_code', 60)->nullable();
            $t->string('descriptive_role', 30)->nullable();
            $t->string('property_name', 160)->nullable();
            $t->string('address', 180)->nullable();
            $t->string('neighborhood', 100)->nullable();
            $t->string('status', 10);
            $t->unsignedInteger('version')->default(1);
            $t->uuid('created_by');
            $t->timestamps();
            $t->unique(['organization_id', 'id']);
            $t->unique(['organization_id', 'document_type', 'document_number'], 'person_document_unique');
            $t->index(['organization_id', 'status', 'created_at', 'id'], 'person_list');
        });
        Schema::create('person_notes', function (Blueprint $t) {
            $t->uuid('person_id')->primary();
            $t->uuid('organization_id');
            $t->text('body');
            $t->uuid('updated_by');
            $t->timestamp('updated_at');
            $t->foreign(['organization_id', 'person_id'])->references(['organization_id', 'id'])->on('persons')->cascadeOnDelete();
        });
        Schema::create('data_authorizations', function (Blueprint $t) {
            $t->uuid('person_id')->primary();
            $t->uuid('organization_id');
            $t->string('basis', 120);
            $t->text('purpose');
            $t->uuid('captured_by');
            $t->dateTime('captured_at');
            $t->foreign(['organization_id', 'person_id'])->references(['organization_id', 'id'])->on('persons')->cascadeOnDelete();
        });

    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
