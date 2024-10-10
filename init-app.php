<?php
spl_autoload_extensions(".php");
spl_autoload_register();

use Helpers\Settings;
use Database\MySQLWrapper;

$opts = getopt('', ['migrate']);
if(isset($opts['migrate'])){
    printf('Database migration enabled');
}

$mysqli = new MySQLWrapper();

$charaset = $mysqli->get_charset();

if($charaset == null) throw new Exception('Charaset could be read');

$mysqli->close();
