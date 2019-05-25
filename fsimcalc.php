<?php


  function initAPI() {

  if(htmlspecialchars($_GET["fid"]) == ""){

      $errormsg = 'There was an error. You did not enter a faction ID. Please try again.';
      return $errormsg;
  }else{
  $fid = htmlspecialchars($_GET["fid"]);

  }
    //get faction api json from file
    try{
        $data = unserialize(file_get_contents('api/'.$fid.'.json')); }
    catch(Exception $ex){
        $errormsg = 'There was an error with the faction ID entered. Please message Heasleys4hemp [1468764] to configure it properly.';
        return $errormsg;
    }
    $factions = json_decode($data, true); // decode the JSON feed
    return $factions;

  }//end of init()

   function getLevels($factions) {
   $data = unserialize(file_get_contents('api/factiontree.json'));
   $factiontree = json_decode($data, true);


   if (is_array($factions) || is_object($factions))
	{
	 foreach($factions as $num)
	 {
	  if (is_array($num) || is_object($num))
	  {
	   foreach($num as $branch)
           {

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
		  for($i = $branch['level']; $i>=1; $i--) {
		     $respectCore += (int)$factiontree['factiontree']['10'][$i]['base_cost'];
		  }
		  break;

		  case stristr($branch['name'],'Capacity'):
		  for($i = $branch['level']; $i>=1; $i--) {
		     $respectCore += (int)$factiontree['factiontree']['11'][$i]['base_cost'];
		  }
		  break;

		  case stristr($branch['name'],'Territory');
		  for($i = $branch['level']; $i>=1; $i--) {
		     $respectCore += (int)$factiontree['factiontree']['12'][$i]['base_cost'];
		  }
		  break;

		 }//switch 'Core' true
		break;


		case 'Criminality':
		 $basecrim = $branch['branchmultiplier'];
		 switch(true) {

		 case stristr($branch['name'],'Nerve'):
		   $_13 = $branch['level'];
		 break;

		 case stristr($branch['name'],'Crimes'):
		   $_14 = $branch['level'];
		 break;

		 case stristr($branch['name'],'Jail time'):
		   $_15 = $branch['level'];
		 break;

		 case stristr($branch['name'],'Bust nerve'):
		   $_16 = $branch['level'];
		 break;

		 case stristr($branch['name'],'Bust skill'):
		   $_17 = $branch['level'];
		 break;


		 }
		break;

		case 'Fortitude':
		 $basefort = $branch['branchmultiplier'];
		 switch(true) {

		 case stristr($branch['name'],'Medical Cooldown'):
		   $_18 = $branch['level'];
		 break;

		 case stristr($branch['name'],'Reviving'):
		   $_19 = $branch['level'];
		 break;

		 case stristr($branch['name'],'Hospital time'):
		   $_20 = $branch['level'];
		 break;

		 case stristr($branch['name'],'Life regeneration'):
		   $_21 = $branch['level'];
		 break;

		 case stristr($branch['name'],'Medical effectiveness'):
		   $_22 = $branch['level'];
		 break;

		 }
		break;

		case 'Voracity':
		 $basevor = $branch['branchmultiplier'];
		 switch(true) {
		 case stristr($branch['name'],'Candy effect'):
		 $_23 = $branch['level'];
		 /* for($i = $branch['level']; $i>=1; $i--) {

		     //$respectVor+= (int)$factiontree['factiontree']['23'][$i]['base_cost'];
		     //$_23r += (int)$factiontree['factiontree']['23'][$i]['base_cost'];
		  }*/
		 break;

		 case stristr($branch['name'],'Energy drink effect'):
		 $_24 = $branch['level'];
		 break;

		 case stristr($branch['name'],'Booster cooldown'):
		  $_25 = $branch['level'];
		 break;

		 case stristr($branch['name'],'Alcohol effect'):
		  $_26 = $branch['level'];
		 break;
		 }

		//echo "Voracity: " . $respectVor . "<br/>";
		break;

	case 'Toleration':
	   $basetol = $branch['branchmultiplier'];
	   switch (true) {
		case stristr($branch['name'],'Side effects'):
			$_27 = $branch['level'];
		break;
		case stristr($branch['name'],'Overdosing'):
			$_28 = $branch['level'];
		break;
		case stristr($branch['name'],'Addiction'):
			$_29 = $branch['level'];
		break;
	   }
	break;

	case 'Excursion':
	   $baseexcur = $branch['branchmultiplier'];
	   switch (true) {
		case stristr($branch['name'],'Hunting'):
			$_31 = $branch['level'];
		break;
		case stristr($branch['name'],'Overseas banking'):
			$_32 = $branch['level'];
		break;
		case stristr($branch['name'],'Travel capacity'):
			$_33 = $branch['level'];
		break;
		case stristr($branch['name'],'Travel cost'):
			$_34 = $branch['level'];
		break;
		case stristr($branch['name'],'Rehab cost'):
			$_35 = $branch['level'];
		break;
	   }
	break;

	case 'Steadfast':
	   $baseste = $branch['branchmultiplier'];
	   switch (true) {
		case stristr($branch['name'],'Strength training'):
			$_36 = $branch['level'];
		break;
		case stristr($branch['name'],'Speed training'):
			$_37 = $branch['level'];
		break;
		case stristr($branch['name'],'Defense training'):
			$_38 = $branch['level'];
		break;
		case stristr($branch['name'],'Dexterity training'):
			$_39 = $branch['level'];
		break;
	   }
	break;

	case 'Aggression':
	   $baseagg = $branch['branchmultiplier'];
	   switch (true) {
	   	case stristr($branch['name'],'Hospitalization'):
			$_40 = $branch['level'];
		break;
		case stristr($branch['name'],'Damage'):
			$_41 = $branch['level'];
		break;
		case stristr($branch['name'],'Strength'):
			$_42 = $branch['level'];
		break;
		case stristr($branch['name'],'Speed'):
			$_43 = $branch['level'];
		break;
		case stristr($branch['name'],'Accuracy'):
			$_44 = $branch['level'];
		break;

	   }
	break;

	case 'Suppression':
	   $basesup = $branch['branchmultiplier'];
	   switch (true) {
		case stristr($branch['name'],'Maximum life'):
			$_45 = $branch['level'];
		break;
		case stristr($branch['name'],'Dexterity'):
			$_46 = $branch['level'];
		break;
		case stristr($branch['name'],'Defense'):
			$_47 = $branch['level'];
		break;
		case stristr($branch['name'],'Escape'):
			$_48 = $branch['level'];
		break;
	   }
	break;
	     }//switch branch
	   }
	  }
	 }
	}

   $criminality = array($basecrim, $_13, $_14, $_15, $_16, $_17);
   $fortitude = array($basefort, $_18, $_19, $_20, $_21, $_22);
   $voracity = array($basevor, $_23, $_24, $_25, $_26);
   $toleration = array($basetol, $_27, $_28, $_29);
   $excursion = array($baseexcur, $_31, $_32, $_33, $_34, $_35);
   $steadfast = array($baseste, $_36, $_37, $_38, $_39);
   $aggression = array($baseagg, $_40, $_41, $_42, $_43, $_44);
   $suppression = array($basesup, $_45, $_46, $_47, $_48);

   return array($respectCore, $criminality, $fortitude, $voracity, $toleration, $excursion, $steadfast, $aggression, $suppression);
   }//getcoreresused function





$data = unserialize(file_get_contents('api/factiontree.json'));
$factiontree = json_decode($data, true);

$factions = initAPI();

$levels = getLevels($factions);


$criminality = $levels[1];

$fortitude = $levels[2];

$voracity = $levels[3];

$toleration = $levels[4];

$excursion = $levels[5];

$steadfast = $levels[6];

$aggression = $levels[7];

$suppression = $levels[8];


$RespectCore = $levels[0];
$totalRespect = $factions['respect'];
$availableRespect = $totalRespect - $RespectCore;

//echo json_encode(array(number_format($totalRespect),number_format($RespectCore),$availableRespect));

echo json_encode(array(number_format($totalRespect),number_format($RespectCore),$availableRespect, $criminality, $fortitude, $voracity, $toleration, $excursion, $steadfast, $aggression, $suppression));
?>