<?php
include_once(__DIR__ . "/../includes/autoloader.inc.php");


getFactionCrimes('1468764', '13784'); //Warbirds
getFactionCrimes('1975338', '35507'); //Nest / deca


function getFactionCrimes($tornid, $factionid) {
  $db_request = new db_request();
  $apikey = $db_request->getRawAPIKeyByUserID($tornid);

  $api_request = new api_request($apikey);
  $factionData = $api_request->getFactionCrimes($factionid);

  if ($factionData) {
    $fid = $factionData['ID'];
    $crimes = $factionData['crimes'];

    foreach ($crimes as $crimeID => $crimeData) {

      if ($crimeData['initiated'] && $crimeData['initiated'] == 1) {

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

        //check if crime exists in database
        $crimeExists = $db_request_factionCrimes->getOrganizedCrimeByCrimeID($crimeID);
        if ($crimeExists == null) {

          $db_request_factionCrimes->insertFactionCrime($crimeID, $fid, $crime_type_id, $crime_name, $time_started, $time_completed, $initiated_by, $planned_by, $success, $money_gain, $respect_gain);



          $participants = $crimeData['participants'];
          if ($participants) {
            $participantsURL = '';
            $participantsMessage = '';
            foreach($participants as $participantData) {

              foreach($participantData as $participantID => $data) {
                $participantsURL .= $participantID . ',';
                $db_request_crimes_participant = new db_request();
                $db_request_crimes_participant->insertFactionCrimeParticipant($crimeID, $participantID);

                $db_request_name = new db_request();
                $participantData = $db_request_name->getMemberByTornID($participantID);

                if ($participantData && $participantData['tornName']) {
                  $participantsMessage .= " " . $participantData['tornName'] . ' [' . $participantData['tornID'] . '],';
                } else {
                  $participantsMessage .= " " . $participantID . ',';
                }
              }

            }

            if ($crime_type_id == 8) {
              if ($success == 1) {
                $pay = ($money_gain / 5);
                $participantsURL = rtrim($participantsURL, ',');
                $participantsMessage = rtrim($participantsMessage, ',');
                $participantsMessage = substr_replace($participantsMessage, ' and', strrpos($participantsMessage, ','), 1);

                $paydayURL = 'https://www.torn.com/factions.php?step=your#/tab=controls&option=pay-day&select=' . $participantsURL . '&pay=' . $pay;

                $db_request_payday_webhook = new db_request();
                $attackWebhook = $db_request_payday_webhook->getWebhookByName('payday');

                $url = 'https://discord.com/api/webhooks/' . $attackWebhook;
                $POST = [
                  'content' => '<@&749043668299677829>',
                  'username' => 'Payday Bot',
                  'embeds' => [
                    [
                     'title' => "Payday link for " . $crime_name . " team",
                     "type" => "rich",
                     "description" => "The " . $crime_name . " attempt was a success!\nhttps://www.torn.com/factions.php?step=your#/tab=crimes&crimeID=" . $crimeID,
                     "url" => $paydayURL,
                     "color" => hexdec("6cad2b"),
                     "fields" => [
                        [
                          "name" => "Money earned: $". number_format($money_gain),
                          "value" => $participantsMessage . " are each owed $" . number_format($pay) . "."
                        ],
                      ]
                    ]
                  ]
                ];

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
            }

          } //if participants



        }//if $crimeExists

      } //if initiated

    } //foreach crime

  } //if faction data

} //function getcrimes

?>
