<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('folder_documents', fn (Blueprint $t) => $t->boolean('delete_pending')->default(false)->index());
    }
    public function down(): void {
        Schema::table('folder_documents', fn (Blueprint $t) => $t->dropColumn('delete_pending'));
    }
};
