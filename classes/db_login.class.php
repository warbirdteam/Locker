<?php

class db_login {

  private $apikey;
  private $userid;
  private $username;
  private $factionid;
  private $site_user;
  private $torn_user;

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

  }

  /////////////////////////////////////////////////

  //Verify that the entered string is accurate to a Torn API Key (16 characters, only numbers and letters)
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

  //Verify the user's faction is part of the faction family
  private function verifyFaction($factionid) {
    $db_request = new db_request();
    $faction_list = $db_request->getAllFactionIDs();

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
        $error = new Error_Message('API Key Error Code: ' . $json['error']['code'] . ' - ' . $json['error']['error'],"../index.php");
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
    //Assume account doesn't exist yet
    $account_exists = false;
    while (!$account_exists) {
      $db_request = new db_request();

      //check if user exists via tornID to site users table
      $site = $db_request->getSiteUserByTornID($this->userid);
      if (empty($site)) {
        $this->register();
        $this->verifyAPI();
        continue;
      } else {
        $this->site_user = $site;
      }

      $account_exists = true;
    } //while

      if ($this->site_user['siteRole'] == "none") {
        if (!$this->verifyFaction($this->factionid) ) {
          $error = new Error_Message("You are not in the Warbirds Family.","../index.php");
        } else {
          $db_request->updateSiteUserRoleBySiteID($this->site_user['siteID'], "member");
        }
      }


      $this->refreshJSON();
      $this->compareAndUpdateAPIKey($this->site_user['siteID'], $this->site_user['enc_api'], $this->site_user['iv'], $this->site_user['tag']);
      $data = ["tornid" => $this->site_user['tornID'], "factionid" => $this->factionid, "username" => $this->username, "userrole" => $this->site_user['siteRole'], "siteID" => $this->site_user['siteID']];

      return $data;
  }

  /////////////////////////////////////////////////

  public function register() {
    $crypt = new API_Crypt();
    $enc_api = $crypt->pad($this->apikey);

    $db_request = new db_request();
    $result = $db_request->registerUser("none", $enc_api, $crypt, $this->userid);

    if(empty($result)){
      $error = new Error_Message("There was an error registering. Please try again later.","../index.php");
    }
  }

  /////////////////////////////////////////////////

  private function refreshJSON() {

    $url = 'https://api.torn.com/user/?selections=networth,personalstats,battlestats,profile,basic,timestamp&key=' . $this->apikey; // url to api json
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

  private function compareAndUpdateAPIKey($siteID, $oldenc_api, $oldiv, $oldtag) {

    $uncrypt = new API_Crypt();
    $unenc_api = $uncrypt->unpad($oldenc_api, $oldiv, $oldtag);

    if ($this->apikey != $unenc_api) {
      $crypt = new API_Crypt();
      $enc_api = $crypt->pad($this->apikey);

      $db_request = new db_request();
      $db_request->updateAPIKey($siteID, $enc_api, $crypt);
    }
  }

  /////////////////////////////////////////////////


}
