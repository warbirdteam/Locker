<?php
session_start();

$time_interval = 5;#In seconds
$max_requests = 1;
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




$type = isset($_POST["type"]) && strlen($_POST["type"]) == 6 ? $_POST["type"] : 'NULL'; // 'revive' or 'attack'
$enemyID = isset($_POST["enemy"]) && is_numeric($_POST["enemy"]) && strlen($_POST["enemy"]) <= 8 ? $_POST["enemy"] : 'NULL';
$userID = isset($_POST["user"]) && is_numeric($_POST["user"]) && strlen($_POST["user"]) <= 8 ? $_POST["user"] : 'NULL';

if ($type == "NULL" OR $enemyID == "NULL" OR $userID == "NULL") {
  echo "failure to request";
  exit;
}

if ($type == 'revive' || $type == 'attack') {
  //continue
} else {
  echo 'not a request';
  exit;
}



include_once("../../includes/autoloader.inc.php"); //include classes


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
      $desc = '**'. $user['tornName'] . '** needs help against **' . $enemy['tornName'] . ' ['. $enemyID . ']** from **' . $faction['factionName'] . '** \n ' . '```css \n [A BIRD NEEDS YOUR HELP!] \n ```';
    } else {
      $desc = '**'. $user['tornName'] . '** needs help against **' . $enemy['tornName'] . ' ['. $enemyID . ']** from **' . $faction['factionName'] . '** \n ' . '```fix \n an AK member needs your help \n ```';
    }

    $url = 'https://discord.com/api/webhooks/' . $attackWebhook;
    $POST = [
      'content' => '<@&642592525755875357>',
      'username' => 'Assist Bot',
      'embeds' => [
        [
         'title' => "Attack page for " . $enemy['tornName'] . ' ['. $enemyID . ']',
         "type" => "rich",
         "description" => $desc,
         "url" => $actionurl,
         "color" => hexdec("8b0000")
        ]
      ]
    ];

    SendToDiscord($url, $POST);


    //if ak war, send additional discord request to AK discord
    if ($akbool == 1) {
      $db_request_akattack_webhook = new db_request();
      $akattackWebhook = $db_request_akattack_webhook->getWebhookByName('akhelp');
      if (empty($akattackWebhook)) {
        echo "Discord channel doesn't exist";
        exit;
      }
      $url = 'https://discord.com/api/webhooks/' . $akattackWebhook;

      $POST = [
        'content' => '<@&805503184919199764>',
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

?>
