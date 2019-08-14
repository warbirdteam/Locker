<?php
// Temporary quick and firty replacement for original
// db_connect.php until it is replaced with PDO.
$config = json_decode(file_get_contents(__DIR__ . '/../config/locker.json'), true);

if (json_last_error()) {
	die('Invalid json file.');
}

$conn = mysqli_connect($config['mysql']['server'], $config['mysql']['username'], $config['mysql']['password'], $config['mysql']['database']);

if (!$conn) {
	die('Database connection failure.');
}
