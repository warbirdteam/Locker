<li class="nav-item active">
  <a class="nav-item nav-link" href="welcome.php">Home</a>
</li>

<li class="nav-item active dropdown">
  <a class="nav-link dropdown-toggle" href="#navFac" id="navFactionDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Faction
  </a>
  <div class="dropdown-menu" aria-labelledby="navFactionDropdown">

    <a class="dropdown-item" href="leaderboards.php"><i class="fas fa-crown"></i> Leaderboards</a>

  </div>
</li>

<li class="nav-item active dropdown">
  <a class="nav-link dropdown-toggle" href="#navPro" id="navProfileDropdown" role="button" data-toggle="dropdown">
    <?php echo $_SESSION['username']; ?>
  </a>
  <div class="dropdown-menu" aria-labelledby="navProfileDropdown">
    <a class="dropdown-item" href="preferences.php"><i class="fas fa-user-cog"></i> Preferences</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="process/logout.php"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
  </div>
</li>
