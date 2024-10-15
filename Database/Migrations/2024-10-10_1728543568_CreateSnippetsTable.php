<?php
namespace Database\Migrations;

use Database\SchemaMigration;

class CreateSnippetsTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return [
            "CREATE TABLE snippets (
                id INT PRIMARY KEY AUTO_INCREMENT,
                snippet TEXT NOT NULL,
                url VARCHAR(255) NOT NULL,
                programing_language VARCHAR(30) NOT NULL,
                sent_time DATETIME NOT NULL,
                expiration_date DATETIME NOT NULL
            )"
        ];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [
            "DROP TABLE snippets"
        ];
    }
}