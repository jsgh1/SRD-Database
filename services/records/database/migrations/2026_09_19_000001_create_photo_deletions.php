<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('photo_deletions', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('organization_id'); $t->uuid('person_id'); $t->uuid('actor_id');
            $t->uuid('correlation_id'); $t->timestamp('created_at');
            $t->timestamp('delivered_at')->nullable();
            $t->unsignedInteger('attempts')->default(0); $t->timestamp('next_attempt_at');
            $t->unique(['organization_id', 'person_id']);
            $t->index(['delivered_at', 'next_attempt_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('photo_deletions'); }
};
