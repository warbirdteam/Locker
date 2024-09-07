<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$db_request = new db_request();
$factions = $db_request->getFactionKeyholders();

foreach($factions as $faction) {
    getFactionRankedWars($faction['userID'], $faction['factionID']);
}


getFactionRankedWars($faction['userID'], $faction['factionID']);


function getFactionRankedWars($tornid, $factionid) {
  $db_request = new db_request();
  $apikey = $db_request->getRawAPIKeyByUserID($tornid); //get apikey of user from database

  $api_request = new api_request($apikey);
  $factionData = $api_request->getFactionRankedWars($factionid); //get faction api data

  if ($factionData) { //if the data exists (null if torn dead or something)
    $wars = $factionData['rankedwars'];

    foreach ($wars as $warID => $warData) { //loop through data
        $war = $warData['war'];
        $factions = $warData['factions'];

        $friendlyFactionID = $factionid;
        $friendlyFactionName  = $factions[$factionid]['name'];
        $friendlyFactionScore = $factions[$factionid]['score'];

        $enemyFactionID = 0;
        $enemyFactionName = "";
        $enemyFactionScore = 0;

        foreach ($factions as $faction_ID => $factionData) {
            if ($faction_ID != $factionid) {
                $enemyFactionID = $faction_ID;
                $enemyFactionName = $factionData['name'];
                $enemyFactionScore = $factionData['score'];
            }
        }

        $start_timestamp = $war['start'];
        $end_timestamp = $war['end'];
        $target = $war['target'];
        $final_target = null;
        $winner = $war['winner'];

        $db_rw = $db_request->getRankedWarByWarID($warID); //check for rw in database already
        if ($db_rw == null) { //not in DB
            if ($winner != 0 && $end_timestamp != 0) {
                $final_target = $target;
            }

            $db_request->insertRankedWar($warID, $enemyFactionID, $enemyFactionName, $enemyFactionScore, $friendlyFactionID, $friendlyFactionName, $friendlyFactionScore, $start_timestamp, $end_timestamp, $winner, $target, $final_target);

        } else { //War already exists in DB

            if ($winner == 0 && $end_timestamp == 0) { //War has not started, do not change
                continue;
            }

            if ($winner != 0 && $end_timestamp != 0) { //War has ended, try to add to db
                if ($db_rw['report_progress'] == "complete" || $db_rw['report_progress'] == "unavailable") { //war report already complete or unavailable
                    continue;
                }
                
                if ($db_rw['winner'] == 0 || $db_rw['end_timestamp'] == 0) {
                    $db_request->updateRankedWarWinnerAndTimestamp($warID, $end_timestamp, $winner, $final_target);
                }
            }
        }


    } //foreach crime

  } //if faction data

} //function getcrimes


?>
