<?php
session_start();
if ($_SESSION['role'] == 'admin') {include('navbar-admin.php');} else {include('navbar.php');}

// Load the database configuration file
include_once("../../../db_connect_stats.php");

/*$action = htmlspecialchars($_GET["action"]);

//something for later, idk just an idea
switch ($action) {
    case "energy":

    break;
    case "":
    //
    break;
    default:
    //
    break;

}*/


?>



<div class="container">
  <div class="row">
   <div class="col border border-dark shadow py-4 mt-4 rounded">

   <table class="table table-hover table-striped table-dark">
      <thead class="thead-light">
        <tr>
          <th scope="col">Player</th>
          <th scope="col">Energy</th>
          <th scope="col">Drug Cooldown</th>
          <th scope="col">Booster Cooldown</th>
          <th scope="col">Energy Refill Used</th>
          <th scope="col">Nerve Refill Used</th>
        </tr>
      </thead>
      <tbody>
      <?php
      // Get member rows
      $result = $statconn->query("SELECT tornuserkey FROM users WHERE tornuserkey <> 'testkey'");

      if($result === false)
      {
         user_error("Query failed: ".$statconn->error."\n$query");
         return false;
      } else {

      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){

          $apikey = $row['tornuserkey'];
          $jsonurl = "https://api.torn.com/user/?selections=timestamp,networth,bazaar,display,inventory,hof,travel,education,medals,honors,notifications,personalstats,workstats,crimes,icons,cooldowns,money,perks,battlestats,bars,profile,basic,stocks,properties,jobpoints,merits,refills,discord,gym&key=" . $apikey;
          $json = file_get_contents($jsonurl); //gets output of API

          $data = json_decode($json, true);
      ?>
        <tr>
          <td><?php echo $data["name"] . ' [' . $data["player_id"] . ']' ?></td>
          <td><?php echo $data["energy"]["current"].'/'.$data["energy"]["maximum"] ?></td>
          <td><?php echo gmdate("H:i:s",$data["cooldowns"]["drug"]) ?></td>
          <td><?php echo gmdate("H:i:s",$data["cooldowns"]["booster"]) ?></td>
          <td><?php echo $data["refills"]["energy_refill_used"] ?></td>
          <td><?php echo $data["refills"]["nerve_refill_used"] ?></td>
        </tr>
      <?php } }else{ ?>
        <tr><td colspan="5">No information found...</td></tr>
      <?php } } ?>
      </tbody>

<?php

/*
echo '<tr>';
echo '<th scope="row">' . $data["name"] . ' [' . $data["player_id"] . ']</th>';
echo '<td>' . $data["energy"]["current"].'/'.$data["energy"]["maximum"] . '</td>';
echo '<td>' . gmdate("H:i:s",$data["cooldowns"]["drug"])  . '</td>';
echo '<td>' . gmdate("H:i:s",$data["cooldowns"]["booster"]) . '</td>';
echo '<td>' . $data["refills"]["energy_refill_used"] . '</td>';
echo '<td>' . $data["refills"]["energy_refill_used"] . '</td>';
echo '</tr>';
*/

?>

</table>


</div> <!-- col -->
</div> <!-- row -->
</div> <!-- container -->




<?php
include('footer.php');
?>
