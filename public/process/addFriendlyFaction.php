<?php
//##### LEADERSHIP & ADMIN ONLY PAGE
//start the session array
session_start();
//If cannot find site ID, empty session array and send to login page with error message
if(!isset($_SESSION['siteID'])){
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
	exit;
}
if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership') {
	//##### LEADERSHIP & ADMIN ONLY PAGE
	//load classes files in classes folder
	include_once(__DIR__ . "/../../includes/autoloader.inc.php");
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: ../welcome.php");
	exit;
}


if (isset($_POST['fidFriendly']) && !empty($_POST['fidFriendly'])) {
    $fid = $_POST['fidFriendly'];


    $pattern = "/^[0-9,]*$/";
    if (preg_match($pattern, $fid)) {
      //Loop through array of faction IDs
      $fidsArray = preg_split ("/\,/", $fid); 
      $get_apikey = new db_request();
      $apikey = $get_apikey->getRawAPIKeyByUserID($_SESSION['userid']);

      foreach ($fidsArray as $fid) {
        $api_request = new api_request($apikey);
        $faction = $api_request->getFactionAPI($fid);
        sleep(1);

        if (!empty($faction) && $faction['ID'] != NULL) {
    
          $db_request_check_friendly_faction = new db_request();
          $row = $db_request_check_friendly_faction->getFriendlyFactionByFactionID($fid);
    
          if (!empty($row)) {
            //faction is already in list of enemy factions
            continue;
          }
    
          $fid = $faction['ID'];
          $fname = $faction['name'];
          $leader = $faction['leader'];
          $coleader = $faction['co-leader'];
          $age = $faction['age'];
          $best_chain = $faction['best_chain'];
          $total_members = count($faction['members']);
          $respect = $faction['respect'];
          $timestamp = 0;
    
          $db_request_add_friendly_faction = new db_request();
          $db_request_add_friendly_faction->insertFriendlyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect, $timestamp);
    
          getFriendlyFactionMembers('1468764', $fid);
        } //if faction api exists
      }

      
      $_SESSION['success'] = "Factions successfully added to friendly list.";
      header("Location: ../war.php");
      exit;
    } else {
      if (!is_numeric($_POST['fidFriendly'])) {
        $_SESSION['error'] = "The faction you entered does not exist.";
        header("Location: ../war.php");
        exit;
      }
    }



    $get_apikey = new db_request();
    $apikey = $get_apikey->getRawAPIKeyByUserID($_SESSION['userid']);

    $api_request = new api_request($apikey);
    $faction = $api_request->getFactionAPI($fid);

    if (!empty($faction) && $faction['ID'] != NULL) {


      $db_request_check_enemy_faction = new db_request();
      $row = $db_request_check_enemy_faction->getFriendlyFactionByFactionID($fid);

      if (!empty($row)) {
        $_SESSION['error'] = "The faction you entered is already a friendly faction.";
        header("Location: ../war.php");
        exit;
      }

      $fid = $faction['ID'];
      $fname = $faction['name'];
      $leader = $faction['leader'];
      $coleader = $faction['co-leader'];
      $age = $faction['age'];
      $best_chain = $faction['best_chain'];
      $total_members = count($faction['members']);
      $respect = $faction['respect'];
      $timestamp = time();

      $db_request_add_friendly_faction = new db_request();
      $db_request_add_friendly_faction->insertFriendlyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect, $timestamp);

      getFriendlyFactionMembers("1468764", $fid);

      $_SESSION['success'] = "Friendly Faction <b>". $fname . " [" . $fid . "]</b> added.";
      header("Location: ../war.php");
      exit;
    } //if faction api exists
} //post fidEnemy set

$_SESSION['error'] = "The faction you entered does not exist.";
header("Location: ../war.php");
exit;


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
  $timestamp = time();

  $row = $db_request->getFriendlyFactionByFactionID($fid);

  if($row) {
    $db_request->updateFriendlyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect, $timestamp);
  } else {
    $db_request->insertFriendlyFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect, $timestamp);
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
