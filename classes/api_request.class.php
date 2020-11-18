<?php

class api_request {

  protected $apikey;

  /////////////////////////////////////////////////

  public function __construct($apikey) {

    if ( isset($apikey) && !empty($apikey) ) {
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
      return false;
    }

    if (!preg_match('/^[A-Za-z0-9_-]+$/', $this->apikey)) {
      return false;
    }

    return true;
  }

  /////////////////////////////////////////////////

  private function verifyFaction($factionid) {
    $faction_list = array("13784","35507","30085","37132");

    if(!in_array($factionid, $faction_list)){
      return false;
    }

    return true;
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

  public function getPlayerPersonalStats($userid) {
    $url = 'https://api.torn.com/user/' . $userid . '?selections=timestamp,basic,personalstats,profile,discord&key=' . $this->apikey;
    $data = file_get_contents($url);
    $json = json_decode($data, true); // decode the JSON feed

    if (is_array($json) || is_object($json)) {
      return $json;
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
  ////////           END OF CLASS          ////////
  /////////////////////////////////////////////////

}
?>
