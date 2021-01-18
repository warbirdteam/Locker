<?php

$type = isset($_POST["type"]) && strlen($_GET["type"]) == 6 ? $_POST["type"] : 'NULL'; // 'revive' or 'attack'
$enemyID = isset($_POST["enemy"]) && is_numeric($_POST["enemy"]) && strlen($_POST["enemy"]) <= 8 ? $_POST["enemy"] : 'NULL';
$userID = isset($_POST["user"]) && is_numeric($_POST["user"]) && strlen($_POST["user"]) <= 8 ? $_POST["user"] : 'NULL';

if ($type == "NULL" OR $enemyID == "NULL" OR $userID == "NULL") {
  echo "failure to request";
  exit;
}

include_once("../../includes/autoloader.inc.php");

$db_request_check_user = new db_request();
$user = $db_request_check_user->getMemberByTornID($userID);

if (empty($user)) {
  echo "not allowed";
  exit;
} else {

  if ($type == 'attack') {
    $db_request_check_attack_status = new db_request();
    $bool = $db_request_check_attack_status->getToggleStatusByName("assists");
    if ($bool != 1) {
      echo "assists disabled";
      exit;
    }

    $db_request_check_enemy = new db_request();
    $enemy = $db_request_check_enemy->getEnemyMemberByTornID($enemyID);

    $db_request_enemy_faction = new db_request();
    $faction = $db_request_enemy_faction->getEnemyFactionByFactionID($enemy['factionID']);

    $db_request_attack_webhook = new db_request();
    $attackWebhook = $db_request_attack_webhook->getWebhookByName('attack');

    if (empty($enemy)) {
      echo "not allowed";
      exit;
    }

    if (empty($attackWebhook)) {
      echo "discord channel doesn't exist";
      exit;
    }

    $actionurl = 'https://www.torn.com/loader.php?sid=attack&user2ID=' . $enemyID;

    $url = 'https://discord.com/api/webhooks/' . $attackWebhook;
    $POST = [
      'content' => '<@&642592525755875357>',
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

  }

  if ($type =='revive') {
    $db_request_check_revive_status = new db_request();
    $bool = $db_request_check_revive_status->getToggleStatusByName("revives");
    if ($bool != 1) {
      echo "revives disabled";
      exit;
    }

    $db_request_attack_webhook = new db_request();
    $reviveWebhook = $db_request_attack_webhook->getWebhookByName('revive');

    $actionurl = 'https://www.torn.com/profiles.php?XID=' . $userID;

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

  }

  $headers = [ 'Content-Type: application/json; charset=utf-8' ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
  $response   = curl_exec($ch);
}
?>
