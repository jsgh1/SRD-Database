<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::unprepared(file_get_contents(__DIR__.'/../asset-photos.mysql.sql'));
    }
    public function down(): void { DB::statement('DROP TABLE IF EXISTS asset_photos'); }
};
