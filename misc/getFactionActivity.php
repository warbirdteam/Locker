<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");

$db_request_check_f_act_status = new db_request();
$bool = $db_request_check_f_act_status->getToggleStatusByName("faction_activity");
$f;
$factionData;




function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");

$NUM_OF_ATTEMPTS = 10;
$attempts = 0;

if ($bool == 1) {
    $db_request = new db_request();
    $factions = $db_request->getFactionKeyholders(); // Pull UserID and FactionID for bird keyholders
    
    foreach($factions as $faction) {
        $f = $faction['factionID'];
        getFactionActivity($faction['factionID']);
    }
}


function getFactionActivity($factionid) {
    global $attempts;
    global $NUM_OF_ATTEMPTS;
    global $factionData;

    $count = 0;
    $onlineMembers = [];

    do {
        try
        {
            getFactionData($factionid);
        } catch (Exception $e) {
            $attempts++;
            sleep(1);
            continue;
        }
        
        break;
    
    } while($attempts < $NUM_OF_ATTEMPTS);
  
    if ($factionid == 13784 && $factionData == null) {
        $db_request_discord_issue = new db_request();
        $discordWebhook = $db_request_discord_issue->getWebhookByName('wbalrt');
        $ping = $db_request_discord_issue->getDiscordWebhookRolePingByName("heasley");

        sendDiscordMessage("UH... something went wrong with the API", "API Issue", $discordWebhook, "<@".$ping.">");
        return;
    }

    updateFactionTables($factionData);

    $timestamp = $factionData['timestamp'];
    $members = $factionData['members'];

    $db_member_request = new db_request();

    foreach ($members as $memberID => $member) { //loop through data
        $count += insertMemberActivity($memberID, $member, $timestamp); //insert member activity

        if ($member['last_action']['status'] != "Offline" && (($timestamp - $member['last_action']['timestamp']) <= 180 )) {
            $onlineMembers[$memberID] = $member;
        }

        $row = $db_member_request->getBirdByTornID($memberID);
        if ($row) {
            $db_member_request->updateBird($memberID, $factionid, $member);
        } else {
            $db_member_request->insertBird($memberID, $factionid, $member);
        }
    }

    if ($count == 0) {
        discordAlert("alert");
    }
    if ($count != 0 && $count <= 3) {
        discordAlert("warning", $onlineMembers);
    }
}

function insertMemberActivity($memberID, $member, $timestamp) {
    if ($member['last_action']['status'] == "Offline") {
        $activity_status = 0;
    }
    if ($member['last_action']['status'] != "Offline" && (($timestamp - $member['last_action']['timestamp']) <= 180 )) {
        $activity_status = 1;
    } else {
        $activity_status = 0;
    }

    $db_request_activity = new db_request();
    $db_request_activity->insertMemberActivity($memberID, $activity_status, $timestamp);

    return $activity_status;
}

function getFactionData($factionid) {
    $db_request = new db_request();
    $api_request = new api_request($db_request->getRandomAPIKey());
    $data = $api_request->getFactionAPI($factionid); //get faction api data

    if ($data) {
        global $factionData;
        $factionData = $data;
    } else {
        throw "Empty data?";
    }
}

function updateFactionTables($factionData) {
    $fid = $factionData['ID'];
    $members = $factionData['members'];

    $fname = $factionData['name'];
    $leader = $factionData['leader'];
    $coleader = $factionData['co-leader'];
    $age = $factionData['age'];
    $best_chain = $factionData['best_chain'];
    $total_members = count($factionData['members']);
    $respect = $factionData['respect'];


    $db_request = new db_request();
    $row = $db_request->getFactionByFactionID($fid);

    if($row) {
      $db_request->updateBirdsFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);
    } else {
      $db_request->insertBirdsFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect);
    }

    
    $dbMemberData = $db_request->getBirdsByFaction($fid);

    if(!empty($dbMemberData)) {

        $diff = array_diff_key($dbMemberData, $members);

        //delete member from database if exists in diff array
        while ($cut = current($diff)) {
        $cutuser = key($diff);
        $memberData = $db_request->getMemberByTornID($cutuser);
        if ($memberData) {
            $db_request->removeMemberByTornID($cutuser);
            $db_request->removeMemberInfoByTornID($cutuser);
        }
        next($diff);
        } //while

    }
}


function discordAlert($type, $data = null) {
    $db_request_check_status = new db_request();
    $wbbool = $db_request_check_status->getToggleStatusByName("wb_active_alert");
    global $f;
    
    if ($wbbool == 1 && $f == 13784) {
        $db_request_discord = new db_request();

        $discordMessage = "";

        if ($type == "alert") {
            $discordWebhook = $db_request_discord->getWebhookByName('wbalrt');
            //$role = $db_request_discord->getDiscordWebhookRolePingByName("admin");
    
            $role = $db_request_discord->getDiscordWebhookRolePingByName("warbirds");
            $ping = "<@&".$role.">";
            $title = "⚠️ ALERT ⚠️: Nobody online in WarBirds!";
            $discordMessage = "**NOBODY IS ONLINE, WATCH THE CHAIN!**";
        }
        if ($type == "warning") {
            $discordWebhook = $db_request_discord->getWebhookByName('wbalrt');
            //$role = $db_request_discord->getDiscordWebhookRolePingByName("admin");

            $role = $db_request_discord->getDiscordWebhookRolePingByName("warbirds_chain");
            $ping = "<@&".$role.">";
            $title = "🚨 Warning 🚨: Low activity in WarBirds.";

            $discordMessage .= "**These members are online, but we need more birds awake!**\n";

            if ($data) {
                foreach ($data as $memberID => $member) { //loop through data
                    $discordMessage .= "\n" . $member["name"] . " [" . $memberID . "]: " . $member["last_action"]["status"] . " - " . $member["last_action"]["relative"];
                }
            }
            
        }

        sendDiscordMessage($discordMessage, $title, $discordWebhook, $ping);
    }
}

function sendDiscordMessage($message, $title, $webhook, $ping) {  
    if ($message != '``````') { //only send discord message if energy has been used
  
      $url = 'https://discord.com/api/webhooks/' . $webhook;
      //create discord webhook message
      $POST = [
        'content' => $ping,
        'username' => 'Activity Alert',
        'embeds' => [
          [
           'title' => $title,
           "type" => "rich",
           "description" => $message,
           "color" => hexdec("D22B2B"),
           "url" => "https://www.torn.com/page.php?sid=UserList&levelFrom=1&levelTo=1&lastAction=7&searchConditionNot=true&searchConditions=inFederalJail&daysOldFrom=365&daysOldTo=400#start=1250"
          ]
        ]
      ];
  
      $headers = [ 'Content-Type: application/json; charset=utf-8' ];
  
      //use curl to send discord webhook message
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
      $response   = curl_exec($ch);
  
    }
}