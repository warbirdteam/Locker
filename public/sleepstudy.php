<?php

include_once("/var/www/html/Warbirds/Locker/misc/db_connect.php");

        $url = "https://api.torn.com/faction/?selections=timestamp,basic&key=" . "AuSfpjzFPNZ07Yaw";

        $data = file_get_contents($url);

        $stats = json_decode($data);

        $time = date('m/d/Y H:00:00');
        $hour_status ='';

        foreach($stats->members as $idx => $member) {
        if(strpos($member->last_action, 'minute') !== false) {
                $hour_status = 'active';
        }
         else if (strpos($member->last_action, 'hour') !== false){
                $hour_status = 'inactive';
        }
         else if (strpos($member->last_action, 'days') !== false) {
                $hour_status = 'kick';
        }
        else if (strpos($member->last_action, 'day') !==false) {
                $hour_status =  'WATCH';
        }

	$sql = "insert into sleepstudy (ndx,ID,name,time,status) values (NULL,'$idx','$member->name','$time','$hour_status')";
	mysqli_query($conn,$sql) or die("insert error" . mysqli_error($conn));
        } //End Foreach
?>



