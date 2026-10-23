<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->uuid('person_id')->nullable()->index();
        });
        Schema::table('memberships', function (Blueprint $table) {
            $table->uuid('person_id')->nullable();
            $table->unique(['organization_id', 'person_id']);
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Los vínculos persona-cuenta requieren una reversión revisada.');
    }
};
