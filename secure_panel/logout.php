<?php include_once("../com/controller.php");
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    unset($_SESSION['admin_type']);
    session_destroy();	
    header("location:./index.php");
	exit;
?>
