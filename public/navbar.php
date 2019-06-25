<?php
session_start();
if(!isset($_SESSION['user_session'])){
	header("Location: index.php");
}
include('header.php');
include_once("../misc/db_connect.php");
$sql = "SELECT tornid, username, password, useremail FROM users WHERE tornid='".$_SESSION['user_session']."'";
$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
$row = mysqli_fetch_assoc($resultset);
?>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand pl-5" href="welcome.php">Warbirds</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMobileDropdown" aria-controls="navMobileDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse" id="navMobileDropdown">

    <div class="container d-flex justify-content-lg-end pr-5">
     <ul class="navbar-nav pr-3">
       <li class="nav-item active">
         <a class="nav-item nav-link" href="welcome.php">Home</a>
       </li>
       <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navFactionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Faction
        </a>
        <div class="dropdown-menu" aria-labelledby="navFactionDropdown">
					<a class="dropdown-item" href="respect_sim.php"><i class="fas fa-calculator"></i> Respect Simulator</a>
          <a class="dropdown-item" href="faction.php"><i class="fas fa-battery-half"></i> Energy</a>
        </div>
      </li>

       <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navProfileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $row['username']; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navProfileDropdown">
          <a class="dropdown-item" href="#"><i class="fas fa-user"></i> View Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
        </div>
      </li>


     </ul>
    </div>

    </div>

</nav>
