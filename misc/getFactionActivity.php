<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$db_request = new db_request();
$factions = $db_request->getFactionKeyholders();

foreach($factions as $faction) {
    getFactionActivity($faction['factionID']);
}


function getFactionActivity($factionid) {
  
    $factionData = getFactionData($factionid);

    $timestamp = $factionData['timestamp'];
  
    $members = $factionData['members'];

    foreach ($members as $memberID => $member) { //loop through data
        if ($member['last_action']['status'] == "Offline") {
            $activity_status = 0;
        }
        if ($member['last_action']['status'] != "Offline" && (($timestamp - $member['last_action']['timestamp']) <= 210 )) {
            $activity_status = 1;
        } else {
            $activity_status = 0;
        }

        $db_request_activity = new db_request();
        $db_request_activity->insertMemberActivity($memberID, $activity_status, $timestamp);
    }

}

function getFactionData($factionid) {
    try {
        $db_request = new db_request();
        $api_request = new api_request($db_request->getRandomAPIKey());
        $data = $api_request->getFactionAPI($factionid); //get faction api data
        return $data;
    } catch (Exception $e) {
        getFactionData($factionid);
    }
}