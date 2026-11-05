<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('folder_documents', function (Blueprint $t) {
            $t->uuid('id')->primary(); $t->uuid('organization_id');
            $t->uuid('folder_id')->nullable(); $t->uuid('parent_key');
            $t->string('name', 255); $t->char('name_key', 64);
            $t->string('mime', 100); $t->char('blob_id', 48)->unique();
            $t->unsignedBigInteger('bytes'); $t->char('sha256', 64);
            $t->boolean('ready')->default(false); $t->uuid('created_by'); $t->timestamps();
            $t->unique(['organization_id','parent_key','name_key'], 'documents_sibling_name');
            $t->index(['organization_id','folder_id','ready'], 'documents_folder');
        });
    }
    public function down(): void { Schema::dropIfExists('folder_documents'); }
};
