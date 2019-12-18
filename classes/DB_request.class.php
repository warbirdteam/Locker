<?php

class DB_request extends DB_connect {

    public $row_count;

    public function getEnergy() {

      $sql = "SELECT * FROM current_data";
    	$stmt = $this->connect()->query($sql);
      $row = $stmt->fetchAll();
      $this->row_count = $stmt->rowCount();
      if(empty($row)) {
        return NULL;
      }
      return $row;

    }

    public function getFactionMembers($factionid) {

      $sql = "SELECT * FROM members where factionid=?";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$factionid]);
      $row = $stmt->fetchAll();
      $this->row_count = $stmt->rowCount();
      if(empty($row)) {
        return NULL;
      }
      return $row;
    }

    public function getChainReports($factionid,$sizelimit) {

      switch ($factionid) {
        case '13784':
        $table = 'wbchains';
        break;
        case '35507':
        $table = 'nestchains';
        break;
        default:
        return NULL;
        break;

      }

      $sql = "SELECT * FROM ". $table ." WHERE hits >= :sizelimit";
      $stmt = $this->connect()->prepare($sql);
      //  $stmt->bindValue(':table', $table, PDO::PARAM_STR);
      $stmt->bindValue(':sizelimit', $sizelimit, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetchAll();
      $this->row_count = $stmt->rowCount();
      if(empty($row)) {
        return NULL;
      }
      return $row;

    }

    public function getUsers() {
      $sql = "SELECT tornid,username,factionid,userrole FROM users";
    	$stmt = $this->connect()->query($sql);
      $row = $stmt->fetchAll();
      $this->row_count = $stmt->rowCount();
      if(empty($row)) {
        return NULL;
      }
      return $row;
    }

    public function getAPIKEYList() {
      $sql = "SELECT tornid,userrole,enc_api,iv,tag FROM users WHERE userrole != 'guest'";
    	$stmt = $this->connect()->query($sql);
      $row = $stmt->fetchAll();
      $this->row_count = $stmt->rowCount();
      if(empty($row)) {
        return NULL;
      }

      return $row;
    }
}

 ?>
