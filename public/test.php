<?php


$url = "https://api.torn.com/user/?selections=timestamp,basic,discord&key=jIirMCNvK8q2hf8u";

$json = file_get_contents($url);

$stuff = json_decode($json, true);

var_dump($stuff);

?>
