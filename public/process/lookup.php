<?php
session_start();
if(!isset($_SESSION['role'])){
			header("Location: ../index.php");
} else {
  if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership') {
    include_once(__DIR__ . "/../../includes/autoloader.inc.php");

    $db_api = new db_request();
    $apikeys = $db_api->getAllAvailableRawAPIKeys();
    $count_api = $db_api->row_count;
} else {
		header("Location: ../welcome.php");
}
}

if (isset($_POST['fidlookup']) && !empty($_POST['fidlookup']) && is_numeric($_POST['fidlookup'])) {
    $fid = $_POST['fidlookup'];

if($count_api > 0){

    $get_apikey = new db_request();
    $apikey = $get_apikey->getRawAPIKeyByUserID($_SESSION['userid']);

    $factionurl = 'https://api.torn.com/faction/' . $fid . '?selections=timestamp,basic&key=' . $apikey;
    $factiondata = file_get_contents($factionurl);
    $faction = json_decode($factiondata, true); // decode the JSON feed


    if (is_array($faction) || is_object($faction)) {
       if (isset($faction['error'])) {
         //return error code
         echo "Error Code: ".$faction['error']['code'] . " using self apikey.";
       } else {

         if (isset($faction['timestamp']) && !empty($faction['members'])) { //api data is real and not a dead faction

					 $db_request = new db_request();

					 $lookup_id = $db_request->insertFactionLookupFaction($faction);

           $i = 0;


             foreach ($faction['members'] as $member_id => $member) {


               $complete = false;
               while ($complete == false) {
                   if ($i >= $count_api) {
                     sleep(3);
                     $i = 0;
                   }

                   $memurl = 'https://api.torn.com/user/' . $member_id . '?selections=timestamp,basic,profile,personalstats&key=' . $apikeys[$i];
                   $memdata = file_get_contents($memurl);
                   $user = json_decode($memdata, true); // decode the JSON feed

                   if (is_array($user) || is_object($user)) {
                      if (isset($user['error'])) {
                        //incorrect key
                        echo "Error Code: ".$user['error']['code'];
                        if ($user['error']['code'] == 2) {
                          //add reminder to update api key
                        }
                        $i++;
                        continue;//go back to while, try again with same user but different apikey.
                      } else {
                        if (isset($user['timestamp'])) {
                          //check to see if personalstat exists (if personalstat is zero, it won't exists in api), else set to 0
                            $xantaken = isset($user['personalstats']['xantaken']) ? $user['personalstats']['xantaken'] : 0;
                            $refills = isset($user['personalstats']['refills']) ? $user['personalstats']['refills'] : 0;
                            $nerverefills = isset($user['personalstats']['nerverefills']) ? $user['personalstats']['nerverefills'] : 0;
                            $boostersused = isset($user['personalstats']['boostersused']) ? $user['personalstats']['boostersused'] : 0;
                            $energydrinkused = isset($user['personalstats']['energydrinkused']) ? $user['personalstats']['energydrinkused'] : 0;
                            $statenhancers = isset($user['personalstats']['statenhancersused']) ? $user['personalstats']['statenhancersused'] : 0;
                            $donator = isset($user['donator']) ? $user['donator'] : 0;
                            $property = isset($user['property']) ? $user['property'] : "Shack";
                            $last_action = isset($user['last_action']['timestamp']) ? $user['last_action']['timestamp'] : 0;
                            $attackswon = isset($user['personalstats']['attackswon']) ? $user['personalstats']['attackswon'] : 0;
                            $defendswon = isset($user['personalstats']['defendswon']) ? $user['personalstats']['defendswon'] : 0;
                            $enemies = isset($user['enemies']) ? $user['enemies'] : 0;

														$db_request->insertFactionLookupPlayer($lookup_id, $user['player_id'], $user['name'], $user['level'], $member['days_in_faction'], $last_action, $donator, $xantaken, $attackswon, $defendswon, $property, $refills, $nerverefills, $boostersused, $energydrinkused, $statenhancers, $enemies);

                          $complete = true;
                          $i++;
                        }//if timestamp
                      }//else
                   }//if isarray

                   $complete = true;
               }//while complete


             } //foreach member row

						 $error = new Success_Message("Faction lookup on ". $faction['name'] . " [" . $faction['ID'] . "] complete.","../faction-lookup.php");
             header("Location: ../faction-lookup.php");











         } //timestamp and has members

       } //else
    }//isarray























} else {echo "no api keys available";header("Location: ../welcome.php");}//count_api else return error: no api keys available

} else {echo "error: no valid input";header("Location: ../welcome.php");} //fidlookup else return error: no valid input
?>
