<?php
session_start();
$_SESSION['title'] = 'Energy';
include('includes/header.php');
?>

<script src="js/jquery.tablesorter.js"></script>
<script src="js/jquery.tablesorter.widgets.js"></script>
<script src="js/tablesort.js"></script>

<?php
	switch ($_SESSION['role']) {
	    case 'admin':
	        include('includes/navbar-admin.php');
	        break;
	    case 'leadership':
	        include('includes/navbar-leadership.php');
	        break;
	    case 'guest':
	        header("Location: /welcome.php");
	        break;
	    case 'member':
	        header("Location: /welcome.php");
	        break;
	    default:
          $_SESSION = array();
	        $_SESSION['error'] = "You are not logged in.";
	        header("Location: /index.php");
	        break;
	}

// Load classes
include_once(__DIR__ . "/../includes/autoloader.inc.php");
?>



<div class="container">
  <div class="row">
   <div class="col border border-dark shadow py-4 mt-4 rounded">

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



</div> <!-- col -->
</div> <!-- row -->
</div> <!-- container -->




<?php
include('includes/footer.php');
?>
