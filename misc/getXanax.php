<?php
include_once("db_connectPDO.php");

$data = $pdo->query('SELECT tornuserkey FROM users')->fetchAll(PDO::FETCH_ASSOC);
$count = $pdo->query("SELECT count(*) FROM users")->fetchColumn();
$i = 0;

$stmt = $pdo->query("SELECT userid,factionid FROM members");
foreach ($stmt as $row) {

    $complete = false;
    while ($complete == false) {
        if ($i >= $count) {
          sleep(5);
          $i = 0;
        }
        $memurl = 'https://api.torn.com/user/' . $row['userid'] . '?selections=timestamp,basic,personalstats,profile&key=' . $data[$i]['tornuserkey'];
        $memdata = file_get_contents($memurl);
        $user = json_decode($memdata, true); // decode the JSON feed

        if (is_array($user) || is_object($user)) {
           if (isset($user['error']) && $user['error']['code'] == 2) {
             //incorrect key
             $i++;
             continue;//go back to while, try again with same user but different apikey.
           } else {
             if (isset($user['timestamp'])) {
               //check to see if personalstat exists (if personalstat is zero, it won't exists in api), else set to 0
                 if(isset($user['personalstats']['xantaken'])) {$xantaken = $user['personalstats']['xantaken'];}else{$xantaken = 0;}
                 if(isset($user['personalstats']['refills'])) {$refills = $user['personalstats']['refills'];}else{$refills = 0;}
                 if(isset($user['personalstats']['nerverefills'])) {$nerverefills = $user['personalstats']['nerverefills'];}else{$nerverefills = 0;}
                 if(isset($user['personalstats']['consumablesused'])) {$consumablesused = $user['personalstats']['consumablesused'];}else{$consumablesused = 0;}
                 if(isset($user['personalstats']['energydrinkused'])) {$energydrinkused = $user['personalstats']['energydrinkused'];}else{$energydrinkused = 0;}
                 if(isset($user['personalstats']['traveltimes'])) {$traveltimes = $user['personalstats']['traveltimes'];}else{$traveltimes = 0;}
                 if(isset($user['personalstats']['dumpsearches'])) {$dumpsearches = $user['personalstats']['dumpsearches'];}else{$dumpsearches = 0;}

                 $sql = "INSERT INTO xanax VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                 $stmtinsert = $pdo->prepare($sql);
                 $stmtinsert->execute([$row['userid'],$row['factionid'],$user['name'],$user['timestamp'],$xantaken,$refills,$nerverefills,$consumablesused,$energydrinkused,$traveltimes,$dumpsearches]);

               $complete = true;
               $i++;
             }//if timestamp
           }//else
        }//if isarray

    }//while

}//foreach

?>
