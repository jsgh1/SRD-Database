<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('file_garbage', function (Blueprint $table) {
            $table->uuid('person_id')->nullable()->index();
        });
        Schema::create('file_deleted_person_blobs', function (Blueprint $table) {
            $table->char('blob_id', 48)->primary();
            $table->uuid('organization_id');
            $table->uuid('person_id');
            $table->index(['organization_id', 'person_id']);
            $table->foreign('blob_id')->references('blob_id')->on('file_garbage')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('La reversión del seguimiento de supresiones requiere revisión manual.');
    }
};
