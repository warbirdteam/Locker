<?php

spl_autoload_register('myAutoLoader');
define('LOCKER_DIR', realpath(__DIR__ . '/../'));

function myAutoLoader($className) {
  $path = LOCKER_DIR . "/classes/";
  $extension = ".class.php";
  $fullPath = $path . $className . $extension;

  if (!file_exists($fullPath)) {
    return false;
  }



  include_once $fullPath;
}
?>
