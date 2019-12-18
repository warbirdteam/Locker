<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

    $connect = new DB_connect();
    $pdo = $connect->connect();

getFactionUsers('1468764', $pdo); //get Warbird Members via Heasleys4hemp key
getFactionUsers('2169837', $pdo); //get Nest Members via Vulture Key

function getFactionUsers($id, $pdo) {

  $sql = "SELECT tornid,enc_api,iv,tag FROM users WHERE tornid = ?";
  $stmtselect = $pdo->prepare($sql);
  $stmtselect->execute([$id]);
  $row = $stmtselect->fetch();

  $uncrypt = new API_Crypt();
  $unenc_api = $uncrypt->unpad($row['enc_api'], $row['iv'], $row['tag']);

  $apikey = $unenc_api;

  $url ='https://api.torn.com/faction/?selections=timestamp,basic&key=' . $apikey;
  $data = file_get_contents($url);
  $faction = json_decode($data, true); // decode the JSON feed

  if (is_array($faction) || is_object($faction)) {
     if (isset($faction['error'])) {
       echo 'Error';
     } else {
     if (isset($faction['timestamp'])) { //I use timestamp to confirm the api is working and not erroring

       $fname = $faction['name'];
       $members = $faction['members'];//members array
       $fid = $faction['ID'];

       //get members from database in correct format, and in single faction currently being looked at
       $sql = "SELECT * FROM members WHERE factionid = ?";
       $stmtselect = $pdo->prepare($sql);
       $stmtselect->execute([$fid]);
       $data = $stmtselect->fetchAll(PDO::FETCH_UNIQUE);

       //find members in database that no longer exist in faction
       $diff = array_diff_key($data, $members);

       //delete member from database if exists in diff array
       while ($cut = current($diff)) {
          $cutuser = key($diff);

          $sql = "SELECT userid FROM members WHERE userid = ?";
          $stmtselect = $pdo->prepare($sql);
          $stmtselect->execute([$cutuser]);
          $row = $stmtselect->fetch();

          if($row) {
            $sql = "DELETE FROM members WHERE userid = ?";
            $stmtdelete = $pdo->prepare($sql);
            $stmtdelete->execute([$cutuser]);
          }

        next($diff);
      }//while

       while ($member = current($members)) {
              $userid = key($members);

              $sql = "SELECT userid FROM members WHERE userid = ?";
              $stmtselect = $pdo->prepare($sql);
              $stmtselect->execute([$userid]);
              $row = $stmtselect->fetch();

              if($row) {
                $sql = "UPDATE members SET name = ?, factionid = ?, days_in_faction = ?, last_action = ?, status = ? WHERE userid = ?";
                $stmtinsert = $pdo->prepare($sql);
                $stmtinsert->execute([$member['name'],$fid,$member['days_in_faction'],$member['last_action']['relative'],$member['status']['description'] . "  " . $member['status']['details'],$userid]);
              } else {
                $sql = "INSERT INTO members VALUES (?,?,?,?,?,?)";
                $stmtinsert = $pdo->prepare($sql);
                $stmtinsert->execute([$userid,$fid,$member['name'],$member['days_in_faction'],$member['last_action']['relative'],$member['status']['description'] . "   " . $member['status']['details']]);
              }

       next($members);
       } //while

     }//if faction timestamp
   }//else
 }//if isarray

}//getfactionusers
?>
