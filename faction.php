<?php
session_start();
if ($_SESSION['role'] == 'admin') {include('navbar-admin.php');} else {include('navbar.php');}


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


$apikey = "UtuyM2roWM6vDjKj"; //Heasleys4hemp's apikey
//$jsonurl = "https://api.torn.com/faction/13784?selections=basic&key=jIirMCNvK8q2hf8u";
$jsonurl = "https://api.torn.com/user/?selections=timestamp,networth,bazaar,display,inventory,hof,travel,education,medals,honors,notifications,personalstats,workstats,crimes,icons,cooldowns,money,perks,battlestats,bars,profile,basic,stocks,properties,jobpoints,merits,refills,discord,gym&key=" . $_SESSION['key'];
   $json = file_get_contents($jsonurl); //gets output of API

$data = json_decode($json, true);

//could do a for loop here later, but only data we have is mine so weeeeee
echo '<tr>';
echo '<th scope="row">' . $data["name"] . ' [' . $data["player_id"] . ']</th>';
echo '<td>' . $data["energy"]["current"].'/'.$data["energy"]["maximum"] . '</td>';
echo '<td>' . gmdate("H:i:s",$data["cooldowns"]["drug"])  . '</td>';
echo '<td>' . gmdate("H:i:s",$data["cooldowns"]["booster"]) . '</td>';
echo '<td>' . $data["refills"]["energy_refill_used"] . '</td>';
echo '<td>' . $data["refills"]["energy_refill_used"] . '</td>';
echo '</tr>';

?>


  </tbody>
</table>


</div> <!-- col -->
</div> <!-- row -->
</div> <!-- container -->




<?php
include('footer.php');
?>
