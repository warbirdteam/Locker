<?php
include_once("../misc/db_connect.php");

setlocale(LC_MONETARY, 'en_US.UTF-8');

$stat = $_POST['stat'];
$threshold = $_POST['threshold']; 
$target = $_POST['target'];
$apikey = $_POST['key'];

check_user($target, $stat); //check if target and stat is already being monitored

        $url = "https://api.torn.com/user/" . $target ."?selections=timestamp,profile,personalstats&key=" . $apikey;
        $ownerinfo = "https://api.torn.com/user/?selections=timestamp,profile,basic,discord&key=" . $apikey;

        $data = file_get_contents($url);
        $owner = file_get_contents($ownerinfo);


        $stats = json_decode($data, true);
        $get_name = json_decode($owner, true);

        $time = date('m/d/Y H:i:s', $stats['timestamp']);
//        $enddate =  date('m/d/Y H:i:s', strtotime($time . " + $duration days"));
        $monitor_stat = $stats['personalstats'][$stat];
        $monitortarget = $stats['name'];
        $owner = $get_name['name'];
	$discord = $get_name['discord']['discordID'];

        if($stat == 'bountiesplaced') {
         $totalspent = $stats['personalstats']['totalbountyspent'];
          echo $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Total Bounty Spent: ' . $totalspent . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
          $msg =  $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Total Bounty Spent: ' . $totalspent . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
        }
	elseif($stat == 'bountiescollected') {
	 $totalbountyreward = $stats['personalstats']['totalbountyreward'];
         echo $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Total Bounty Reward: ' , $totalbountyreward . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
         $msg =  $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Total Bounty Reward: ' . $totalbountyreward . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
	}
	else {
         echo '<@' . $discord . '>' . ' | ' . $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
         $msg = '<@' . $discord . '>' . ' | ' . $time . ' | ' . 'Target: ' . $monitortarget . ' | '  . $_POST['stat'] . ': ' . $monitor_stat . ' | ' . 'Job Owner: ' . $owner . ' | ' . 'Threshold: ' . $_POST['threshold'] . "\r\n";
	}

$curl = curl_init("https://discordapp.com/api/webhooks/597206102668607519/jXDKX8mxYqcf9ZubBEPo0pG7b7sNZ-dymsuvsymLlZ6s4OnShj2AyBtikQstgm_FZziI");
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("content" => $msg, "username" => "Gypsy Bot")));

curl_exec($curl);


function check_target($target,$stat) {
$sql = 'select * from active_jobs where targettornid=' . $target . 'and statmonitored=' $stat;


}
?>

