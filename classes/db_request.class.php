<?php

class db_request extends db_connect {

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

  public function getAllMembers() {
    $sql = "SELECT * FROM torn_members";
    $stmt = $this->pdo->query($sql);
    $row = $stmt->fetchAll();
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }
    return $row;
  }

  /////////////////////////////////////////////////

  public function getAllMembersIDs() {
    $sql = "SELECT tornID FROM torn_members";
    $stmt = $this->pdo->query($sql);
    $row = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }
    return $row;
  }

  /////////////////////////////////////////////////

  public function getAllMembersIDsFromInfo() {
    $sql = "SELECT tornID FROM torn_members_info";
    $stmt = $this->pdo->query($sql);
    $row = $stmt->fetchAll(PDO::FETCH_COLUMN);
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

  public function getMemberInfoByTornID($tornID) {
    $sql = "SELECT * FROM torn_members_info WHERE tornID = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$tornID]);
    $row = $stmt->fetch();
    if(empty($row)) {
      return NULL;
    }
    return $row;
  }

  /////////////////////////////////////////////////

  public function getAllMemberInfoOrderBy($sort) {
    switch ($sort) {
      case 'networth':
      $sql = "SELECT * FROM torn_members_info ORDER BY networth DESC";
      break;
      case 'awards':
      $sql = "SELECT * FROM torn_members_info ORDER BY awards DESC";
      break;
      case 'level':
      $sql = "SELECT * FROM torn_members_info ORDER BY level DESC";
      break;

      default:
      return NULL;
      break;
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([]);
    $row = $stmt->fetchAll();
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }
    return $row;
  }

  /////////////////////////////////////////////////

  public function updateMemberInfo($tornID, $discordID, $donator, $property, $networth, $awards, $age, $level) {
    $sql = "UPDATE torn_members_info SET discordID = ?, donator = ?, property = ?, networth = ?, awards = ?, age = ?, level = ? WHERE tornID = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$discordID, $donator, $property, $networth, $awards, $age, $level, $tornID]);
  }

  /////////////////////////////////////////////////

  public function insertMemberInfo($tornID, $discordID, $donator, $property, $networth, $awards, $age, $level) {
    $sql = "INSERT INTO torn_members_info (tornID, discordID, donator, property, networth, awards, age, level) values (?,?,?,?,?,?,?,?)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$tornID, $discordID, $donator, $property, $networth, $awards, $age, $level]);
  }

  /////////////////////////////////////////////////

  public function insertMemberPersonalStats($tornID, $xantaken, $overdosed, $refills, $nerverefills, $consumablesused, $boostersused, $energydrinkused, $statenhancers, $traveltimes, $dumpsearches) {
    $sql = "INSERT INTO torn_members_personalstats (tornID, xanax, overdosed, refill_energy, refill_nerve, consumablesused, boostersused, energydrinkused, statenhancersused, travel, dumpsearches) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$tornID, $xantaken, $overdosed, $refills, $nerverefills, $consumablesused, $boostersused, $energydrinkused, $statenhancers, $traveltimes, $dumpsearches]);
  }

  /////////////////////////////////////////////////

  public function insertMember($userid, $fid, $member) {
    $sql = "INSERT INTO torn_members VALUES (?,?,?,?,?,?,?)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$userid, $fid, $member['name'], $member['days_in_faction'], $member['last_action']['timestamp'], $member['status']['description'], $member['status']['details']]);
  }

  /////////////////////////////////////////////////

  public function removeMemberByTornID($tornID) {
    $delete_sql_member = "DELETE FROM torn_members WHERE tornID = ?";
    $stmt_delete_member = $this->pdo->prepare($delete_sql_member);
    $stmt_delete_member->execute([$tornID]);
  }

  /////////////////////////////////////////////////

  public function removeMemberInfoByTornID($tornID) {
    $delete_sql_info = "DELETE FROM torn_members_info WHERE tornID = ?";
    $stmt_delete_info = $this->pdo->prepare($delete_sql_info);
    $stmt_delete_info->execute([$tornID]);
  }

  /////////////////////////////////////////////////

  public function getFactionByFactionID($fid) {
    $sql = "SELECT * FROM torn_factions WHERE factionID = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$fid]);
    $row = $stmt->fetch();
    if(empty($row)) {
      return NULL;
    }
    return $row;
  }

  /////////////////////////////////////////////////

  public function updateFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect) {
    $sql = "UPDATE torn_factions SET factionName = ?, leader = ?, co_leader = ?, age = ?, best_chain = ?, total_members = ?, respect = ? WHERE factionID = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$fname, $leader, $coleader, $age, $best_chain, $total_members, $respect, $fid]);
  }

  /////////////////////////////////////////////////

  public function insertFactionInfo($fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect) {
    $sql = "INSERT INTO torn_factions (factionID, factionName, leader, co_leader, age, best_chain, total_members, respect) values (?,?,?,?,?,?,?,?)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$fid, $fname, $leader, $coleader, $age, $best_chain, $total_members, $respect]);
  }

  /////////////////////////////////////////////////

  public function getAllFactionLookups() {
    $sql = "SELECT * from faction_lookup_factions";
    $stmt = $this->pdo->query($sql);
    $row = $stmt->fetchAll();
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }

    return $row;
  }

  /////////////////////////////////////////////////

  public function getUsersInLookup($lookup_id) {
    $sql = "SELECT * from faction_lookups where lookup_id=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$lookup_id]);
    $row = $stmt->fetchAll();
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }

    return $row;
  }

  /////////////////////////////////////////////////

  public function insertFactionLookupFaction($faction) {
    $sql = "INSERT INTO faction_lookup_factions (faction_id, faction_name, respect, leader, co_leader, age, best_chain, total_members) VALUES (?,?,?,?,?,?,?,?)";
    $stmtinsert = $this->pdo->prepare($sql);
    $stmtinsert->execute([$faction['ID'],$faction['name'],$faction['respect'],$faction['leader'],$faction['co-leader'],$faction['age'],$faction['best_chain'],count($faction['members'])]);

    $lookup_id = $this->pdo->lastInsertId();
    return $lookup_id;
  }

  /////////////////////////////////////////////////

  public function insertFactionLookupPlayer($lookup_id, $userid, $username, $level, $days_in_faction, $last_action, $donator, $xantaken, $attackswon, $defendswon, $property, $refills, $nerverefills, $boostersused, $energydrinkused, $statenhancers, $enemies) {
    $sql = "INSERT INTO faction_lookups (lookup_id, userid, username, level, days_in_faction, last_action, donator_status, xanax, attackswon, defendswon, property, energy_refills, nerve_refills, boosters, cans, stat_enhancers, enemies) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmtinsert = $this->pdo->prepare($sql);
    $stmtinsert->execute([$lookup_id, $userid, $username, $level, $days_in_faction, $last_action, $donator, $xantaken, $attackswon, $defendswon, $property, $refills, $nerverefills, $boostersused, $energydrinkused, $statenhancers, $enemies]);
  }

  /////////////////////////////////////////////////

  public function insertChainID($factionID, $chainID, $userID) {
    $sql = "INSERT INTO faction_chains (factionID, chainID, uploadedByUserID) values (?,?,?)";
    $stmtinsert = $this->pdo->prepare($sql);
    $stmtinsert->execute([$factionID, $chainID, $userID]);
  }

  /////////////////////////////////////////////////

  public function getChainByChainID($chainID) {
    $sql = "SELECT * FROM faction_chains WHERE chainID=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$chainID]);
    $row = $stmt->fetchAll();
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }

    return $row;
  }

  /////////////////////////////////////////////////

  public function getChainsByFactionID($factionID) {
    $sql = "SELECT * FROM faction_chains WHERE factionID=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$factionID]);
    $row = $stmt->fetchAll();
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }

    return $row;
  }

  /////////////////////////////////////////////////

  public function getAllChainIDs() {
    $sql = "SELECT * FROM faction_chains";
    $stmt = $this->pdo->query($sql);
    $row = $stmt->fetchAll();
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }
    return $row;
  }

  /////////////////////////////////////////////////

  public function getMemberStatsByIDWeek($userid) {
    $sql = "SELECT * FROM (SELECT tornID FROM torn_members_personalstats WHERE tornID=? ORDER BY timestamp DESC LIMIT 1) as tmpinfo JOIN (SELECT max(xanax)-min(xanax) as xanaxweek, max(overdosed)-min(overdosed) as overdosedweek, (((max(xanax)-min(xanax))+(3*(max(overdosed)-min(overdosed))))/7) as xanscore, max(refill_energy)-min(refill_energy) as refill_energyweek, max(refill_nerve)-min(refill_nerve) as refill_nerveweek, max(consumablesused)-min(consumablesused) as consumablesusedweek, max(boostersused)-min(boostersused) as boostersusedweek, max(energydrinkused)-min(energydrinkused) as energydrinkusedweek, max(statenhancersused)-min(statenhancersused) as statenhancersusedweek, max(travel)-min(travel) as travelweek, max(dumpsearches)-min(dumpsearches) as dumpsearchesweek from (SELECT * FROM torn_members_personalstats WHERE tornID=? AND timestamp >= DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -7 DAY) order by timestamp desc) as tmpweek) as tmpmath";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$userid,$userid]);
    $row = $stmt->fetchAll();
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }
    return $row;
  }

  /////////////////////////////////////////////////

  public function getMemberStatsByIDMonth($userid) {
    $sql = "SELECT * FROM (SELECT tornID FROM torn_members_personalstats WHERE tornID=? ORDER BY timestamp DESC LIMIT 1) as tmpinfo JOIN (SELECT max(xanax)-min(xanax) as xanaxweek, max(overdosed)-min(overdosed) as overdosedweek, (((max(xanax)-min(xanax))+(3*(max(overdosed)-min(overdosed))))/30) as xanscore, max(refill_energy)-min(refill_energy) as refill_energyweek, max(refill_nerve)-min(refill_nerve) as refill_nerveweek, max(consumablesused)-min(consumablesused) as consumablesusedweek, max(boostersused)-min(boostersused) as boostersusedweek, max(energydrinkused)-min(energydrinkused) as energydrinkusedweek, max(statenhancersused)-min(statenhancersused) as statenhancersusedweek, max(travel)-min(travel) as travelweek, max(dumpsearches)-min(dumpsearches) as dumpsearchesweek from (SELECT * FROM torn_members_personalstats WHERE tornID=? AND timestamp >= DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -30 DAY) order by timestamp desc) as tmpmonth) as tmpmath";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$userid,$userid]);
    $row = $stmt->fetchAll();
    $this->row_count = $stmt->rowCount();
    if(empty($row)) {
      return NULL;
    }
    return $row;
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

  public function getAllAvailableRawAPIKeys() {
    $sql = "SELECT siteID FROM site_users_preferences WHERE share_api = 1";
    $stmt = $this->pdo->query($sql);
    $rows = $stmt->fetchAll();
    $this->row_count = $stmt->rowCount();
    if(empty($rows)) {
      return NULL;
    }

    $apikeys = [];

    foreach ($rows as $row) {
      $sql = "SELECT enc_api, iv, tag FROM site_users WHERE siteID=?";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([$row['siteID']]);
      $row = $stmt->fetch();
      if(empty($row)) {
        throw new Exception('Could not find API Key associated with user.');
      }

      $uncrypt = new API_Crypt();
      $apikey = $uncrypt->unpad($row['enc_api'], $row['iv'], $row['tag']);
      if(empty($apikey)) {
        throw new Exception('Could not unencrypt API Key.');
      }

      array_push($apikeys, $apikey);
    }

    return $apikeys;
  }

  /////////////////////////////////////////////////
  ////////         LOGIN FUNCTIONS         ////////
  /////////////////////////////////////////////////

  public function getTornUserByTornID($userid) {
    $sql = "SELECT * FROM torn_users WHERE tornID = ? LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$userid]);
    $torn = $stmt->fetch();
    if(empty($torn)) {
      return NULL;
    }

    return $torn;
  }

  /////////////////////////////////////////////////

  public function getSiteUserBySiteID($siteID) {
    $sql = "SELECT * FROM site_users WHERE siteID = ? LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$siteID]);
    $site = $stmt->fetch();
    if(empty($site)) {
      return NULL;
    }

    return $site;
  }


  public function registerUser($siteRole, $enc_api, $crypt, $tornID, $tornName, $tornFaction, $factionRole) {
    $sql = "INSERT INTO site_users (siteRole, enc_api, iv, tag) VALUES(?,?,?,?)";
    $stmt = $this->pdo->prepare($sql);
    $result = $stmt->execute([$siteRole, $enc_api, $crypt->iv, $crypt->tag]);
    if (!$result) {return FALSE;};

    $last_id = $this->pdo->lastInsertId();

    $sql = "INSERT INTO torn_users (tornID, siteID, tornName, tornFaction, factionRole) VALUES(?,?,?,?,?)";
    $stmt = $this->pdo->prepare($sql);
    $result = $stmt->execute([$tornID, $last_id, $tornName, $tornFaction, $factionRole]);

    return $result;
  }


  /////////////////////////////////////////////////

  public function updateAPIKey($siteID, $enc_api, $iv, $tag) {
    $sql = "UPDATE site_users SET enc_api=?, iv=?, tag=? WHERE siteID=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$enc_api, $crypt->iv, $crypt->tag, $siteID]);
  }


  /////////////////////////////////////////////////
  ////////           END OF CLASS          ////////
  /////////////////////////////////////////////////

}
?>
