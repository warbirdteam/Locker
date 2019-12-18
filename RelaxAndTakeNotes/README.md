# Notes and help

Current Session Data available for usage
```
$_SESSION['userid'] = $row['tornid']; //Torn ID
$_SESSION['role'] = $row['userrole']; //Website Role
$_SESSION['username'] = $row['username']; //Torn Username
$_SESSION['factionid'] = $row['factionid']; //Torn Faction ID
```




For each webpage users will look at, such as welcome.php, you must include the following.
Change include(...) to "header("Location: /welcome.php");" if disallowing access to webpage.
```
<?php
session_start();
$_SESSION['title'] = 'YOUR TITLE'; //Add whatever title you wish here. This will be displayed in the tab of your browser
include('includes/header.php'); //required to include basic bootstrap and javascript files
//Add extra scripts/css below this. This could be tablesorter javascript files or custom css files
?>

<script type="text/javascript" src="js/your_javascript_files.js"></script>

<?php
//Add extra scripts/css before this.
//determine if user is an admin, leadership, member, or guest and include appropriate navbar file
switch ($_SESSION['role']) {
    case 'admin':
        include('includes/navbar-admin.php');
        break;
    case 'leadership':
        include('includes/navbar-leadership.php');
        break;
    case 'guest':
        include('includes/navbar-guest.php');
        break;
    case 'member':
        include('includes/navbar-member.php');
        break;
    default:
        $_SESSION = array();
        $_SESSION['error'] = "You are not logged in.";
        header("Location: /index.php");
        break;
}
?>
```

If you want to disallow a webpage from certain user groups, insert this before the switch statement
Add or remove roles depending on page
```
if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'leadership' || $_SESSION['role'] == 'member') {

  switch ($_SESSION['role']) {
      case 'admin':
      ...

} else {
  header("Location: /welcome.php");
}
```
