<?php

 for( $i= 1 ; $i <= 4 ; $i++ ) {
	echo $_FILES['file' . $i]['name'];
	echo '<br/>';
 }

echo '<br/>';

print_r($_FILES);

//echo file_get_contents($_FILES['file']['tmp_name'][0]);

?>