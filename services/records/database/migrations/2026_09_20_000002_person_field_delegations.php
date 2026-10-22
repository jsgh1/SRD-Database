<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::table('person_field_schemas', fn (Blueprint $t) => $t->json('delegated_roles')->nullable()); }
    public function down(): void { Schema::table('person_field_schemas', fn (Blueprint $t) => $t->dropColumn('delegated_roles')); }
};
