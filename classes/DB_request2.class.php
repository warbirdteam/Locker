<?php

class DB_request2 extends DB_connect2 {

  public $row_count;

/////////////////////////////////////////////////

  public function getFactionMembersByFaction($factionid) {
    $sql = "SELECT * FROM torn_members where factionID=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$factionid]);
    $row = $stmt->fetchAll(PDO::FETCH_UNIQUE);
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }
    return $row;
  }

/////////////////////////////////////////////////

  public function getMemberByTornID($tornID) {
    $sql = "SELECT * FROM torn_members WHERE tornID = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$tornID]);
    $row = $stmt->fetch();
    if(empty($row)) {
      return NULL;
    }
    return $row;
  }

/////////////////////////////////////////////////

  public function updateMember($userid, $member) {
    $sql = "UPDATE torn_members SET tornName = ?, days_in_faction = ?, last_action = ?, status_desc = ?, status_details = ? WHERE tornID = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$member['name'], $member['days_in_faction'], $member['last_action']['timestamp'], $member['status']['description'], $member['status']['details'], $userid]);
  }

/////////////////////////////////////////////////

  public function insertMember($userid, $fid, $member) {
    $sql = "INSERT INTO torn_members VALUES (?,?,?,?,?,?,?)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$userid, $fid, $member['name'], $member['days_in_faction'], $member['last_action']['timestamp'], $member['status']['description'], $member['status']['details']]);
  }

/////////////////////////////////////////////////

  public function removeMemberByTornID($tornID) {
    $sql = "DELETE FROM torn_members WHERE tornID = ?";
    $stmtdelete = $this->pdo->prepare($sql);
    $stmtdelete->execute([$tornID]);
  }

/////////////////////////////////////////////////

  public function getRawAPIKeyByUserID($userid) {
    $sql = "SELECT siteID FROM torn_users WHERE tornID=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$userid]);
    $siteID = $stmt->fetchColumn();
    if(empty($siteID)) {
      throw new Exception('Could not find user associated with Torn ID.');
    }

    $sql = "SELECT enc_api, iv, tag FROM site_users WHERE siteID=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$siteID]);
    $row = $stmt->fetch();
    if(empty($row)) {
      throw new Exception('Could not find API Key associated with user.');
    }

    $uncrypt = new API_Crypt();
    $apikey = $uncrypt->unpad($row['enc_api'], $row['iv'], $row['tag']);
    if(empty($apikey)) {
      throw new Exception('Could not unencrypt API Key.');
    }

    return $apikey;
  }

/////////////////////////////////////////////////
////////           END OF CLASS          ////////
/////////////////////////////////////////////////

}
?>
