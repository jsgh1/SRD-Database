<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('person_filter_settings', function (Blueprint $t) {
            $t->uuid('organization_id')->primary();
            $t->unsignedInteger('version')->default(0);
            $t->json('base');
            $t->json('custom')->nullable();
            $t->json('delegated_roles');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('person_filter_settings'); }
};
