<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$db_request = new db_request();
$factions = $db_request->getAllEnemyFactions();

foreach($factions as $faction) {
  getEnemyFactionMembers('1468764', $faction['factionID']);
}



function getEnemyFactionMembers($userid, $factionID) {

  $db_request = new db_request();
  $apikey = $db_request->getRawAPIKeyByUserID($userid);

  $api_request = new api_request($apikey);
  $factionData = $api_request->getFactionAPI($factionID);

  //save faction info to database
  $fid = $factionData['ID'];
  $fname = $factionData['name'];
  $leader = $factionData['leader'];
  $coleader = $factionData['co-leader'];
  $age = $factionData['age'];
  $best_chain = $factionData['best_chain'];
  $total_members = count($factionData['members']);
  $respect = $factionData['respect'];

  $row = $db_request->getEnemyFactionByFactionID($fid);

  if($row) {
    $db_request->updateEnemyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);
  } else {
    $db_request->insertEnemyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);
  }


  $members = $factionData['members']; //members array

  $dbMemberData = $db_request->getEnemyMembersByFaction($fid);

  if(!empty($dbMemberData) && !empty($members)) {

    $diff = array_diff_key($dbMemberData, $members);

    //delete member from database if exists in diff array
    while ($cut = current($diff)) {
      $cutuser = key($diff);
      $memberData = $db_request->getEnemyMemberByTornID($cutuser);
      if ($memberData) {
        $db_request->removeEnemyMemberByTornID($cutuser);
      }
      next($diff);
    } //while

  }



  while ($member = current($members)) {
    $userid = key($members);
    $row = $db_request->getEnemyMemberByTornID($userid);

    if($row) {
      $db_request->updateEnemyMember($userid, $member);
    } else {
      $db_request->insertEnemyMember($userid, $fid, $member);
    }

    next($members);
  }

} //getEnemyFactionMembers Function









function removeOldMembers() {
  $db_request_members = new db_request();
  $allMemberIDs = $db_request_members->getAllMembersIDs();
  $allMemberIDsByInfo = $db_request_members->getAllMembersIDsFromInfo();
  $diffs = array_diff($allMemberIDsByInfo,$allMemberIDs);
  foreach ($diffs as $diff){

    $db_request_members->removeMemberByTornID($diff);
    $db_request_members->removeMemberInfoByTornID($diff);
  }
}



?>
