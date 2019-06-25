<?php
include('header.php');
include_once("../misc/db_connect.php");
?>
<title>Login</title>
<script type="text/javascript" src="script/jquery.validate.js"></script>
<script type="text/javascript" src="script/login.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
<?php include('navbar-index.php');?>
<div class="content">

<div class="container">
  <div class="row">
   <div class="col-xl-4 col-lg-5 col-md-6 col-sm-7 col-8 border border-dark shadow mx-auto align-self-center py-4 mt-4 rounded">
     <form method="post" id="login-form">
	 <div>
      <h2 class="font-weight-light text-center pb-2">Login</h2>
  <hr/>
       <div class="form-group pb-1">
         <input type="email" class="form-control" name="user_email" id="user_email" placeholder="Email Address">
	<span id="check-e"></span>
       </div>
       <div class="form-group pb-1">
         <input type="password" class="form-control" name="password" id="password" placeholder="Password">
       </div>
  <hr />
  <div class="footer text-center pt-2">
       <button type="submit" class="btn btn-primary" name="login_button" id="login_button">
         <i class="fas fa-sign-in-alt"></i> Sign In
       </button>
	   </div>
	 </div>
    </form>
  </div>
</div>
</div>

</div>
<?php include('footer.php');?>
