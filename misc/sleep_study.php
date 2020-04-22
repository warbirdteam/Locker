<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$connect = new DB_connect();
$pdo = $connect->connect();

$get_apikey = new DB_request();
$enc_apikey = $get_apikey->getSelfAPIKey("1468764"); //heasley key

$uncryptSelf = new API_Crypt();
$unenc_api = $uncryptSelf->unpad($enc_apikey['enc_api'], $enc_apikey['iv'], $enc_apikey['tag']);
$apikey = $unenc_api;

$userid = "1975338"; //deca test

$memurl = 'https://api.torn.com/user/' . $userid . '?selections=timestamp,basic,profile,personalstats&key=' . $apikey;
$memdata = file_get_contents($memurl);
$user = json_decode($memdata, true); // decode the JSON feed

if (is_array($user) || is_object($user)) {
   if (isset($user['error'])) {
     //incorrect key
     echo "Error Code: ".$user['error']['code']." using 1468764's key.";
     if ($user['error']['code'] == 2) {
       //add reminder to update api key
     }
   } else {
     if (isset($user['timestamp'])) {

       $torn_timestamp = isset($user['timestamp']) ? $user['timestamp'] : 0;
       $last_action_status = isset($user['last_action']['status']) ? $user['last_action']['status'] : 0;
       $last_action_timestamp = isset($user['last_action']['timestamp']) ? $user['last_action']['timestamp'] : 0;
       $ps_useractivity = isset($user['personalstats']['useractivity']) ? $user['personalstats']['useractivity'] : 0;
       $ps_logins = isset($user['personalstats']['logins']) ? $user['personalstats']['logins'] : 0;

       $sql = "INSERT INTO sleepstudy (userid,torn_timestamp,last_action_status,last_action_timestamp,ps_useractivity,ps_logins) VALUES (?,?,?,?,?,?)";
       $stmtinsert = $pdo->prepare($sql);
       $stmtinsert->execute([$userid,$torn_timestamp,$last_action_status,$last_action_timestamp,$ps_useractivity,$ps_logins]);

       }
     }
   }
 ?>
