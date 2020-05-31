<?php

class api_request {

  private $apikey;

  /////////////////////////////////////////////////

  public function __construct($apikey) {

    if ( isset($this->apikey) && !empty($this->apikey) ) {
      $this->apikey = $apikey;
    } else {
      throw new Exception('API Key was not passed correctly or does not exist.');
    }

    if ( !$this->verifyString() ) {
      throw new Exception('API Key could not be verified.');
    }

  }

  /////////////////////////////////////////////////

  private function verifyString() {
    if (strlen($this->apikey) != 16) {
      throw new Exception('API Key is not 16 characters: ' . $this->apikey);
    }

    if (!preg_match('/^[A-Za-z0-9_-]+$/', $this->apikey)) {
      throw new Exception('API Key has illegal characters: ' . $this->apikey);
    }

    return true;
  }

  /////////////////////////////////////////////////

  private function verifyFaction($factionid) {
    $faction_list = array("13784","35507","30085","37132");

    if(!in_array($factionid, $faction_list)){
      throw new Exception('API User is not in Warbirds Family.');
    }

  }

  /////////////////////////////////////////////////

  public function getFactionAPI($factionid) {
    $url = 'https://api.torn.com/faction/'. $factionid .'?selections=timestamp,basic&key=' . $this->apikey; // URL to Torn API
    $data = file_get_contents($url);

    $json = json_decode($data, true); // decode the JSON feed

    if (is_array($json) || is_object($json)) {

      if (isset($json['error'])) {
        $this->APIERROR(); //TORN API ERROR
      } else {
        if ( isset($json['timestamp']) ) {
          return $json;
        } else {
          throw new Exception('Could not find API data.');
        }
      }

    } else {
      throw new Exception('Error while fetching API data.');
    }
  }

  /////////////////////////////////////////////////

  private function APIError($error) {
    //Check Error Code and describe reason, such as bad key, etc
    throw new Exception('API Key Error Code: ' . $json['error']['code'] . ' - ' . $json['error']['error']);
  }

  /////////////////////////////////////////////////

}
?>
