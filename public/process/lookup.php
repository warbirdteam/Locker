<?php
//##### LEADERSHIP & ADMIN ONLY PAGE
//start the session array
session_start();
//If cannot find site ID, empty session array and send to login page with error message
if(!isset($_SESSION['siteID'])){
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
	exit;
}
if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership') {
	//##### LEADERSHIP & ADMIN ONLY PAGE
	//load classes files in classes folder
	include_once(__DIR__ . "/../../includes/autoloader.inc.php");
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: ../welcome.php");
	exit;
}


if (isset($_POST['fidlookup']) && !empty($_POST['fidlookup']) && is_numeric($_POST['fidlookup'])) {
  $fid = $_POST['fidlookup'];

  $get_apikey = new db_request();
  $faction_api_request = new api_request($get_apikey->getRawAPIKeyByUserID($_SESSION['userid']));
  
  $faction = $faction_api_request->getFactionAPI($fid);

  if (is_array($faction) || is_object($faction)) {
    if (isset($faction['error'])) {
      //return error code
      $_SESSION['error'] = "Error Code: ".$faction['error']['code'] . " using self apikey.";
      header("Location: ../welcome.php");
    }

    if (isset($faction['timestamp']) && !empty($faction['members'])) { //api data is real and not a dead faction

      $db_request = new db_request();
      $lookup_id = $db_request->insertFactionLookupFaction($faction);

      $db_request_api = new api_loop($faction['members'], "factionLookup");
      $data = $db_request_api->processData();



        foreach ($data as $member_id => $user) {

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
              $days_in_faction = (isset($user['faction']) && isset($user['faction']['days_in_faction'])) ? $user['faction']['days_in_faction'] : 0;

              $db_request->insertFactionLookupPlayer($lookup_id, $user['player_id'], $user['name'], $user['level'], $days_in_faction, $last_action, $donator, $xantaken, $attackswon, $defendswon, $property, $refills, $nerverefills, $boostersused, $energydrinkused, $statenhancers, $enemies);
          }//if timestamp

        } //foreach member row

        $error = new Success_Message("Faction lookup on ". $faction['name'] . " [" . $faction['ID'] . "] complete.","../faction-lookup.php");
        header("Location: ../faction-lookup.php");











    } //timestamp and has members


 }//isarray

} else {
  echo "error: no valid input for faction id.";header("Location: ../welcome.php");
} //fidlookup else return error: no valid input
?>
