<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$db_request = new db_request();
$factions = $db_request->getAllFriendlyFactions();



foreach($factions as $faction) {
  if ($db_request->row_count > 5) {
    sleep(3);
  }
  getFriendlyFactionMembers('1468764', $faction['factionID']);
}



function getFriendlyFactionMembers($userid, $factionID) {

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

  $row = $db_request->getFriendlyFactionByFactionID($fid);

  if($row) {
    $db_request->updateFriendlyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);
  } else {
    $db_request->insertFriendlyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);
  }


  $members = $factionData['members']; //members array

  $dbMemberData = $db_request->getFriendlyMembersByFaction($fid);

  if(!empty($dbMemberData) && !empty($members)) {

    $diff = array_diff_key($dbMemberData, $members);

    //delete member from database if exists in diff array
    while ($cut = current($diff)) {
      $cutuser = key($diff);
      $memberData = $db_request->getFriendlyMemberByTornID($cutuser);
      if ($memberData) {
        $db_request->removeFriendlyMemberByTornID($cutuser);
      }
      next($diff);
    } //while

  }



  while ($member = current($members)) {
    $userid = key($members);
    $row = $db_request->getFriendlyMemberByTornID($userid);

    if($row) {
      $db_request->updateFriendlyMember($userid, $member);
    } else {
      $db_request->insertFriendlyMember($userid, $fid, $member);
    }

    next($members);
  }

} //getFriendlyFactionMembers Function




?>
