<?php

$host = "localhost";
$user = "root";
$pass = "Semaj000";
$db = "torn";
$conn = mysqli_connect($host,$user,$pass,$db);
if(!$conn) {
	echo "Error: uable to connecto to MySQL." . PHP_EOL;
	echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
	echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
	exit;
}


//include_once("../misc/db_connect.php");

setlocale(LC_MONETARY, 'en_US.UTF-8');

$stat = $_POST['stat'];
$threshold = $_POST['threshold'];
$target = $_POST['target'];
$apikey = $_POST['key'];

$user_count = check_target($target, $stat, $conn); //check if target and stat is already being monitored

if($user_count >= 1 ) {
	echo "User and stat already being monitored";
	exit;
  } else if ($user_count == 0){
        $url = "https://api.torn.com/user/" . $target ."?selections=timestamp,profile,personalstats&key=" . $apikey;
        $ownerinfo = "https://api.torn.com/user/?selections=timestamp,profile,basic,discord&key=" . $apikey;

        $data = file_get_contents($url);
        $owner = file_get_contents($ownerinfo);


        $stats = json_decode($data, true);
        $get_name = json_decode($owner, true);


        $time = date('Y-m-d H:i:s', $stats['timestamp']);
        $enddate =  date('Y-m-d H:i:s', strtotime($time . " + 14 days"));
        $monitor_stat = $stats['personalstats'][$stat];
        $monitortarget = $stats['name'];
        $owner = $get_name['name'];
	$ownerID = $get_name['player_id'];
	$discord = $get_name['discord']['discordID'];

        if($stat == 'bountiesplaced') {
         $totalspent = $stats['personalstats']['totalbountyspent'];
          echo 'Added to Datbase: ' . $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Total Bounty Spent: ' . $totalspent . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
          $msg =  $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Total Bounty Spent: ' . $totalspent . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
	  $sql = "insert into active_jobs (ndx,targetname,targettornid,statmonitored,stat_value,totalspent,jobowner,jobownerid,threshold,startdate,enddate,apikey) values('','$monitortarget','$target','$stat','$monitor_stat','$totalspent','$owner',,'$ownerID','$threshold','$time','$enddate','$apikey')";
	  mysqli_query($conn,$sql) or die('Error: Bounties Placed Query');
	sendit($msg);
        }
	elseif($stat == 'bountiescollected') {
	 $totalbountyreward = $stats['personalstats']['totalbountyreward'];
         echo $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Total Bounty Reward: ' , $totalbountyreward . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
         $msg =  $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Total Bounty Reward: ' . $totalbountyreward . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
         $sql = "insert into active_jobs (ndx,targetname,targettornid,statmonitored,stat_value,totalspent,jobowner,jobownerid,threshold,startdate,enddate,apikey) values('','$monitortarget','$target','$stat','$monitor_stat','$totalbountyreward','$owner','$ownerID','$threshold','$time','$enddate','$apikey')";
	 mysqli_query($conn,$sql) or die('Error: Bounties Collected Query');
	sendit($msg);
	}
	else {
         echo   '<@' . $discord . '>' . ' | ' . $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
         $msg = '<@' . $discord . '>' . ' | ' . $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
	 $sql = "insert into active_jobs (ndx,targetname,targettornid,statmonitored,stat_value,jobowner,jobownerid,threshold,startdate,enddate,apikey) values ('','$monitortarget','$target','$stat','$monitor_stat','$owner','$ownerID','$threshold','$time','$enddate','$apikey')";
	 mysqli_query($conn,$sql) or die('Error: All Else Insert Query');
	sendit($msg);
	}
    }else if ($rowcount = '') {
	echo "There has been error: Beep boo boo bop";
	exit;



} // end BIG IF statement



function check_target($target,$stat,$conn) {
	$sql = "select * from active_jobs where targettornid='" . $target . "' and statmonitored='" . $stat . "'";

	$result = mysqli_query($conn, $sql);

	if(!$result) {
 	  $rowcount = 0;
	return $rowcount;
 	} else {
	  $rowcount = mysqli_num_rows($result);
	return $rowcount;
 	}
}
function sendit($msg){
	$curl = curl_init("https://discordapp.com/api/webhooks/597206102668607519/jXDKX8mxYqcf9ZubBEPo0pG7b7sNZ-dymsuvsymLlZ6s4OnShj2AyBtikQstgm_FZziI");
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("content" => $msg, "username" => "Mr. Boombastic")));
	curl_exec($curl);
}

?>
