<?php

include_once("../misc/db_connect.php");

$sql = "select * from sleepstudy order by time";
$result = $conn->query($sql);

if(!$result) {
	die("Query error: " . mysqli_error($result));
	}

if($result->num_rows > 0) {
	$delimiter = ",";
	$filename = "sleepstudy_" . date('Y-m-d-H-i-s') . ".csv";

	$f = fopen('php://memory', 'w');
	fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

	$fields = array('ID', 'Name', 'Time', 'Status');
	fputcsv($f, $fields, $delimiter);
       while($row = mysqli_fetch_assoc($result)) {
	 $data = array($row["ID"], $row["name"], $row["time"], $row["status"]);
	 fputcsv($f, $data, $delimiter);
	}
	fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
fpassthru($f);

}
exit;
?>

