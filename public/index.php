<?php
session_start();
$_SESSION['title'] = "Login";
include('includes/header.php');
?>

<script src="js/index.js"></script>

<?php
include('includes/navbar-index.php');
include_once("../includes/autoloader.inc.php");
?>

<div class="content">
  <div class="container">
    <?php
    if (isset($_SESSION['error'])) {
      echo '<div class="alert alert-danger my-3 col-xl-4 offset-xl-4 col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" role="alert">'.$_SESSION['error'].'</div>';
      unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
      echo '<div class="alert alert-success my-3 col-xl-4 offset-xl-4 col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2" role="alert">'.$_SESSION['success'].'</div>';
      unset($_SESSION['success']);
    }
    ?>
    <div class="col-xl-4 offset-xl-4 col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-8 offset-2 card border border-dark shadow rounded py-4 mt-4">

      <div>
        <h2 class="font-weight-light text-center pb-2">Login</h2>
        <hr/>
        <form method="post" id="login-form" action="process/login.php">
          <div class="col">
            <span>Please enter your Torn API Key.</span>
            <input type="password" class="form-control" name="apikey" id="apikey" autocomplete="current-password" minlength="16" maxlength="16" required>

            <div class="form-check my-2">
              <input class="form-check-input" type="checkbox" id="apichkbox">
              <label class="form-check-label" for="apichkbox">
                Remember me
              </label>
            </div>

          </div>

          <hr />

          <div class="footer text-center pt-2">
            <button type="submit" class="btn btn-primary" id="login_button">
              <i class="fas fa-sign-in-alt"></i> Login
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>

</div>
<?php include('includes/footer.php');

?>
