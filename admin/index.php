<?php
session_start();

include_once("../../../db_connect.php");
include_once("../../../db_connect_stats.php");

if(!isset($_SESSION['user_session'])){
	header("Location: index.php");
}

$sql = "SELECT tornid, username, password, useremail, userrole FROM users WHERE tornid=$_SESSION['user_session']";
	$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
	$row = mysqli_fetch_assoc($resultset);	
		
	if($row['userrole']!= "admin"){				
		header("Location: faction.php");
		exit;
	}
	
$strReport = "select strB4.Player, strPost.Contribution-strB4.Contribution AS Difference from strB4, strPost where strB4.Player=strPost.Player HAVING Difference > 0";
$defReport = "select defB4.Player, defPost.Contribution-defB4.Contribution AS Difference from defB4, defPost where defB4.Player=defPost.Player HAVING Difference > 0";
$dexReport = "select dexB4.Player, dexPost.Contribution-dexB4.Contribution AS Difference from dexB4, dexPost where dexB4.Player=dexPost.Player HAVING Difference > 0";
$spdReport = "select spdB4.Player, spdPost.Contribution-spdB4.Contribution AS Difference from spdB4, spdPost where spdB4.Player=spdPost.Player HAVING Difference > 0";

$str_result = mysqli_query($conn, $strReport) or die("Strength query error:". mysqli_error($conn));
	$row = mysqli_fetch_assoc($str_result);

$def_result = mysqli_query($conn, $defReport) or die("Defense query error:". mysqli_error($conn));
	$row = mysqli_fetch_assoc($def_result);
	
$dex_result = mysqli_query($conn, $dexReport) or die("Dexterity query error:". mysqli_error($conn));
	$row = mysqli_fetch_assoc($dex_result);

$spd_result = mysqli_query($conn, $spdReport) or die("Speed query error:". mysqli_error($conn));
	$row = mysqli_fetch_assoc($spd_result);

echo "Continue on!";

?>