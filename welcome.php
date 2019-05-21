<?php
include('navbar.php');
?>

<div class="container">
	<div class='alert alert-success'>
		<button class='close' data-dismiss='alert'>&times;</button>
		Hello, <br><br>Welcome to the members page.<br><br>
    </div>
</div>

<div class="container mt-3 mx-5">
<?php
$apikey = "UtuyM2roWM6vDjKj"; //Heasleys4hemp's apikey
//$jsonurl = "https://api.torn.com/faction/13784?selections=basic&key=jIirMCNvK8q2hf8u";
$jsonurl = "https://api.torn.com/user/?selections=timestamp,networth,bazaar,display,inventory,hof,travel,education,medals,honors,notifications,personalstats,workstats,crimes,icons,cooldowns,money,perks,battlestats,bars,profile,basic,stocks,properties,jobpoints,merits,refills,discord,gym&key=" . $apikey;
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

<a class="mb-3" href="https://www.torn.com/<?php echo $data["player_id"];?>" ><img src="https://www.torn.com/sigs/27_<?php echo $data["player_id"];?>.png" /></a>
<h3><span class="badge badge-dark p-2"><?php echo $data["name"] . ' [' . $data["player_id"] . ']';?></span></h3>
<h3>Energy: <span class="badge badge-dark p-2"><?php echo $data["energy"]["current"].'/'.$data["energy"]["maximum"]; ?></span></h3>
<h3>Nerve: <span class="badge badge-dark p-2"><?php echo $data["nerve"]["current"].'/'.$data["nerve"]["maximum"]; ?></span></h3>
<h3>Drug Cooldown: <span class="badge badge-dark p-2"><?php echo gmdate("H:i:s",$data["cooldowns"]["drug"]); ?></span></h3>
<h3>Booster Cooldown: <span class="badge badge-dark p-2"><?php echo gmdate("H:i:s",$data["cooldowns"]["booster"]); ?></span></h3>


</div> <!-- container -->

<?php
include('footer.php');
?>
