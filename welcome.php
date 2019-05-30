<?php
session_start();
if ($_SESSION['role'] == 'admin') {include('navbar-admin.php');} else {include('navbar.php');}
$apikey =  $_SESSION['key']; // currernt user apikey

?>

<?php
//$apikey = "UtuyM2roWM6vDjKj"; //Heasleys4hemp's apikey
//$jsonurl = "https://api.torn.com/faction/13784?selections=basic&key=jIirMCNvK8q2hf8u";
$jsonurl = "https://api.torn.com/user/?selections=timestamp,networth,bazaar,display,inventory,hof,travel,education,medals,honors,notifications,personalstats,workstats,crimes,icons,cooldowns,perks,battlestats,bars,profile,basic,stocks,properties,jobpoints,merits,refills,discord,gym&key=" . $apikey;
   $json = file_get_contents($jsonurl); //gets output of API

$data = json_decode($json, true);

//echo '<pre>'; print_r($data); echo '</pre>';

/*
   $decodedString =  new RecursiveIteratorIterator ( new RecursiveArrayIterator(json_decode($json, true)), RecursiveIteratorIterator::SELF_FIRST); //parses API JSON output
echo "<table border='1'><tr>";
foreach($decodedString as $key=>$value) {
    if(is_array($value)) {
     echo "<td>$key: </td></tr>";
    } else {
     echo "<td>$key</td><td align='right'> $value</td></tr>";
    }
}
echo "</table>";
function printValues($arr) {
    global $count;
    global $values;

    // Check input is an array
    if(!is_array($arr)){
        die("ERROR: Input is not an array");
    }

    /*
    Loop through array, if value is itself an array recursively call the
    function else add the value found to the output items array,
    and increment counter by 1 for each value found
    */
		/*
    foreach($arr as $key=>$value){
        if(is_array($value)){
            printValues($value);
        } else{
            $values[] = $value;
            $count++;
        }
    }

    // Return total count and values found in array
    return array('total' => $count, 'values' => $values);
}*/
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Type');
        data.addColumn('number', 'Money');
        data.addRows([
          ['Pending', <?php echo (int)$data["networth"]["pending"] ?>],
          ['Wallet', <?php echo (int)$data["networth"]["wallet"] ?>],
          ['Bank', <?php echo (int)$data["networth"]["bank"] ?>],
          ['Points', <?php echo (int)$data["networth"]["points"] ?>],
          ['Cayman Islands', <?php echo (int)$data["networth"]["cayman"] ?>],
          ['Vault', <?php echo (int)$data["networth"]["vault"] ?>],
          ['Piggy Bank', <?php echo (int)$data["networth"]["piggybank"] ?>],
          ['Items', <?php echo (int)$data["networth"]["items"] ?>],
          ['Display Case', <?php echo (int)$data["networth"]["displaycase"] ?>],
          ['Bazaar', <?php echo (int)$data["networth"]["bazaar"] ?>],
          ['Properties', <?php echo (int)$data["networth"]["properties"] ?>],
          ['Stock Market', <?php echo (int)$data["networth"]["stockmarket"] ?>],
          ['Auction House', <?php echo (int)$data["networth"]["auctionhouse"] ?>],
          ['Company', <?php echo (int)$data["networth"]["company"] ?>],
          ['Bookie', <?php echo (int)$data["networth"]["bookie"] ?>],
          ['Loan', <?php echo (int)$data["networth"]["loan"] ?>]
        ]);


        var formatter = new google.visualization.NumberFormat({pattern:'$###,###'});
        formatter.format(data,1);

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data);
      }
    </script>




<div class="content">

<div class="container pt-2" style="width: 30rem;">
	<div class='alert alert-success'>
		<button class='close' data-dismiss='alert'>&times;</button>
		Hello <?php echo $data['name'] ?>,<br>Welcome to the members page.<br>
    </div>
</div>

<div class="container-fluid mt-3">

	<div class="row pb-3">

		 <div class="col-lg-3 col-md-6 pt-3">
			<div class="card border border-dark shadow rounded">
			  <h5 class="card-header">Networth: $<?php echo number_format($data["networth"]["total"]) ?></h5>
			  <div class="card-body">

			   <div id="chart_div"></div>

			  </div>
			</div>
		 </div> <!-- col -->

		 <div class="col-lg-3 col-md-6 pt-3">
			<div class="card border border-dark shadow rounded">
			  <h5 class="card-header">Networth: $<?php echo number_format($data["networth"]["total"]) ?></h5>
			  <div class="card-body">
			   <p class="card-text"></p>
			   <p class="card-text">You currently have $<?php echo number_format($data["networth"]["wallet"]) ?> on hand.</p>
			   <?php if ($data['networth']['wallet'] > 999999) { echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>You should bank that!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'; } ?>
			  </div>
			</div>
		 </div> <!-- col -->

		 <div class="col-lg-3 col-md-6 pt-3">
			<div class="card border border-dark shadow rounded">
			  <h5 class="card-header">Everything</h5>
			  <div class="card-body">

			   <p class="card-text"><?php echo '<pre>'; print_r($data); echo '</pre>';?></p>

			  </div>
			</div>
		 </div> <!-- col -->

	</div>

</div> <!-- container -->

</div> <!-- content -->
<?php
include('footer.php');
?>
