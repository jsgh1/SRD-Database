<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void {
        Schema::create('person_position_catalogs', function (Blueprint $t) {
            $t->uuid('organization_id')->primary();
            $t->unsignedInteger('version')->default(0);
            $t->json('items');
            $t->timestamps();
        });
        Schema::table('persons', fn (Blueprint $t) => $t->string('position_label', 80)->nullable());
        foreach (['president'=>'Presidente','vicepresident'=>'Vicepresidente','secretary'=>'Secretario','treasurer'=>'Tesorero','fiscal'=>'Fiscal','other'=>'Otro'] as $code => $label) {
            DB::table('persons')->where('position_code', $code)->update(['position_label' => $label]);
        }
    }
    public function down(): void {
        Schema::table('persons', fn (Blueprint $t) => $t->dropColumn('position_label'));
        Schema::dropIfExists('person_position_catalogs');
    }
};
