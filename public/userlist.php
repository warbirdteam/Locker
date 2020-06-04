<?php
//##### ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Userlist';
include('includes/header.php');
?>



<?php
include('includes/navbar-logged.php');
?>

<?php
if (!isset($_SESSION['roleValue'])) {
	$_SESSION = array();
	$_SESSION['error'] = "You are no longer logged in.";
	header("Location: /index.php");
}

if ($_SESSION['roleValue'] <= 3) { // 1 = guest / register, 2 = member, 3 = leadership, 4 = admin
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
}
?>

<div class="container">
  <div class="row">
   <div class="col border border-dark shadow py-4 mt-4 rounded">

   <table class="table table-hover table-striped table-dark">
      <thead class="thead-dark">
        <tr>
          <th scope="col">User ID</th>
          <th scope="col">Username</th>
          <th scope="col">Faction ID</th>
          <th scope="col">Role</th>
        </tr>
      </thead>
      <tbody>
				<form>

        <?php
        // Get member rows
        $db_users = new DB_request();
        $rows = $db_users->getUsers();
        $count = $db_users->row_count;

        if($count > 0){

        foreach ($rows as $row){
        ?>

         <tr>
           <td><?php echo $row['tornid'] ?></td>
           <td><?php echo $row['username'] ?></td>
           <td><?php echo $row['factionid'] ?></td>
           <td>
						 <div class="input-group mb-3">
							  <select class="custom-select" id="userrole">
									<option><?php echo $row['userrole'] ?></option>
							    <option value="1">Guest</option>
							    <option value="2">Member</option>
							    <option value="3">Leadership</option>
									<option value="4">Admin</option>
							  </select>
							</div>
						</td>
         </tr>

        <?php } }else{ ?>
          <tr><td colspan="4">No information found...</td></tr>
        <?php } ?>
			</form>
      </tbody>
   </table>
	 <button>Submit</button>



</div> <!-- col -->
</div> <!-- row -->
</div> <!-- container -->

<?php
include('includes/footer.php');
?>
