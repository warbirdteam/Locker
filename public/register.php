<?php
session_start();
$_SESSION['title'] = "Register";
include('includes/header.php');
include('includes/navbar-index.php');
include_once("..\includes\autoloader.inc.php");
?>
<div class="content">
<div class="container">
  <?php
  if (isset($_SESSION['error']))
  {
  echo '<div class="alert alert-danger my-3 col-xl-4 offset-xl-4 col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" role="alert">'.$_SESSION['error'].'</div>';
  unset($_SESSION['error']);
  }
  ?>
  <div class="col-xl-4 offset-xl-4 col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 card border border-dark shadow rounded py-4 mt-4">

   <div>
      <h2 class="font-weight-light text-center pb-2">Register</h2>
      <hr/>
      <form method="post" id="register-form" action="process/registrar.php">
          <div class="col">

              <input type="text" class="form-control" name="apikey" id="apikey" placeholder="Enter your Torn API Key to register">


          </div>

          <hr />

          <div class="footer text-center pt-2">
               <button type="submit" class="btn btn-primary" id="register_button">
                 <i class="fas fa-sign-in-alt"></i> Register
               </button>
          </div>

      </form>
	 </div>

  </div>
</div>

</div>
<?php include('includes/footer.php');

?>
