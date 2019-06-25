<?php
define('CONFIG_DIR', realpath(__DIR__ . '/../config'));
define('REQUEST_ID', uniqid());
require_once('../vendor/autoload.php');

use Cascade\Cascade;
use Locker\Registry;
use Locker\Config;

$config = new Config();
$registry = new Registry();
$registry->setConfig($config);
Cascade::fileConfig($config['monologCascade']->toArray());

set_exception_handler(function($ex) {
	Cascade::getLogger('default')->error($ex);
	die("Error ID: " . REQUEST_ID);
});