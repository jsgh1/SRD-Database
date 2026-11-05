<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('name_en', 160)->nullable();
            $table->string('category_en', 80)->nullable();
            $table->string('unit_en', 40)->nullable();
            $table->text('description_en')->nullable();
            $table->string('location_en', 180)->nullable();
            $table->string('condition_en', 80)->nullable();
        });
        Schema::table('asset_movements', function (Blueprint $table) {
            $table->string('reason_en', 500)->nullable();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
