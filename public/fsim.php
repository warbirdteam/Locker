<?php



  function initAPI() {

  if(htmlspecialchars($_GET["fid"]) == "" || htmlspecialchars($_GET["fid"]) == 0){

      $errormsg = 'There was an error. You did not enter a faction ID. Please try again.';
      return null;
  }else{
  $fid = htmlspecialchars($_GET["fid"]);

  }


    //get faction api json from file
    try{
        $data = unserialize(file_get_contents('../misc/api/'.$fid.'.json')); }
    catch(Exception $ex){
        $errormsg = 'There was an error with the faction ID entered. Please message Heasleys4hemp [1468764] to configure it properly.';
        return null;
    }
    $factions = json_decode($data, true); // decode the JSON feed
    return $factions;

  }//end of init()


   function getCoreResUsed($factions) {
   $data = unserialize(file_get_contents('../misc/api/factiontree.json'));
   $factiontree = json_decode($data, true);
	//var_dump($factiontree);
	//echo $factiontree;
   //echo "<b><p>Factiontree - ".$factiontree['factiontree']['10']['1']['base_cost']."</p></b>";

   $respectCore = 0;
   if (is_array($factions) || is_object($factions))
	{
	 foreach($factions as $num)
	 {
	  if (is_array($num) || is_object($num))
	  {
	   foreach($num as $branch)
           {
		if (isset($branch['branch'])) {
	     switch ($branch['branch']) {
		case 'Core':
		 switch(true) {
		  case stristr($branch['name'],' armory'):
		    $respectCore += (int)$branch['basecost'];
		  break;
		  case stristr($branch['name'],'Point storage'):
		    $respectCore += (int)$branch['basecost'];
		  break;
		  case stristr($branch['name'],'Laboratory'):
		    $respectCore += (int)$branch['basecost'];
		  break;
		  case stristr($branch['name'],'Chaining'):
		    switch (true) {
		       case stristr($branch['name'],'Chaining XIII'):
		        $respectCore += (int)$factiontree['factiontree']['10']['13']['base_cost'];
		       case stristr($branch['name'],'Chaining XII'):
		        $respectCore += (int)$factiontree['factiontree']['10']['12']['base_cost'];
		       case stristr($branch['name'],'Chaining XI'):
		        $respectCore += (int)$factiontree['factiontree']['10']['11']['base_cost'];
		       case stristr($branch['name'],'Chaining X'):
		        $respectCore += (int)$factiontree['factiontree']['10']['10']['base_cost'];
		       case stristr($branch['name'],'Chaining IX'):
		        $respectCore += (int)$factiontree['factiontree']['10']['9']['base_cost'];
		       case stristr($branch['name'],'Chaining VIII'):
		        $respectCore += (int)$factiontree['factiontree']['10']['8']['base_cost'];
		       case stristr($branch['name'],'Chaining VII'):
		        $respectCore += (int)$factiontree['factiontree']['10']['7']['base_cost'];
		       case stristr($branch['name'],'Chaining VI'):
		        $respectCore += (int)$factiontree['factiontree']['10']['6']['base_cost'];
		       case stristr($branch['name'],'Chaining V'):
		        $respectCore += (int)$factiontree['factiontree']['10']['5']['base_cost'];
		       case stristr($branch['name'],'Chaining IV'):
		        $respectCore += (int)$factiontree['factiontree']['10']['4']['base_cost'];
		       case stristr($branch['name'],'Chaining III'):
		        $respectCore += (int)$factiontree['factiontree']['10']['3']['base_cost'];
		       case stristr($branch['name'],'Chaining II'):
		        $respectCore += (int)$factiontree['factiontree']['10']['2']['base_cost'];
		       case stristr($branch['name'],'Chaining I'):
		        $respectCore += (int)$factiontree['factiontree']['10']['1']['base_cost'];
		       break;
		    }
		  break;
		  case stristr($branch['name'],'Capacity'):
		    switch (true) {
		    	case stristr($branch['name'],'Capacity X'):
		    	  $respectCore += (int)$factiontree['factiontree']['11']['10']['base_cost'];
		    	case stristr($branch['name'],'Capacity IX'):
		    	  $respectCore += (int)$factiontree['factiontree']['11']['9']['base_cost'];
		    	case stristr($branch['name'],'Capacity VIII'):
		    	  $respectCore += (int)$factiontree['factiontree']['11']['8']['base_cost'];
		    	case stristr($branch['name'],'Capacity VII'):
		    	  $respectCore += (int)$factiontree['factiontree']['11']['7']['base_cost'];
		    	case stristr($branch['name'],'Capacity VI'):
		    	  $respectCore += (int)$factiontree['factiontree']['11']['6']['base_cost'];
		    	case stristr($branch['name'],'Capacity V'):
		    	  $respectCore += (int)$factiontree['factiontree']['11']['5']['base_cost'];
		    	case stristr($branch['name'],'Capacity IV'):
		    	  $respectCore += (int)$factiontree['factiontree']['11']['4']['base_cost'];
		    	case stristr($branch['name'],'Capacity III'):
		    	  $respectCore += (int)$factiontree['factiontree']['11']['3']['base_cost'];
		    	case stristr($branch['name'],'Capacity II'):
		    	  $respectCore += (int)$factiontree['factiontree']['11']['2']['base_cost'];
		    	case stristr($branch['name'],'Capacity I'):
		    	  $respectCore += (int)$factiontree['factiontree']['11']['1']['base_cost'];
		    	break;
		    }
		  break;
		  case stristr($branch['name'],'Territory');
		    switch (true) {
		      case stristr($branch['name'],'Territory XXX'):
		        $respectCore += (int)$factiontree['factiontree']['12']['30']['base_cost'];
		      case stristr($branch['name'],'Territory XXIX'):
		        $respectCore += (int)$factiontree['factiontree']['12']['29']['base_cost'];
		      case stristr($branch['name'],'Territory XXVIII'):
		        $respectCore += (int)$factiontree['factiontree']['12']['28']['base_cost'];
		      case stristr($branch['name'],'Territory XXVII'):
		        $respectCore += (int)$factiontree['factiontree']['12']['27']['base_cost'];
		      case stristr($branch['name'],'Territory XXVI'):
		        $respectCore += (int)$factiontree['factiontree']['12']['26']['base_cost'];
		      case stristr($branch['name'],'Territory XXV'):
		        $respectCore += (int)$factiontree['factiontree']['12']['25']['base_cost'];
		      case stristr($branch['name'],'Territory XXIV'):
		        $respectCore += (int)$factiontree['factiontree']['12']['24']['base_cost'];
		      case stristr($branch['name'],'Territory XXIII'):
		        $respectCore += (int)$factiontree['factiontree']['12']['23']['base_cost'];
		      case stristr($branch['name'],'Territory XXII'):
		        $respectCore += (int)$factiontree['factiontree']['12']['22']['base_cost'];
		      case stristr($branch['name'],'Territory XXI'):
		        $respectCore += (int)$factiontree['factiontree']['12']['21']['base_cost'];
		      case stristr($branch['name'],'Territory XX'):
		        $respectCore += (int)$factiontree['factiontree']['12']['20']['base_cost'];
		      case stristr($branch['name'],'Territory XIX'):
		        $respectCore += (int)$factiontree['factiontree']['12']['19']['base_cost'];
		      case stristr($branch['name'],'Territory XVIII'):
		        $respectCore += (int)$factiontree['factiontree']['12']['18']['base_cost'];
		      case stristr($branch['name'],'Territory XVII'):
		        $respectCore += (int)$factiontree['factiontree']['12']['17']['base_cost'];
		      case stristr($branch['name'],'Territory XVI'):
		        $respectCore += (int)$factiontree['factiontree']['12']['16']['base_cost'];
		      case stristr($branch['name'],'Territory XV'):
		        $respectCore += (int)$factiontree['factiontree']['12']['15']['base_cost'];
		      case stristr($branch['name'],'Territory XIV'):
		        $respectCore += (int)$factiontree['factiontree']['12']['14']['base_cost'];
		      case stristr($branch['name'],'Territory XIII'):
		        $respectCore += (int)$factiontree['factiontree']['12']['13']['base_cost'];
		      case stristr($branch['name'],'Territory XII'):
		        $respectCore += (int)$factiontree['factiontree']['12']['12']['base_cost'];
		      case stristr($branch['name'],'Territory XI'):
		        $respectCore += (int)$factiontree['factiontree']['12']['11']['base_cost'];
		      case stristr($branch['name'],'Territory X'):
		        $respectCore += (int)$factiontree['factiontree']['12']['10']['base_cost'];
		      case stristr($branch['name'],'Territory IX'):
		        $respectCore += (int)$factiontree['factiontree']['12']['9']['base_cost'];
		      case stristr($branch['name'],'Territory VIII'):
		        $respectCore += (int)$factiontree['factiontree']['12']['8']['base_cost'];
		      case stristr($branch['name'],'Territory VII'):
		        $respectCore += (int)$factiontree['factiontree']['12']['7']['base_cost'];
		      case stristr($branch['name'],'Territory VI'):
		        $respectCore += (int)$factiontree['factiontree']['12']['6']['base_cost'];
		      case stristr($branch['name'],'Territory V'):
		        $respectCore += (int)$factiontree['factiontree']['12']['5']['base_cost'];
		      case stristr($branch['name'],'Territory IV'):
		        $respectCore += (int)$factiontree['factiontree']['12']['4']['base_cost'];
		      case stristr($branch['name'],'Territory III'):
		        $respectCore += (int)$factiontree['factiontree']['12']['3']['base_cost'];
		      case stristr($branch['name'],'Territory II'):
		        $respectCore += (int)$factiontree['factiontree']['12']['2']['base_cost'];
		      case stristr($branch['name'],'Territory I'):
		        $respectCore += (int)$factiontree['factiontree']['12']['1']['base_cost'];
		      break;
		    }
		  break;


		 }//switch 'Core' true
		break;
	     }//switch branch
	   }
		   }
	  }
	 }
	}

   return $respectCore;
   }//getcoreresused function


   function Criminality($factiontree, $Arr) {
   $respect = 0;
   $_13R = 0;
   $_14R = 0;
   $_15R = 0;
   $_16R = 0;
   $_17R = 0;

		//nerve
		for($i = 1; $i<=$Arr[0]; $i++) {
		    $_13R += (int)$factiontree['factiontree']['13'][$i]['base_cost'];
		}
		//crimes
		for($i = 1; $i<=$Arr[1]; $i++) {
		    $_14R += (int)$factiontree['factiontree']['14'][$i]['base_cost'];
		}
		//jailtime
		for($i = 1; $i<=$Arr[2]; $i++) {
		    $_15R += (int)$factiontree['factiontree']['15'][$i]['base_cost'];
		}
		//bustnerve
		for($i = 1; $i<=$Arr[3]; $i++) {
		    $_16R += (int)$factiontree['factiontree']['16'][$i]['base_cost'];
		}
		//bustskill
		for($i = 1; $i<=$Arr[4]; $i++) {
		    $_17R += (int)$factiontree['factiontree']['17'][$i]['base_cost'];
		}

	$respect = $respect + $_13R + $_14R + $_15R + $_16R + $_17R;

   $respectArr = array($respect, $_13R, $_14R, $_15R, $_16R, $_17R);

   return $respectArr;
   }

   function Fortitude($factiontree, $Arr) {
   $respect = 0;
   $_18R = 0;
   $_19R = 0;
   $_20R = 0;
   $_21R = 0;
   $_22R = 0;

		//medicalcooldown
		for($i = 1; $i<=$Arr[0]; $i++) {
		    $_18R += (int)$factiontree['factiontree']['18'][$i]['base_cost'];
		}
		//reviving
		for($i = 1; $i<=$Arr[1]; $i++) {
		    $_19R += (int)$factiontree['factiontree']['19'][$i]['base_cost'];
		}
		//Hospital Time
		for($i = 1; $i<=$Arr[2]; $i++) {
		    $_20R += (int)$factiontree['factiontree']['20'][$i]['base_cost'];
		}
		//Life Regen
		for($i = 1; $i<=$Arr[3]; $i++) {
		    $_21R += (int)$factiontree['factiontree']['21'][$i]['base_cost'];
		}
		//Medical Effectiveness
		for($i = 1; $i<=$Arr[4]; $i++) {
		    $_22R += (int)$factiontree['factiontree']['22'][$i]['base_cost'];
		}

	$respect = $respect + $_18R + $_19R + $_20R + $_21R + $_22R;

   $respectArr = array($respect, $_18R, $_19R, $_20R, $_21R, $_22R);

   return $respectArr;
   }

      function Voracity($factiontree, $Arr) {
   $respect = 0;
   $_23R = 0;
   $_24R = 0;
   $_25R = 0;
   $_26R = 0;

		//candy effect
		for($i = 1; $i<=$Arr[0]; $i++) {
		    $_23R += (int)$factiontree['factiontree']['23'][$i]['base_cost'];
		}
		//energy effect
		for($i = 1; $i<=$Arr[1]; $i++) {
		    $_24R += (int)$factiontree['factiontree']['24'][$i]['base_cost'];
		}
		//booster cooldown
		for($i = 1; $i<=$Arr[2]; $i++) {
		    $_25R += (int)$factiontree['factiontree']['25'][$i]['base_cost'];
		}
		//alcohol effect
		for($i = 1; $i<=$Arr[3]; $i++) {
		    $_26R += (int)$factiontree['factiontree']['26'][$i]['base_cost'];
		}

		$respect = $respect + $_23R + $_24R + $_25R + $_26R;

   $respectArr = array($respect, $_23R, $_24R, $_25R, $_26R);

   return $respectArr;
   }

      function Toleration($factiontree, $Arr) {
   $respect = 0;
   $_27R = 0;
   $_28R = 0;
   $_29R = 0;

		//side effect
		for($i = 1; $i<=$Arr[0]; $i++) {
		    $_27R += (int)$factiontree['factiontree']['27'][$i]['base_cost'];
		}
		//overdosing
		for($i = 1; $i<=$Arr[1]; $i++) {
		    $_28R += (int)$factiontree['factiontree']['28'][$i]['base_cost'];
		}
		//addiction
		for($i = 1; $i<=$Arr[2]; $i++) {
		    $_29R += (int)$factiontree['factiontree']['29'][$i]['base_cost'];
		}

	$respect = $respect + $_27R + $_28R + $_29R;


   $respectArr = array($respect, $_27R, $_28R, $_29R);

   return $respectArr;
   }

      function Excursion($factiontree, $Arr) {
   $respect = 0;
   $_31R = 0;
   $_32R = 0;
   $_33R = 0;
   $_34R = 0;
   $_35R = 0;

		//hunting
		for($i = 1; $i<=$Arr[0]; $i++) {
		    $_31R += (int)$factiontree['factiontree']['31'][$i]['base_cost'];
		}
		//overseabanking
		for($i = 1; $i<=$Arr[1]; $i++) {
		    $_32R += (int)$factiontree['factiontree']['32'][$i]['base_cost'];
		}
		//travel capacity
		for($i = 1; $i<=$Arr[2]; $i++) {
		    $_33R += (int)$factiontree['factiontree']['33'][$i]['base_cost'];
		}
		//travel cost
		for($i = 1; $i<=$Arr[3]; $i++) {
		    $_34R += (int)$factiontree['factiontree']['34'][$i]['base_cost'];
		}
		//rehab cost
		for($i = 1; $i<=$Arr[4]; $i++) {
		    $_35R += (int)$factiontree['factiontree']['35'][$i]['base_cost'];
		}

   $respect = $respect + $_31R + $_32R + $_33R + $_34R + $_35R;

   $respectArr = array($respect, $_31R, $_32R, $_33R, $_34R, $_35R);

   return $respectArr;
   }

function Steadfast($factiontree, $Arr) {
   $respect = 0;
   $_36R = 0;
   $_37R = 0;
   $_38R = 0;
   $_39R = 0;

		//strength
		for($i = 1; $i<=$Arr[0]; $i++) {
		    $_36R += (int)$factiontree['factiontree']['36'][$i]['base_cost'];
		}
		//speed
		for($i = 1; $i<=$Arr[1]; $i++) {
		    $_37R += (int)$factiontree['factiontree']['37'][$i]['base_cost'];
		}
		//defense
		for($i = 1; $i<=$Arr[2]; $i++) {
		    $_38R += (int)$factiontree['factiontree']['38'][$i]['base_cost'];
		}
		//dexterity
		for($i = 1; $i<=$Arr[3]; $i++) {
		    $_39R += (int)$factiontree['factiontree']['39'][$i]['base_cost'];
		}

   $respect = $respect + $_36R + $_37R + $_38R + $_39R;

   $respectArr = array($respect, $_36R, $_37R, $_38R, $_39R);

   return $respectArr;
   }



function Aggression($factiontree, $Arr) {
   $respect = 0;
   $_40R = 0;
   $_41R = 0;
   $_42R = 0;
   $_43R = 0;
   $_44R = 0;

		//hospitalization
		for($i = 1; $i<=$Arr[0]; $i++) {
		    $_40R += (int)$factiontree['factiontree']['40'][$i]['base_cost'];
		}
		//damage
		for($i = 1; $i<=$Arr[1]; $i++) {
		    $_41R += (int)$factiontree['factiontree']['41'][$i]['base_cost'];
		}
		//aggstrength
		for($i = 1; $i<=$Arr[2]; $i++) {
		    $_42R += (int)$factiontree['factiontree']['42'][$i]['base_cost'];
		}
		//aggspeeed
		for($i = 1; $i<=$Arr[3]; $i++) {
		    $_43R += (int)$factiontree['factiontree']['43'][$i]['base_cost'];
		}
		//accuracy
		for($i = 1; $i<=$Arr[4]; $i++) {
		    $_44R += (int)$factiontree['factiontree']['44'][$i]['base_cost'];
		}

   $respect = $respect + $_40R + $_41R + $_42R + $_43R + $_44R;

   $respectArr = array($respect, $_40R, $_41R, $_42R, $_43R, $_44R);

   return $respectArr;
   }


function Suppression($factiontree, $Arr) {
   $respect = 0;
   $_45R = 0;
   $_46R = 0;
   $_47R = 0;
   $_48R = 0;

		//maxlife
		for($i = 1; $i<=$Arr[0]; $i++) {
		    $_45R += (int)$factiontree['factiontree']['45'][$i]['base_cost'];
		}
		//aggdefense
		for($i = 1; $i<=$Arr[1]; $i++) {
		    $_46R += (int)$factiontree['factiontree']['46'][$i]['base_cost'];
		}
		//aggdexterity
		for($i = 1; $i<=$Arr[2]; $i++) {
		    $_47R += (int)$factiontree['factiontree']['47'][$i]['base_cost'];
		}
		//escape
		for($i = 1; $i<=$Arr[3]; $i++) {
		    $_48R += (int)$factiontree['factiontree']['48'][$i]['base_cost'];
		}

   $respect = $respect + $_45R + $_46R + $_47R + $_48R;

   $respectArr = array($respect, $_45R, $_46R, $_47R, $_48R);

   return $respectArr;
   }




$data = unserialize(file_get_contents('../misc/api/factiontree.json'));
$factiontree = json_decode($data, true);



$factions = initAPI();

if ($factions['timestamp']) {

    $respectCore = getCoreResUsed($factions);
	$totalRespect = $factions['respect'];
	$availableRespect = $totalRespect - $respectCore;

} else {

        $respectCore = null;
	$totalRespect = null;
	$availableRespect = null;

}




//criminality
$nerve = htmlspecialchars($_GET['13']); //max: 40
$crimes = htmlspecialchars($_GET['14']); //max: 25
$jailtime = htmlspecialchars($_GET['15']); //max: 15
$bustnerve = htmlspecialchars($_GET['16']); //max: 3
$bustskill = htmlspecialchars($_GET['17']); //max: 10

//fortitude
$medicalcooldown = htmlspecialchars($_GET['18']); //max: 12
$reviving = htmlspecialchars($_GET['19']); //max: 10
$hospitaltime = htmlspecialchars($_GET['20']); //max: 25
$liferegen = htmlspecialchars($_GET['21']); //max: 20
$medicaleffectiveness = htmlspecialchars($_GET['22']); //max: 20

//voracity
$candyeffect = htmlspecialchars($_GET['23']); //max: 10
$energyeffect = htmlspecialchars($_GET['24']); //max: 10
$boostercooldown = htmlspecialchars($_GET['25']); //max: 24
$alcoholeffect = htmlspecialchars($_GET['26']); //max: 10

//toleration
$sideeffect = htmlspecialchars($_GET['27']); //max: 10
$overdosing = htmlspecialchars($_GET['28']); //max: 10
$addiction = htmlspecialchars($_GET['29']); //max: 30

//excursion
$hunting = htmlspecialchars($_GET['31']); //max: 10
$overseabanking = htmlspecialchars($_GET['32']); //max: 5
$travelcapacity = htmlspecialchars($_GET['33']); //max: 10
$travelcost = htmlspecialchars($_GET['34']); //max: 5
$rehabcost = htmlspecialchars($_GET['35']); //max: 10

//steadfast
$strength = htmlspecialchars($_GET['36']); //max: 10, 15, or 20
$speed = htmlspecialchars($_GET['37']);
$defense = htmlspecialchars($_GET['38']);
$dexterity = htmlspecialchars($_GET['39']);

//aggression
$hospitalization = htmlspecialchars($_GET['40']);//max: 10
$damage = htmlspecialchars($_GET['41']);//max: 10
$aggstrength = htmlspecialchars($_GET['42']); //max: 20
$aggspeed = htmlspecialchars($_GET['43']); //max: 20
$accuracy = htmlspecialchars($_GET['44']); //max: 10

//suppression
$maxlife = htmlspecialchars($_GET['45']);//max: 20
$supdefense = htmlspecialchars($_GET['46']);//max: 20
$supdexterity = htmlspecialchars($_GET['47']); //max: 20
$escape = htmlspecialchars($_GET['48']); //max: 10



$criminalityRespect = Criminality($factiontree, array($nerve, $crimes, $jailtime, $bustnerve, $bustskill));

$fortitudeRespect = Fortitude($factiontree, array($medicalcooldown, $reviving, $hospitaltime, $liferegen, $medicaleffectiveness));

$voracityRespect = Voracity($factiontree, array($candyeffect, $energyeffect, $boostercooldown, $alcoholeffect));

$tolerationRespect = Toleration($factiontree, array($sideeffect, $overdosing, $addiction));

$excursionRespect = Excursion($factiontree, array($hunting, $overseabanking, $travelcapacity, $travelcost, $rehabcost));

$steadfastRespect = Steadfast($factiontree, array($strength, $speed, $defense, $dexterity));

$aggressionRespect = Aggression($factiontree, array($hospitalization, $damage, $aggstrength, $aggspeed, $accuracy));

$suppressionRespect = Suppression($factiontree, array($maxlife, $supdefense, $supdexterity, $escape));


echo json_encode(array($totalRespect,$respectCore,$availableRespect, $criminalityRespect, $fortitudeRespect, $voracityRespect, $tolerationRespect, $excursionRespect, $steadfastRespect, $aggressionRespect, $suppressionRespect));
?>
