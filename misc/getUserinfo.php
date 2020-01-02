<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$connect = new DB_connect();
$pdo = $connect->connect();

$db_members = new DB_request();
$rows = $db_members->getFactionMembers();
$count = $db_members->row_count;

$db_api = new DB_request();
$rows_api = $db_api->getAPIKEYList();
$count_api = $db_api->row_count;

$i = 0;

if($count > 0 && $count_api > 0){

  foreach ($rows as $row){


    $complete = false;
    while ($complete == false) {
        if ($i >= $count_api) {
          sleep(5);
          $i = 0;
        }

        $uncrypt = new API_Crypt();
        $unenc_api = $uncrypt->unpad($rows_api[$i]['enc_api'], $rows_api[$i]['iv'], $rows_api[$i]['tag']);
        $apikey = $unenc_api;

        $memurl = 'https://api.torn.com/user/' . $row['userid'] . '?selections=timestamp,basic,personalstats,profile&key=' . $apikey;
        $memdata = file_get_contents($memurl);
        $user = json_decode($memdata, true); // decode the JSON feed

        if (is_array($user) || is_object($user)) {
           if (isset($user['error'])) {
             //incorrect key
             $i++;
             continue;//go back to while, try again with same user but different apikey.
           } else {
             if (isset($user['timestamp'])) {
                 echo "<pre>".$user['name']." [".$user['player_id']."]</pre>";
               //check to see if personalstat exists (if personalstat is zero, it won't exists in api), else set to 0
                 $xantaken = isset($user['personalstats']['xantaken']) ? $user['personalstats']['xantaken'] : 0;
                 $refills = isset($user['personalstats']['refills']) ? $user['personalstats']['refills'] : 0;
                 $nerverefills = isset($user['personalstats']['nerverefills']) ? $user['personalstats']['nerverefills'] : 0;
                 $consumablesused = isset($user['personalstats']['consumablesused']) ? $user['personalstats']['consumablesused'] : 0;
                 $energydrinkused = isset($user['personalstats']['energydrinkused']) ? $user['personalstats']['energydrinkused'] : 0;
                 $traveltimes = isset($user['personalstats']['traveltimes']) ? $user['personalstats']['traveltimes'] : 0;
                 $dumpsearches = isset($user['personalstats']['dumpsearches']) ? $user['personalstats']['dumpsearches'] : 0;
                 $overdosed = isset($user['personalstats']['overdosed']) ? $user['personalstats']['overdosed'] : 0;
                 $statenhancers = isset($user['personalstats']['statenhancersused']) ? $user['personalstats']['statenhancersused'] : 0;
                 $donator = isset($user['donator']) ? $user['donator'] : 0;
                 $property = isset($user['property']) ? $user['property'] : "Shack";
                 $last_action = isset($user['last_action']['relative']) ? $user['last_action']['relative'] : "N/A";

                 $sql = "INSERT INTO memberinfo (factionid, userid, username, donator, property, last_action, xanax, overdosed, refill_energy, refill_nerve, consumablesused, energydrinkused, statenhancersused, travel, dumpsearches) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                 $stmtinsert = $pdo->prepare($sql);
                 $stmtinsert->execute([$row['factionid'],$row['userid'],$user['name'],$donator,$property,$last_action,$xantaken,$overdosed,$refills,$nerverefills,$consumablesused,$energydrinkused,$statenhancers,$traveltimes,$dumpsearches]);

               $complete = true;
               $i++;
             }//if timestamp
           }//else
        }//if isarray

$complete = true;
$i++;
    }//while complete


  } //foreach member row

}//if count




?>