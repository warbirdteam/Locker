<?php
//##### LEADERSHIP & ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Energy';
include('includes/header.php');
?>



<?php
include('includes/navbar-logged.php');
?>

<?php
if (!isset($_SESSION['roleValue'])) {
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
}

if ($_SESSION['roleValue'] <= 2) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
}
?>



<div class="container">
  <div class="row">
   <div class="col border border-dark shadow py-4 mt-4 rounded">
<div class="table-responsive">
   <table class="table table-hover table-striped table-dark">
      <thead class="thead-dark">
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
        $db_energy = new DB_request();
        $rows = $db_energy->getEnergy();
        $count = $db_energy->row_count;

        if($count > 0){

        foreach ($rows as $row){

        		if($row['refill_energy'] == '') {
        		  $row['refill_energy'] = '0';
        	 	}
        		if($row['refill_nerve'] == '') {
        		  $row['refill_nerve'] = '0';
        		}
        ?>

         <tr>
           <td><?php echo $row["name"] . ' [' . $row["userid"] . ']' ?></td>
           <td><?php echo $row["energy"] ?></td>
           <td><?php echo gmdate("H:i:s",$row["cooldown_drug"]) ?></td>
           <td><?php echo gmdate("H:i:s",$row["cooldown_booster"]) ?></td>
           <td><?php echo $row['refill_energy'] ?></td>
           <td><?php echo $row['refill_nerve'] ?></td>
         </tr>

        <?php } }else{ ?>
          <tr><td colspan="6">No information found...</td></tr>
        <?php } ?>
      </tbody>
   </table>
 </div>



</div> <!-- col -->
</div> <!-- row -->
</div> <!-- container -->




<?php
include('includes/footer.php');
?>
