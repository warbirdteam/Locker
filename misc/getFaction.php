<?php

function getFactionInfo($apikey,$fid) {

   $url = 'https://api.torn.com/faction/' . $fid . '?selections=timestamp,basic,upgrades,stats&key=' . $apikey; // url to api json
   $data = file_get_contents($url);
   $file = 'api/' . $fid . '.json';

   $factions = json_decode($data, true); // decode the JSON feed


   if ($factions['error']) {
     echo 'Error';
   } else { if ($factions['timestamp']) {
     file_put_contents($file, serialize($data));
   }}
}



function getFactionTree($apikey) {

   $url = 'https://api.torn.com/torn/?selections=timestamp,factiontree&key=' . $apikey;
   $data = file_get_contents($url);
   $file = 'api/factiontree.json';
   $factions = json_decode($data, true);
   if ($factions['error']) {
     echo 'Error';
   } else { if ($factions['timestamp']) {
     file_put_contents($file, serialize($data));
   }}


}

//Warbird's related
//getFactionInfo('****************','35507'); //Skive's Key / The Nest ID  - Inactive
getFactionInfo('****************','35507'); //Hakawai's Key / The Nest ID
getFactionInfo('********','13784'); //Heasleys4hemp's key / Warbirds ID
//getFactionTree('********'); //Heasleys4hemp's key  // only needed this to happen once
?>
