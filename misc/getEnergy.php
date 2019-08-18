<?php
include_once("db_connectPDO.php");

  	$stmt = $pdo->query("SELECT tornid,tornuserkey FROM users");
    foreach ($stmt as $row)
    {
      $apikey = $row['tornuserkey'];
      $jsonurl = "https://api.torn.com/user/?selections=timestamp,cooldowns,bars,basic,refills&key=" . $apikey;
      $json = file_get_contents($jsonurl);
      $data = json_decode($json, true);
      if (is_array($data) || is_object($data)) {
          if (isset($data['error'])) {
            echo 'Error';
          }
          else{
               if (isset($data['timestamp'])) {
                 //check if user exists in table
                 $sql = "SELECT userid FROM current_data WHERE userid = ?";
                 $stmtselect = $pdo->prepare($sql);
                 $stmtselect->execute([$data['player_id']]);
                 $row = $stmtselect->fetch();
                 if ($row){
                  $sql = "UPDATE current_data SET name = ?, energy = ?, cooldown_drug = ?, cooldown_booster = ?, refill_energy = ?, refill_nerve = ? WHERE userid = ?";
                  $stmtupdate = $pdo->prepare($sql);
                  $stmtupdate->execute([$data['name'],$data['energy']['current'] . '/' . $data['energy']['maximum'],$data['cooldowns']['drug'],$data['cooldowns']['booster'],$data['refills']['energy_refill_used'],$data['refills']['nerve_refill_used'],$data['player_id']]);
                 } else {
                  $sql = "INSERT INTO current_data (userid, name, energy, cooldown_drug, cooldown_booster, refill_energy, refill_nerve) VALUE(?,?,?,?,?,?,?)";
                	$stmtinsert = $pdo->prepare($sql);
                	$stmtinsert->execute([$data['player_id'],$data['name'],$data['energy']['current'] . '/' . $data['energy']['maximum'],$data['cooldowns']['drug'],$data['cooldowns']['booster'],$data['refills']['energy_refill_used'],$data['refills']['nerve_refill_used']]);
                }
               }//if
          }//else
      }
    }//foreach
?>
