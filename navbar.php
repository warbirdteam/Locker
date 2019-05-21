<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand pl-5" href="#">Warbirds</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMobileDropdown" aria-controls="navMobileDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse" id="navMobileDropdown">

    <div class="container d-flex justify-content-lg-end pr-5">
     <ul class="navbar-nav pr-3">
       <li class="nav-item active">
         <a class="nav-item nav-link" href="#">Home</a>
       </li>
       <li class="nav-item active">
         <a class="nav-item nav-link" href="#">Placeholder</a>
       </li>
       <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navFactionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Faction
        </a>
        <div class="dropdown-menu" aria-labelledby="navFactionDropdown">
          <a class="dropdown-item" href="faction.php"><i class="fas fa-users"></i> Faction</a>
          <a class="dropdown-item" href="faction.php?action=energy"><i class="fas fa-battery-half"></i> Energy</a>
        </div>
      </li>

       <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navProfileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $row['username']; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navProfileDropdown">
          <a class="dropdown-item" href="#"><i class="fas fa-user"></i> View Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Placeholder</a>
          <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
        </div>
      </li>


     </ul>
    </div>

    </div>

</nav>
