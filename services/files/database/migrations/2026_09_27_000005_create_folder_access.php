<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('folder_access', function (Blueprint $table) {
            $table->uuid('organization_id')->primary();
            $table->unsignedInteger('version')->default(0);
            $table->text('reader_roles');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('folder_access'); }
};
