<?php
namespace Database;

use mysqli;
use Helpers\Settings;

class MySQLWrapper extends mysqli {
    public function __construct(?string $hostname = 'localhost', ?string $username = null, ?string $password = null, ?string $database = null, ?int $port = null, ?string $socket = null)
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $username = $username ?? Settings::env('DATABASE_USER');
        $database = $database ?? Settings::env('DATABASE_NAME');

        parent::__construct($hostname, $username, $password, $database, $port, $socket);
    }

    public function getDatabaseName(): string
    {
        return $this->query("SELECT database() AS the_db")->fetch_row()[0];
    }
}