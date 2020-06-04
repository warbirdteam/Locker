<?php

class db_login {

  private $apikey;
  private $userid;
  private $username;
  private $factionid;

  /////////////////////////////////////////////////

  public function __construct($apikey) {

    if ( isset($apikey) && !empty($apikey) ) {
      $this->apikey = $apikey;
    } else {
      $error = new Error_Message("You did not enter anything into the API textbox.","../index.php");
    }

    if ( !$this->verifyString() ) {
      $error = new Error_Message("The API key you entered is invalid.","../index.php");
    }

    $this->verifyAPI();

    if ( !$this->verifyFaction($this->factionid) ) {
      $error = new Error_Message("You are not in the Warbirds Family.","../index.php");
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

  private function verifyAPI() {
    $url = 'https://api.torn.com/user/?selections=timestamp,basic,profile&key=' . $this->apikey; // url to api json
    $data = file_get_contents($url);

    $json = json_decode($data, true); // decode the JSON feed

    if (is_array($json) || is_object($json)) {
      if (isset($json['error'])) {
        //APIKEY probably invalid
        $error = new Error_Message('API Key Error Code: ' . $player['error']['code'] . ' - ' . $player['error']['error'],"../index.php");
      } else {
        if (isset($json['timestamp'])) {
          $this->userid = $json['player_id'];
          $this->username = $json['name'];
          $this->factionid = isset($json['faction']['faction_id']) ? $json['faction']['faction_id'] : NULL;
        }
      }
    }
  }

  /////////////////////////////////////////////////

  public function login() {
    $db_request = new db_request();
    $torn = $db_request->getTornUserByTornID($this->userid);
    $site = $db_request->getSiteUserBySiteID($torn['siteID']);

    $this->refreshJSON();
    $this->compareAndUpdateAPIKey($torn['siteID'], $site['enc_api'], $site['iv'], $site['tag']);

    $data = ["tornid" => $torn['tornID'], "factionid" => $torn['tornFaction'], "username" => $torn['tornName'], "userrole" => $site['siteRole']];

    return $data;
  }

  /////////////////////////////////////////////////

  private function refreshJSON() {

    $url = 'https://api.torn.com/user/?selections=networth,bazaar,display,inventory,hof,travel,events,messages,education,medals,honors,notifications,personalstats,workstats,crimes,icons,money,perks,battlestats,profile,basic,attacksfull,revivesfull,stocks,properties,jobpoints,merits,refills,weaponexp,ammo,gym,timestamp&key=' . $this->apikey; // url to api json
    $data = file_get_contents($url);
    $file = __DIR__.'/../TornAPIs/' . $this->factionid . '/'.$this->userid.'.json';


    $json = json_decode($data, true); // decode the JSON feed


    if (is_array($json) || is_object($json)) {
      if (isset($json['error'])) {
        $error = new Error_Message('API Key Error Code: ' . $player['error']['code'] . ' - ' . $player['error']['error'],"../index.php");
      }

      if (!is_dir(__DIR__.'/../TornAPIs/' . $this->factionid)) {
        mkdir(__DIR__.'/../TornAPIs/' . $this->factionid);
      }

      file_put_contents($file, serialize($data));

    }


  }

  /////////////////////////////////////////////////

  private function compareAndUpdateAPIKey($siteID, $enc_api, $iv, $tag) {

    $uncrypt = new API_Crypt();
    $unenc_api = $uncrypt->unpad($enc_api, $iv, $tag);

    if ($this->apikey != $unenc_api) {
      $crypt = new API_Crypt();
      $enc_api = $crypt->pad($this->apikey);

      $db_request = new db_request();
      $db_request->updateAPIKey();
    }
  }

  /////////////////////////////////////////////////


}
