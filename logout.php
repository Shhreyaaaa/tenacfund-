<?php   include_once ('includes/config.php');
session_start();
session_unset();
session_destroy();
$_SESSION['userdetail']='';
print_r($_SESSION['userdetail']);
header("location:index.php");
exit();
?>