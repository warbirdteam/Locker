<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");


getFactionCrimes('1468764', '13784'); //Warbirds
getFactionCrimes('1975338', '35507'); //Nest / deca


function getFactionCrimes($tornid, $factionid) {
  $db_request = new db_request();
  $apikey = $db_request->getRawAPIKeyByUserID($tornid); //get apikey of user from database

  $api_request = new api_request($apikey);
  $factionData = $api_request->getFactionCrimes($factionid); //get faction api crime data

  if ($factionData) { //if the data exists (null if torn dead or something)
    $fid = $factionData['ID'];
    $crimes = $factionData['crimes'];

    foreach ($crimes as $crimeID => $crimeData) { //loop through crimes

      if ($crimeData['initiated'] && $crimeData['initiated'] == 1) { //if crime "initiated" variable exists and crime has been initiated

        $crime_type_id = isset($crimeData['crime_id']) ? $crimeData['crime_id'] : 0;
        $crime_name = isset($crimeData['crime_name']) ? $crimeData['crime_name'] : 'N/A';
        $time_started = isset($crimeData['time_started']) ? $crimeData['time_started'] : 0;
        $time_completed = isset($crimeData['time_completed']) ? $crimeData['time_completed'] : 0;
        $initiated_by = isset($crimeData['initiated_by']) ? $crimeData['initiated_by'] : 0;
        $planned_by = isset($crimeData['planned_by']) ? $crimeData['planned_by'] : 0;
        $success = isset($crimeData['success']) ? $crimeData['success'] : 0;
        $money_gain = isset($crimeData['money_gain']) ? $crimeData['money_gain'] : 0;
        $respect_gain = isset($crimeData['respect_gain']) ? $crimeData['respect_gain'] : 0;


        $db_request_factionCrimes = new db_request();
        $crimeExists = $db_request_factionCrimes->getOrganizedCrimeByCrimeID($crimeID); //check if crime exists in database
        if ($crimeExists == null) { //not in database

          $db_request_factionCrimes->insertFactionCrime($crimeID, $fid, $crime_type_id, $crime_name, $time_started, $time_completed, $initiated_by, $planned_by, $success, $money_gain, $respect_gain); //add crime data to database


          $participants = $crimeData['participants'];
          if ($participants) { //check if participant data exists
            $participantsURL = '';
            $participantsMessage = '';
            $i = 0;
            foreach($participants as $participantData) { //loop through participants

              foreach($participantData as $participantID => $data) { //loop through participant data again cuz ched
                if ($crime_type_id == 8) {
                  $pay = splitPay($i, $money_gain);
                  $i++;
                } else {
                  $pay = ($money_gain / 8);
                }

                $participantsURL .= $participantID . ',';
                $db_request_crimes_participant = new db_request();
                $db_request_crimes_participant->insertFactionCrimeParticipant($crimeID, $participantID); //add participant data to oc participants table

                $db_request_name = new db_request();
                $participantData = $db_request_name->getMemberByTornID($participantID); //get faction member data

                if ($participantData && $participantData['tornName']) {
                  $participantsMessage .= strval($participantData['tornName'] . ' [' . $participantData['tornID'] . '] is owed: **$' . number_format($pay) . '** ') . "\n";
                } else {
                  $participantsMessage .= strval(" [" . $participantID . "] is owed: **$" . number_format($pay) . "**") . "\n";
                }
              }

            }

            if ($crime_type_id == 8) {
              if ($success == 1) {
                //$pay = ($money_gain / 5);

                $paydayURL = 'https://www.torn.com/factions.php?step=your#/tab=controls&option=give-to-user'; //easy payday link

                $db_request_payday_webhook = new db_request();
                $attackWebhook = $db_request_payday_webhook->getWebhookByName('payday'); //get webhook id from database

                $url = 'https://discord.com/api/webhooks/' . $attackWebhook;
                //create discord webhook message
                $POST = [
                  'content' => '<@&749043668299677829>',
                  'username' => 'Payday Bot',
                  'embeds' => [
                    [
                     'title' => "Adjust balances for " . $crime_name . " team",
                     "type" => "rich",
                     "description" => "The " . $crime_name . " attempt was a success!\nhttps://www.torn.com/factions.php?step=your#/tab=crimes&crimeID=" . $crimeID,
                     "url" => $paydayURL,
                     "color" => hexdec("6cad2b"),
                     "fields" => [
                        [
                          "name" => "Money earned: $". number_format($money_gain),
                          "value" => $participantsMessage
                        ],
                      ]
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

          } //if participants



        }//if $crimeExists

      } //if initiated

    } //foreach crime

  } //if faction data

} //function getcrimes


function splitPay($i, $money) {
  $pay = 0;
  switch ($i) {
    case 0:
    $pay = ($money*0.35);
    break;
    case 1:
    $pay = ($money*0.25);
    break;
    case 2:
    $pay = ($money*0.20);
    break;
    case 3:
    $pay = ($money*0.10);
    break;

    default:
      $pay = 0;
    break;
  }

  return $pay;
}

?>
