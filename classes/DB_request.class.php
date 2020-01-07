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

    public function getFactionMembersByFaction($factionid) {

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

    public function getFactionMembers() {

      $sql = "SELECT * FROM members";
      $stmt = $this->connect()->query($sql);
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


    public function getMemberInfoByIDWeek($userid) {
      /*
SELECT * FROM
(SELECT userid,username,donator,property FROM `memberinfo` WHERE userid=1468764 ORDER BY timestamp DESC LIMIT 1) as tmpinfo
JOIN
(SELECT max(xanax)-min(xanax) as xanaxweek, max(overdosed)-min(overdosed) as overdosedweek, max(refill_energy)-min(refill_energy) as refill_energyweek, max(refill_nerve)-min(refill_nerve) as refill_nerveweek, max(consumablesused)-min(consumablesused) as consumablesusedweek, max(energydrinkused)-min(energydrinkused) as energydrinkusedweek, max(statenhancersused)-min(statenhancersused) as statenhancersusedweek, max(travel)-min(travel) as travelweek, max(dumpsearches)-min(dumpsearches) as dumpsearchesweek from (SELECT * FROM memberinfo WHERE userid=1468764 AND timestamp >= DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -7 DAY) order by timestamp desc) as tmpweek) as tmpmath
*/
      $sql = "SELECT * FROM (SELECT userid,username,donator,property FROM memberinfo WHERE userid=? ORDER BY timestamp DESC LIMIT 1) as tmpinfo JOIN (SELECT max(xanax)-min(xanax) as xanaxweek, max(overdosed)-min(overdosed) as overdosedweek, (((max(xanax)-min(xanax))+(3*(max(overdosed)-min(overdosed))))/7) as xanscore, max(refill_energy)-min(refill_energy) as refill_energyweek, max(refill_nerve)-min(refill_nerve) as refill_nerveweek, max(consumablesused)-min(consumablesused) as consumablesusedweek, max(energydrinkused)-min(energydrinkused) as energydrinkusedweek, max(statenhancersused)-min(statenhancersused) as statenhancersusedweek, max(travel)-min(travel) as travelweek, max(dumpsearches)-min(dumpsearches) as dumpsearchesweek from (SELECT * FROM memberinfo WHERE userid=? AND timestamp >= DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -7 DAY) order by timestamp desc) as tmpweek) as tmpmath";
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$userid,$userid]);
      $row = $stmt->fetchAll();
      $this->row_count = $stmt->rowCount();
      if(empty($row)) {
        return NULL;
      }
      return $row;
    }

    public function getMemberInfoByIDMonth($userid) {
    $sql = "SELECT * FROM (SELECT userid,username,donator,property FROM memberinfo WHERE userid=? ORDER BY timestamp DESC LIMIT 1) as tmpinfo JOIN (SELECT max(xanax)-min(xanax) as xanaxweek, max(overdosed)-min(overdosed) as overdosedweek, (((max(xanax)-min(xanax))+(3*(max(overdosed)-min(overdosed))))/30) as xanscore, max(refill_energy)-min(refill_energy) as refill_energyweek, max(refill_nerve)-min(refill_nerve) as refill_nerveweek, max(consumablesused)-min(consumablesused) as consumablesusedweek, max(energydrinkused)-min(energydrinkused) as energydrinkusedweek, max(statenhancersused)-min(statenhancersused) as statenhancersusedweek, max(travel)-min(travel) as travelweek, max(dumpsearches)-min(dumpsearches) as dumpsearchesweek from (SELECT * FROM memberinfo WHERE userid=? AND timestamp >= DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -30 DAY) order by timestamp desc) as tmpmonth) as tmpmath";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$userid,$userid]);
    $row = $stmt->fetchAll();
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }
    return $row;
  }

}

 ?>
