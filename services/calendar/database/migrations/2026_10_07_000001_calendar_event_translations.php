<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->string('title_en', 160)->nullable();
            $table->text('description_en')->nullable();
            $table->string('location_en', 160)->nullable();
        });
        Schema::table('calendar_delivery_jobs', function (Blueprint $table) {
            $table->string('title_en', 160)->nullable();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
