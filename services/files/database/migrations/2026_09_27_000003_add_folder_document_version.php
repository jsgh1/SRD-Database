<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::table('folder_documents', fn (Blueprint $t) => $t->unsignedInteger('version')->default(1)); }
    public function down(): void { Schema::table('folder_documents', fn (Blueprint $t) => $t->dropColumn('version')); }
};
