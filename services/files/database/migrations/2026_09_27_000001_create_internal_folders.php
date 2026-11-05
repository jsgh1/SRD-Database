<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('internal_folders', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('organization_id');
            $t->uuid('parent_id')->nullable();
            $t->uuid('parent_key');
            $t->string('name', 120);
            $t->char('name_key', 64);
            $t->unsignedInteger('version')->default(1);
            $t->uuid('created_by');
            $t->timestamps();
            $t->unique(['organization_id', 'parent_key', 'name_key'], 'folders_sibling_name');
            $t->index(['organization_id', 'parent_id'], 'folders_parent');
        });
    }
    public function down(): void { Schema::dropIfExists('internal_folders'); }
};
