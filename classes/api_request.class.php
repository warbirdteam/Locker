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
    $url = 'https://api.torn.com/'.$type.'/'. $id .'?selections='.$selection.'&comment=wb.rocks&key=' . $this->apikey; // URL to Torn API
    $data = file_get_contents($url);
    $json = json_decode($data, true); // decode the JSON feed

    if ( $this->verifyJSON($json) ) {
      return $json;
    }
  }

  /////////////////////////////////////////////////

  public function getFactionAPI($factionid) {
    $url = 'https://api.torn.com/faction/'. $factionid .'?selections=timestamp,basic&comment=wb.rocks&key=' . $this->apikey; // URL to Torn API
    $data = file_get_contents($url);
    $json = json_decode($data, true); // decode the JSON feed

    if (is_array($json) || is_object($json)) {

      if (isset($json['error'])) {
        $this->APIERROR($json['error']); //TORN API ERROR
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

    return NULL;
  }

  /////////////////////////////////////////////////

  public function getPlayerPersonalStats($userid) {
    $url = 'https://api.torn.com/user/' . $userid . '?selections=timestamp,basic,personalstats,profile,discord&comment=wb.rocks&key=' . $this->apikey;
    $data = file_get_contents($url);
    $json = json_decode($data, true); // decode the JSON feed

    if (is_array($json) || is_object($json)) {
      return $json;
    } else {
      throw new Exception('Error while fetching API data.');
    }
  }

  public function getPlayerPersonalStatsTimestamp($userid, $timestamp) {
    $url = 'https://api.torn.com/user/' . $userid . '?selections=timestamp,basic,personalstats,profile,discord&timestamp='.$timestamp.'&comment=wb.rocks&key=' . $this->apikey;
    $data = file_get_contents($url);
    $json = json_decode($data, true); // decode the JSON feed

    if (is_array($json) || is_object($json)) {
      return $json;
    } else {
      throw new Exception('Error while fetching API data.');
    }
  }


  /////////////////////////////////////////////////


  public function getFactionStats($factionid) {
    $url = 'https://api.torn.com/faction/' . $factionid . '?selections=timestamp,basic,stats&comment=wb.rocks&key=' . $this->apikey;

    $data = file_get_contents($url);
    $json = json_decode($data, true); // decode the JSON feed

    if (is_array($json) || is_object($json)) {

      if (isset($json['error'])) {
        $this->APIERROR($json['error']); //TORN API ERROR
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


  public function getFactionCrimes($factionid) {
    $url = 'https://api.torn.com/faction/' . $factionid . '?selections=timestamp,basic,crimes&comment=wb.rocks&key=' . $this->apikey;

    $data = file_get_contents($url);
    $json = json_decode($data, true); // decode the JSON feed

    if (is_array($json) || is_object($json)) {

      if (isset($json['error'])) {
        $this->APIERROR($json['error']); //TORN API ERROR
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


  public function getFactionContributions($factionid,$stat) {
    $stats  = ["gymstrength","gymdefense","gymspeed","gymdexterity"]; // the white list of allowed field names
    $key     = array_search($stat, $stats); // see if we have such a name
    $field = $stats[$key];

    if ($field == NULL) {
      return NULL;
      exit;
    }

    $url = 'https://api.torn.com/faction/' . $factionid . '?selections=timestamp,contributors&comment=wb.rocks&stat=' . $field . '&key=' . $this->apikey;

    $data = file_get_contents($url);
    $json = json_decode($data, true); // decode the JSON feed

    if (is_array($json) || is_object($json)) {

      if (isset($json['error'])) {
        $this->APIERROR($json['error']); //TORN API ERROR
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


  public function getFactionBalances($factionid) {
    $json = $this->pullAPI('faction', $factionid, 'donations');
    return $json;
  }



  public function getBasicUser() {
    $json = $this->pullAPI('user','','');
    return $json;
  }

  /////////////////////////////////////////////////


  public function getFactionRankedWars($factionid) {
    $url = 'https://api.torn.com/faction/' . $factionid . '?selections=timestamp,rankedwars&comment=wb.rocks&key=' . $this->apikey;

    $data = file_get_contents($url);
    $json = json_decode($data, true); // decode the JSON feed

    if (is_array($json) || is_object($json)) {

      if (isset($json['error'])) {
        $this->APIERROR($json['error']); //TORN API ERROR
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
    throw new Exception('API Key Error Code: ' . $error['code'] . ' - ' . $error['error']);
    exit('API Key Error Code: ' . $error['code'] . ' - ' . $error['error']);
  }

  /////////////////////////////////////////////////
  ////////           END OF CLASS          ////////
  /////////////////////////////////////////////////

}
?>
