<?php 
include('header.php');
include_once("../../../db_connect.php");
?>
<title>Shitty Logon</title>
<script type="text/javascript" src="script/jquery.validate.js"></script>
<script type="text/javascript" src="script/login.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
<?php include('navbar-index.php');?>
<div class="container">
	<h2>This thing is broken.</h2>

<form method="post" id="login-form">
  <h2>User Log In Form</h2>
  <hr/>
  <div class="form-group">
    <input type="email" class="form-control" name="user_email" id="user_email" placeholder="Email Address">
	<span id="check-e"></span>
  </div>
  <div class="form-group">
    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
  </div>
  <hr />
  <button type="submit" class="btn btn-primary" name="login_button" id="login_button">
    <i class="fas fa-sign-in-alt"></i> Sign In
  </button>
</form>
	
		
</div>
<?php include('footer.php');?>
