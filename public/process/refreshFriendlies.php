<?php
session_start();
if(!isset($_SESSION['siteID'])){
  $_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: ../index.php");
}

if ($_SESSION['roleValue'] <= 2) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
}

include_once(__DIR__ . "/../../misc/getFriendlyFactionMembers.php");

$success = new Success_Message("Friendly Factions refreshed successfully.","../war.php");
header("Location: ../war.php");
exit;

?>
