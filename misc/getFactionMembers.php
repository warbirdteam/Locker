<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");


refreshFactionMembers('1468764', '13784'); //Warbirds
refreshFactionMembers('1468764', '35507'); //The Nest
refreshFactionMembers('1468764', '30085'); //Warbirds Next Gen
refreshFactionMembers('1468764', '37132'); //Fowl Med



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
