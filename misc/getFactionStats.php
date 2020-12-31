<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");


getFactionStats('1468764', '13784'); //Warbirds


function getFactionStats($tornid, $factionid) {
$db_request = new db_request();
$apikey = $db_request->getRawAPIKeyByUserID($tornid);

$api_request = new api_request($apikey);
$factionData = $api_request->getFactionStats($factionid);


  if ($factionData) {
    $fid = $factionData['ID'];

    $db_request_factionStats = new db_request();
    $db_request_factionStats->insertFactionStats($fid, $factionData);

  }
}
?>
