<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$db_request_check_gymspy_status = new db_request();
$bool = $db_request_check_gymspy_status->getToggleStatusByName("gymspy");

if ($bool == 1) {
  //Get faction keyholders (api key access for faction data)
  $db_request = new db_request();
  $factions = $db_request->getFactionKeyholders();

  foreach($factions as $faction) {
    getFactionContributors($faction['userID'], $faction['factionID']);
  }
}

function getFactionContributors($tornid, $factionid) {
  $db_request = new db_request();
  $apikey = $db_request->getRawAPIKeyByUserID($tornid); //get apikey of user from database

  $api_request = new api_request($apikey);

  $stats  = ["gymstrength","gymdefense","gymspeed","gymdexterity"];

  foreach ($stats as $type) {
    $json = $api_request->getFactionContributions($factionid, $type);
    saveFactionContributors($factionid, $json, $type);
  }

  $databaseData = [];


  foreach ($stats as $type) {

    $fileBefore = __DIR__.'/../TornAPIs/' . $factionid .'/'. 'contributions' .'/'. $type .'_before_daily.json';
    $fileAfter = __DIR__.'/../TornAPIs/' . $factionid .'/'. 'contributions' .'/'. $type.'_after_daily.json';

    if (file_exists($fileAfter)) {
      $handle = fopen($fileAfter, "r");
      $contents = fread($handle, filesize($fileAfter));
      fclose($handle);
      $data = unserialize($contents);
      $afterData = json_decode($data, true); // decode the JSON feed
    } else {
      die("After file does not exist.");
    }

    if (file_exists($fileBefore)) {
      $handle = fopen($fileBefore, "r");
      $contents = fread($handle, filesize($fileBefore));
      fclose($handle);
      $data = unserialize($contents);
      $beforeData = json_decode($data, true); // decode the JSON feed
    } else {
      die("Before file does not exist.");
    }

      if ($afterData && $afterData['contributors'] && $afterData['contributors'][$type]) {
      if ($beforeData && $beforeData['contributors'] && $beforeData['contributors'][$type]) {

        foreach($afterData['contributors'][$type] as $userID => $contributed) {
          if ($beforeData['contributors'][$type][$userID]) {
            if ($beforeData['contributors'][$type][$userID]['contributed'] == $contributed['contributed']) {
              //No change, no energy used in this type
            } else {
              $dif = $contributed['contributed'] - $beforeData['contributors'][$type][$userID]['contributed'];
              //energy difference, energy has been trained in this type
              $databaseData[$userID]['contributions'][$type] = $dif;
            }
          }
        }

      }
      }

  }

  $totalContributions = [];

  foreach ($databaseData as $userID => $contributionData) {
    $db_request_energy = new db_request();
    $db_request_energy->insertMemberEnergyUsed($userID, $factionid, $contributionData['contributions']);

    //Add totals for each contribution type (strength, dex, speed, defense)
    foreach($contributionData['contributions'] as $key => $value) {
      if (!empty($totalContributions[$userID]) && !empty($totalContributions[$userID]['total'])) {
        $totalContributions[$userID]['total'] = ($totalContributions[$userID]['total'] + $value);
      } else {
        $totalContributions[$userID]['total'] = $value;
      }
    }
  }

  //Sort Array by total
  uasort($totalContributions, function($b, $a) {
      return $a['total'] <=> $b['total'];
  });

  $discordMessage = "```";

  $db_request_faction = new $db_request();
  $faction = $db_request_faction->getFactionByFactionID($factionid);

  if ($faction) {
    $factionName = $faction['factionName'];
  } else {
    $factionName = $factionid;
  }

  $db_request_gymspy_webhook = new db_request();

  //custom thing to get correct webhook id
  switch ($factionid) {
    //WarBirds
    case 13784:
      $gymspyWebhook = $db_request_gymspy_webhook->getWebhookByName('wbgspy');
    break;
    //Nest
    case 35507:
      $gymspyWebhook = $db_request_gymspy_webhook->getWebhookByName('negspy');
    break;
    //Fowl
    case 37132:
      $gymspyWebhook = $db_request_gymspy_webhook->getWebhookByName('fwgspy');
    break;

    default:
      $gymspyWebhook = $db_request_gymspy_webhook->getWebhookByName('gymspy'); //default gymspy channel if can't find others
    break;
  }


  foreach ($totalContributions as $userID => $total) {
    $db_request_member = new $db_request();
    $member = $db_request_member->getMemberByTornID($userID);

    if ($member && $member['tornName']) {
      $discordMessage .= $member['tornName'] . " [" . $userID . "]: " . number_format($total['total']) . "e\n";
    } else {
      $discordMessage .= "[" . $userID . "]: " . number_format($total['total']) . "e\n";
    }
  }

  $discordMessage .= '```';

  if ($discordMessage != '``````') { //only send discord message if energy has been used

    $url = 'https://discord.com/api/webhooks/' . $gymspyWebhook;
    //create discord webhook message
    $POST = [
      'content' => '',
      'username' => 'Gym Spy Bot',
      'embeds' => [
        [
         'title' => "These members of ".$factionName." have just trained in the gym.",
         "type" => "rich",
         "description" => $discordMessage,
         "color" => hexdec("6cad2b"),
        ]
      ]
    ];

    $headers = [ 'Content-Type: application/json; charset=utf-8' ];

    //use curl to send discord webhook message
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
    $response   = curl_exec($ch);

  }

}//function getFactionContributors



function saveFactionContributors($factionid, $json, $type) {

  $fileBefore = __DIR__.'/../TornAPIs/' . $factionid .'/'. 'contributions' .'/'. $type .'_before_daily.json';
  $fileAfter = __DIR__.'/../TornAPIs/' . $factionid .'/'. 'contributions' .'/'. $type.'_after_daily.json';


  if (is_array($json) || is_object($json)) {
    if (isset($json['error'])) {
      exit($json['error']['code']);
    }

    if (!is_dir(__DIR__.'/../TornAPIs/' . $factionid)) {
      mkdir(__DIR__.'/../TornAPIs/' . $factionid);
    }

    if (!is_dir(__DIR__.'/../TornAPIs/' . $factionid .'/'. 'contributions')) {
      mkdir(__DIR__.'/../TornAPIs/' . $factionid .'/'. 'contributions');
    }

    if (file_exists($fileAfter)) {
        copy($fileAfter, $fileBefore); //copy current "after" and overwrite to "before"
    }

    $data = json_encode($json, true); // decode the JSON feed

    $f=fopen($fileAfter,'w');
    fwrite($f,serialize($data)); //overwrite current "after" with new data
    fclose($f);

  }
}



?>
