<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");


refreshFactionMembers('1468764', '13784');
refreshFactionMembers('1468764', '35507');
refreshFactionMembers('1468764', '30085');



function refreshFactionMembers($tornid, $factionid) {

  $db_request = new DB_request2();
  $apikey = $db_request->getRawAPIKeyByUserID($tornid);

  $api_request = new api_request($apikey);
  $factionData = $api_request->getFactionAPI($factionid);


  $fid = $factionData['ID'];
  $fname = $factionData['name'];
  $members = $factionData['members']; //members array

  $dbMemberData = $db_request->getFactionMembersByFaction($fid);

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
