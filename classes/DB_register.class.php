<?php

class DB_register extends DB_connect {

  private $apikey;
  private $userid;
  private $username;
  private $factionid;


  public function __construct($apikey) {

    $this->apikey = $apikey;

    if (strlen($this->apikey) != 16) {
      $error = new Error_Message("API Key invalid. Please try again.","register.php");
    }

    if (!preg_match('/^[A-Za-z0-9_-]+$/', $this->apikey)) {
        $error = new Error_Message("API Key invalid. Please try again.","register.php");
    }

    $this->checkPlayerAPI();

    $faction_list = array("13784","35507","30085");
    if(!in_array($this->factionid, $faction_list)){
      $error = new Error_Message("You are not part of the Warbirds Family.","register.php");
    }

    $this->checkPlayerDB();

    $this->register();

  }

  private function checkPlayerAPI() {
    $playerurl = 'https://api.torn.com/user/?selections=timestamp,basic,profile&key=' . urlencode($this->apikey); // url to api json
    $playerdata = file_get_contents($playerurl);

    $player = json_decode($playerdata, true); // decode the JSON feed

    if (is_array($player) || is_object($player)) {
      if (isset($player['error'])) {
        //APIKEY probably invalid
        $error = new Error_Message('API Key Error Code: ' . $player['error']['code'] . ' - ' . $player['error']['error'],"register.php");
      } else {
         if (isset($player['timestamp'])) {
            $this->userid = $player['player_id'];
            $this->username = $player['name'];
            $this->factionid = isset($player['faction']['faction_id']) ? $player['faction']['faction_id'] : NULL;
          }
        }
      }
  }

  private function checkPlayerDB() {

    //Check to see if user already exists
	  $sql = "SELECT tornid FROM users WHERE tornid=? LIMIT 1";
  	$stmt = $this->connect()->prepare($sql);
  	$stmt->execute([$this->userid]);
	  $uid = $stmt->fetchColumn();

    if ($uid == $this->userid) {
      $error = new Error_Message("User already registered. Please login.","register.php");
    }

  }

  private function register() {

      $crypt = new API_Crypt();
      $enc_api = $crypt->pad($this->apikey);

      $sql = "INSERT INTO users (tornid, username, factionid, userrole, enc_api, iv, tag) VALUES(?,?,?,?,?,?,?)";
      $stmt = $this->connect()->prepare($sql);
      $result = $stmt->execute([$this->userid, $this->username, $this->factionid, 'member', $enc_api, $crypt->iv, $crypt->tag]);
      if($result){
        $error = new Error_Message("User registered successfully! You may now login.","register.php");
      } else {
        $error = new Error_Message("There was an error registering. Please try again.","register.php");
      }

  }

}
