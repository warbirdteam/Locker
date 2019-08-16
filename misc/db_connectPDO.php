<?php

$config = json_decode(file_get_contents(__DIR__ . '/../config/locker.json'), true);

if (json_last_error()) {
	die('Invalid json file.');
}

$host = $config['mysql']['server'];
$db   = $config['mysql']['database'];
$user = $config['mysql']['username'];
$pass = $config['mysql']['password'];
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
