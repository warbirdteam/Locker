<?php
session_start();

$type = isset($_POST["type"]) ? $_POST["type"] : NULL; // 'revive' or 'attack' or 'checkFaction'
$enemyID = isset($_POST["enemy"]) && is_numeric($_POST["enemy"]) && strlen($_POST["enemy"]) <= 8 ? $_POST["enemy"] : NULL;
$userID = isset($_POST["user"]) && is_numeric($_POST["user"]) && strlen($_POST["user"]) <= 8 ? $_POST["user"] : NULL;

if ($type == 'checkFaction') {
  $time_interval = 0;#In seconds
  $max_requests = 10;
} else {
  $time_interval = 5;#In seconds
  $max_requests = 1;
}


$fast_request_check = ($_SESSION['last_session_request'] > time() - $time_interval);

if (!isset($_SESSION))
{
    # This is fresh session, initialize session and its variables
    session_start();
    $_SESSION['last_session_request'] = time();
    $_SESSION['request_cnt'] = 1;
}
elseif($fast_request_check && ($_SESSION['request_cnt'] < $max_requests))
{
   # This is fast, consecutive request, but meets max requests limit
   $_SESSION['request_cnt']++;
}
elseif($fast_request_check)
{
    # This is fast, consecutive request, and exceeds max requests limit - kill it
    die("Too many requests");
}
else
{
    # This request is not fast, so reset session variables
    $_SESSION['last_session_request'] = time();
    $_SESSION['request_cnt'] = 1;
}



if (empty($type) OR empty($enemyID) OR empty($userID)) {
  echo "failure to request";
  exit;
}

if ($type == 'revive' || $type == 'attack' || $type == 'checkFaction') {
  //continue
} else {
  echo 'not a request';
  exit;
}
include_once("../../includes/autoloader.inc.php"); //include classes

// API Authentication
//check if AK War or warbirds war
$db_request_check_api_auth = new db_request();
$api_auth_bool = $db_request_check_api_auth->getToggleStatusByName("assist_api");
$headers = array_change_key_case(getallheaders());

if ($api_auth_bool == 1) {
    if (array_key_exists('authorization', $headers)) {
        $apikey = $headers['authorization'];
        if (empty($apikey)) {
          echo "api key invalid";
          exit;
        }
        
        //log authorization
        $ip_address = get_client_ip();
        $db_request_save_auth = new db_request();
        $db_request_save_auth->insertAuthorizationLog($userID, $apikey, $type, $enemyID, $ip_address);

        //check if apikey has already been checked and saved in database, to save spamming api
        $db_request_api_auth = new db_request();
        $authCheck = $db_request_api_auth->getAPIAuthByAPIKEY($apikey); //has apikey already been authorized

        if (!empty($authCheck)) {
          $userID = $authCheck['userID'];
        } else {
          //check apikey via api request
          $api_request = new api_request($apikey);
          $json = $api_request->getBasicUser();
  
          if (!empty($json) && $json['player_id'] != NULL) {
            if ($userID != $json['player_id']) { //someone changed userID in script, or not using their own api key
              echo "user not allowed";
              exit;
            }
            //good ending, player is okay to request
            $userID = $json['player_id'];
            //save auth apikey to db
            $db_request_save_auth = new db_request();
            $db_request_save_auth->insertAPIAuth($userID, $apikey);
  
          } else {
            echo "api key invalid";
            exit;
          }
        }
    } else {
        echo "api key invalid"; //api key invalid
        exit;
    }
}



if ($type == "checkFaction") {
  if (empty($enemyID) OR empty($userID)) {
    echo "failed to obtain enemy or user";
    exit;
  }

  $db_request_check_faction = new db_request();
  $bool = $db_request_check_faction->getToggleStatusByName("check_faction");

  if ($bool != 1) {
    echo "checking factions currently disabled";
    exit;
  }


  $db_request_check_user = new db_request();
  $user = $db_request_check_user->getFriendlyByTornID($userID);

  $db_request_check_bird = new db_request();
  $bird = $db_request_check_bird->getMemberByTornID($userID);

  if (empty($user)) {
    echo "user not allowed";
    exit;
  }
  if (empty($bird)) {
    echo "user not allowed";
    exit;
  }

  //check enemy
  $db_request_check_faction_e = new db_request();
  $factionEnemy = $db_request_check_faction_e->getEnemyFactionByTornID($enemyID);

  if ($factionEnemy && !empty($factfactionEnemyion)) {
    header("Content-Type: application/json");
    $fearray = array('faction_name' => $factionEnemy['factionName'], 'faction_id' => $factionEnemy['factionID'], 'user_id' => $enemyID, 'faction_type' => 'enemy');

    echo json_encode($fearray);
    exit;
  }

  //check friendly
  $db_request_check_faction_f = new db_request();
  $factionFriendly = $db_request_check_faction_f->getFriendlyFactionByTornID($enemyID);

  if ($factionFriendly && !empty($factionFriendly)) {
    header("Content-Type: application/json");
    $ffarray = array('faction_name' => $factionFriendly['factionName'], 'faction_id' => $factionFriendly['factionID'], 'user_id' => $enemyID, 'faction_type' => 'friendly');

    echo json_encode($ffarray);
    exit;
  }

  echo "something went wrong";
  exit;
}


//check if AK War or warbirds war
$db_request_check_war_status = new db_request();
$akbool = $db_request_check_war_status->getToggleStatusByName("akwars");


if ($akbool == 1) {
  //check for ally member instead of just bird
  $db_request_check_user = new db_request();
  $user = $db_request_check_user->getFriendlyByTornID($userID);

  $db_request_check_bird = new db_request();
  $bird = $db_request_check_bird->getMemberByTornID($userID);

  if (empty($user)) {
    echo "user not allowed"; //user not allowed
    exit;
  }

  if (empty($bird)) {
    $isBirdBool = false;
  } else {
    $isBirdBool = true;
  }

} else {
  //check for bird
  $db_request_check_user = new db_request();
  $user = $db_request_check_user->getMemberByTornID($userID);
  $isBirdBool = true;

  if (empty($user)) {
    echo "user not allowed"; //user not allowed
    exit;
  }
}


  if ($type == 'attack') {
    $db_request_check_attack_status = new db_request();
    $bool = $db_request_check_attack_status->getToggleStatusByName("assists");
    if ($bool != 1) {
      echo "Assist bot currently disabled";
      exit;
    }

    $db_request_check_enemy = new db_request();
    $enemy = $db_request_check_enemy->getEnemyMemberByTornID($enemyID);

    $db_request_enemy_faction = new db_request();
    $faction = $db_request_enemy_faction->getEnemyFactionByFactionID($enemy['factionID']);

    $db_request_attack_webhook = new db_request();
    $attackWebhook = $db_request_attack_webhook->getWebhookByName('attack');

    if (empty($enemy)) {
      echo "Assist target not allowed";
      exit;
    }

    if (empty($attackWebhook)) {
      echo "Discord channel doesn't exist";
      exit;
    }

    $actionurl = 'https://www.torn.com/loader.php?sid=attack&user2ID=' . $enemyID;

    if ($isBirdBool == true) {
      $foot = [
       "icon_url" => "https://cdn.discordapp.com/attachments/553367872580223008/805562504759476294/warbird.png",
       "text" => "Help a muthafuckin' bird out will ya!"
      ];
    } else {
      $foot = [
       "icon_url" => "https://cdn.discordapp.com/attachments/654438792748597249/655065404816752680/Asset_92x_AK_wh.png",
       "text" => "An alliance member needs your help!"
      ];
    }
      
    $db_request_webhook_ping = new db_request();

    $attackPingRole = $db_request_webhook_ping->getDiscordWebhookRolePingByName('nest_ping');

      if (empty($attackPingRole)) {
        $attackPingRole = "🔫";
      } else {
        $attackPingRole = "<@&" . $attackPingRole . ">";
      }
      

    $url = 'https://discord.com/api/webhooks/' . $attackWebhook;
    $POST = [
      'content' => $attackPingRole,
      'username' => 'Assist Bot',
      'embeds' => [
        [
         'title' => "Attack page for " . $enemy['tornName'] . ' ['. $enemyID . ']',
         "type" => "rich",
         "description" => '**'. $user['tornName'] . '** needs help against **' . $enemy['tornName'] . ' ['. $enemyID . ']** from **' . $faction['factionName'] . '**',
         "url" => $actionurl,
         "color" => hexdec("8b0000"),
         "footer" => $foot
        ]
      ]
    ];

    SendToDiscord($url, $POST);


    //if ak war, send additional discord request to AK discord
    if ($akbool == 1) {
      $db_request_akattack_webhook = new db_request();
      $akattackWebhook = $db_request_akattack_webhook->getWebhookByName('akhelp');

      $akattackPingRole = $db_request_akattack_webhook->getDiscordWebhookRolePingByName('team_war_ping');

      if (empty($akattackPingRole)) {
        $akattackPingRole = "🔫";
      } else {
        $akattackPingRole = "<@&" . $akattackPingRole . ">";
      }
        
      if (empty($akattackWebhook)) {
        echo "Discord channel doesn't exist";
        exit;
      }
      $url = 'https://discord.com/api/webhooks/' . $akattackWebhook;

      $POST = [
        'content' => $akattackPingRole,
        'username' => 'Assist Bot',
        'embeds' => [
          [
           'title' => "Attack page for " . $enemy['tornName'] . ' ['. $enemyID . ']',
           "type" => "rich",
           "description" => '**'. $user['tornName'] . '** needs help against **' . $enemy['tornName'] . ' ['. $enemyID . ']** from **' . $faction['factionName'] . '**',
           "url" => $actionurl,
           "color" => hexdec("8b0000")
          ]
        ]
      ];

      SendToDiscord($url, $POST);
    }

  }



  if ($type =='revive') {
    $db_request_check_revive_status = new db_request();
    $bool = $db_request_check_revive_status->getToggleStatusByName("revives");
    if ($bool != 1) {
      echo "Revive bot currently disabled";
      exit;
    }
    $actionurl = 'https://www.torn.com/profiles.php?XID=' . $userID;

    if ($isBirdBool == true) {
        $db_request_attack_webhook = new db_request();
        $reviveWebhook = $db_request_attack_webhook->getWebhookByName('revive');

        if (empty($reviveWebhook)) {
          echo "Discord channel doesn't exist";
          exit;
        }

        $url = 'https://discord.com/api/webhooks/' . $reviveWebhook;
        $POST = [
          'content' => '<@&692792217424887948>',
          'username' => 'Revive Bot',
          'embeds' => [
            [
             'title' => "Profile page for " . $user['tornName'] . ' [' . $userID . ']',
             "type" => "rich",
             "description" => $user['tornName'] . ' needs a revive!',
             "url" => $actionurl,
             "color" => hexdec("F0F0F0"),
             "footer" => [
              "icon_url" => "https://i.imgur.com/c22oa4p.png",
              "text" => "Revive me!"
            ],
            ]
          ]
        ];

        SendToDiscord($url, $POST); //send to Nest Discord
    } //if bird

    //if ak war, send additional discord request to AK discord
    if ($akbool == 1) {
      $db_request_akrevive_webhook = new db_request();
      $akreviveWebhook = $db_request_akrevive_webhook->getWebhookByName('akrevs');
      if (empty($akreviveWebhook)) {
        echo "Discord channel doesn't exist";
        exit;
      }
      $url = 'https://discord.com/api/webhooks/' . $akreviveWebhook;

      $POST = [
        'content' => '<@&649369952905592833>',
        'username' => 'Revive Bot',
        'embeds' => [
          [
           'title' => "Profile page for " . $user['tornName'] . ' [' . $userID . ']',
           "type" => "rich",
           "description" => $user['tornName'] . ' needs a revive!',
           "url" => $actionurl,
           "color" => hexdec("F0F0F0"),
           "footer" => [
            "icon_url" => "https://i.imgur.com/c22oa4p.png",
            "text" => "Revive me!"
          ],
          ]
        ]
      ];

      SendToDiscord($url, $POST); //send to AK discord
    }
  }


  echo $type . " request sent successfully";
  exit;


function SendToDiscord($url, $POST) {
  $headers = [ 'Content-Type: application/json; charset=utf-8' ];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
  $response = curl_exec($ch);
}

// Function to get the client IP address
function get_client_ip() {
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
      $ipaddress = getenv('HTTP_CLIENT_IP');
  else if(getenv('HTTP_X_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if(getenv('HTTP_X_FORWARDED'))
      $ipaddress = getenv('HTTP_X_FORWARDED');
  else if(getenv('HTTP_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if(getenv('HTTP_FORWARDED'))
     $ipaddress = getenv('HTTP_FORWARDED');
  else if(getenv('REMOTE_ADDR'))
      $ipaddress = getenv('REMOTE_ADDR');
  else
      $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

?>
