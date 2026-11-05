<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('folder_access', function (Blueprint $table) {
            $table->text('reader_memberships')->nullable();
        });
    }
    public function down(): void {
        Schema::table('folder_access', function (Blueprint $table) {
            $table->dropColumn('reader_memberships');
        });
    }
};
