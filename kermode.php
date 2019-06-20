<?php
include_once("../../../db_connect.php");





$apikey = 'Nxd3N0E941VN1jJR'; //Heasleys4hemp's API Key
$fid = '13784';

$url ='https://api.torn.com/faction/' . $fid . '?selections=timestamp,basic&key=' . $apikey;
$data = file_get_contents($url);

$file = '/home/heasleys/FactionInfo/' . $fid . '.json';
$faction = json_decode($data, true); // decode the JSON feed

   if ($faction['error']) {
     echo 'Error';
   } else { if ($faction['timestamp']) { //I use timestamp to confirm the api is working and not erroring
     //file_put_contents($file, serialize($data)); //save data to file

     $fname = $faction['name'];
     $members = $faction['members'];

     while ($member = current($members)) {
            $userid = key($members);
            $sql = "insert into members VALUES ('" . key($members) . "','" . $members['name'] . "','" . $members['days_in_faction'] . "','" . $members['last_action'] . "')";
            $conn->query($sql);

            //echo key($members).'<br />';
            //echo '<pre>'; print_r($member); echo '</pre>';
            /*
            sleep(5); //wait 5 seconds
            $memurl = 'https://api.torn.com/user/' . $userid . '?selections=timestamp,basic,personalstats,crimes,profile&key=' . $apikey;
            $memdata = file_get_contents($memurl);
            $memfile = '/home/heasleys/FactionInfo/User/' . $userid . '.json';
            $user = json_decode($memdata, true); // decode the JSON feed


            if ($user['error']) {
             echo 'Error';
           } else { if ($user['timestamp']) { //I use timestamp to confirm the api is working and not erroring

            //this is where you would add insert to database shit for whatever we want to save
               //echo '<pre>'; print_r($user); echo '</pre>';
            //file_put_contents($memfile, serialize($memdata)); //this can be changed to save data to database rather than to a file




           }}

           */

    //}
    //sleep(5);
    next($members);
    }
   }}

?>
