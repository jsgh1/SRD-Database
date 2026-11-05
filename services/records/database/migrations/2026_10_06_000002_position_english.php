<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('persons', fn (Blueprint $table) => $table->string('position_label_en', 80)->nullable()->after('position_label'));
        foreach (['president'=>['Presidente','President'], 'vicepresident'=>['Vicepresidente','Vice president'],
            'secretary'=>['Secretario','Secretary'], 'treasurer'=>['Tesorero','Treasurer'],
            'fiscal'=>['Fiscal','Controller'], 'other'=>['Otro','Other']] as $code => [$spanish, $english]) {
            DB::table('persons')->where('position_code', $code)->where('position_label', $spanish)
                ->update(['position_label_en' => $english]);
        }
    }

    public function down(): void {
        Schema::table('persons', fn (Blueprint $table) => $table->dropColumn('position_label_en'));
    }
};
