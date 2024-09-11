<?php

class api_request {

  protected $apikey;
  private $baseURL = "https://api.torn.com";
  private $baseURLv2 = "https://api.torn.com/v2";

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

    $faction_list = array("13784","35507");

    if(!in_array($factionid, $faction_list)){
      return false;
    }

    return true;
  }

  /////////////////////////////////////////////////

  private function verifyJSON($json) {
    if (is_array($json) || is_object($json)) {
      if (isset($json['error'])) {
        $this->APIERROR($json['error']); //TORN API ERROR
        return false;
      }
    } else {
      throw new Exception('Error while fetching API data. Data not in JSON form.');
    }

    return true;
  }

  /////////////////////////////////////////////////

  private function pullAPI($type, $id, $selection) {
    $url = $this->baseURL.'/'.$type.'/'. $id .'?selections='.$selection.'&comment=wb.rocks&key='.$this->apikey; // URL to Torn API
    $data = file_get_contents($url);
    $json = json_decode($data, true); // decode the JSON feed

    if ( $this->verifyJSON($json) ) {
      return $json;
    }
  }

  /////////////////////////////////////////////////
  ////////           API Requests          ////////
  /////////////////////////////////////////////////
  

  public function getFactionAPI($factionid) {
    return $this->pullAPI('faction', $factionid, 'timestamp,basic');
  }


  public function getPlayerPersonalStats($userid) {
    return $this->pullAPI('user', $userid, 'timestamp,basic,personalstats,profile,discord');
  }

  public function getPlayerPersonalStatsTimestamp($userid, $timestamp) {
    return $this->pullAPI('user', $userid, 'timestamp,basic,personalstats,profile,discord&timestamp='.$timestamp);
  }


  public function getFactionStats($factionid) {
    return $this->pullAPI('faction', $factionid, 'timestamp,basic,stats');
  }


  public function getFactionCrimes($factionid) {
    return $this->pullAPI('faction', $factionid, 'timestamp,basic,crimes');
  }


  public function getFactionContributions($factionid,$stat) {
    $stats  = ["gymstrength","gymdefense","gymspeed","gymdexterity"]; // the white list of allowed field names
    $key     = array_search($stat, $stats); // see if we have such a name
    $field = $stats[$key];

    if ($field == NULL) {
      return NULL;
      exit;
    }

    return $this->pullAPI('faction', $factionid, 'timestamp,contributors&stat=' . $field);
  }


  public function getFactionBalances($factionid) {
    return $this->pullAPI('faction', $factionid, 'donations');
  }


  public function getBasicUser() {
    return $this->pullAPI('user','','');
  }

  public function getUserProfile() {
    return $this->pullAPI('user','','timestamp,basic,profile');
  }


  public function getFactionRankedWars($factionid) {
    return $this->pullAPI('faction', $factionid, 'timestamp,rankedwars');
  }


  /////////////////////////////////////////////////

  private function APIError($error) {
    //Check Error Code and describe reason, such as bad key, etc
    throw new Exception('API Key Error Code: ' . $error['code'] . ' - ' . $error['error']);
    exit('API Key Error Code: ' . $error['code'] . ' - ' . $error['error']);
  }

  /////////////////////////////////////////////////
  ////////           END OF CLASS          ////////
  /////////////////////////////////////////////////

}
?>
