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

$dataPoints = array( 
	//array("label"=>"Pending", "y"=>number_format(number_format($data["networth"]["pending"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"Wallet", "y"=>number_format(number_format($data["networth"]["wallet"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"Bank", "y"=>number_format(number_format($data["networth"]["bank"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"Points", "y"=>number_format(number_format($data["networth"]["points"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"Cayman", "y"=>number_format(number_format($data["networth"]["cayman"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"Vault", "y"=>number_format(number_format($data["networth"]["vault"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"piggybank", "y"=>number_format(number_format($data["networth"]["piggybank"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"Items", "y"=>number_format(number_format($data["networth"]["items"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"Display Case", "y"=>number_format(number_format($data["networth"]["displaycase"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"Bazaar", "y"=>number_format(number_format($data["networth"]["bazaar"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	array("label"=>"Properties", "y"=>number_format(number_format($data["networth"]["properties"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	array("label"=>"Stock Market", "y"=>number_format(number_format($data["networth"]["stockmarket"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"Auction House", "y"=>number_format(number_format($data["networth"]["auctionhouse"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"Company", "y"=>number_format(number_format($data["networth"]["company"],3) / number_format($data["networth"]["total"],3) * 100,2))
	//array("label"=>"Bookie", "y"=>number_format(number_format($data["networth"]["bookie"],3) / number_format($data["networth"]["total"],3) * 100,2)),
	//array("label"=>"Loan", "y"=>number_format(number_format($data["networth"]["loan"],3) / number_format($data["networth"]["total"],3) * 100,2))
)

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

<script>
window.onload = function() {
 
 
var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2",
	animationEnabled: true,
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
	      
$('.canvasjs-chart-credit').hide();
}
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

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

			   <div id="chartContainer" style="height: 370px; width: 100%;"></div>
				
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
			  <h5 class="card-header">Placeholder</h5>
			  <div class="card-body">

			   <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

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
