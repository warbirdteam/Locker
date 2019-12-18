<?php
	session_start();
	unset($_SESSION['userid']);
	if(session_destroy()) {
		header("Location: /index.php");
	}
?>
