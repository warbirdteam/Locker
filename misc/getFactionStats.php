<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$db_request = new db_request();
$factions = $db_request->getFactionKeyholders();

foreach($factions as $faction) {
  getFactionStats($faction['userID'], $faction['factionID']);
}


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
