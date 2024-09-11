<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");


$db_request_members = new db_request();
$members = $db_request_members->getAllMembers();

$db_request_api = new api_loop($members, "getFactionMembersStats");
$data = $db_request_api->processData();

foreach ($data as $memberdata) {
  if (is_array($memberdata) || is_object($memberdata)) {

    if (isset($memberdata['error'])) {
      //incorrect key
      echo "Error Code: ".$memberdata['error']['code']." using " . $apikeys[$i].".";
      if ($memberdata['error']['code'] == 2) {
        //add reminder to update api key
      }
      $i++;
      continue; //go back to while, try again with same user but different apikey.
    } else {
  
      if (isset($memberdata['timestamp'])) {
        //check to see if personalstat exists (if personalstat is zero, it won't exists in api), else set to 0
        $xantaken = isset($memberdata['personalstats']['xantaken']) ? $memberdata['personalstats']['xantaken'] : 0;
        $refills = isset($memberdata['personalstats']['refills']) ? $memberdata['personalstats']['refills'] : 0;
        $nerverefills = isset($memberdata['personalstats']['nerverefills']) ? $memberdata['personalstats']['nerverefills'] : 0;
        $consumablesused = isset($memberdata['personalstats']['consumablesused']) ? $memberdata['personalstats']['consumablesused'] : 0;
        $boostersused = isset($memberdata['personalstats']['boostersused']) ? $memberdata['personalstats']['boostersused'] : 0;
        $energydrinkused = isset($memberdata['personalstats']['energydrinkused']) ? $memberdata['personalstats']['energydrinkused'] : 0;
        $traveltimes = isset($memberdata['personalstats']['traveltimes']) ? $memberdata['personalstats']['traveltimes'] : 0;
        $dumpsearches = isset($memberdata['personalstats']['dumpsearches']) ? $memberdata['personalstats']['dumpsearches'] : 0;
        $overdosed = isset($memberdata['personalstats']['overdosed']) ? $memberdata['personalstats']['overdosed'] : 0;
        $statenhancers = isset($memberdata['personalstats']['statenhancersused']) ? $memberdata['personalstats']['statenhancersused'] : 0;
        $revives = isset($memberdata['personalstats']['revives']) ? $memberdata['personalstats']['revives'] : 0;
  
  
        $donator = isset($memberdata['donator']) ? $memberdata['donator'] : 0;
        $property = isset($memberdata['property']) ? $memberdata['property'] : "Shack";
        $networth = isset($memberdata['personalstats']['networth']) ? $memberdata['personalstats']['networth'] : 0;
        $awards = isset($memberdata['awards']) ? $memberdata['awards'] : 0;
        $age = isset($memberdata['age']) ? $memberdata['age'] : 0;
        $level = isset($memberdata['level']) ? $memberdata['level'] : 1;
  
        $discordID = isset($memberdata['discord']['discordID']) ? $memberdata['discord']['discordID'] : null;
  
        $db_request_members->insertMemberPersonalStats($member['tornID'],$xantaken,$overdosed,$refills,$nerverefills,$consumablesused,$boostersused,$energydrinkused,$statenhancers,$traveltimes,$dumpsearches,$revives);
  
        $db_request_members->setMemberStatsByIDWeek($member['tornID']);
        $db_request_members->setMemberStatsByIDMonth($member['tornID']);
  
        $memexists = $db_request_members->getMemberInfoByTornID($member['tornID']);
        if (!empty($memexists)) {
          $db_request_members->updateMemberInfo($member['tornID'],$discordID,$donator,$property,$networth,$awards,$age,$level);
        } else {
          $db_request_members->insertMemberInfo($member['tornID'],$discordID,$donator,$property,$networth,$awards,$age,$level);
        }
        $complete = true;
        $i++;
      }//if timestamp
  
    }//else
  
  }//if isarray
}


?>
