<?php
  class CheckSession{
	  // to check session variable exists
	  public function __construct( $param , $page ){
		  
		  if( !isset( $_SESSION[$param] ) || empty( $_SESSION[$param] ) ) {
			  
			  $_SESSION["session_expired"] = "Your Session has expired.<br/> Please Login to continue !!!";
			  header("location:$page");
			  
		  }
		  
	  }
	  
  }
?>