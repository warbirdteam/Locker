<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

    $connect = new DB_connect();
    $pdo = $connect->connect();

    $db_api = new DB_request();
    $rows = $db_api->getAPIKEYList();
    $count = $db_api->row_count;

    if($count > 0){

    foreach ($rows as $row){

      $uncrypt = new API_Crypt();
      $unenc_api = $uncrypt->unpad($row['enc_api'], $row['iv'], $row['tag']);

      $apikey = $unenc_api;
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
  }//if Count
?>
