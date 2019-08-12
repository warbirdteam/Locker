<?php
session_start();

if($_SESSION['role'] == 'admin') {
  include('navbar-admin.php');
} else {
  include('navbar.php');
}

include_once('../misc/db_connect.php');

$result = $conn->query("select * from sleepstudy order by time asc");
if(!$result) {
	echo "Database query error\n";
	}

echo "<center><table border=1 width=\"800\">";
echo "<tr><td colspan=4 align=center><h3>Nest Sleep Study</h3></td><td><a href=\"exportsleep.php\" target=_blank>Export CSV</a></td></tr>";
echo "<tr><th style=\"text-align:center\">ID</th><th style=\"text-align:center\">Name</th><th style=\"text-align:center\">Time</th><th style=\"text-align:center\">Status</th><th style=\"text-align:center\">URL</th></tr>";

while($row = mysqli_fetch_assoc($result)) {
   if($row["status"] == "active"){
	echo "<tr bgcolor=\"#DAF7A6\"><td>" . $row["ID"] . "</td><td>" . $row["name"] . "</td><td>" . $row["time"] . "</td><td>" . $row["status"] . "</td><td>" . "<a href=\"https://www.torn.com/profiles.php?XID=" . $row["ID"]."\" target=_blank>" . "Torn Page</a>" . "</td></tr>";
   } else if($row["status"] == "inactive") {
	echo "<tr bgcolor=\"#FFC300\"><td>" . $row["ID"] . "</td><td>" . $row["name"] . "</td><td>" . $row["time"] . "</td><td>" . $row["status"] . "</td><td>" . "<a href=\"https://www.torn.com/profiles.php?XID=" . $row["ID"] ."\" target=_blank>Torn Page</a>" . "</td></tr>";
   } else if($row["status"] == "WATCH") {
	echo "<tr bgcolor=\"#FF5733\"><td>" . $row["ID"] . "</td><td>" . $row["name"] . "</td><td>" . $row["time"] . "</td><td>" . $row["status"] . "</td><td>" . "<a href=\"https://www.torn.com/profiles.php?XID=" . $row["ID"] . "\" target=_blank>Torn Page</a>" . "</td></tr>";
   } else {
	echo "<tr bgcolor=\"#C70039\"><td>" . $row["ID"] . "</td><td>" . $row["name"] . "</td><td>" . $row["time"] . "</td><td>" . $row["status"] . "</td><td>" . "<a href=\"https://www.torn.com/profiles.php?XID=" . $row["ID"] . "\" target=_blank>Torn Page</a>" . "</td></tr>";
   }


	
}
echo "</table></center>";
$conn->close();
?>
