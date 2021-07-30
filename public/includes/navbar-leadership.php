<li class="nav-item active">
  <a class="nav-item nav-link" href="welcome.php">Home</a>
</li>

<li class="nav-item active dropdown">
  <a class="nav-link dropdown-toggle" href="#navTools" id="navToolsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Tools
  </a>
  <div class="dropdown-menu" aria-labelledby="navToolsDropdown">
    <a class="dropdown-item" href="war.php"><i class="fas fa-skull-crossbones"></i> War</a>
    <a class="dropdown-item" href="faction-lookup.php"><i class="fas fa-search"></i> Faction Lookup</a>
    <a class="dropdown-item" href="https://www.heasleys.org/fs/"><i class="fas fa-calculator"></i> Respect Simulator</a>
  </div>
</li>
<li class="nav-item active dropdown">
  <a class="nav-link dropdown-toggle" href="#navFac" id="navFactionDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Faction
  </a>
  <div class="dropdown-menu" aria-labelledby="navFactionDropdown">
    <a class="dropdown-item" href="faction.php"><i class="fas fa-users"></i> Faction</a>
    <a class="dropdown-item" href="memberstats.php"><i class="fas fa-archive"></i> Member Stats</a>
    <a class="dropdown-item" href="chains.php"><i class="fas fa-link"></i> Chain History</a>
  </div>
</li>

<li class="nav-item active dropdown">
  <a class="nav-link dropdown-toggle" href="#navPro" id="navProfileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php echo $_SESSION['username']; ?>
  </a>
  <div class="dropdown-menu" aria-labelledby="navProfileDropdown">
    <a class="dropdown-item" href="preferences.php"><i class="fas fa-user-cog"></i> Preferences</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="process/logout.php"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
  </div>
</li>
