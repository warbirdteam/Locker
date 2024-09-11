<?php

class api_request {

  protected $apikey;
  private $siteID;
  private $baseURL = "https://api.torn.com";
  private $baseURLv2 = "https://api.torn.com/v2";

  /////////////////////////////////////////////////

  public function __construct($apikey, $siteID = null) {

    if ( isset($apikey) && !empty($apikey) ) {
      $this->apikey = $apikey;
    } else {
      throw new Exception('API Key was not passed correctly or does not exist.');
    }

    if ( isset($siteID) && !empty($siteID) ) {
      $this->siteID = $siteID;
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
      return false;
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
  ////////             API ERROR           ////////
  /////////////////////////////////////////////////

  private function APIError($error) {
    //Check Error Code and describe reason, such as bad key, etc
    if (!isset($error['code'])) {
      throw new Exception('API Error: No error code.');
      exit('API Error: No error code. ');
    }

    switch ($error['code']) {
      case 0:
        //  Unknown error : Unhandled error, should not occur.
      break;

      case 1:
        // Key is empty : Private key is empty in current request.
      break;

      case 2:
        // Incorrect Key : Private key is wrong/incorrect format.
        $this->updateKeyActive(0);
      break;
      
      case 3:
        // Wrong type : Requesting an incorrect basic type.
      break;

      case 4:
        // Wrong fields : Requesting incorrect selection fields.
      break;

      case 5:
        // Too many requests : Requests are blocked for a small period of time because of too many requests per user (max 100 per minute).
      break;

      case 6:
        // Incorrect ID : Wrong ID value.
      break;

      case 7:
        //  Incorrect ID-entity relation : A requested selection is private (For example, personal data of another user / faction).
      break;

      case 8:
        // IP block : Current IP is banned for a small period of time because of abuse.
      break;

      case 9:
        //  API disabled : Api system is currently disabled.
      break;

      case 10:
        // Key owner is in federal jail : Current key can't be used because owner is in federal jail.
        $this->updateKeyActive(0);
      break;

      case 11:
        //  Key change error : You can only change your API key once every 60 seconds.
      break;

      case 12:
        // Key read error : Error reading key from Database.
      break;

      case 13:
        // The key is temporarily disabled due to owner inactivity : The key owner hasn't been online for more than 7 days.
        $this->updateKeyActive(0);
      break;

      case 14:
        // Daily read limit reached : Too many records have been pulled today by this user from our cloud services.
      break;

      case 15:
        // Temporary error : An error code specifically for testing purposes that has no dedicated meaning.
      break;

      case 16:
        // Access level of this key is not high enough : A selection is being called of which this key does not have permission to access.
      break;

      case 17:
        // Backend error occurred, please try again.
      break;

      case 18:
        // API key has been paused by the owner.
        $this->updateKeyActive(0);
      break;

      case 19:
        // Must be migrated to crimes 2.0.
      break;

      case 20:
        // Race not yet finished.
      break;

      case 21:
        // Incorrect category : Wrong cat value.
      break;
      
      default:
        exit('API Key Error Code: ' . $error['code'] . ' - ' . $error['error']);
      break;
    }

    throw new Exception('API Key Error Code: ' . $error['code'] . ' - ' . $error['error']);
  }

  private function updateKeyActive($active) {
    if (isset($this->siteID) && !empty($this->siteID)) {
      $db_request_api = new db_request();
      $db_request_api->updateSiteAPIActive($this->siteID, $active);
    }
  }

  /////////////////////////////////////////////////
  ////////           END OF CLASS          ////////
  /////////////////////////////////////////////////

}
?>
