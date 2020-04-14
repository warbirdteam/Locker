<?php
session_start();
if(!isset($_SESSION['role'])){
			header("Location: ../index.php");
} else {
  if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership') {
    include_once(__DIR__ . "/../../includes/autoloader.inc.php");
    $connect = new DB_connect();
    $pdo = $connect->connect();

    $db_api = new DB_request();
    $rows_api = $db_api->getAPIKEYList();
    $count_api = $db_api->row_count;
} else {
		header("Location: ../welcome.php");
}
}

if (isset($_POST['fidlookup']) && !empty($_POST['fidlookup']) && is_numeric($_POST['fidlookup'])) {
    $fid = $_POST['fidlookup'];

if($count_api > 0){

    $get_apikey = new DB_request();
    $enc_apikey = $get_apikey->getSelfAPIKey($_SESSION['userid']);

    $uncryptSelf = new API_Crypt();
    $unenc_api = $uncryptSelf->unpad($enc_apikey['enc_api'], $enc_apikey['iv'], $enc_apikey['tag']);
    $apikey = $unenc_api;

    $factionurl = 'https://api.torn.com/faction/' . $fid . '?selections=timestamp,basic&key=' . $apikey;
    $factiondata = file_get_contents($factionurl);
    $faction = json_decode($factiondata, true); // decode the JSON feed


    if (is_array($faction) || is_object($faction)) {
       if (isset($faction['error'])) {
         //return error code
         echo "Error Code: ".$faction['error']['code'] . " using self apikey.";
       } else {

         if (isset($faction['timestamp']) && !empty($faction['members'])) { //api data is real and not a dead faction

           $sql = "INSERT INTO faction_lookup_factions (faction_id, faction_name, respect, leader, co_leader, age, best_chain, total_members) VALUES (?,?,?,?,?,?,?,?)";
           $stmtinsert = $pdo->prepare($sql);
           $stmtinsert->execute([$faction['ID'],$faction['name'],$faction['respect'],$faction['leader'],$faction['co-leader'],$faction['age'],$faction['best_chain'],count($faction['members'])]);

           $lookup_id = $pdo->lastInsertId();
           $i = 0;


             foreach ($faction['members'] as $member_id => $member) {


               $complete = false;
               while ($complete == false) {
                   if ($i >= $count_api) {
                     sleep(3);
                     $i = 0;
                   }

                   $uncrypt = new API_Crypt();
                   $unenc_api = $uncrypt->unpad($rows_api[$i]['enc_api'], $rows_api[$i]['iv'], $rows_api[$i]['tag']);
                   $apikey = $unenc_api;

                   $memurl = 'https://api.torn.com/user/' . $member_id . '?selections=timestamp,basic,profile,personalstats&key=' . $apikey;
                   $memdata = file_get_contents($memurl);
                   $user = json_decode($memdata, true); // decode the JSON feed

                   if (is_array($user) || is_object($user)) {
                      if (isset($user['error'])) {
                        //incorrect key
                        echo "Error Code: ".$user['error']['code']." using ".$rows_api[$i]['tornid']."'s key.";
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
                            $last_action = isset($user['last_action']['timestamp']) ? $user['last_action']['timestamp'] : "N/A";
                            $attackswon = isset($user['personalstats']['attackswon']) ? $user['personalstats']['attackswon'] : 0;
                            $defendswon = isset($user['personalstats']['defendswon']) ? $user['personalstats']['defendswon'] : 0;
                            $enemies = isset($user['enemies']) ? $user['enemies'] : 0;

                            $sql = "INSERT INTO faction_lookups (lookup_id, faction_id, userid, username, level, days_in_faction, last_action, donator_status, xanax, attackswon, defendswon, property, energy_refills, nerve_refills, boosters, cans, stat_enhancers, enemies) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $stmtinsert = $pdo->prepare($sql);
                            $stmtinsert->execute([$lookup_id, $faction['ID'], $user['player_id'], $user['name'], $user['level'], $member['days_in_faction'], $member['last_action']['timestamp'], $donator, $xantaken, $attackswon, $defendswon, $property, $refills, $nerverefills, $boostersused, $energydrinkused, $statenhancers, $enemies]);

                          $complete = true;
                          $i++;
                        }//if timestamp
                      }//else
                   }//if isarray

                   $complete = true;
               }//while complete


             } //foreach member row

             header("Location: ../faction-lookup.php");











         } //timestamp and has members

       } //else
    }//isarray























} else {echo "no api keys available";header("Location: ../welcome.php");}//count_api else return error: no api keys available

} else {echo "error: no valid input";header("Location: ../welcome.php");} //fidlookup else return error: no valid input
?>
