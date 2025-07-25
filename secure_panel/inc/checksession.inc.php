<?php
$referer = $_SERVER['REQUEST_URI']; 
unset( $_SESSION['page'] );
$_SESSION['page'] = basename( $referer );
  
if( !isset( $_SESSION["user_id"] ) || empty( $_SESSION["user_id"] ) || $_SESSION["user_id"] == "" )
{ 

	$_SESSION["login_error"] = "<br/>Please <b><a href=\"index.php?redirect=$referer\">Login</a> to continue</b>";
    header( "location:index.php" );
	die();
}
 
?>