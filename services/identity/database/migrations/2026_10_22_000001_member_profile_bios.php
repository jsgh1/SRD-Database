<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('member_profile_bios', function (Blueprint $table) {
            $table->uuid('organization_id');
            $table->foreignUuid('user_id')->constrained('users');
            $table->string('bio', 500);
            $table->string('bio_en', 500);
            $table->primary(['organization_id', 'user_id']);
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
