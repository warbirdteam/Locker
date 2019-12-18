<?php

class DB_login extends DB_connect {

  private $apikey;
  private $userid;
  private $username;
  private $factionid;


  public function __construct($apikey) {

    $this->apikey = $apikey;

    if (strlen($this->apikey) != 16) {
      $error = new Error_Message("API Key invalid. Please try again.","index.php");
    }

    if (!preg_match('/^[A-Za-z0-9_-]+$/', $this->apikey)) {
        $error = new Error_Message("API Key invalid. Please try again.","index.php");
    }

    $this->checkPlayerAPI();

    $faction_list = array("13784","35507","30085");
    if(!in_array($this->factionid, $faction_list)){
      $error = new Error_Message("You are not part of the Warbirds Family.","index.php");
    }

  }

  private function checkPlayerAPI() {
    $playerurl = 'https://api.torn.com/user/?selections=timestamp,basic,profile&key=' . urlencode($this->apikey); // url to api json
    $playerdata = file_get_contents($playerurl);

    $player = json_decode($playerdata, true); // decode the JSON feed

    if (is_array($player) || is_object($player)) {
      if (isset($player['error'])) {
        //APIKEY probably invalid
        $error = new Error_Message('API Key Error Code: ' . $player['error']['code'] . ' - ' . $player['error']['error'],"index.php");
      } else {
         if (isset($player['timestamp'])) {
            $this->userid = $player['player_id'];
            $this->username = $player['name'];
            $this->factionid = isset($player['faction']['faction_id']) ? $player['faction']['faction_id'] : NULL;
          }
        }
      }
  }

  public function login() {

    $sql = "SELECT * FROM users WHERE tornid=? LIMIT 1";
  	$stmt = $this->connect()->prepare($sql);
    $stmt->execute([$this->userid]);
    $row = $stmt->fetch();
    if(empty($row)) {
      $error = new Error_Message("No user found. You are not registered.","index.php");
    } else {
      $this->updateAPIKEY($row['enc_api'],$row['iv'],$row['tag']);
    }
    return $row;

  }

  private function updateAPIKEY($enc_api, $iv, $tag) {

    $uncrypt = new API_Crypt();
    $unenc_api = $uncrypt->unpad($enc_api, $iv, $tag);

    if ($this->apikey != $unenc_api) {

      //encrypt new api key
      $crypt = new API_Crypt();
      $enc_api = $crypt->pad($this->apikey);

      //insert new encrypted apikey, new iv, and new tag into database
      $sql = "UPDATE users SET enc_api=?, iv=?, tag=? WHERE tornid=?";
    	$stmt = $this->connect()->prepare($sql);
      $stmt->execute([$enc_api, $crypt->iv, $crypt->tag,$this->userid]);

    }
  }


}
