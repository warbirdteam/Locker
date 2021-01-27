<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

getFactionContributors('1468764', '13784'); //Warbirds
getFactionContributors('1975338', '35507'); //Nest / deca


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

  foreach ($databaseData as $userID => $contributionData) {
    $db_request_energy = new db_request();
    $db_request_energy->insertMemberEnergyUsed($userID, $factionid, $contributionData['contributions']);
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
