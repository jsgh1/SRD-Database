<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql') throw new RuntimeException('Photo storage requires MySQL.');
        DB::unprepared(file_get_contents(__DIR__.'/../schema.mysql.sql'));
    }
    public function down(): void
    {
        foreach (['outbox_events', 'file_garbage', 'person_photos', 'file_quotas'] as $table) DB::statement('DROP TABLE IF EXISTS '.$table);
    }
};
