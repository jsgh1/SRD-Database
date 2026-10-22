<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('planilla_settings', function (Blueprint $table) {
            $table->string('h1_en', 120)->nullable();
            $table->string('h2_en', 120)->nullable();
            $table->string('h3_en', 120)->nullable();
        });
        DB::table('planilla_settings')->where('h1', 'JUNTA DE ACCIÓN COMUNAL')->update(['h1_en' => 'COMMUNITY ACTION BOARD']);
        DB::table('planilla_settings')->where('h3', 'PLANILLA DE FIRMAS')->update(['h3_en' => 'SIGNATURE SHEET']);
    }

    public function down(): void
    {
        Schema::table('planilla_settings', fn (Blueprint $table) => $table->dropColumn(['h1_en', 'h2_en', 'h3_en']));
    }
};
