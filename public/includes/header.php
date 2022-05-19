<?php /*
This is a basic header. In the webpage.php file, add this first, then add any extra css/js files needed. Then add appropriate navbars
*/?>
<!DOCTYPE html>
<html lang="en" xml:lang="en">
  <head>
    <title><?php echo $_SESSION['title']; ?></title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- CSS -->
	<link rel="stylesheet" href="css/lib/bootstrap.css"> <!-- Bootstrap -->
	<link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/lib/fontawesome-all.css"> <!-- Font Awesome -->

	<script src="js/lib/jquery-3.4.1.min.js"></script> <!-- jQuery -->
	<script src="js/lib/bootstrap.bundle.js"></script> <!-- Bootstrap -->
  <script src="js/lib/fontawesome-all.min.js"></script> <!-- Font Awesome -->
  <script src="js/lib/jquery.tablesorter.js"></script>
  <script src="js/lib/jquery.tablesorter.widgets.js"></script>

  <script src="js/tablesort.js"></script>
