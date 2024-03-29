<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$heasleyID = '1468764';
$db_request_faction_ids = new db_request();
$allMemberIDs = $db_request_faction_ids->getAllFactionIDs();
foreach ($allMemberIDs as $key => $factionID) {
  refreshFactionMembers($heasleyID, $factionID);
}


removeOldMembers();



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


function refreshFactionMembers($tornid, $factionid) {

  $db_request = new db_request();
  $apikey = $db_request->getRawAPIKeyByUserID($tornid);

  $api_request = new api_request($apikey);
  $factionData = $api_request->getFactionAPI($factionid);


  //save faction info to database
  $fid = $factionData['ID'];
  $fname = $factionData['name'];
  $leader = $factionData['leader'];
  $coleader = $factionData['co-leader'];
  $age = $factionData['age'];
  $best_chain = $factionData['best_chain'];
  $total_members = count($factionData['members']);
  $respect = $factionData['respect'];

  $row = $db_request->getFactionByFactionID($fid);

  if($row) {
    $db_request->updateFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);
  } else {
    $db_request->insertFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);
  }


  $members = $factionData['members']; //members array

  $dbMemberData = $db_request->getFactionMembersByFaction($fid);

  if(!empty($dbMemberData)) {

    $diff = array_diff_key($dbMemberData, $members);

    //delete member from database if exists in diff array
    while ($cut = current($diff)) {
      $cutuser = key($diff);
      $memberData = $db_request->getMemberByTornID($cutuser);
      if ($memberData) {
        $db_request->removeMemberByTornID($cutuser);
        $db_request->removeMemberInfoByTornID($cutuser);
      }
      next($diff);
    } //while

  }



  while ($member = current($members)) {
    $userid = key($members);
    $row = $db_request->getMemberByTornID($userid);

    if($row) {
      $db_request->updateMember($userid, $member);
    } else {
      $db_request->insertMember($userid, $fid, $member);
    }

    next($members);
  }



} //refreshFactionMembers
?>
