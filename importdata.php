<?php
// Load the database configuration file
include_once("../../../db_connect_stats.php");

if(isset($_POST['importSubmit'])){
    


   // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    
	 for( $i= 1 ; $i <= 8 ; $i++ ) {
	
    // Validate whether selected file is a CSV file
    if(!empty($_FILES['file' . $i]['name']) && in_array($_FILES['file' . $i]['type'], $csvMimes)){
        
        // If the file is uploaded
        if(is_uploaded_file($_FILES['file' . $i]['tmp_name'])){
            
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file' . $i]['tmp_name'], 'r');
            
            // Skip the first line
            fgetcsv($csvFile);
            
            // Parse data from CSV file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                // Get row data
                $Player  = $line[0];
				//echo $Player . ',';
                $Player_Profile  = $line[1];
				//echo $Player_Profile . ',';
                $Contribution  = $line[2];
				//echo $Contribution . '<br/>';
                
                // Check whether member already exists in the database with the same email
                //$prevQuery = "SELECT id FROM members WHERE email = '".$line[1]."'";
                //$prevResult = $db->query($prevQuery);
                
                //if($prevResult->num_rows > 0){
                    // Update member data in the database
                    //$db->query("UPDATE members SET name = '".$name."', phone = '".$phone."', status = '".$status."', modified = NOW() WHERE email = '".$email."'");
                //}else{
                    // Insert member data in the database
					
					switch ($i) {
						case 1:	//strength-start	
							$statconn->query("INSERT INTO strb4 (Player, URL, Contribution) VALUES ('".$Player."', '".$Player_Profile."', '".$Contribution."')");
						break;
						case 2: //speed-start
							$statconn->query("INSERT INTO spdb4 (Player, URL, Contribution) VALUES ('".$Player."', '".$Player_Profile."', '".$Contribution."')");
						break;
						case 3: //defense-start
							$statconn->query("INSERT INTO defb4 (Player, URL, Contribution) VALUES ('".$Player."', '".$Player_Profile."', '".$Contribution."')");
						break;
						case 4: //dexterity-start
							$statconn->query("INSERT INTO dexb4 (Player, URL, Contribution) VALUES ('".$Player."', '".$Player_Profile."', '".$Contribution."')");
						break;
						case 5:	//strength-end	
							$statconn->query("INSERT INTO strpost (Player, URL, Contribution) VALUES ('".$Player."', '".$Player_Profile."', '".$Contribution."')");
						break;
						case 6: //speed-end
							$statconn->query("INSERT INTO spdpost (Player, URL, Contribution) VALUES ('".$Player."', '".$Player_Profile."', '".$Contribution."')");
						break;
						case 7: //defense-end
							$statconn->query("INSERT INTO defpost (Player, URL, Contribution) VALUES ('".$Player."', '".$Player_Profile."', '".$Contribution."')");
						break;
						case 8: //dexterity-end
							$statconn->query("INSERT INTO dexpost (Player, URL, Contribution) VALUES ('".$Player."', '".$Player_Profile."', '".$Contribution."')");
						break;
					}
            }
            
            // Close opened CSV file
            fclose($csvFile);
            
            $qstring = '?status=succ';
        }else{
            $qstring = '?status=err';
        }
    }else{
        $qstring = '?status=invalid_file';
    }
	}//for loop
}

// Redirect to the listing page
header("Location: chain-energy-jk.php".$qstring);

?>