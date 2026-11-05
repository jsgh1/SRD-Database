<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calendar_participants', function (Blueprint $table) {
            $table->uuid('event_id');
            $table->uuid('organization_id');
            $table->uuid('user_id');
            $table->string('name', 120);
            $table->timestamps();
            $table->primary(['event_id', 'user_id']);
            $table->index(['organization_id', 'user_id']);
            $table->foreign('event_id')->references('id')->on('calendar_events');
        });
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperaciÃ³n revisada.');
    }
};
