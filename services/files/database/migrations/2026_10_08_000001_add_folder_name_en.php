<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('internal_folders', fn (Blueprint $table) => $table->string('name_en', 120)->nullable()->after('name'));
    }

    public function down(): void
    {
        Schema::table('internal_folders', fn (Blueprint $table) => $table->dropColumn('name_en'));
    }
};
