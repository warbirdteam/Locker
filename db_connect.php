<?php

/* Database connection start */
$servername = "localhost:3307";
$username = "root";
$password = "ZpWm5015@";
$dbname = "locker";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

?>