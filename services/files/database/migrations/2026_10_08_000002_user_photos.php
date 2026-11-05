<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql') throw new RuntimeException('Photo storage requires MySQL.');
        DB::statement('CREATE TABLE user_photos (
            organization_id CHAR(36) NOT NULL,
            user_id CHAR(36) NOT NULL,
            slot VARCHAR(16) NOT NULL,
            version BIGINT UNSIGNED NOT NULL,
            blob_id CHAR(48) NULL,
            bytes BIGINT UNSIGNED NOT NULL DEFAULT 0,
            sha256 CHAR(64) NULL,
            width INT UNSIGNED NULL,
            height INT UNSIGNED NULL,
            PRIMARY KEY (organization_id,user_id,slot),
            UNIQUE KEY (blob_id),
            FOREIGN KEY (organization_id) REFERENCES file_quotas(organization_id)
        ) ENGINE=InnoDB');
    }

    public function down(): void
    {
        throw new RuntimeException('Rollback destructivo deshabilitado: usar recuperación revisada.');
    }
};
