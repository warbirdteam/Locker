<?php

class DB_connect {

  private $host;
  private $username;
  private $password;
  private $database;


  private function connect() {
    $config = json_decode(file_get_contents(__DIR__ . '/../config/locker.json'), true);

    $this->host = $config['mysql']['server'];
    $this->username = $config['mysql']['username'];
    $this->password = $config['mysql']['password'];
    $this->database   = $config['mysql']['database'];
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$this->host;dbname=$this->database;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];


    try {
         $pdo = new PDO($dsn, $this->username, $this->password, $options);
    } catch (\PDOException $e) {
         throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    return $pdo;

  }


}

?>
