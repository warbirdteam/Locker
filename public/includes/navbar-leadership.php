<?php
if(!isset($_SESSION['userid'])){
	header("Location: /index.php");
}
?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
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
          <a class="dropdown-item" href="/chain-energy.php"><i class="fas fa-file-code"></i></i> CSV Energy Reports</a>
					<a class="dropdown-item" href="https://www.heasleys.org/fs/"><i class="fas fa-calculator"></i> Respect Simulator</a>
          <a class="dropdown-item" href="/energy.php"><i class="fas fa-battery-half"></i> Energy</a>
          <a class="dropdown-item" href="/faction.php"><i class="fas fa-battery-half"></i> Faction</a>
          <a class="dropdown-item" href="/chains.php"><i class="fas fa-unlock"></i> Chain History</a>
        </div>
      </li>

       <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navProfileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $_SESSION['username']; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navProfileDropdown">
          <a class="dropdown-item" href="#"><i class="fas fa-user"></i> View Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="/process/logout.php"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
        </div>
      </li>


     </ul>
    </div>

    </div>

</nav>
